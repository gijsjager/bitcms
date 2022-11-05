<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Page Entity
 *
 * @property int $id
 * @property int $online
 * @property string $title
 * @property string $slug
 * @property string $seo_title
 * @property string $seo_description
 * @property int $sort
 * @property int $parent_id
 *
 * @property \App\Model\Entity\ParentPage $parent_page
 * @property \App\Model\Entity\ChildPage[] $child_pages
 */
class Page extends Entity
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
        '*' => true,
        'id' => false
    ];
}
