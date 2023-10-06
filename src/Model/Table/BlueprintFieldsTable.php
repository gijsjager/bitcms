<?php
declare(strict_types=1);

namespace Bitcms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

/**
 * BlueprintFields Model
 *
 * @property \Bitcms\Model\Table\BlueprintsTable&\Cake\ORM\Association\BelongsTo $Blueprints
 * @property \Bitcms\Model\Table\ItemFieldsTable&\Cake\ORM\Association\HasMany $ItemFields
 *
 * @method \Bitcms\Model\Entity\BlueprintField newEmptyEntity()
 * @method \Bitcms\Model\Entity\BlueprintField newEntity(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField[] newEntities(array $data, array $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField get($primaryKey, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Bitcms\Model\Entity\BlueprintField[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BlueprintFieldsTable extends Table
{

    public const TYPE_TEXT = 'text';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_HTML = 'html';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_SELECT = 'select';
    public const TYPE_NUMBER = 'number';
    public const TYPE_EMAIL = 'email';
    public const TYPE_URL = 'url';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_COLOR = 'color';
    public const TYPE_TEL = 'tel';
    public const TYPE_IMAGES = 'images';
    public const TYPE_FILES = 'files';
    public const TYPE_CONNECT = 'connect';


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('blueprint_fields');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->belongsTo('Blueprints', [
            'foreignKey' => 'blueprint_id',
            'joinType' => 'INNER',
            'className' => 'Bitcms.Blueprints',
        ]);
        $this->hasMany('ItemFields', [
            'foreignKey' => 'blueprint_field_id',
            'className' => 'Bitcms.ItemFields',
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
            ->scalar('field_type')
            ->maxLength('field_type', 255)
            ->requirePresence('field_type', 'create')
            ->notEmptyString('field_type');

        $validator
            ->scalar('handle')
            ->maxLength('handle', 255)
            ->requirePresence('handle', 'create')
            ->notEmptyString('handle');

        $validator
            ->scalar('label')
            ->maxLength('label', 255)
            ->requirePresence('label', 'create')
            ->notEmptyString('label');

        $validator
            ->boolean('is_required')
            ->requirePresence('is_required', 'create')
            ->notEmptyString('is_required');

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

    public function beforeSave($event, $entity, $options)
    {
        if (!empty($entity->handle)) {
            $entity->handle = Text::slug(strtolower($entity->handle));
        }
    }

    /**
     * @return array
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_TEXT => __('Text'),
            self::TYPE_TEXTAREA => __('Textarea'),
            self::TYPE_HTML => __('HTML'),
            self::TYPE_CHECKBOX => __('Checkbox'),
            self::TYPE_SELECT => __('Select'),
            self::TYPE_NUMBER => __('Number'),
            self::TYPE_EMAIL => __('E-mail'),
            self::TYPE_URL => __('Website'),
            self::TYPE_PASSWORD => __('Password'),
            self::TYPE_COLOR => __('Color'),
            self::TYPE_TEL => __('Telephone'),
            self::TYPE_IMAGES => __('Images'),
            self::TYPE_FILES => __('Files'),
            self::TYPE_CONNECT => __('Connect'),
        ];
    }
}
