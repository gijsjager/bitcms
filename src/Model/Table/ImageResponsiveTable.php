<?php
namespace Bitcms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Composer\DependencyResolver\Rule;

/**
 * ImageResponsive Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Images
 *
 * @method \App\Model\Entity\ImageResponsive get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImageResponsive newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImageResponsive[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImageResponsive|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImageResponsive patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImageResponsive[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImageResponsive findOrCreate($search, callable $callback = null, $options = [])
 */
class ImageResponsiveTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('image_responsive');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Images', [
            'className' => 'Bitcms.Images',
            'foreignKey' => 'image_id'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('type', 'create')
            ->allowEmptyString('type');

        return $validator;
    }


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['image_id'], 'Images'));

        return $rules;
    }

    /**
     * Before delete event, delete the images
     *
     * @param $event
     * @param $entity
     */
    public function beforeDelete( $event, $entity ){

        // find all files in the correct model folder
        $dir = new Folder(WWW_ROOT . DS . 'files' . DS . $entity->model .  DS . $entity->type);
        if( $files = $dir->findRecursive($entity->filename) ){
            foreach($files as $file){
                @unlink($file);
            }
        }
    }
}
