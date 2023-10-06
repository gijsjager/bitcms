<?php
declare(strict_types=1);

namespace Bitcms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemFieldItemsFixture
 */
class ItemFieldItemsFixture extends TestFixture
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
                'item_field_id' => 1,
                'item_id' => 1,
            ],
        ];
        parent::init();
    }
}
