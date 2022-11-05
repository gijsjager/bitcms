<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;

/**
 * Images Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entities
 *
 * @method \App\Model\Entity\Image get($primaryKey, $options = [])
 * @method \App\Model\Entity\Image newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Image[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Image|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Image patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Image[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Image findOrCreate($search, callable $callback = null, $options = [])
 */
class ImagesTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('images');
        $this->setDisplayField('filename');
        $this->setPrimaryKey('id');

        $this->hasMany('ImageResponsive');

        $this->addBehavior('Translate', [
            'fields' => [
                'title',
                'alt'
            ]
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('model', 'create')
            ->allowEmptyString('model');

        $validator
            ->allowEmptyString('filename');

        $validator
            ->allowEmptyString('alt');

        $validator
            ->allowEmptyString('title');

        $validator
            ->allowEmptyString('meta');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        return $validator;
    }

    /**
     * @param $event
     * @param $query
     */
    public function beforeFind( $event, $query )
    {
        $query->order([ $this->_alias . '.position' => 'asc']);
    }

    /**
     * Before delete event, delete the images
     *
     * @param $event
     * @param $entity
     */
    public function beforeDelete( $event, $entity ){

        // find all files in the correct model folder
        $dir = new Folder(WWW_ROOT . DS . 'files' . DS . $entity->model);
        if( $files = $dir->findRecursive($entity->filename) ){
            foreach($files as $file){
                @unlink($file);
            }
        }
    }
}
