<?php
namespace App\Controller\Bitcms;

use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[] paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $where = [];
        if( $this->request->getQuery('q') ){
            $where['OR'] = [
                'title LIKE' => '%'.$this->request->getQuery('q').'%',
                'slug LIKE' => '%'.$this->request->getQuery('q').'%',
            ];
        }

        $items = $this->Items->find()->where($where)->contain(['Images'])->toArray();
        $newItem = $this->Items->newEntity();

        if( $this->request->is(['post', 'put']) ){

            $this->Items->patchEntity($newItem, $this->request->getData());
            $newItem->slug = Text::slug(strtolower(trim($newItem->title)));

            $newItem->position = $this->Items->find()->count() + 1;

            // check if slug exists
            while( !$this->Items->findBySlug($newItem->slug)->isEmpty() ){
                $newItem->slug = $newItem->slug . '-copy';
            }

            if( $this->Items->save($newItem) ){
                $this->Flash->success(__('Item added'));
            } else {
                $errorString = __('Could not add item.<br/>');
                $errors = $newItem->getErrors();
                foreach($errors as $field => $error){
                    $errorString .= __('Error: field "{0}" - {1}', [$field, reset($error)]) . '<br/>';
                }

                $this->Flash->error($errorString, ['escape' => false]);
            }
            return $this->redirect( $this->referer() );
        }

        $this->set(compact('category', 'items', 'newItem'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Images']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $item = $this->Items->patchEntity($item, $this->request->getData());
            $item->setDirty('slug', true);

            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $this->set(compact('item'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Update position
     * Ajax method
     */
    public function updatePosition()
    {
        $this->autoRender = false;
        if( $items = $this->request->getData('items') ){
            foreach($items as $position => $item){
                $itemId = preg_replace("/([^0-9]+)/", "", $item);
                if( $item = $this->Items->findById($itemId)->first() ){
                    $item->position = $position;
                    $this->Items->save($item);
                }
            }
        }
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

        return $this->redirect( $this->referer() );
    }
}
