<?php

namespace Bitcms\Controller\Frontend;

use App\Controller\AppController;
use Cake\View\Exception\MissingTemplateException;

/**
 * Items Controller
 * Display items for front-end
 */
class ItemsController extends AppController
{
    /**
     * @param $slug
     * @return \Cake\Http\Response|void|null
     */
    public function view($slug = '', $blueprint = null)
    {
        $itemsTable = $this->fetchTable('Bitcms.Items');
        $blueprintTable = $this->fetchTable('Bitcms.Blueprints');

        $blueprint = $blueprintTable->find()->where([
            $blueprintTable->translationField('slug') => $blueprint
        ])->first();

        $item = $itemsTable->find()->where([
            $itemsTable->translationField('slug') => $slug,
            'blueprint_id' => $blueprint->id,
            'online' => 1
        ])->contain([
            'ItemFields' => [
                'Images',
                'Files',
                'Items',
            ]
        ]);

        // 404 page
        if ($item->all()->isEmpty()) {
            return $this->redirect([
                'lang' => $this->getRequest()->getParam('lang'),
                'controller' => 'Pages',
                'action' => 'notfound',
                '?' => ['url' => $this->getRequest()->getRequestTarget()]
            ]);
        }

        $item = $item->first();

        $this->set('item', $item);
        $this->set('seo_title', (!empty($item->seo_title)) ? $item->seo_title : $item->title);
        $this->set('seo_description', $item->seo_description);

        $this->viewBuilder()->addHelper('Bitcms.Content');

        try {
            $this->render('view');
        } catch (MissingTemplateException $e) {
            $this->render('Bitcms.view');
        }
    }
}
