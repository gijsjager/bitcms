<?php
declare(strict_types=1);

namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;

/**
 * BlueprintField Entity
 *
 * @property int $id
 * @property int $blueprint_id
 * @property string $field_type
 * @property string $handle
 * @property string $label
 * @property bool $is_required
 * @property string $options
 * @property int $position
 *
 * @property \Bitcms\Model\Entity\Blueprint $blueprint
 * @property \Bitcms\Model\Entity\ItemField[] $item_fields
 */
class BlueprintField extends Entity
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
        'blueprint_id' => true,
        'field_type' => true,
        'handle' => true,
        'label' => true,
        'is_required' => true,
        'options' => true,
        'position' => true,
        'blueprint' => true,
        'item_fields' => true,
    ];
}
