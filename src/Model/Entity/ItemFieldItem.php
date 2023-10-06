<?php
declare(strict_types=1);

namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemFieldItem Entity
 *
 * @property int $id
 * @property int $item_field_id
 * @property int $item_id
 *
 * @property \Bitcms\Model\Entity\ItemField $item_field
 */
class ItemFieldItem extends Entity
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
        'item_field_id' => true,
        'item_id' => true,
        'item_field' => true,
    ];
}
