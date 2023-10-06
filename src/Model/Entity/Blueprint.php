<?php
declare(strict_types=1);

namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Blueprint Entity
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $icon
 *
 * @property \Bitcms\Model\Entity\BlueprintField[] $blueprint_fields
 * @property \Bitcms\Model\Entity\Item[] $items
 */
class Blueprint extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'icon' => true,
        'blueprint_fields' => true,
        'items' => true,
    ];
}
