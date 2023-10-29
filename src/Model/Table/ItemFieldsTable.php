<?php
declare(strict_types=1);

namespace Bitcms\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemFields Model
 *
 * @property \Bitcms\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \Bitcms\Model\Table\BlueprintFieldsTable&\Cake\ORM\Association\BelongsTo $BlueprintFields
 * @property \Bitcms\Model\Table\BlueprintFieldsTable&\Cake\ORM\Association\HasMany $ItemFieldItems
 *
 * @method \Bitcms\Model\Entity\ItemField newEmptyEntity()
 * @method \Bitcms\Model\Entity\ItemField newEntity(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemField[] newEntities(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemField get($primaryKey, $options = [])
 * @method \Bitcms\Model\Entity\ItemField findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Bitcms\Model\Entity\ItemField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemField[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\ItemField|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\ItemField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\ItemField[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\ItemField[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\ItemField[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\ItemField[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ItemFieldsTable extends Table
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

        $this->setTable('item_fields');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
            'className' => 'Bitcms.Items',
        ]);
        $this->belongsTo('BlueprintFields', [
            'foreignKey' => 'blueprint_field_id',
            'joinType' => 'INNER',
            'className' => 'Bitcms.BlueprintFields',
        ]);


        $this->hasMany('Images', [
            'className' => 'Bitcms.Images',
            'foreignKey' => 'entity_id',
            'conditions' => ['Images.model' => 'ItemFields'],
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->hasMany('Files', [
            'className' => 'Bitcms.Files',
            'foreignKey' => 'entity_id',
            'conditions' => ['Files.model' => 'ItemFields'],
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->belongsToMany('Items', [
            'joinTable' => 'item_field_items',
            'className' => 'Bitcms.Items',
            'foreignKey' => 'item_field_id',
            'targetForeignKey' => 'item_id',
            'propertyName' => 'items',
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'modified_at' => 'always',
                ],
            ],
        ]);

        $this->addBehavior('Translate', [
            'fields' => [
                'value',
            ]
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
            ->integer('item_id')
            ->notEmptyString('item_id');

        $validator
            ->integer('blueprint_field_id')
            ->notEmptyString('blueprint_field_id');

        $validator
            ->scalar('handle')
            ->maxLength('handle', 255)
            ->requirePresence('handle', 'create')
            ->notEmptyString('handle');

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
        $rules->add($rules->existsIn('item_id', 'Items'), ['errorField' => 'item_id']);
        $rules->add($rules->existsIn('blueprint_field_id', 'BlueprintFields'), ['errorField' => 'blueprint_field_id']);

        return $rules;
    }

    public function beforeMarshal(Event $event, \ArrayObject $data, \ArrayObject $options)
    {
        if (!empty($data['value']) && is_array($data['value'])) {
            $data['value'] = json_encode($data['value']);
        }
    }

    /**
     * Before save
     * @param Event $event
     * @param EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity, \ArrayObject $options): void
    {
        if (empty($entity->value)) {
            $entity->value = '';
        }
    }

    /**
     * After save connect items / upload files / images
     * @param Event $event
     * @param EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function afterSave(Event $event, EntityInterface $entity, \ArrayObject $options): void
    {
        // get the blueprint field and check if it's a connect item
        $blueprintField = $this->BlueprintFields->get($entity->blueprint_field_id);
        if ($blueprintField->field_type == BlueprintFieldsTable::TYPE_CONNECT) {
            $this->connect($entity->id, json_decode($entity->value, true));
        }
    }

    /**
     * Connect items to an item field
     * @param int $fieldId
     * @param array|null $items
     * @return void
     */
    public function connect(int $fieldId, ?array $items): void
    {
        if (!empty($items)) {
            foreach($items as $itemId) {
                if (empty($itemId)) {
                    continue;
                }

                $entity = $this->ItemFieldItems->newEntity([
                    'item_id' => $itemId,
                    'item_field_id' => $fieldId
                ]);

                // save connection
                if ($this->ItemFieldItems->save($entity) ) {
                    $stored[] = $entity->id;
                }
            }
        }


        // remove connection not in the list
        $where = [
            'item_field_id' => $fieldId,
        ];
        if (!empty($items)) {
            $where['item_id NOT IN'] = $items;
        }
        $this->ItemFieldItems->deleteAll($where);
    }
}
