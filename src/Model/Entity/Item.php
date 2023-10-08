<?php
declare(strict_types=1);

namespace Bitcms\Model\Entity;

use Cake\I18n\I18n;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $blueprint_id
 * @property string $title
 * @property string $slug
 * @property int $online
 * @property string $seo_title
 * @property string $seo_description
 * @property int $position
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \Bitcms\Model\Entity\Blueprint $blueprint
 * @property \Bitcms\Model\Entity\ItemField[] $item_fields
 */
class Item extends Entity
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
        'title' => true,
        'slug' => true,
        'online' => true,
        'seo_title' => true,
        'seo_description' => true,
        'position' => true,
        'created_at' => true,
        'modified_at' => true,
        'blueprint' => true,
        'item_fields' => true,
    ];

    protected $_virtual = ['url'];

    /**
     * Get full URL of an item
     * @return string
     */
    protected function _getUrl(): string
    {
        $languages = TableRegistry::getTableLocator()->get('Bitcms.Languages');
        $langs = $languages->find()->where(['active' => 1]);

        $url = '/';

        // Get language abbreviation
        if ($langs->count() > 1) {
            $locale = ($this->locale) ? $this->locale : I18n::getLocale();
            $lang = $langs->where(['locale' => $locale])->first();
            $url .= $lang->abbreviation . '/';
        }

        // get blueprint
        if (!empty($this->blueprint_id)) {
            $blueprints = TableRegistry::getTableLocator()->get('Bitcms.Blueprints');
            $blueprint = $blueprints->get($this->blueprint_id);
            $url .= $blueprint->slug . '/';
        }

        return $url . $this->slug;
    }

    /**
     * Get field value
     * @param string $handle
     * @return mixed
     */
    public function field(string $handle = ''): mixed
    {
        if (!empty($this->item_fields)) {
            foreach ($this->item_fields as $field) {
                if ($field->handle == $handle) {
                    if (!empty($field->images)) {
                        return $field->images;
                    } else if (!empty($field->files)) {
                        return $field->files;
                    } else if (!empty($field->items)) {
                        return $field->items;
                    }

                    return $field->value;
                }
            }
        }
        return null;
    }
}
