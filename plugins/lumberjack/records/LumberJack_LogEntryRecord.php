<?php
namespace Blocks;

class LumberJack_LogEntryRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'lumberjack_log_entries';
    }

    public function defineAttributes()
    {
        return array(
            'plugin_name'       => AttributeType::String,
            'level'             => AttributeType::String,
            'message'           => array(AttributeType::String, 'column' => ColumnType::Text),
            'meta'              => AttributeType::Mixed,
        );        
    }
    
    /**
     * createRecord
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function createRecord() 
    {
        return new LumberJack_LogEntryRecord;
    }
}

