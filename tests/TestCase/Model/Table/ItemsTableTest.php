<?php
declare(strict_types=1);

namespace Bitcms\Test\TestCase\Model\Table;

use Bitcms\Model\Table\ItemsTable;
use Cake\TestSuite\TestCase;

/**
 * Bitcms\Model\Table\ItemsTable Test Case
 */
class ItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bitcms\Model\Table\ItemsTable
     */
    protected $Items;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Bitcms.Items',
        'plugin.Bitcms.Blueprints',
        'plugin.Bitcms.ItemFields',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Items') ? [] : ['className' => ItemsTable::class];
        $this->Items = $this->getTableLocator()->get('Items', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Items);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
