<?php
declare(strict_types=1);

namespace Bitcms\Test\TestCase\Model\Table;

use Bitcms\Model\Table\ItemFieldsTable;
use Cake\TestSuite\TestCase;

/**
 * Bitcms\Model\Table\ItemFieldsTable Test Case
 */
class ItemFieldsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bitcms\Model\Table\ItemFieldsTable
     */
    protected $ItemFields;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Bitcms.ItemFields',
        'plugin.Bitcms.Items',
        'plugin.Bitcms.BlueprintFields',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ItemFields') ? [] : ['className' => ItemFieldsTable::class];
        $this->ItemFields = $this->getTableLocator()->get('ItemFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ItemFields);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemFieldsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Bitcms\Model\Table\ItemFieldsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
