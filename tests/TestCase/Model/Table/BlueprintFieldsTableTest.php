<?php
declare(strict_types=1);

namespace Bitcms\Test\TestCase\Model\Table;

use Bitcms\Model\Table\BlueprintFieldsTable;
use Cake\TestSuite\TestCase;

/**
 * Bitcms\Model\Table\BlueprintFieldsTable Test Case
 */
class BlueprintFieldsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bitcms\Model\Table\BlueprintFieldsTable
     */
    protected $BlueprintFields;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Bitcms.BlueprintFields',
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
        $config = $this->getTableLocator()->exists('BlueprintFields') ? [] : ['className' => BlueprintFieldsTable::class];
        $this->BlueprintFields = $this->getTableLocator()->get('BlueprintFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BlueprintFields);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Bitcms\Model\Table\BlueprintFieldsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Bitcms\Model\Table\BlueprintFieldsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
