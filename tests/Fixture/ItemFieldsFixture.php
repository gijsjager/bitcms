<?php
declare(strict_types=1);

namespace Bitcms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemFieldsFixture
 */
class ItemFieldsFixture extends TestFixture
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
                'item_id' => 1,
                'blueprint_field_id' => 1,
                'handle' => 'Lorem ipsum dolor sit amet',
                'value' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created_at' => '2023-10-05 11:10:37',
                'modified_at' => '2023-10-05 11:10:37',
            ],
        ];
        parent::init();
    }
}
