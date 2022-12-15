<?php
namespace Bitcms\Controller;

use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\I18n\I18n;
use Cake\Utility\Text;

class FrontendController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        if($this->request->is('ajax')){
            $this->viewBuilder()->setLayout('ajax');
        }

        $this->checkRedirect();
        $this->setLanguage();
        $this->registerVisit();
        $this->set('settings', $this->getSettings());
        $this->set('menu', $this->getMenu());
        $this->set('humanizer', $this->getHumanizerCode());
        $this->set('languages', $this->fetchTable('Bitcms.Languages')->find()->where(['active' => true])->toArray());
    }

    /**
     * Check for a redirect
     */
    protected function checkRedirect()
    {
        $redirects = $this->fetchTable('Bitcms.Redirects');
        if ($redirect = $redirects->find()->where(['from_url' => $this->getRequest()->getRequestTarget()])->first()) {
            header("HTTP/1.1 '.$redirect->type.' Moved Permanently");
            header("Location: " . $redirect->to_url);
            exit;
        }
    }

    /**
     * Register a visit
     * @return mixed
     */
    public function registerVisit()
    {
//        if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) return true;

        $visitors = $this->fetchTable('Bitcms.Visitors');

        $browserData = $_SERVER;
        //$browserData['browser'] = get_browser();

        $query = $visitors->find();
        $date = $query->func()->date_format([
            'date_created' => 'literal',
            "'%Y-%m-%d'" => 'literal'
        ]);
        $q = $query->select(['created' => $date])->where([
            'ipaddress' => md5($browserData['REMOTE_ADDR']),
        ])->having([
            'created' => date('Y-m-d')
        ]);

        if($q->all()->isEmpty()){
            $v = $visitors->newEntity([
                'ipaddress' => md5($browserData['REMOTE_ADDR']),
                'url' => $this->getRequest()->getRequestTarget(),
                'browser_data' => null
            ]);
            return $visitors->save($v);
        } else {
            return true;
        }
    }

    /**
     * Get menu
     * Store in cache if found
     * @return mixed
     */
    protected function getMenu()
    {
        $cacheName = 'menu_' . I18n::getLocale();
        $pages = $this->fetchTable('Bitcms.Pages');
        return $pages->find()
            ->where(['menu', true, 'parent_id IS' => null])
            ->orderAsc('position')
            ->contain(['ChildPages' => function($q){
                return $q->where(['menu' => 1]);
            }])
            ->cache($cacheName)
            ->toArray();

    }

    /**
     * Set correct language
     * @return bool
     */
    public function setLanguage(): bool
    {
        if($this->request->is('post')){
            return true;
        }

        $languageTable = $this->fetchTable('Bitcms.Languages');
        $languages = $languageTable->find()->where(['active' => true]);
        $defaultLanguage = $languageTable->find()->where(['is_default' => true])->first();

        // there is just one language, skip everything
        if ($languages->count() == 1) {
            // language is set, but we only have one language - redirect without the language
            if ($this->getRequest()->getParam('lang')) {
                $this->gotoLanguage(str_replace($this->getRequest()->getParam('lang'), '', $this->getRequest()->getRequestTarget()));
            }

            // set language
            I18n::setLocale($defaultLanguage->locale);
            $this->set('language', $defaultLanguage);

            return true;

        } else {
            // we have multiple language but it's not set in the browser yet
            // redirect to the default language
            if (!$this->getRequest()->getParam('lang') || $this->getRequest()->getParam('lang') == '') {
                $this->gotoLanguage('/' . $defaultLanguage->abbreviation . $this->getRequest()->getRequestTarget());
            }

            // try to find the request language in the database
            if ($requestLanguage = $languageTable->findByAbbreviationAndActive($this->getRequest()->getParam('lang'), true)->first()) {

                // set language
                I18n::setLocale($requestLanguage->locale);
                $this->set('language', $requestLanguage);

                // request language is not found - redirect to the default language
            } else {
                $this->gotoLanguage('/' . $defaultLanguage->abbreviation);
            }


        }

        return true;
    }

    /**
     * Go to a specific language
     * @param $url
     */
    protected function gotoLanguage($url)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $url);
        exit;
    }

    /**
     * Get settings
     * Store in cache if found
     * @return mixed
     */
    protected function getSettings()
    {
        return $this->fetchTable('Bitcms.Settings')->find('list', [
            'keyField' => 'title',
            'valueField' => 'value'
        ])->cache('settings_' . I18n::getLocale())->toArray();
    }

    /**
     * Get Humanizer code for forms
     * @return string
     */
    public function getHumanizerCode()
    {
        return md5(date($this->getRequest()->getServerParams()['REMOTE_ADDR'] . 'YYYYMMDD'));
    }

    /**
     * Get BitCMS config
     * @return array|mixed
     */
    public function getConfig()
    {
        if (file_exists(CONFIG . 'bitcms.php')){
            return include_once CONFIG . 'bitcms.php';
        } else {
            return [];
        }
    }
}
