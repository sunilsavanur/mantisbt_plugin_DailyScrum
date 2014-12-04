<?php
 
class DailyScrumPlugin extends MantisPlugin {
 
  function register() {
    $this->name        = 'Daily Scrum';
    $this->description = 'Gives your Mantis Daily Scrum powers.';
 
    $this->version     = '1.0';
    $this->requires    = array(
      'MantisCore'       => '1.2.0',
    );
 
    $this->author      = 'Sunil Savanur';
    $this->contact     = 'Sunil.Savanur@h.com';
    $this->url         = 'http://local';
  }
 
	function events() {
        return array(
            'EVENT_DAILYSCRUM_FOO' => EVENT_TYPE_EXECUTE,
            'EVENT_DAILYSCRUM_BAR' => EVENT_TYPE_CHAIN,
			//'EVENT_LAYOUT_CONTENT_BEGIN' =>EVENT_TYPE_OUTPUT,
        );
    }
 
	function hooks() {
        return array(
            'EVENT_DAILYSCRUM_FOO' => 'foo',
            'EVENT_DAILYSCRUM_BAR' => 'bar',
			'EVENT_MENU_MAIN' => 'main_ds_menu',
			//'EVENT_MENU_SUMMARY' => 'main_dummy',
			//'EVENT_LAYOUT_CONTENT_BEGIN' => 'daily_scrum_view_menu',
			'EVENT_MENU_SUMMARY' => 'install_db_ds',
        );
    }
 
    function foo( $p_event ) {
        echo 'In method foo(). ';
		//return print_bracket_link( plugin_page( 'daily_scrum_view_menu' ), 'new_scrum' );
    }

    function bar( $p_event, $p_chained_param ) {
        return str_replace( 'foo', 'bar', $p_chained_param );
    }

	function config() {
        return array(
            'foo_or_bar' => 'foo',
        );
	}	

	function init() {
	plugin_event_hook( 'EVENT_PLUGIN_INIT', 'header' );
	}
 
  /**
   * Handle the EVENT_PLUGIN_INIT callback.
   */
	function header() {
	header( 'DailyScrum-Mantis: This Mantis has Daily Scrum powers.' );
	}

	function main_ds_menu( ) {
		return array( '<a href="' . plugin_page( 'main_daily_scrum' ) . '">' . plugin_lang_get( 'menu_daily_scrum' ) . '</a>', );
	}

//	function daily_scrum_view_menu( ) {
//		return print_bracket_link( plugin_page( 'daily_scrum_view_menu' ), 'view' );
//	}

//	function main_dummy( ) {
//		return array( 
					//print_bracket_link( plugin_page( 'dummy' ), plugin_lang_get( 'dummy' ) ),
					//print_bracket_link( plugin_page( 'install_db_ds' ), plugin_lang_get( 'install_db_ds' ) )
//					array( '<a href="' . plugin_page( 'dummy' ) . '">' . plugin_lang_get( 'dummy' ) . '</a>', ),
//					array( '<a href="' . plugin_page( 'install_db_ds' ) . '">' . plugin_lang_get( 'install_db_ds' ) . '</a>', )
//					);
//	}

	function summary_ds_menu( ) {
		return array( '<a href="' . plugin_page( 'summary_daily_scrum' ) . '">' . plugin_lang_get( 'daily_scrum_summary' ) . '</a>', );
	}

  	function install_db_ds( ) {
		return array( '<a href="' . plugin_page( 'install_db_ds' ) . '">' . plugin_lang_get( 'install_db_ds' ) . '</a>', );
	}	
	
	function schema() {
//	 return array ( array('CreateTableSQL',
//							array(plugin_table( 'mantis_daily_scrum_table' ),"
//								tid			 I  UNSIGNED NOTNULL PRIMARY AUTOINCREMENT,
//								project_id 		 I  UNSIGNED NOTNULL DEFAULT '0',
//								handler_id 		 I  UNSIGNED NOTNULL DEFAULT '0',
//								date	 	T NOTNULL DEFAULT '0000-00-00 ',
//								whatisdone 		C(250) NOTNULL DEFAULT \" '' \",
//								todo 			C(250) NOTNULL DEFAULT \" '' \",
//								impediments 	C(250) NOTNULL DEFAULT \" '' \",  
//								riskresolution 	C(10) NOTNULL DEFAULT \" '' \", 
//								"), array( "mysql" => "DEFAULT CHARSET=utf8" )) 
//						); 

	}
	
	function plugin_callback_DailyScrum_schema() {
	 return array ( array('CreateTableSQL',
							array(plugin_table( 'mantis_daily_scrum_table' ),"
								tid			 I  UNSIGNED NOTNULL PRIMARY AUTOINCREMENT,
								project_id 		 I  UNSIGNED NOTNULL DEFAULT '0',
								handler_id 		 I  UNSIGNED NOTNULL DEFAULT '0',
								date	 	T NOTNULL DEFAULT '0000-00-00 ',
								whatisdone 		C(250) NOTNULL DEFAULT \" '' \",
								todo 			C(250) NOTNULL DEFAULT \" '' \",
								impediments 	C(250) NOTNULL DEFAULT \" '' \",  
								riskresolution 	C(10) NOTNULL DEFAULT \" '' \", 
								"), array( "mysql" => "DEFAULT CHARSET=utf8" )) 
						); 
	}
	
	function  plugin_callback_DailyScrum_upgrade()	{
	}
	
	function  plugin_callback_DailyScrum_uninstall()	{
		return array( 'DropTableSQL', array( mantis_daily_scrum_table ) );
	}
	
}
