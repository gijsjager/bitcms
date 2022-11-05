<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mail Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $date_created
 * @property string|null $receiver
 * @property string|null $sender
 * @property string|null $subject
 * @property string|null $content
 */
class Mail extends Entity
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
        'receiver' => true,
        'sender' => true,
        'subject' => true,
        'content' => true,
    ];
}
