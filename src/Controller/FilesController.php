<?php
namespace Bitcms\Controller;

use Bitcms\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Error\FatalErrorException;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \Bitcms\Model\Entity\File[] paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{

    public function edit( $id )
    {
        $this->viewBuilder()->setLayout('ajax');

        $file = $this->Files->findById($id)->first();

        if( $this->request->is(['put', 'post']) ){
            $this->Files->patchEntity($file, $this->request->getData());
            if( $this->Files->save($file) ){
                echo 'success';
            } else {
                throw new FatalErrorException(__('Could not save file'));
            }
        }

        $this->set('languages', $this->fetchTable('Bitcms.Languages')->find('list'));
        $this->set('file', $file);
    }

    /**
     * Delete file method
     *
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function delete( $id )
    {
        $this->request->allowMethod(['put', 'post']);

        if( $file = $this->Files->findById($id)->first() ){
            if( $this->Files->delete($file) ){
                $this->Flash->success(__('File removed'));
            } else {
                $this->Flash->error(__('Could not remove file'));
            }
        } else {
            $this->Flash->error(__('Could not find file'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Reload file overview
     * Ajax method
     */
    public function reloadOverview()
    {
        $this->request->allowMethod(['get', 'put', 'post']);
        $this->viewBuilder()->setLayout('ajax');

        // check for needed values
        if( !$this->request->getData('model') ){
            throw new FatalErrorException(__('Model not set'));
        }
        if( !$this->request->getData('entity_id') ){
            throw new FatalErrorException(__('Entity ID not set'));
        }

        $model = $this->request->getData('model');
        $entity_id = $this->request->getData('entity_id');

        $files = $this->Files->find()->where([
            'model' => $model,
            'entity_id' => $entity_id
        ])->contain(['Languages'])->toArray();

        $this->set(compact('files', 'model', 'entity_id'));
    }

    /**
     * Upload file method
     * Ajax post call
     */
    public function upload()
    {
        $this->autoRender = false;

        // check for needed values
        if( !$this->request->getData('model') ){
            throw new FatalErrorException(__('Model not set'));
        }
        if( !$this->request->getData('entity_id') ){
            throw new FatalErrorException(__('Entity ID not set'));
        }
        if( !$this->request->getData('file') ){
            throw new FatalErrorException(__('No file found!'));
        }

        $model      = $this->request->getData('model');
        $entity_id  = $this->request->getData('entity_id');
        $file       = $this->request->getData('file');

        // create correct dirs
        $filesFolder = new Folder(WWW_ROOT . DS . 'files', true, 0775);
        $modelFolder = new Folder(WWW_ROOT . DS . 'files' . DS . $model, true, 0775);

        // check if name already exist
        $name   = $file->getClientFilename();
        $ext    = pathinfo($name, PATHINFO_EXTENSION);
        while( file_exists( $modelFolder->path . DS . $name ) ){
            $nameWithoutExtension = str_replace('.'.$ext, '', $name);
            $name = $nameWithoutExtension . '_copy.' . $ext;
        }

        // upload file
        $file->moveTo($modelFolder->path . DS . $name);

        // add to database
        $position = $this->Files->find()->where(['model' => $model,  'entity_id' => $entity_id])->count();
        $file = $this->Files->newEntity([
            'model' => $model,
            'entity_id' => $entity_id,
            'filename' => $name,
            'position' => $position+1
        ]);
        if( $this->Files->save($file) ){
            echo json_encode( $file->toArray() );
        } else {
            throw new FatalErrorException(__('Could not add file to the database'));
        }

    }
}
