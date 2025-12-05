<?php
declare(strict_types=1);

namespace Bitcms\Controller;

use Bitcms\Controller\AppController;
use Cake\Cache\Cache;

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
        $pages = $this->fetchTable('Bitcms.Pages')->find()->orderByDesc('Pages.id')->limit(5);

        $dir = WWW_ROOT;
        // get the size of the directory
        $dirsize = $this->getDirectorySize($dir);

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

    /**
     * Calculate directory size recursively
     *
     * @param string $directory Directory path
     * @return int Size in bytes
     */
    private function getDirectorySize(string $directory): int
    {
        $size = 0;

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)) as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }

        return $size;
    }
}
