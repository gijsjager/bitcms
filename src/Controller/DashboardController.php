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
        $mails = $this->fetchTable('Bitcms.Mails')->find()->count();
        $visitors = $this->fetchTable('Bitcms.Visitors')->find()->count();
        $images = $this->fetchTable('Bitcms.Images')->find()->count();
        $pages = $this->fetchTable('Bitcms.Pages')->find()->order(['Pages.id' => 'desc'])->limit(5);

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
