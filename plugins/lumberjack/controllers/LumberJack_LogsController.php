<?php

namespace Blocks;

/**
 *
 * Defines actions which can be posted to by forms in our templates.
 */
class LumberJack_LogsController extends BaseController
{
    public function actionTableData() 
    {        
        
        $columns = array_filter(explode(',', blx()->request->getParam('sColumns', '')));
        
        $params = array(
            'start'         => blx()->request->getParam('iDisplayStart', 0),
            'limit'         => blx()->request->getParam('iDisplayLength', 10),
            'q'             => blx()->request->getParam('sSearch'),
            'columns'       => $columns,
            'sortByIndex'   => blx()->request->getParam('iSortCol_0', 0),
            'sortDir'       => blx()->request->getParam('sSortDir_0', 'asc'),
        );
        
        //lets log are query
        // if (($lumberJack = blx()->plugins->getPlugin('LumberJack')) && $lumberJack->isInstalled && $lumberJack->isEnabled)
        // {
        //     blx()->lumberJack->log(array(
        //         'plugin_name'       => 'LumberJack',
        //         'level'             => LumberJack_LogEntryModel::INFO,
        //         'message'           => 'Datatable query was executed',
        //         'meta'              => $params,
        //     ));
        // }
        
        $data = blx()->lumberJack->searchLogEntries($params); 
          
        $count = Arr::get($data, 'count');
        $records = Arr::get($data, 'records', array());
            
        $output = array(
            "sEcho"                 => blx()->request->getParam('sEcho'),
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
