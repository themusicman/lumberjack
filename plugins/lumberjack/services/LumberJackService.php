<?php

namespace Blocks;



class LumberJackService extends BaseApplicationComponent
{
    
    protected $logEntryRecord;
    
    /**
     * __construct
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function __construct($logEntryRecord = null) 
    {
        $this->logEntryRecord = $logEntryRecord;
        if (is_null($this->logEntryRecord)) {
            $this->logEntryRecord = LumberJack_LogEntryRecord::model();
        }
    }
    
    /**
     * getAllLogEntries
     *
     * @access public
     * @return array
     * 
     **/
    public function getAllLogEntries() 
    {
        $records = $this->logEntryRecord->findAll();
        return LumberJack_LogEntryModel::populateModels($records, 'id');
    }
    
    /**
     * searchLogEntries
     *
     * @access public
     * @param array $params array(
     *         'columns' => array(...), 
     *         'q' => <q:''>, 
     *         'limit' => <limit:10>, 
     *         'start' => <start:0>, 
     *         'sortByIndex' => <sortByIndex:id>,
     *         'sortDir' => <sortDir:asc>,
     *     )
     * @return array array('count' => <count>, 'records' => array(array(),...))
     * 
     **/
    public function searchLogEntries($params = array()) 
    {
        $select = '*';
        $order_column = 'id';
        
        $columns = Arr::get($params, 'columns', array());
        if ( ! empty($columns)) 
        {
            unset($params['columns']);
            $select = implode(', ', $columns);
            $sortByIndex = Arr::get($params, 'sortByIndex');
            $order_column = Arr::get($columns, $sortByIndex, 'id');
        }
        
        $offset = (int) Arr::get($params, 'start', 0);
        $limit = (int) Arr::get($params, 'limit', 10);
        
        $query = blx()->db->createCommand()->from('lumberjack_log_entries');
            
        if ($q = Arr::get($params, 'q'))
        {
            foreach ($columns as $column) 
            {
                $query = $query->orWhere(array('like', $column, '%'.$q.'%'));
            }
        }
        
        $count_query = clone $query;
        $count_data = $count_query->select('count(id) as count')->queryRow();
                 
        $records = $query->select($select)
                        ->limit($limit, $offset)
                        ->order(array($order_column . ' ' . Arr::get($params, 'sortDir', 'asc')))
                        ->queryAll();   
        return array(
            'count'         => Arr::get($count_data, 'count', 0),
            'records'       => $records,
        );
    }
    
    /**
     * log
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function log($attributes = array()) 
    {
        $model = $this->newLogEntry($attributes);
        $logEntrySaved = $this->saveLogEntry($model);
        if ($logEntrySaved) 
        {
            blx()->plugins->callHook('lumberJackLogEntrySaved', array($model));
        }
        return $logEntrySaved;
    }
    
    /**
     * Get a new log entry
     *
     * @param  array $attributes
     * @return LumberJack_LogEntryModel
     */
    public function newLogEntry($attributes = array())
    {
        $model = new LumberJack_LogEntryModel();
        $model->setAttributes($attributes);
        return $model;
    }
    
    /**
     * Save a new or existing ingredient back to the database.
     *
     * @param  CocktailRecipes_IngredientModel $model
     * @return bool
     */
    public function saveLogEntry(LumberJack_LogEntryModel &$model)
    {
        $id = $model->getAttribute('id');
        
        if ($id) 
        {
            $record = $this->logEntryRecord->findByPk($id);
            if ($record === null) 
            {
                throw new Exception(Blocks::t('Can\'t find log entry with ID "{id}"', array('id' => $id)));
            }
        } 
        else 
        {
            $record = $this->logEntryRecord->createRecord();
        }
                
                 
        $record->level = $model->level;
        $record->message = $model->message;
        $record->plugin_name = $model->plugin_name;
        $record->meta = $model->meta;
        
        if ($record->save()) 
        {
            // update id on model (for new records)
            $model->setAttribute('id', $record->getAttribute('id'));
            return true;
        } 
        else 
        {
            $model->addErrors($record->getErrors());
            return false;
        }
    }
    

}
