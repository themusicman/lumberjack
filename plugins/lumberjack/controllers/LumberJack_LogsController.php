<?php

namespace Craft;

/**
 *
 * Defines actions which can be posted to by forms in our templates.
 */
class LumberJack_LogsController extends BaseController
{
    public function actionTableData() 
    {        
        
        $columns = array_filter(explode(',', craft()->request->getParam('sColumns', '')));
        
        $params = array(
            'start'         => craft()->request->getParam('iDisplayStart', 0),
            'limit'         => craft()->request->getParam('iDisplayLength', 10),
            'q'             => craft()->request->getParam('sSearch'),
            'columns'       => $columns,
            'sortByIndex'   => craft()->request->getParam('iSortCol_0', 0),
            'sortDir'       => craft()->request->getParam('sSortDir_0', 'asc'),
        );
        
        //lets log are query
        // if (($lumberJack = craft()->plugins->getPlugin('LumberJack')) && $lumberJack->isInstalled && $lumberJack->isEnabled)
        // {
        //     craft()->lumberJack->log(array(
        //         'plugin_name'       => 'LumberJack',
        //         'level'             => LumberJack_LogEntryModel::INFO,
        //         'message'           => 'Datatable query was executed',
        //         'meta'              => $params,
        //     ));
        // }
        
        $data = craft()->lumberJack->searchLogEntries($params); 
          
        $count = Arr::get($data, 'count');
        $records = Arr::get($data, 'records', array());
            
        $output = array(
            "sEcho"                 => craft()->request->getParam('sEcho'),
            "iTotalRecords"         => $count,
            "iTotalDisplayRecords"  => $count,
            "aaData"                => array()
        );
        
        foreach ($records as $record) 
        {
            $row = array();
            
            foreach ($record as $key => $value) 
            {
                if ($key === 'dateCreated') 
                {            
                    $row[] = DateTimeHelper::nice(DateTimeHelper::fromString($value));
                }
                else
                {
                    $row[] = $value;
                }
            }
            
            $output['aaData'][] = $row;
        }
                
        $this->returnJson($output);
    }

}
