<?php
namespace Bitcms\Controller;

use Bitcms\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Utility\Text;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 *
 * @method \Bitcms\Model\Entity\Page[] paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentPages']
        ];
        $pages = $this->Pages->find()->where(['parent_id IS NULL'])->contain(['ChildPages']);
        $pagesList = $this->Pages->find('list');

        $newPage = $this->Pages->newEmptyEntity();

        if( $this->request->is(['post', 'put']) ){

            $this->Pages->patchEntity($newPage, $this->request->getData());
            $newPage->slug = Text::slug(strtolower(trim($newPage->title)));

            $where = ['parent_id IS NULL'];
            if( $this->request->getData('parent_id') != '' ){
                $where = ['parent_id' => $this->request->getData('parent_id')];
            }
            $newPage->position = $this->Pages->find()->where($where)->count() + 1;

            // check if slug exists
            while( !$this->Pages->findBySlug($newPage->slug)->all()->isEmpty() ){
                $newPage->slug = $newPage->slug . '-copy';
            }

            if( $this->Pages->save($newPage) ){
                $this->Flash->success(__('Page added'));
            } else {
                $errorString = __('Could not add page.<br/>');
                $errors = $newPage->getErrors();
                foreach($errors as $field => $error){
                    $errorString .= __('Error: field "{0}" - {1}', [$field, reset($error)]) . '<br/>';
                }

                $this->Flash->error($errorString, ['escape' => false]);
            }
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->getQuery('q')) {
            $pages->where(['OR' => [
                'Pages.title LIKE' => '%'.$this->request->getQuery('q').'%',
                'Pages.slug LIKE' => '%'.$this->request->getQuery('q').'%',
            ]]);
        }

        $this->set(compact('pages', 'newPage', 'pagesList'));
        $this->set('_serialize', ['pages']);
    }

    /**
     * Save new positions
     * Ajax method
     */
    public function savePositions()
    {
        $this->request->allowMethod(['put', 'post']);
        $this->autoRender = false;

        if( $this->request->getData('positions') ){
            $positions = $this->request->getData('positions');
            foreach( $positions as $position => $item ){
                if( $page = $this->Pages->findById( $item['id'] )->first() ){
                    $page->position = $position;
                    $page->parent_id = null;
                    $this->Pages->save($page);
                }
                if( !empty($item['children']) ){
                    foreach( $item['children'] as $childPosition=>$child ){
                        if( $page = $this->Pages->findById( $child['id'] )->first() ){
                            $page->position = $childPosition;
                            $page->parent_id = $item['id'];
                            $this->Pages->save($page);
                        }
                    }
                }

            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => [
                'BlockGroups' => [
                    'Blocks' => ['Images']
                ]
            ]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->getData(), [
                'associated' => ['BlockGroups', 'BlockGroups.Blocks']
            ]);

            $page->setDirty('slug', true);

            if ($this->Pages->save($page)) {

                // save blocks too
                if( $this->request->getData('blocks') ){
                    $this->saveBlocks( $this->request->getData('blocks') );
                }

                Cache::clearAll();
                $this->Flash->success(__('The page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The page could not be saved. Please, try again.'));
        }
        $parentPages = $this->Pages->ParentPages->find('list', ['limit' => 200]);
        $this->set(compact('page', 'parentPages'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('The page has been deleted.'));
        } else {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Save page blocks method
     *
     * @param $blocks (post array)
     * @return bool
     */
    protected function saveBlocks( $blocks )
    {
        if( empty($blocks) ) return false;

        foreach($blocks as $blockGroupId=>$blockGroup){

            if( $blockGroupEntity = $this->Pages->BlockGroups->findById($blockGroupId)->first() ){
                $cloneBlockGroup = $blockGroup;
                unset($cloneBlockGroup['blocks']);
                $this->Pages->BlockGroups->patchEntity($blockGroupEntity, $cloneBlockGroup, ['validate' => false, 'associated' => []]);
                $this->Pages->BlockGroups->save($blockGroupEntity);
            }

            if( !empty($blockGroup['blocks']) ){
                foreach($blockGroup['blocks'] as $blockId=>$block){
                    if( $blockEntity = $this->Pages->BlockGroups->Blocks->findById($blockId)->first() ){
                        if( isset($block['class']) ){
                            $blockEntity->class = (!empty($block['class'])) ? $block['class'] : '';
                        }
                        $blockEntity->content = (!empty($block['content'])) ? $block['content'] : '';
                        $this->Pages->BlockGroups->Blocks->save($blockEntity);
                    }
                }
            }
        }

        return true;
    }
}
