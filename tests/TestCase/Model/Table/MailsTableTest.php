<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MailsTable Test Case
 */
class MailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MailsTable
     */
    protected $Mails;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Mails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Mails') ? [] : ['className' => MailsTable::class];
        $this->Mails = $this->getTableLocator()->get('Mails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Mails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
