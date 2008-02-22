<?php
/**
 * class to handle grantss
 * 
 * @package     Egwbase
 * @subpackage  Record
 * @license     http://www.gnu.org/licenses/agpl.html
 * @copyright   Copyright (c) 2007-2008 Metaways Infosystems GmbH (http://www.metaways.de)
 * @author      Lars Kneschke <l.kneschke@metaways.de>
 * @version     $Id$
 */

/**
 * defines the datatype for one application
 */
class Egwbase_Model_Grants extends Egwbase_Record_Abstract
{
	/**
     * key in $_validators/$_properties array for the filed which 
     * represents the identifier
     * 
     * @var string
     */    
    protected $_identifier = 'accountId';
    
    /**
     * application the record belongs to
     *
     * @var string
     */
    protected $_application = 'Egwbase';
    
    /**
     * list of zend inputfilter
     * 
     * this filter get used when validating user generated content with Zend_Filter_Input
     *
     * @var array
     */
    protected $_filters = array(
        '*'      => 'StringTrim'
    );

    /**
     * list of zend validator
     * 
     * this validators get used when validating user generated content with Zend_Filter_Input
     *
     * @var array
     */
    protected $_validators = array();

    public function __construct($_data = NULL, $_bypassFilters = false, $_convertDates = NULL)
    {
        $this->_validators = array(
            'accountId'   => array('Digits', 'presence' => 'required'),
            'accountName' => array('presence' => 'required'),
            'readGrant'   => array(
                new Zend_Validate_InArray(array(TRUE, FALSE), TRUE), 
                'default' => FALSE
            ),
            'addGrant'   => array(
                new Zend_Validate_InArray(array(TRUE, FALSE), TRUE), 
                'default' => FALSE
            ),
            'editGrant'   => array(
                new Zend_Validate_InArray(array(TRUE, FALSE), TRUE), 
                'default' => FALSE
            ),
            'deleteGrant'   => array(
                new Zend_Validate_InArray(array(TRUE, FALSE), TRUE), 
                'default' => FALSE
            ),
            'adminGrant'   => array(
                new Zend_Validate_InArray(array(TRUE, FALSE), TRUE), 
                'default' => FALSE
            )
        );
        
        return parent::__construct($_data, $_bypassFilters);
    }
}