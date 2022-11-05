<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mails Model
 *
 * @method \App\Model\Entity\Mail newEmptyEntity()
 * @method \App\Model\Entity\Mail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Mail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Mail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MailsTable extends Table
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

        $this->setTable('mails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->dateTime('date_created')
            ->allowEmptyDateTime('date_created');

        $validator
            ->scalar('receiver')
            ->maxLength('receiver', 255)
            ->allowEmptyString('receiver');

        $validator
            ->scalar('sender')
            ->maxLength('sender', 255)
            ->allowEmptyString('sender');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->allowEmptyString('subject');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        return $validator;
    }
}
