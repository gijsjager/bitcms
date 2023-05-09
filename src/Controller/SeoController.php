<?php

namespace Bitcms\Controller;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\FactoryLocator;
use Cake\Datasource\RepositoryInterface;
use Cake\I18n\I18n;
use Cake\ORM\Exception\MissingTableClassException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Seo controller
 */
class SeoController extends AppController
{
    public function index()
    {
        $images = $this->fetchTable('Bitcms.Images')->find()->where(['alt' => ''])->count();

        $models = $this->getSeoModels();
        $pages = 0;
        foreach($models as $model){
            $pages += $model->find()->where(['OR' => ['seo_title' => '', 'seo_description' => '']])->all()->count();
        }

        $this->set(compact('pages', 'images'));
    }

    public function images()
    {

        $table = $this->fetchTable('Bitcms.Images');
        if ($this->request->is(['post', 'put'])) {
            $entities = [];
            foreach ($this->request->getData('images') as $id => $data) {
                $img = $table->get($id);
                $table->patchEntity($img, $data);
                $entities[] = $img;
            }
            if ($table->saveMany($entities)) {
                $this->Flash->success(__('Images are updated'), ['plugin' => 'Bitcms']);
                $this->redirect(['action' => 'images', '?' => ['language' => $this->getRequest()->getQuery('language')]]);
            } else {
                $this->Flash->error(__('Could not save alt text'), ['plugin' => 'Bitcms']);
            }
        }
        $images = $table->find();
        $this->set('images', $images);

    }

    public function fillImageAltFromSeo()
    {
        $table = $this->fetchTable('Bitcms.Images');
        $images = $table->find();
        $stored = 0;
        foreach ($images as $img) {
            if ($img->alt === '' && !empty($img->origin)) {
                $img->alt = $img->origin->seo_title;
                $table->save($img);
                $stored++;
            }
        }
        $this->Flash->success(__('{0} image-alt has been updated!', [$stored]), ['plugin' => 'Bitcms']);
        return $this->redirect($this->referer());
    }

    public function pages()
    {

        $models = $this->getSeoModels();

        if ($this->request->is(['post', 'put'])) {
            foreach ($this->request->getData('models') as $model => $data) {

                $table = null;
                foreach($models as $m){
                    if($m->getAlias() === $model){
                        $table = $this->fetchTable($m->getRegistryAlias());
                        break;
                    }
                }

                if (!empty($table)){

                    $entities = [];
                    foreach($data as $id => $seo){
                        $page = $table->findById($id)->first();
                        $table->patchEntity($page, $seo);
                        $entities[] = $page;
                    }

                    if (!$table->saveMany($entities)) {
                        $this->Flash->error(__('Could not save alt text'), ['plugin' => 'Bitcms']);
                    }
                }
            }

            $this->Flash->success(__('Stored! Let\'s fire up that SEO!'));
            $this->redirect(['action' => 'pages', '?' => ['language' => $this->request->getQuery('language')]]);

        }

        $this->set('models', $models);
    }

    protected function getSeoModels(): array
    {
        $schema = ConnectionManager::get('default')->getSchemaCollection();
        $tables = $schema->listTables();
        $tablesWithSeo = [];
        foreach ($tables as $table) {
            $t = $schema->describe($table);
            if ($t->getColumn('seo_title')) {
                $tablesWithSeo[] = $t;
            }
        }

        $models = [];

        foreach ($tablesWithSeo as $table) {
            $model = null;
            // try custom model
            try {
                $model = $this->fetchTable(Inflector::camelize($table->name()));
            } catch (MissingTableClassException $exception) {
            }
            // try bitcms model
            if (empty($model)) {
                try {
                    $model = $this->fetchTable('Bitcms.' . Inflector::camelize($table->name()));
                } catch (MissingTableClassException $exception) {
                }
            }

            if ($model) {
                $models[] = $model;
            }

        }
        return $models;
    }
}
