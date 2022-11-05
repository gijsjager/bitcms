<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * File Entity
 *
 * @property int $id
 * @property string $model
 * @property int $entity_id
 * @property int $language_id
 * @property string $filename
 * @property string $title
 *
 * @property \App\Model\Entity\Entity $entity
 * @property \App\Model\Entity\Language $language
 */
class File extends Entity
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
        '*' => true,
        'id' => false
    ];

    protected function _getUrl()
    {
        return Router::url('/files/' . $this->_properties['model'] . '/' . $this->_properties['filename']);
    }
}
