<?php
declare(strict_types=1);

namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemField Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $blueprint_field_id
 * @property string $handle
 * @property string $value
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \Bitcms\Model\Entity\Item $item
 * @property array<\Bitcms\Model\Entity\Item> $items
 * @property \Bitcms\Model\Entity\BlueprintField $blueprint_field
 */
class ItemField extends Entity
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
        'item_id' => true,
        'blueprint_field_id' => true,
        'handle' => true,
        'value' => true,
        'created_at' => true,
        'modified_at' => true,
        'item' => true,
        'items' => true,
        'blueprint_field' => true,
    ];
}
