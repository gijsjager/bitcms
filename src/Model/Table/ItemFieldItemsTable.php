<?php
declare(strict_types=1);

namespace Bitcms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemFieldItems Model
 *
 * @property \Bitcms\Model\Table\ItemFieldsTable&\Cake\ORM\Association\BelongsTo $ItemFields
 *
 * @method \Bitcms\Model\Entity\ItemFieldItem newEmptyEntity()
 * @method \Bitcms\Model\Entity\ItemFieldItem newEntity(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem[] newEntities(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem get($primaryKey, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\ItemFieldItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ItemFieldItemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('item_field_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ItemFields', [
            'foreignKey' => 'item_field_id',
            'joinType' => 'INNER',
            'className' => 'Bitcms.ItemFields',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
            'className' => 'Bitcms.Items',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('item_field_id')
            ->notEmptyString('item_field_id');

        $validator
            ->integer('item_id')
            ->notEmptyString('item_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('item_field_id', 'ItemFields'), ['errorField' => 'item_field_id']);
        $rules->add($rules->existsIn('item_id', 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
