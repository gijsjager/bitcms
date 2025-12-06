<?php

namespace Bitcms\Model\Table;

use Bitcms\Utilities\Storage;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Images Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entities
 *
 * @method \App\Model\Entity\Image get($primaryKey, $options = [])
 * @method \App\Model\Entity\Image newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Image[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Image|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Image patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Image[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Image findOrCreate($search, callable $callback = null, $options = [])
 */
class ImagesTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('images');
        $this->setDisplayField('filename');
        $this->setPrimaryKey('id');

        $this->hasMany('ImageResponsive', [
            'className' => 'Bitcms.ImageResponsive',
        ]);

        $this->addBehavior('Translate', [
            'strategyClass' => \Cake\ORM\Behavior\Translate\EavStrategy::class,
            'fields' => [
                'title',
                'alt'
            ]
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('model', 'create')
            ->allowEmptyString('model');

        $validator
            ->allowEmptyString('filename');

        $validator
            ->allowEmptyString('alt');

        $validator
            ->allowEmptyString('title');

        $validator
            ->allowEmptyString('meta');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        return $validator;
    }

    public function beforeFind($event, Query $query): void
    {
        $query->orderBy([$this->_alias . '.position' => 'asc']);
    }

    public function beforeDelete(Event $event, EntityInterface $entity): void
    {

        // find all files in the correct model folder
        $dir = WWW_ROOT . DS . 'files' . DS . $entity->model;
        $filesystem = new Storage();
        if ($files = $filesystem->findRecursive($dir, '/^' . preg_quote($entity->filename, '/') . '$/')) {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }
}
