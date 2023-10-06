<?php
declare(strict_types=1);

namespace Bitcms\Test\TestCase\Model\Table;

use Bitcms\Model\Table\ItemItemTable;
use Cake\TestSuite\TestCase;

/**
 * Bitcms\Model\Table\ItemItemTable Test Case
 */
class ItemItemTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bitcms\Model\Table\ItemItemTable
     */
    protected $ItemItem;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Bitcms.ItemItem',
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
        $config = $this->getTableLocator()->exists('ItemItem') ? [] : ['className' => ItemItemTable::class];
        $this->ItemItem = $this->getTableLocator()->get('ItemItem', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ItemItem);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemItemTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemItemTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
