<?php
declare(strict_types=1);

namespace Bitcms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemsFixture
 */
class ItemsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'blueprint_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'slug' => 'Lorem ipsum dolor sit amet',
                'online' => 1,
                'seo_title' => 'Lorem ipsum dolor sit amet',
                'seo_description' => 'Lorem ipsum dolor sit amet',
                'position' => 1,
                'created_at' => '2023-10-05 18:21:15',
                'modified_at' => '2023-10-05 18:21:15',
            ],
        ];
        parent::init();
    }
}
