<?php

namespace Bitcms\Controller;

use Cake\Error\FatalErrorException;
use Cake\Routing\Router;
use Cake\Utility\Filesystem;
use Laminas\Diactoros\UploadedFile;

/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 *
 * @method \Bitcms\Model\Entity\Image[] paginate($object = null, array $settings = [])
 */
class ImagesController extends AppController
{

    public $_paginate = [
        'limit' => 36
    ];

    /**
     * Index method
     */
    public function index()
    {
        $images = $this->Images->find();
        if ($this->request->getQuery('q')) {
            $images->where(['OR' => [
                'filename LIKE' => '%' . $this->request->getQuery('q') . '%',
                'title LIKE' => '%' . $this->request->getQuery('q') . '%',
            ]]);
        }
        $images->orderBy(['Images.id' => 'desc']);

        $this->set('images', $this->paginate($images));
    }

    /**
     * Edit method
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function edit($id)
    {
        $image = $this->Images->findById($id)->contain('ImageResponsive')->first();

        if ($this->request->is(['put', 'post'])) {
            $this->Images->patchEntity($image, $this->request->getData());
            if ($this->Images->save($image)) {
                $this->Flash->success(__('Image saved'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->success(__('Could not save image'));
            }
        }

        $this->set('languagesList', $this->fetchTable('Bitcms.Languages')->find('list'));
        $this->set('image', $image);
    }

    /**
     * Delete image method
     *
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function delete($id)
    {
        $this->request->allowMethod(['put', 'post']);

        if ($image = $this->Images->findById($id)->first()) {
            if ($this->Images->delete($image)) {
                $this->Flash->success(__('Image removed'));
            } else {
                $this->Flash->error(__('Could not remove image'));
            }
        } else {
            $this->Flash->error(__('Could not find image'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete a responsive image
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function deleteResponsive($id)
    {
        $image = $this->Images->ImageResponsive->findById($id)->first();
        if (!empty($image)) {
            $this->Images->ImageResponsive->delete($image);
            $this->Flash->success(__('Adaptive image deleted'));
        } else {
            $this->Flash->error(__('Could not find image'));
        }

        return $this->redirect($this->referer());

    }

    /**
     * Set a responsive image
     * @param string $type
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function responsive($type = 'mobile', $id = null)
    {
        if ($id == null) {
            $this->Flash->error(__('No ID found!'));
            return $this->redirect($this->referer());
        }

        $image = $this->Images->findById($id)->contain(['ImageResponsive'])->first();

        if ($this->request->is(['put', 'post'])) {

            // create dir
            $filesystem = new Filesystem();
            $dir = WWW_ROOT . 'files/' . $image->model . '/responsive/' . $type;
            $filesystem->mkdir($dir, 0775);
            if ($dir) {
                $imagePart = explode(',', $this->request->getData('image'));
                $file = new File($dir . DS . $image->filename, true);
                $file->write(base64_decode($imagePart[1]));
                $file->close();

                $this->createNextGen($image->model, $image->filename, $type);

                // clear prev
                $this->Images->ImageResponsive->deleteAll([
                    'image_id' => $id,
                    'type' => $type
                ]);

                // save to db
                $entity = $this->Images->ImageResponsive->newEntity([
                    'image_id' => $id,
                    'filename' => $image->filename,
                    'type' => $type,
                    'model' => $image->model
                ]);
                if ($this->Images->ImageResponsive->save($entity)) {
                    $this->Flash->success(__('Adaptive image saved for {0}', [$type]));
                    return $this->redirect(['action' => 'edit', $id]);
                } else {
                    $this->Flash->error(__('Could not save adaptive image'));
                }
            }
        }

        $this->set(compact('image', 'type'));
    }

    /**
     * Update position
     */
    public function updatePosition()
    {
        $this->autoRender = false;
        if ($items = $this->request->getData('items')) {
            foreach ($items as $position => $item) {
                $itemId = preg_replace("/([^0-9]+)/", "", $item);
                if ($item = $this->Images->findById($itemId)->first()) {
                    $item->position = $position;
                    $this->Images->save($item);
                }
            }
        }
    }


    /**
     * Reload image overview
     * Ajax method
     */
    public function reloadOverview()
    {
        $this->request->allowMethod(['get', 'put', 'post']);
        $this->viewBuilder()->setLayout('ajax');

        // check for needed values
        if (!$this->request->getData('model')) {
            throw new FatalErrorException(__('Model not set'));
        }
        if (!$this->request->getData('entity_id')) {
            throw new FatalErrorException(__('Entity ID not set'));
        }

        $model = $this->request->getData('model');
        $entity_id = $this->request->getData('entity_id');

        $images = $this->Images->find()->where([
            'Images.model' => $model,
            'Images.entity_id' => $entity_id
        ])->toArray();

        $this->set(compact('images', 'model', 'entity_id'));
    }

    /**
     * Upload image method
     * Ajax post call
     */
    public function upload()
    {
        $this->autoRender = false;

        // check for needed values
        if (!$this->request->getData('model')) {
            throw new FatalErrorException(__('Model not set'));
        }
        if (!$this->request->getData('entity_id')) {
            throw new FatalErrorException(__('Entity ID not set'));
        }
        if (!$this->request->getData('file')) {
            throw new FatalErrorException(__('No file found!'));
        }

        $model = $this->request->getData('model');
        $entity_id = $this->request->getData('entity_id');
        $file = $this->request->getData('file');

        // create correct dirs
        $filesystem = new Filesystem();
        $filesFolder = WWW_ROOT . DS . 'files';
        $modelFolder = WWW_ROOT . DS . 'files' . DS . $model;
        $filesystem->mkdir($filesFolder, 0775);
        $filesystem->mkdir($modelFolder, 0775);

        // check if name already exist
        $name = $file->getClientFilename();
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        while (file_exists($modelFolder . DS . $name)) {
            $nameWithoutExtension = str_replace('.' . $ext, '', $name);
            $name = $nameWithoutExtension . '_copy.' . $ext;
        }

        // upload file
        $file->moveTo($modelFolder . DS . $name);

        // optimize image
        $imageSize = filesize($modelFolder . DS . $name);
        if (($imageSize / 1048576) > 1) {
            $imageLibrary = new \Zebra_Image();
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['jpg', 'jpeg'])) {
                $imageLibrary->jpeg_quality = 60;
            }
            $imageLibrary->preserve_aspect_ratio = true;
            $imageLibrary->enlarge_smaller_images = true;
            $imageLibrary->preserve_time = true;
            $imageLibrary->auto_handle_exif_orientation = true;
            $imageLibrary->source_path = $modelFolder . DS . $name;
            $imageLibrary->target_path = $modelFolder . DS . $name;
            $imageLibrary->resize(2000, 2000, ZEBRA_IMAGE_NOT_BOXED);
        }

        $this->createNextGen($model, $name);
        $this->createThumbnail($model, $name);

        // add to database
        $position = $this->Images->find()->where(['Images.model' => $model, 'Images.entity_id' => $entity_id])->count();
        $image = $this->Images->newEntity([
            'model' => $model,
            'entity_id' => $entity_id,
            'filename' => $name,
            'meta' => $ext === 'jpg' ? exif_read_data(WWW_ROOT . 'files' . DS . $model . DS . $name) : '',
            'position' => $position + 1
        ]);
        if ($this->Images->save($image)) {
            echo json_encode($image->toArray());
        } else {
            throw new FatalErrorException(__('Could not add image to the database'));
        }

    }

    /**
     * @param $model
     * @param $name
     * @return bool
     */
    protected function createThumbnail($model, $name): bool
    {
        $fileSystem = new Filesystem();
        $thumbDir = WWW_ROOT . 'files' . DS . $model . DS . 'thumbnails';
        $fileSystem->mkdir($thumbDir, 0775);

        $imageLibrary = new \Zebra_Image();
        $imageLibrary->auto_handle_exif_orientation = true;
        $imageLibrary->source_path = WWW_ROOT . DS . 'files' . DS . $model . DS . $name;
        $imageLibrary->target_path = $thumbDir . DS . $name;
        return $imageLibrary->resize(200, 200, ZEBRA_IMAGE_CROP_CENTER);
    }

    /**
     * Create next gen image
     * @param string $model
     * @param string $name
     * @return bool
     */
    protected function createNextGen(string $model, string $name, string $responsive = ''): bool
    {
        $fileSystem = new Filesystem();

        if (!empty($responsive)) {
            $dir = WWW_ROOT . 'files' . DS . $model . DS . 'responsive' . DS . $responsive . DS . 'webp';
            $fileSystem->mkdir($dir, 0775);
        } else {
            $dir = WWW_ROOT . 'files' . DS . $model . DS . 'webp';
            $fileSystem->mkdir($dir, 0775);
        }

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $nextGen = str_replace('.' . $ext, '.webp', $name);

        $imageLibrary = new \Zebra_Image();
        $imageLibrary->auto_handle_exif_orientation = true;
        $imageLibrary->source_path = WWW_ROOT . DS . 'files' . DS . $model . DS . $name;
        $imageLibrary->target_path = $dir . DS . $nextGen;
        $imageLibrary->webp_quality = 80;
        return $imageLibrary->resize();
    }

    /**
     * Crop image
     *
     * @param $id
     */
    public function crop($id)
    {
        $fileSystem = new Filesystem();
        $this->autoRender = false;
        $image = $this->Images->findById($id)->first();

        // move file to original directory if it doesn't exist yet
        if (!is_dir(WWW_ROOT . DS . 'files' . DS . $image->model . DS . 'original')) {
            $folder = WWW_ROOT . DS . 'files' . DS . $image->model . DS . 'original';
            $fileSystem->mkdir($folder, 0775);
        }
        if (!is_file(WWW_ROOT . DS . 'files' . DS . $image->model . DS . 'original' . DS . $image->filename)) {
            copy(WWW_ROOT . DS . 'files' . DS . $image->model . DS . $image->filename, $folder . DS . $image->filename);
        }

        $croppedImage = $this->request->getData('croppedImage');

        $croppedImage->moveTo(WWW_ROOT . DS . 'files' . DS . $image->model . DS . $image->filename);

        $this->createNextGen($image->model, $image->filename);

        $this->Flash->success(__('Image cropped successfully'));
    }

    /**
     * Upload inline editor image
     * @return \Cake\Http\Response
     */
    public function inlineUpload()
    {

        $content = [];

        // upload file
        if ($this->request->getData("file")) {

            /** @var UploadedFile $file */
            $file = $this->request->getData('file');
            $name = $file->getClientFilename();

            $dir = WWW_ROOT . 'files' . DS . 'Inline';
            if (!is_dir($dir)) {
                mkdir($dir, 755);
            }


            $file->moveTo($dir . DS . $name);

            // resize image
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $nextGen = str_replace('.' . $ext, '.webp', $name);

            $imageLibrary = new \Zebra_Image();
            $imageLibrary->auto_handle_exif_orientation = true;
            $imageLibrary->source_path = $dir . DS . $name;
            $imageLibrary->target_path = $dir . DS . $nextGen;
            $imageLibrary->webp_quality = 80;
            $useNextGen = $imageLibrary->resize(1300);


            $content = json_encode([
                'location' => Router::url('/', true) . 'files/Inline/' . ($useNextGen ? $nextGen : $name)
            ]);
        }


        $this->response = $this->response->withStringBody($content);
        $this->response = $this->response->withType('json');
        return $this->response;
    }
}
