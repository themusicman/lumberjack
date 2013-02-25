#LumberJack
A logging plugin for Blocks CMS.

##Installation
1. Put the plugins/lumberjack folder in the blocks/plugins folder of the site.  
2. Login and go to the Settings > Plugins screen and click "Install." 
3. Cue the [music](http://youtu.be/5zey8567bcg "music")

##Usage

Example usage in code:

    //first check to see if it is installed and enabled. then make the call to log
    if (($lumberJack = blx()->plugins->getPlugin('LumberJack')) && $lumberJack->isInstalled && $lumberJack->isEnabled)
    {
        $params = array(...);
        
        blx()->lumberJack->log(array(
            'plugin_name'       => 'LumberJack',
            'level'             => LumberJack_LogEntryModel::INFO,
            'message'           => 'Datatable query was executed',
            'meta'              => $params,
        ));
    }
    
Example usage in template:

    {% set logEntrySaved = blx.lumberjack.log({plugin_name: "LumberJack", level: 'debug', message: 'This is a test...', meta: {username: 'me', first_name: 'Thomas'}}) %}
    

##Todo
1. Move CSS and JS out of index.html file to external files
2. Improve column spacing and style of log viewer table.
3. Add notifiers (email/webhook/hipchat)