<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProductCategories
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemsTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('items');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Images', [
            'foreignKey' => 'entity_id',
            'conditions' => ['Images.model' => 'Items'],
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);


        $this->addBehavior('Translate', [
            'fields' => [
                'title',
                'slug',
                'intro',
                'content',
                'info',
                'seo_title',
                'seo_description',
            ]
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->allowEmptyString('title');

        $validator
            ->requirePresence('slug', 'create')
            ->allowEmptyString('slug');


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
}
