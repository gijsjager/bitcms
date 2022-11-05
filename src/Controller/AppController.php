<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $authUser;


    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
        ]);


        $this->loadModel('Languages');

        // get user
        if ($this->Auth->user('id')) {
            $this->loadModel('Users');
            $this->authUser = $this->Users->findById($this->Auth->user('id'))->first();
            $this->set('authUser', $this->authUser);
        }

        // Dotbits layout
        if ($this->getRequest()->getParam('prefix') === 'Bitcms') {

            $isAuthorized = $this->isAuthorized($this->Auth->user());
            $this->set('isAuthorized', $isAuthorized);

            $this->viewBuilder()->setLayout('bitcms');
            $this->set('maxUploadSize', $this->getMaxFileUploadSize());

            // set language
            $defaultLanguage = $this->Languages->find()->where(['is_default' => true])->first();
            Configure::write('App.defaultLocale', env('APP_DEFAULT_LOCALE', $defaultLanguage->locale));
            if ($this->request->getQuery('language')) {
                $language = $this->Languages->find()->where(['abbreviation' => $this->request->getQuery('language')])->first();
            }
            if (empty($language)) {
                $language = $defaultLanguage;
            }
            $this->set('language', $language);
            $this->set('languages', $this->Languages->find()->toArray());
            I18n::setLocale($language->locale);

            // front-end layout
        } else {
            $this->Auth->allow();
            $this->checkRedirect();
            $this->setLanguage();
            $this->registerVisit();
            $this->set('settings', $this->getSettings());
            $this->set('menu', $this->getMenu());
            $this->set('authUser', $this->authUser);
            $this->set('languages', $this->Languages->find()->where(['active' => true])->toArray());

        }

    }

    /**
     * Is user authorized to visit action
     * @param $authUser
     * @return bool
     */
    public function isAuthorized($user): bool
    {
        // Any registered user can access public functions
        if (!$this->getRequest()->getParam('prefix')) {
            return true;
        }

        // Only admins can access admin functions
        if ($this->getRequest()->getParam('prefix') === 'bitcms') {
            return (bool)($user['role'] === 'admin');
        }

        // Default deny
        return false;
    }

    public function setLanguage()
    {
        $this->loadModel('Languages');
        $languages = $this->Languages->find()->where(['active' => true]);
        $defaultLanguage = $this->Languages->find()->where(['is_default' => true])->first();

        // there is just one language, skip everything
        if ($languages->count() == 1) {
            // language is set, but we only have one language - redirect without the language
            if ($this->request->getParam('lang')) {
                return $this->gotoLanguage(str_replace($this->request->getParam('lang'), '', $this->request->getRequestTarget()));
            }

            // set language
            I18n::setLocale($defaultLanguage->locale);
            $this->set('language', $defaultLanguage);

            return true;

        } else {
            // we have multiple language but it's not set in the browser yet
            // redirect to the default language
            if (!$this->request->getParam('lang') || $this->request->getParam('lang') == '') {
                return $this->gotoLanguage('/' . $defaultLanguage->abbreviation . $this->request->getRequestTarget());
            }

            // try to find the request language in the database
            if ($requestLanguage = $this->Languages->findByAbbreviationAndActive($this->request->getParam('lang'), true)->first()) {

                // set language
                I18n::setLocale($requestLanguage->locale);
                $this->set('language', $requestLanguage);

                // request language is not found - redirect to the default language
            } else {
                return $this->gotoLanguage('/' . $defaultLanguage->abbreviation);
            }


        }

        return true;
    }

    /**
     * Check for a redirect
     */
    protected function checkRedirect()
    {
        $this->loadModel('Redirects');
        if ($redirect = $this->Redirects->find()->where(['from_url' => $this->request->getRequestTarget()])->first()) {
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
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') return true;

        $this->loadModel('Visitors');

        $browserData = $_SERVER;
        //$browserData['browser'] = get_browser();

        $v = $this->Visitors->newEntity([
            'ipaddress' => $_SERVER['REMOTE_ADDR'],
            'url' => $this->request->getRequestTarget(),
            'browser_data' => json_encode($browserData)
        ]);
        return $this->Visitors->save($v);
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
     * Get menu
     * Store in cache if found
     * @return mixed
     */
    protected function getMenu()
    {
        $menu = Cache::read('menu_' . I18n::getLocale());

        if ($menu !== false) {
            return $menu;
        } else {
            $this->loadModel('Pages');
            $menu = $this->Pages->find()->where(['menu', true])->contain(['ChildPages'])->toArray();
            $this->loadModel('Products');
            foreach ($menu as $k => $menuItem) {

                if ($menuItem->id == 2) { //products submenu
                    if ($products = $this->Products->find()->where(['online' => true])->toArray()) {
                        foreach ($products as $product) {
                            $product->slug = Router::url([
                                'controller' => 'Products',
                                'action' => 'view',
                                $product->slug,
                                'lang' => $this->request->getParam('lang')
                            ]);
                        }
                        $menu[$k]->child_pages = $products;
                    }

                    break;
                }

            }

            Cache::write('menu_' . I18n::getLocale(), $menu);

            return $menu;
        }

    }

    /**
     * Get settings
     * Store in cache if found
     * @return mixed
     */
    protected function getSettings()
    {
        $settings = Cache::read('settings_' . I18n::getLocale());

        if ($settings !== false) {
            return $settings;
        } else {
            $this->loadModel('Settings');
            $settings = $this->Settings->find('list', [
                'keyField' => 'title',
                'valueField' => 'value'
            ])->toArray();

            Cache::write('settings_' . I18n::getLocale(), $settings);
            return $settings;
        }
    }

    protected function getMaxFileUploadSize(): int
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = $this->parseSize(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = $this->parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size / 1024 / 1024;
    }

    protected function parseSize($size): int
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
}
