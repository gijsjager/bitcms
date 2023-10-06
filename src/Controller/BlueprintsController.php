<?php

namespace Bitcms\Controller;

use Cake\Core\Plugin;

/**
 * Blueprints Controller
 *
 * @property \Bitcms\Model\Table\BlueprintsTable $Blueprints
 */
class BlueprintsController extends AppController
{
    /**
     * Index method
     * @return \Cake\Http\Response|void|null
     */
    public function index()
    {
        $blueprints = $this->Blueprints->find()->order('title');
        $blueprint = $this->Blueprints->newEmptyEntity();

        if ($this->request->getQuery('q')) {
            $blueprints->where(['title LIKE' => '%' . h($this->request->getQuery('k')) . '%']);
        }
        if ($this->request->is('post')) {
            $this->Blueprints->patchEntity($blueprint, $this->request->getData());

            // set default icon
            $blueprint->icon = 'server';

            if ($this->Blueprints->save($blueprint)) {
                $this->Flash->success(__('Blueprint saved!'), ['plugin' => 'Bitcms']);
                return $this->redirect(['action' => 'edit', $blueprint->id]);
            }
            $this->Flash->error(__('Something went wrong.'), ['plugin' => 'Bitcms']);
        }

        $this->set('blueprints', $this->paginate($blueprints));
        $this->set('blueprint', $blueprint);
    }

    /**
     * Edit method
     * @param $id
     * @return \Cake\Http\Response|void|null
     */
    public function edit($id = null)
    {
        $blueprint = $this->Blueprints->find()
            ->contain(['BlueprintFields'])
            ->where(['Blueprints.id' => $id])->firstOrFail();

        if ($this->request->is('put')) {
            $this->Blueprints->patchEntity($blueprint, $this->request->getData());
            if ($this->Blueprints->save($blueprint)) {
                $this->Flash->success(__('Blueprint saved!'), ['plugin' => 'Bitcms']);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Something went wrong.'), ['plugin' => 'Bitcms']);
        }

        $this->set('blueprint', $blueprint);
        $this->set('icons', $this->getIcons());
    }

    /**
     * Delete method
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $blueprint = $this->Blueprints->find()->where(['id' => $id])->firstOrFail();
        if ($this->request->is('post')) {
            if ($this->Blueprints->delete($blueprint)) {
                $this->Flash->success(__('Blueprint deleted!'), ['plugin' => 'Bitcms']);
            } else {
                $this->Flash->error(__('Something went wrong.'), ['plugin' => 'Bitcms']);
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Get list of icons
     * based on the stroke 7 icon set within the Bitcms theme
     * @return array
     */
    public function getIcons()
    {
        $selection = json_decode(file_get_contents(Plugin::path('Bitcms') . 'webroot' . DS . 'lib' . DS . 'stroke-7' . DS . 'selection.json'));
        $icons = [];
        foreach ($selection->icons as $icon) {
            $icons[$icon->properties->name] = $icon->properties->name;
        }
        asort($icons);
        return $icons;

    }

    /**
     * Render new blueprint field set
     * @return void
     */
    public function getNewField()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->render('element/Blueprints/field');
    }
}