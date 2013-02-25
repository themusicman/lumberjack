<?php

namespace Blocks;

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
    public function getAllLogEntries()
    {
        return blx()->lumberJack->getAllLogEntries();
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
        return blx()->lumberJack->log($attributes);
    }

}
