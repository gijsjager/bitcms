<?php
declare(strict_types=1);

namespace Bitcms\Test\TestCase\Model\Table;

use Bitcms\Model\Table\BlueprintsTable;
use Cake\TestSuite\TestCase;

/**
 * Bitcms\Model\Table\BlueprintsTable Test Case
 */
class BlueprintsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bitcms\Model\Table\BlueprintsTable
     */
    protected $Blueprints;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Bitcms.Blueprints',
        'plugin.Bitcms.BlueprintFields',
        'plugin.Bitcms.Items',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Blueprints') ? [] : ['className' => BlueprintsTable::class];
        $this->Blueprints = $this->getTableLocator()->get('Blueprints', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Blueprints);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Bitcms\Model\Table\BlueprintsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
