<?php
declare(strict_types=1);

namespace Bitcms\Controller;

use Bitcms\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Filesystem\Folder;

/**
 * Dashboard Controller
 */
class DashboardController extends AppController
{
    public function index()
    {
        $this->loadModel('Bitcms.Mails');
        $mails = $this->Mails->find()->count();

        $this->loadModel('Bitcms.Visitors');
        $visitors = $this->Visitors->find()->count();

        $this->loadModel('Bitcms.Images');
        $images = $this->Images->find()->count();

        $this->loadMOdel('Bitcms.Pages');
        $pages = $this->Pages->find()->order(['Pages.id' => 'desc'])->limit(5);

        $folder = new Folder(WWW_ROOT);
        $dirsize = $folder->dirsize();

        $this->set(compact('mails', 'visitors', 'images', 'pages', 'dirsize'));
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        Cache::clearAll();
        $this->Flash->success(__('Cache successfully cleared'), ['plugin' => 'Bitcms']);
        $this->redirect( $this->referer() );
    }
}
