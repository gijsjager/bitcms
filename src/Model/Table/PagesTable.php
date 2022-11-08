<?php
namespace Bitcms\Model\Table;

use Cake\I18n\I18n;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentPages
 * @property \Cake\ORM\Association\HasMany $ChildPages
 *
 * @method \App\Model\Entity\Page get($primaryKey, $options = [])
 * @method \App\Model\Entity\Page newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Page[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Page|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Page patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Page[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Page findOrCreate($search, callable $callback = null, $options = [])
 */
class PagesTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('pages');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentPages', [
            'className' => 'Bitcms.Pages',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildPages', [
            'className' => 'Bitcms.Pages',
            'foreignKey' => 'parent_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->hasMany('BlockGroups', [
            'foreignKey' => 'entity_id',
            'className' => 'Bitcms.BlockGroups',
            'conditions' => ['BlockGroups.model' => 'Pages'],
            'dependent' => true,
            'cascadeCallbacks' => true,
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

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->integer('online')
            ->allowEmptyString('online');

        $validator
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyString('seo_title');

        $validator
            ->allowEmptyString('seo_description');

        $validator
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

        return $validator;
    }

    public function findTranslated( Query $query, $options )
    {
        $query->join([
            'table' => 'i18n',
            'alias' => 'i18n_slug',
            'type' => 'LEFT',
            'conditions' => [
                'i18n_slug.foreign_key = ' . $this->getAlias() . '.id',
                'i18n_slug.model = "'.$this->getAlias().'"',
                'i18n_slug.field = "slug"',
                'i18n_slug.locale = "' . I18n::getLocale() . '"',
            ]
        ]);

        return $query->select($this)->select(['translated_slug' => 'i18n_slug.content']);
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['slug']));
        $rules->add($rules->existsIn(['parent_id'], 'ParentPages'));

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
