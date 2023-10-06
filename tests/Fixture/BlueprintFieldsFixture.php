<?php
declare(strict_types=1);

namespace Bitcms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BlueprintFieldsFixture
 */
class BlueprintFieldsFixture extends TestFixture
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
                'field_type' => 'Lorem ipsum dolor sit amet',
                'handle' => 'Lorem ipsum dolor sit amet',
                'label' => 'Lorem ipsum dolor sit amet',
                'is_required' => 1,
                'options' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'position' => 1,
            ],
        ];
        parent::init();
    }
}
