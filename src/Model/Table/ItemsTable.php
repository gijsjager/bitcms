<?php
declare(strict_types=1);

namespace Bitcms\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \Bitcms\Model\Table\BlueprintsTable&\Cake\ORM\Association\BelongsTo $Blueprints
 * @property \Bitcms\Model\Table\ItemFieldsTable&\Cake\ORM\Association\HasMany $ItemFields
 *
 * @method \Bitcms\Model\Entity\Item newEmptyEntity()
 * @method \Bitcms\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Item get($primaryKey, $options = [])
 * @method \Bitcms\Model\Entity\Item findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Bitcms\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Item[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Blueprints', [
            'foreignKey' => 'blueprint_id',
            'joinType' => 'INNER',
            'className' => 'Bitcms.Blueprints',
        ]);

        $this
            ->hasMany('ItemFields', [
                'foreignKey' => 'item_id',
                'className' => 'Bitcms.ItemFields',
            ])
            ->setCascadeCallbacks(true)
            ->setDependent(true)
            ->setSaveStrategy('replace');


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
                'title',
                'slug',
                'seo_title',
                'seo_description'
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
            ->integer('blueprint_id')
            ->notEmptyString('blueprint_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->notEmptyString('online');

        $validator
            ->scalar('seo_title')
            ->maxLength('seo_title', 255);

        $validator
            ->scalar('seo_description')
            ->maxLength('seo_description', 255);

        $validator
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

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
        $rules->add($rules->existsIn('blueprint_id', 'Blueprints'), ['errorField' => 'blueprint_id']);

        return $rules;
    }
}
