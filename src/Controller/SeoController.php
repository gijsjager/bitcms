<?php
namespace Bitcms\Controller;

/**
 * Seo controller
 */
class SeoController extends AppController
{
    public function index()
    {
        $images = $this->fetchTable('Bitcms.Images')->find()->where(['alt' => ''])->count();
        $pages = $this->fetchTable('Bitcms.Pages')->find()->where(['OR' => ['seo_title' => '', 'seo_description' => '']])->count();
        $this->set(compact('pages', 'images'));
    }

    public function images()
    {

        $table = $this->fetchTable('Bitcms.Images');
        if ($this->request->is(['post', 'put'])) {
            $entities = [];
            foreach($this->request->getData('images') as $id => $data){
                $img = $table->get($id);
                $table->patchEntity($img, $data);
                $entities[] = $img;
            }
            if ($table->saveMany($entities) ){
                $this->Flash->success(__('Images are updated'), ['plugin' => 'Bitcms']);
                $this->redirect(['action' => 'images']);
            } else {
                $this->Flash->error(__('Could not save alt text'), ['plugin' => 'Bitcms']);
            }
        }
        $images = $table->find();
        $this->set('images', $images);

    }

    public function pages()
    {
        $table = $this->fetchTable('Bitcms.Pages');
        if ($this->request->is(['post', 'put'])) {
            $entities = [];
            foreach($this->request->getData('pages') as $id => $data){
                $page = $table->get($id);
                $table->patchEntity($page, $data);
                $entities[] = $page;
            }
            if ($table->saveMany($entities) ){
                $this->Flash->success(__('Pages are updated'), ['plugin' => 'Bitcms']);
                $this->redirect(['action' => 'pages']);
            } else {
                $this->Flash->error(__('Could not save alt text'), ['plugin' => 'Bitcms']);
            }
        }
        $pages = $table->find();
        $this->set('pages', $pages);
    }
}
