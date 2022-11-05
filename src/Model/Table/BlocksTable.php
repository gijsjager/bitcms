<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Composer\DependencyResolver\Rule;

/**
 * Blocks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BlockGroups
 *
 * @method \App\Model\Entity\Block get($primaryKey, $options = [])
 * @method \App\Model\Entity\Block newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Block[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Block|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Block patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Block[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Block findOrCreate($search, callable $callback = null, $options = [])
 */
class BlocksTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('blocks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BlockGroups', [
            'foreignKey' => 'block_group_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Images', [
            'foreignKey' => 'entity_id',
            'conditions' => ['Images.model' => 'Blocks'],
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->addBehavior('Translate', [
            'fields' => ['content']
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

        $validator
            ->allowEmptyString('class');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        $validator
            ->allowEmptyString('content');

        return $validator;
    }


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['block_group_id'], 'BlockGroups'));

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
}
