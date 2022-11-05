<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Visitor Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $date_created
 * @property string|null $ipaddress
 * @property string|null $url
 * @property string|null $browser_data
 */
class Visitor extends Entity
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
        'date_created' => true,
        'ipaddress' => true,
        'url' => true,
        'browser_data' => true,
    ];
}
