<?php
declare(strict_types=1);

namespace Bitcms\Test\TestCase\Model\Table;

use Bitcms\Model\Table\ItemFieldItemsTable;
use Cake\TestSuite\TestCase;

/**
 * Bitcms\Model\Table\ItemFieldItemsTable Test Case
 */
class ItemFieldItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bitcms\Model\Table\ItemFieldItemsTable
     */
    protected $ItemFieldItems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Bitcms.ItemFieldItems',
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
        $config = $this->getTableLocator()->exists('ItemFieldItems') ? [] : ['className' => ItemFieldItemsTable::class];
        $this->ItemFieldItems = $this->getTableLocator()->get('ItemFieldItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ItemFieldItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemFieldItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemFieldItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
