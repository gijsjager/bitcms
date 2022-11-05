<?php
namespace App\Controller\Bitcms;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Cache\Cache;


/**
 * Dashboard Controller
 */
class DashboardController extends AppController
{
    public function index()
    {
        $this->loadModel('Mails');
        $mails = $this->Mails->find()->count();

        $this->loadModel('Visitors');
        $visitors = $this->Visitors->find()->count();

        $this->loadModel('Images');
        $images = $this->Images->find()->count();

        $this->loadMOdel('Pages');
        $pages = $this->Pages->find()->order(['id' => 'desc'])->limit(5);

        $folder = new Folder(WWW_ROOT);
        $dirsize = $folder->dirsize();


        $this->set(compact('mails', 'visitors', 'images', 'pages', 'dirsize'));
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        Cache::clear(false);
        $this->Flash->success(__('Cache successfully cleared'));
        $this->redirect( $this->referer() );
    }
}