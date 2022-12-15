<?php
declare(strict_types=1);

namespace Bitcms\Controller;

use App\Controller\AppController as BaseController;
use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Utility\Text;

class AppController extends BaseController
{
    public function initialize(): void
    {
        $this->loadHelpers();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginAction' => [
                'plugin' => 'Bitcms',
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false
            ],
            'authenticate' => [
                AuthComponent::ALL => ['userModel' => 'Bitcms.Users'],
                'Basic',
                'Form'
            ]
        ]);

        // get user
        if ($this->Auth->user('id')) {
            $this->authUser = $this->fetchTable('Bitcms.Users')->findById($this->Auth->user('id'))->first();
            $this->set('authUser', $this->authUser);
        }


        $this->set('isAuthorized', $this->isAuthorized($this->Auth->user()));
        $this->set('maxUploadSize', $this->getMaxFileUploadSize());
        $this->set('bitcms', $this->getConfig());
        $this->setLanguages();
        $this->viewBuilder()->setLayout('Bitcms.bitcms');
    }

    /**
     * Set language and possible languages
     * @return void
     */
    protected function setLanguages(): void
    {
        $defaultLanguage = $this->fetchTable('Bitcms.Languages')->find()->where(['is_default' => true])->first();
        Configure::write('App.defaultLocale', env('APP_DEFAULT_LOCALE', $defaultLanguage->locale));
        if ($this->request->getQuery('language')) {
            $language = $this->fetchTable('Bitcms.Languages')->find()->where(['abbreviation' => $this->request->getQuery('language')])->first();
        }
        if (empty($language)) {
            $language = $defaultLanguage;
        }
        $this->set('language', $language);
        $this->set('languages', $this->fetchTable('Bitcms.Languages')->find()->toArray());
        I18n::setLocale($language->locale);
    }


    /**
     * Is user authorized to visit action
     * @param $user
     * @return bool
     */
    public function isAuthorized($user): bool
    {
        // Any registered user can access public functions
        if (!$this->getRequest()->getParam('prefix')) {
            return true;
        }


        // Only admins can access admin functions
        if (!empty($user)) {
            return (bool)($user['role'] === 'admin');
        }

        // Default deny
        return false;
    }

    /**
     * Load needed helpers
     * @return void
     */
    protected function loadHelpers(): void
    {
        // Bootstrap helpers
        $this->viewBuilder()->addHelper('Breadcrumbs', [
            'className' => 'Bootstrap.Breadcrumbs',
        ]);
        $this->viewBuilder()->addHelper('Html', [
            'className' => 'Bootstrap.Html',
            'buttons' => ['type' => 'primary'],
        ]);
        $this->viewBuilder()->addHelper('Form', [
            'className' => 'Bootstrap.Form',
            'buttons' => ['type' => 'primary'],
            'templates' => [
                'inputContainer' => '<div class="form-group {{attrs}}{{type}}{{required}}">{{content}}</div>',
                'checkboxWrapper' => '<div class="custom-control custom-checkbox ">{{label}}</div>',
                'checkboxContainer' => '<div class="custom-control custom-checkbox {{required}}">{{content}}</div>',
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}><span class="custom-control-indicator custom-control-color"></span>',
                'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>'],
        ]);

        $this->viewBuilder()->addHelper('Paginator', ['templates' => 'Bitcms.paginator-templates']);

        $this->viewBuilder()->addHelper('Time');
        $this->viewBuilder()->addHelper('Bitcms.Content');
    }

    /**
     * Get max file upload size
     * @return float
     */
    protected function getMaxFileUploadSize(): float
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

    /**
     * Parse a size to a readable amount
     * @param string $size size as int
     * @return float
     */
    protected function parseSize(string $size): float
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

    /**
     * Get BitCMS config
     * @return array
     */
    public function getConfig(): array
    {
        if (file_exists(CONFIG . 'bitcms.php')){
            return include_once CONFIG . 'bitcms.php';
        } else {
            return [];
        }

    }
}
