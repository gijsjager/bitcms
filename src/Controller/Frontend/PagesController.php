<?php
namespace Bitcms\Controller\Frontend;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class PagesController extends AppController
{
    /**
     * @param $slug
     * @return \Cake\Http\Response|void|null
     */
    public function view($slug)
    {
        $table = $this->fetchTable('Bitcms.Pages');

        $page = $table->find()->where([
            $table->translationField('slug') => $slug,
            'online' => 1
        ])->contain([
            'BlockGroups' => [
                'Blocks' => ['Images']
            ]
        ]);

        // 404 page
        if ($page->all()->isEmpty()) {
            return $this->redirect([
                'lang' => $this->getRequest()->getParam('lang'),
                'action' => 'notfound',
                '?' => ['url' => $this->getRequest()->getRequestTarget()]
            ]);
        }

        $page = $page->first();

        $this->set('page', $page);
        $this->set('seo_title', (!empty($page->seo_title)) ? $page->seo_title : $page->title);
        $this->set('seo_description', $page->seo_description);

        $this->viewBuilder()->addHelper('Bitcms.Content');

        try {
            $this->render('view');
        } catch(MissingTemplateException $e){
            $this->render('Bitcms.view');
        }
    }

    /**
     * Not found page
     * @return void
     */
    public function notfound()
    {
        $url = $this->request->getQuery('url');
        $this->set('url', $url);
        $this->set('seo_title', __('Page not found'));
        http_response_code(404);
    }
}
