<?php
namespace Bitcms\Controller;

use Bitcms\Controller\AppController;

/**
 * BlockGroups Controller
 *
 * @property \App\Model\Table\BlockGroupsTable $BlockGroups
 *
 * @method \Bitcms\Model\Entity\BlockGroup[] paginate($object = null, array $settings = [])
 */
class BlockGroupsController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $blockGroup = $this->BlockGroups->newEntity([]);
        if ($this->request->is('post')) {
            $blockGroup = $this->BlockGroups->patchEntity($blockGroup, $this->request->getData());
            if ($this->BlockGroups->save($blockGroup)) {
                $this->Flash->success(__('The block group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The block group could not be saved. Please, try again.'));
        }
        $this->set(compact('blockGroup'));
        $this->set('_serialize', ['blockGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Block Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $blockGroup = $this->BlockGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $blockGroup = $this->BlockGroups->patchEntity($blockGroup, $this->request->getData());
            if ($this->BlockGroups->save($blockGroup)) {
                $this->Flash->success(__('The block group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The block group could not be saved. Please, try again.'));
        }
        $this->set(compact('blockGroup'));
        $this->set('_serialize', ['blockGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Block Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $blockGroup = $this->BlockGroups->get($id);
        if ($this->BlockGroups->delete($blockGroup)) {
            if($this->getRequest()->is('ajax')){
                die('success');
            } else {
                $this->Flash->success(__('The block group has been deleted.'));
            }
        } else {
            if($this->getRequest()->is('ajax')){
                die('error');
            } else {
                $this->Flash->error(__('The block group could not be deleted. Please, try again.'));
            }

        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Ajax get add form
     */
    public function addForm()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->set('id', $this->request->getData('id'));
        $this->set('model', $this->request->getData('model'));
    }
    public function addFormBlocks()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->set('id', $this->request->getData('id'));
        $this->set('amount_blocks', $this->request->getData('amount_blocks') + 1);
    }
}
