<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;

/**
 * Files Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entities
 * @property \Cake\ORM\Association\BelongsTo $Languages
 *
 * @method \App\Model\Entity\File get($primaryKey, $options = [])
 * @method \App\Model\Entity\File newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\File[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\File|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\File patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\File[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\File findOrCreate($search, callable $callback = null, $options = [])
 */
class FilesTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('files');
        $this->setDisplayField('filename');
        $this->setPrimaryKey('id');

        $this->hasOne('Languages', [
            'bindingKey' => 'language_id',
            'foreignKey' => 'id'
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
            ->requirePresence('filename', 'create')
            ->allowEmptyString('filename');

        $validator
            ->allowEmptyString('title');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        //$rules->add($rules->existsIn(['language_id'], 'Languages'));
        return $rules;
    }

    /**
     * @param $event
     * @param $query
     */
    public function beforeFind( $event, $query )
    {
        $query->order([ $this->getAlias() . '.position' => 'asc']);
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
