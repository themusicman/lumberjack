<?php

namespace Craft;

class LumberJack_LogEntryModel extends BaseModel
{
    //Level Constants
    const TRACE     = 'trace';  //Used for logging data ex. message: user_id:10
    const DEBUG     = 'debug';  //Any info helpful in debugging problems
    const INFO      = 'info';   //Runtime events ex. message: Contact form submitted 
    const WARN      = 'warn';   //Something bad happened but not catastropic and somebody should be alerted to it
    const ERROR     = 'error';  //Houston we have a problem
    
    /**
     * Define the attributes this model will have.
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'id'                => AttributeType::Number,
            'plugin_name'       => AttributeType::String,
            'level'             => AttributeType::String,
            'message'           => array(AttributeType::String, 'column' => ColumnType::Text),
            'meta'              => AttributeType::Mixed,
            'dateCreated'       => AttributeType::DateTime,
        );
    }
}
