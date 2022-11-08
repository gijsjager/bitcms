<?php
namespace Bitcms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BlockGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entities
 * @property \Cake\ORM\Association\HasMany $Blocks
 *
 * @method \App\Model\Entity\BlockGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\BlockGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BlockGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BlockGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BlockGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BlockGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BlockGroup findOrCreate($search, callable $callback = null, $options = [])
 */
class BlockGroupsTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('block_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Blocks', [
            'className' => 'Bitcms.Blocks',
            'foreignKey' => 'block_group_id',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->allowEmptyString('class');

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
        $query->order([ $this->getAlias() . '.position' => 'asc']);
    }

    public function beforeSave($event, $entity)
    {
        if( $entity->position == 0 ){
            $count = $this->find()->where(['model' => $entity->model, 'entity_id' => $entity->entity_id])->count();
            $entity->position = $count+1;
        }
    }
}
