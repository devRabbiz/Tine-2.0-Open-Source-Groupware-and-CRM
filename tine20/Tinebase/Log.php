<?php
/**
 * Tine 2.0
 * 
 * @package     Tinebase
 * @subpackage  Log
 * @license     http://www.gnu.org/licenses/agpl.html AGPL Version 3
 * @copyright   Copyright (c) 2013 Metaways Infosystems GmbH (http://www.metaways.de)
 * @author      Philipp Schüle <p.schuele@metaways.de>
 * 
 */

/**
 * class Tinebase_Log
 * 
 * @package Tinebase
 * @subpackage Log
 */
class Tinebase_Log extends Zend_Log
{
    /**
     * 
     * @var Tinebase_Log_Formatter
     */
    protected $_formatter;
    
    /**
     * add strings to replace in log output (passwords for example)
     * 
     * @param string $search
     * @param string $replace
     */
    public function addReplacement($search, $replace = '********')
    {
        $this->getFormatter()->addReplacement($search, $replace);
    }
    
    /**
     * 
     * @return Tinebase_Log_Formatter
     */
    public function getFormatter()
    {
        if (!$this->_formatter instanceof Tinebase_Log_Formatter) {
            $this->_formatter = new Tinebase_Log_Formatter();
        }
        
        return $this->_formatter;
    }
    
    /**
     * add new log writer defined by a config object/array
     * 
     * @param Tinebase_Config_Struct|Zend_Config|array $loggerConfig
     * 
     * @throws Tinebase_Exception_NotFound
     */
    public function addWriterByConfig($loggerConfig)
    {
        $loggerConfig = ($loggerConfig instanceof Tinebase_Config_Struct || $loggerConfig instanceof Zend_Config)
            ? $loggerConfig : new Tinebase_Config_Struct($loggerConfig);
        
        if (empty($loggerConfig->filename)) {
            throw new Tinebase_Exception_NotFound('filename missing in logger config');
        }

        $filename = $loggerConfig->filename;
        $writer = new Zend_Log_Writer_Stream($filename);
        
        $writer->setFormatter($this->getFormatter());

        $priority = ($loggerConfig->priority) ? (int)$loggerConfig->priority : Zend_Log::EMERG;
        $filter = new Zend_Log_Filter_Priority($priority);
        $writer->addFilter($filter);

        // add more filters here
        if (isset($loggerConfig->filter->user)) {
            $writer->addFilter(new Tinebase_Log_Filter_User($loggerConfig->filter->user));
        }
        if (isset($loggerConfig->filter->message)) {
            $writer->addFilter(new Zend_Log_Filter_Message($loggerConfig->filter->message));
        }
        
        $this->addWriter($writer);
    }
    
    /**
     * get max log priority
     * 
     * @param Tinebase_Config_Struct|Zend_Config $loggerConfig
     * @return integer
     */
    public static function getMaxLogLevel($loggerConfig)
    {
        $logLevel = $loggerConfig && $loggerConfig->priority ? (int)$loggerConfig->priority : Zend_Log::EMERG;
        if ($loggerConfig && $loggerConfig->additionalWriters) {
            foreach ($loggerConfig->additionalWriters as $writerConfig) {
                $writerConfig = ($writerConfig instanceof Tinebase_Config_Struct || $writerConfig instanceof Zend_Config)
                    ? $writerConfig : new Tinebase_Config_Struct($writerConfig);
                if ($writerConfig->priority && $writerConfig->priority > $logLevel) {
                    $logLevel = (int) $writerConfig->priority;
                }
            }
        }
        return $logLevel;
    }
}
