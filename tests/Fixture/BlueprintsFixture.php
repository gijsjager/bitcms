<?php
declare(strict_types=1);

namespace Bitcms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BlueprintsFixture
 */
class BlueprintsFixture extends TestFixture
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
                'title' => 'Lorem ipsum dolor sit amet',
                'slug' => 'Lorem ipsum dolor sit amet',
                'icon' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
