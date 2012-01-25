<?php
/**
 * Tine 2.0 - http://www.tine20.org
 * 
 * @package     Tests
 * @license     http://www.gnu.org/licenses/agpl.html AGPL Version 3
 * @copyright   Copyright (c) 2010-2011 Metaways Infosystems GmbH (http://www.metaways.de)
 * @author      Cornelius Weiss <c.weiss@metaways.de>
 */

/**
 * Test class for FolderSync_Controller_Event
 * 
 * @package     Tests
 */
abstract class Syncope_Command_ATestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Syncope_Model_IDevice
     */
    protected $_device;
    
    /**
     * @var Syncope_Backend_IDevice
     */
    protected $_deviceBackend;

    /**
     * @var Syncope_Backend_IFolder
     */
    protected $_folderBackend;
    
    /**
     * @var Syncope_Backend_ISyncState
     */
    protected $_syncStateBackend;
    
    /**
     * @var Syncope_Backend_IContent
     */
    protected $_contentStateBackend;
    
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    
    protected $_logPriority = Zend_Log::ALERT;
    
    /**
     * (non-PHPdoc)
     * @see Syncope/Syncope_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->_db = getTestDatabase();
        
        $this->_db->beginTransaction();

        #$writer = new Zend_Log_Writer_Null();
        
        $filter = new Zend_Log_Filter_Priority($this->_logPriority);
        $writer = new Zend_Log_Writer_Stream('php://output');
        $writer->addFilter($filter);
        
        $logger = new Zend_Log($writer);
        
        $this->_deviceBackend       = new Syncope_Backend_Device($this->_db);
        $this->_folderBackend       = new Syncope_Backend_Folder($this->_db);
        $this->_syncStateBackend    = new Syncope_Backend_SyncState($this->_db);
        $this->_contentStateBackend = new Syncope_Backend_Content($this->_db);

        $this->_device = $this->_deviceBackend->create(
            Syncope_Backend_DeviceTests::getTestDevice()
        );
        
        Syncope_Registry::set('deviceBackend',       $this->_deviceBackend);
        Syncope_Registry::set('folderStateBackend',  $this->_folderBackend);
        Syncope_Registry::set('syncStateBackend',    $this->_syncStateBackend);
        Syncope_Registry::set('contentStateBackend', $this->_contentStateBackend);
        Syncope_Registry::set('loggerBackend',       $logger);
    }

    /**
     * Tears down the fixture
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        $this->_db->rollBack();
    }    
}
