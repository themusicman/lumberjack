<?php

namespace Craft;

/**
 * LumberJack Variable provides access to database objects from templates
 */
class LumberJackVariable
{
    /**
     * Get all log entries
     *
     * @return array
     */
    public function getAllLogEntries($params = array())
    {
        return craft()->lumberJack->getAllLogEntries($params);
    }
    
    /**
     * newLogEntry
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function log($attributes = array()) 
    {
        return craft()->lumberJack->log($attributes);
    }

}
