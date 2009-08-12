<?php
/**
 * Tine 2.0
 *
 * @package     Timetracker
 * @subpackage  Setup
 * @license     http://www.gnu.org/licenses/agpl.html AGPL3
 * @copyright   Copyright (c) 2008 Metaways Infosystems GmbH (http://www.metaways.de)
 * @author      Philipp Schuele <p.schuele@metaways.de>
 * @version     $Id: Release0.php 9867 2009-08-11 13:37:53Z p.schuele@metaways.de $
 */

class Timetracker_Setup_Update_Release2 extends Setup_Update_Abstract
{

    public function update_0()
    {
        $declaration = new Setup_Backend_Schema_Field_Xml('
            <field>
                <name>budget</name>
                <type>float</type>
            </field>');
        $this->_backend->alterCol('timetracker_timeaccount', $declaration, 'budget');   
        
        $declaration = new Setup_Backend_Schema_Field_Xml('
            <field>
                <name>price</name>
                <type>float</type>
            </field>');
        $this->_backend->alterCol('timetracker_timeaccount', $declaration, 'price');   

        $this->setTableVersion('timetracker_timeaccount', '5');

        $this->setApplicationVersion('Timetracker', '2.1');
    }

}
