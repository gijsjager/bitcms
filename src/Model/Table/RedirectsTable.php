<?php
namespace Bitcms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Redirects Model
 *
 * @method \App\Model\Entity\Redirect get($primaryKey, $options = [])
 * @method \App\Model\Entity\Redirect newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Redirect[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Redirect|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Redirect patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Redirect[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Redirect findOrCreate($search, callable $callback = null, $options = [])
 */
class RedirectsTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('redirects');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('from_url', 'create')
            ->notEmptyString('from_url')
            ->add('from_url', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('to_url', 'create')
            ->notEmptyString('to_url');

        $validator
            ->allowEmptyString('type');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['from_url']));

        return $rules;
    }

    /**
     * Alter query before find
     *
     * @param $event
     * @param $query
     */
    public function beforeFind( $event, $query )
    {
        $query->order(['date_created' => 'desc']);
    }
}
