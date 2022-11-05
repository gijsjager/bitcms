<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Static content controller
 * This controller will render views from Template/Pages/
 */
class PagesController extends AppController
{

    /**
     * View method
     */
    public function view($slug = '')
    {


        $page = $this->Pages->find()->where([
            $this->Pages->translationField('slug') => $slug,
            'online' => 1
        ])->contain([
            'BlockGroups' => [
                'Blocks' => ['Images']
            ]
        ]);


        // 404 page
        if ($page->isEmpty()) {
            return $this->redirect([
                'lang' => $this->request->getParam('lang'),
                'action' => 'notfound',
                'url' => $this->request->getRequestTarget()
            ]);
        }

        $page = $page->first();

        $this->set('page', $page);
        $this->set('seo_title', (!empty($page->seo_title)) ? $page->seo_title : $page->title);
        $this->set('seo_description', $page->seo_description);
    }

    public function notfound()
    {
        $url = $this->request->getQuery('url');
        $this->set('url', $url);
        $this->set('seo_title', __('Page not found'));
        http_response_code(404);
    }
}
