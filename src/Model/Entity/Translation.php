<?php
declare(strict_types=1);

namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Translation Entity
 *
 * @property int|null $id
 * @property string $locale
 * @property string $template_key
 * @property string|null $original
 * @property string $content
 */
class Translation extends Entity
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
        'id' => true,
        'template_key' => true,
        'locale' => true,
        'original' => true,
        'content' => true,
    ];
}
