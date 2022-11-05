<?php
namespace App\Controller\Bitcms;

use App\Controller\AppController;

/**
 * Redirects Controller
 *
 * @property \App\Model\Table\RedirectsTable $Redirects
 *
 * @method \App\Model\Entity\Redirect[] paginate($object = null, array $settings = [])
 */
class RedirectsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $redirects = $this->paginate($this->Redirects);

        $this->set(compact('redirects'));
        $this->set('_serialize', ['redirects']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $redirect = $this->Redirects->newEntity();
        if ($this->request->is('post')) {
            $redirect = $this->Redirects->patchEntity($redirect, $this->request->getData());
            if ($this->Redirects->save($redirect)) {
                $this->Flash->success(__('The redirect has been saved.'));

                return $this->redirect(['controller' => 'Settings', 'action' => 'index']);
            }
            $this->Flash->error(__('The redirect could not be saved. Please, try again.'));
        }
        $this->set(compact('redirect'));
        $this->set('_serialize', ['redirect']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Redirect id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $redirect = $this->Redirects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $redirect = $this->Redirects->patchEntity($redirect, $this->request->getData());
            if ($this->Redirects->save($redirect)) {
                $this->Flash->success(__('The redirect has been saved.'));

                return $this->redirect(['controller' => 'Settings', 'action' => 'index']);
            }
            $this->Flash->error(__('The redirect could not be saved. Please, try again.'));
        }
        $this->set(compact('redirect'));
        $this->set('_serialize', ['redirect']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Redirect id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $redirect = $this->Redirects->get($id);
        if ($this->Redirects->delete($redirect)) {
            $this->Flash->success(__('The redirect has been deleted.'));
        } else {
            $this->Flash->error(__('The redirect could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Settings', 'action' => 'index']);
    }
}
