<?php
// Call Setup_Backend_Schema_TableTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Setup_Backend_Schema_TableTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../../TestHelper.php';

/**
 * Test class for Setup_Backend_Schema_Table.
 * Generated by PHPUnit on 2008-04-23 at 17:26:04.
 */
class Setup_Backend_Schema_TableTest extends Setup_Backend_AbstractTest
{

    public function testIsValid()
    {
        $table = $this->_table;
        $this->assertTrue($table->isValid(), 'Test if a valid field is correctly marked as valid');
        $this->assertTrue($table->isValid(true), 'Test if no Exception is thrown on validating a valid field is correctly marked as valid');
        
        $table->setName(str_pad('A', 24, 'a'));
        $this->assertFalse($table->isValid(), 'Test if a too long field name is invalid');
        
        $this->setExpectedException('Setup_Exception_InvalidSchema');
        $table->isValid(true); //Test if the parameter throwException works as expected
    }
	
    public function testSetName()
    {
        $name = 'phpunit-test';
        $this->_table->setName($name);
        $this->assertEquals('phpunit-test', $this->_table->name);
        
        $this->_table->setName(SQL_TABLE_PREFIX . 'phpunit-test');
        $this->assertEquals('phpunit-test', $this->_table->name);
    }
	
    /**
     * @todo Implement testAddDeclarationField().
     */
    public function testAddDeclarationField() {
    	//$this->_table->addField()
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
	
    /**
     * @todo Implement testSetDeclarationField().
     */
    public function testSetDeclarationField() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testAddDeclarationIndex().
     */
    public function testAddDeclarationIndex() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetDeclarationIndex().
     */
    public function testSetDeclarationIndex() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testAddIndex().
     */
    public function testAddIndex() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetIndex().
     */
    public function testSetIndex() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetForeign().
     */
    public function testSetForeign() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testFixFieldKey().
     */
    public function testFixFieldKey() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}

// Call Setup_Backend_Schema_TableTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'Setup_Backend_Schema_TableTest::main') {
    Setup_Backend_Schema_TableTest::main();
}
