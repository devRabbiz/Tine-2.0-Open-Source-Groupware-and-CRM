<?php
/**
 * Tine 2.0
 * 
 * @package     Tinebase
 * @subpackage  Server
 * @license     http://www.gnu.org/licenses/agpl.html AGPL Version 3
 * @copyright   Copyright (c) 2007-2010 Metaways Infosystems GmbH (http://www.metaways.de)
 * @author      Philipp Schuele <p.schuele@metaways.de>
 * @version     $Id$
 * 
 */

/**
 * Interface for setup server class
 * 
 * @package     Tinebase
 * @subpackage  Server
 */
interface Setup_Server_Interface
{
    /**
     * handler for tine requests
     * 
     * @return boolean
     */
    public function handle();
}
