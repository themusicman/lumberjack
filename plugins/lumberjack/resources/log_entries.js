jQuery(function() {
    jQuery('#log-entries').dataTable({
        "bPaginate": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": Craft.getActionUrl('lumberjack/logs/tableData'),
        "aoColumns": [
    			{ "sName": "id" },
    			{ "sName": "plugin_name" },
    			{ "sName": "level" },
    			{ "sName": "message" },
    			{ "sName": "meta" },
    			{ "sName": "dateCreated" }
		    ]
    });
});