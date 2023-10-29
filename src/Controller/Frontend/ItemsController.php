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

        $blueprint = $blueprintTable->find()->where(['handle' => $blueprint])->first();

        $item = $itemsTable->find()->where([
            'OR' => [
                $itemsTable->translationField('slug') => $slug,
                'slug' => $slug,
            ],
            'blueprint_id' => $blueprint->id,
            'online' => 1
        ])->contain([
            'ItemFields' => [
                'Images',
                'Files',
                'Items',
            ]
        ])->first();


        // 404 page
        if (empty($item)) {
            return $this->redirect([
                'lang' => $this->getRequest()->getParam('lang'),
                'controller' => 'Pages',
                'action' => 'notfound',
                '?' => ['url' => $this->getRequest()->getRequestTarget()]
            ]);
        }

        $this->set('item', $item);
        $this->set('seo_title', (!empty($item->seo_title)) ? $item->seo_title : $item->title);
        $this->set('seo_description', $item->seo_description);

        $this->viewBuilder()->addHelper('Bitcms.Content');

        try {
            $this->render($blueprint->handle);
        } catch (MissingTemplateException $e) {
            die('Template not found: Items/' . $blueprint->handle);
        }
    }
}
