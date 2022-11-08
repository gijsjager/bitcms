<?php
namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Block Entity
 *
 * @property int $id
 * @property int $block_group_id
 * @property string $type
 * @property string $class
 * @property int $position
 * @property string $content
 *
 * @property \Bitcms\Model\Entity\BlockGroup $block_group
 */
class Block extends Entity
{

    use TranslateTrait;

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
