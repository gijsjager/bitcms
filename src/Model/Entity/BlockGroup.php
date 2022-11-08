<?php
namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;

/**
 * BlockGroup Entity
 *
 * @property int $id
 * @property string $model
 * @property int $entity_id
 * @property string $class
 * @property int $wrapper_class
 * @property int $position
 *
 * @property \Bitcms\Model\Entity\Entity $entity
 * @property \Bitcms\Model\Entity\Block[] $blocks
 */
class BlockGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true
    ];
}
