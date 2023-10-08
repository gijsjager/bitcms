<?php
declare(strict_types=1);

namespace Bitcms\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Blueprints Model
 *
 * @property \Bitcms\Model\Table\BlueprintFieldsTable&\Cake\ORM\Association\HasMany $BlueprintFields
 * @property \Bitcms\Model\Table\ItemsTable&\Cake\ORM\Association\HasMany $Items
 *
 * @method \Bitcms\Model\Entity\Blueprint newEmptyEntity()
 * @method \Bitcms\Model\Entity\Blueprint newEntity(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Blueprint[] newEntities(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Blueprint get($primaryKey, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Blueprint[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\Blueprint|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\Blueprint[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BlueprintsTable extends Table
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

        $this->setTable('blueprints');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('BlueprintFields', [
            'foreignKey' => 'blueprint_id',
            'className' => 'Bitcms.BlueprintFields',
        ])
            ->setDependent(true)
            ->setCascadeCallbacks(true)
            ->setSaveStrategy('replace');

        $this->hasMany('Items', [
            'foreignKey' => 'blueprint_id',
            'className' => 'Bitcms.Items',
        ]);

        $this->addBehavior('Translate', [
            'fields' => [
                'slug',
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
            ->scalar('icon')
            ->maxLength('icon', 255)
            ->requirePresence('icon', 'create')
            ->notEmptyString('icon');

        return $validator;
    }

    public function beforeMarshal(\Cake\Event\EventInterface $event, \ArrayObject $data, \ArrayObject $options)
    {
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = \Cake\Utility\Text::slug(strtolower(trim($data['title'])));
        }
        if (isset($data['title']) && !isset($data['handle'])) {
            $data['handle'] = \Cake\Utility\Text::slug(strtolower(trim($data['handle'])));
        }
    }
}
