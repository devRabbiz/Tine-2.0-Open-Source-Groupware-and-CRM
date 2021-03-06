<?php
/**
 * Tine 2.0
 *
 * @package     HumanResources
 * @subpackage  Exception
 * @license     http://www.gnu.org/licenses/agpl.html AGPL Version 3
 * @copyright   Copyright (c) 2013 Metaways Infosystems GmbH (http://www.metaways.de)
 * @author      Alexander Stintzing <a.stintzing@metaways.de>
 *
 */

/**
 * Contract to old to update Exception
 *
 * @package     HumanResources
 * @subpackage  Exception
 */
class HumanResources_Exception_ContractNotEditable extends HumanResources_Exception
{
    /**
     * the title of the Exception (may be shown in a dialog)
     *
     * @var string
     */
    protected $_title = 'Contract not editable'; // _('Contract not editable')
    
    /**
     * @see SPL Exception
     */
    protected $message = 'You are not allowed to change the record if a vacation has been booked already!'; // _('You are not allowed to change the record if a vacation has been booked already!')

    /**
     * @see SPL Exception
     */
    protected $code = 912;
}
