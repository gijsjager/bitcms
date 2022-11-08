<?php
namespace Bitcms\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Image Entity
 *
 * @property int $id
 * @property string $model
 * @property int $entity_id
 * @property string $filename
 * @property string $alt
 * @property string $title
 * @property string $meta
 * @property int $position
 *
 * @property \Bitcms\Model\Entity\Entity $entity
 */
class Image extends Entity
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
        $basePath = '/files/' . $this->_properties['model'] . '/';
        if( Router::getRequest()->is('mobile') ){
            if( file_exists( WWW_ROOT . $basePath . 'responsive/mobile/' . $this->_properties['filename'] ) ){
                return Router::url( $basePath . 'responsive/mobile/' . $this->_properties['filename'] );
            }
        }

        if( Router::getRequest()->is('tablet') ){
            if( file_exists( WWW_ROOT . $basePath . 'responsive/tablet/' . $this->_properties['filename'] ) ){
                return Router::url( $basePath . 'responsive/tablet/' . $this->_properties['filename'] );
            }
        }

        return Router::url( $basePath . $this->_properties['filename']);
    }

    /**
     * Get origin URL for an image
     *
     * @return string
     */
    protected function _getOriginUrl()
    {
        $model = $this->model;
        $entity_id = $this->entity_id;

        if( $this->model == 'Blocks' ){

            $BlockGroups = TableRegistry::getTableLocator()->get('Bitcms.BlockGroups');

            if( $blockGroup = $BlockGroups->findById( $this->entity_id )->first() ){
                $Table = TableRegistry::getTableLocator()->get('Bitcms.'.$blockGroup->model);
                if( $item = $Table->findById($blockGroup->entity_id)->first() ){
                    return Router::url(['controller' => $blockGroup->model, 'action' => 'edit', $item->id]);
                }
            }

            return FALSE;

        } else {
            return Router::url(['controller' => $model, 'action' => 'edit', $entity_id]);
        }
    }
}
