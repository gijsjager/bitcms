<?php

namespace Bitcms\Controller;

use Bitcms\Model\Entity\Blueprint;
use Bitcms\Model\Entity\Item;
use Cake\Utility\Text;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \Bitcms\Model\Entity\Item[] paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($blueprint = null)
    {
        // fetch blueprint
        $blueprint = $this->Items->Blueprints->findById($blueprint)
            ->contain(['BlueprintFields'])
            ->firstOrFail();

        $where = [
            'blueprint_id' => $blueprint->id
        ];
        if ($this->request->getQuery('q')) {
            $where['OR'] = [
                'title LIKE' => '%' . $this->request->getQuery('q') . '%',
                'slug LIKE' => '%' . $this->request->getQuery('q') . '%',
            ];
        }

        $items = $this->Items->find()->where($where)->order(['position' => 'ASC']);
        $newItem = $this->Items->newEmptyEntity();

        if ($this->request->is('post')) {
            $this->create($newItem, $blueprint);
            return $this->redirect(['action' => 'edit', $newItem->id]);
        }

        $this->set('items', $this->paginate($items));
        $this->set(compact('newItem', 'blueprint'));
    }


    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => [
                'ItemFields' => [
                    'BlueprintFields',
                    'Items',
                    'Images',
                    'Files'
                ]
            ]
        ]);

        // get blueprint
        $blueprint = $this->Items->Blueprints->get($item->blueprint_id, [
            'contain' => ['BlueprintFields']
        ]);


        if ($this->request->is('put')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());

            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index', $blueprint->id]);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }

        $this->set('item', $item);
        $this->set('blueprint', $blueprint);

    }


    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Create new item
     * @param Item $item
     * @param Blueprint $blueprint
     * @return void
     */
    protected function create(Item &$item, Blueprint $blueprint)
    {
        $postData = $this->getRequest()->getData();

        // make sure blueprint fields are added too as default
        foreach ($blueprint->blueprint_fields as $blueprint_field) {
            $postData['item_fields'][] = [
                'blueprint_field_id' => $blueprint_field->id,
                'handle' => $blueprint_field->handle,
                'value' => ''
            ];
        }

        $this->Items->patchEntity($item, $postData);
        $item->slug = Text::slug(strtolower(trim($item->title)));
        $item->position = $this->Items->find()->count() + 1;


        // check if slug exists
        $key = 1;
        while (!$this->Items->findBySlug($item->slug)->all()->isEmpty()) {
            $item->slug = $item->slug . '-' . $key;
            $key++;
        }

        if ($this->Items->save($item)) {
            $this->Flash->success(__('Item added'));
        } else {
            $errorString = __('Could not add item.<br/>');
            $errors = $item->getErrors();
            foreach ($errors as $field => $error) {
                $errorString .= __('Error: field "{0}" - {1}', [$field, reset($error)]) . '<br/>';
            }

            $this->Flash->error($errorString, ['escape' => false]);
        }
    }
}
