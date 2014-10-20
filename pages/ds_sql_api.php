<?php
//function daily_scrum_insert_record($assign_to = 0, $date = 0, $action_items = 0 , $done = 0, $impediments = 0, $ds_submit_button){
html_page_top( );

//	echo "Daily Scurm ". $_POST['handler_id']. "<br />";
//	echo "What was done  ". $_POST['what_description'].  "<br />";
//	echo "Today s plan  ". $_POST['todo_description'].  "<br />";
//	echo "Risks are ". $_POST['impediments_description'].  "<br />";
//	echo "Risks Resolution ". $_POST['risk_resolution'].  "<br />";
	
	$dt	= $_POST['date_year'] . '-' . $_POST['date_month'] . '-' . $_POST['date_day'];
	if($_POST['date_year'] != date("Y") )
	{
		$dt = date("Y/m/d"); //Initialize to today's date
	}	
//	echo $dt;
	$datestamp = strtotime($dt);
	
	//$datestamp = date(DATE_ATOM, $datestamp);
	$datestamp = date("Y/m/d", strtotime($dt));
//	echo $datestamp;

	$submit = isset( $_POST['ds_submit'] );
//	echo $submit;
	
	$p_project = helper_get_current_project();
//	echo $p_project;
	
	if ( ! isset( $_POST['handler_id'] ) || $_POST['handler_id'] == 'user0' ) 
	{
		echo '<br /><div class="center">';
		echo lang_get( 'Assignment cannot be null' ) . '<br />';
		print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
		echo '</div>';
		exit();
	}
	
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	//$t_ds_table = db_get_table( 'mantis_daily_scrum_table' );
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if(! $conn )
	{
	  die('Could not connect: ' . mysql_error());
	}
//	echo 'Connected successfully';

	$sql = "INSERT INTO mantis_daily_scrum_table ".
		   "(project_id,handler_id,scrum_date, whatisdone, todo, impediments, riskresolution) ".
		   "VALUES ".
		   "('$p_project','$_POST[handler_id]','$datestamp','$_POST[what_description]','$_POST[todo_description]','$_POST[impediments_description]','$_POST[risk_resolution]')";
		   
	mysql_select_db('bugtracker');
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not insert row table: ' . mysql_error());
	}
	//echo "Table daily scrum data row inserted successfully\n";
	printf("Records affected: %d\n", mysql_affected_rows());
	mysql_close($conn);

	//print_successful_redirect( 'plugins/DailyScrum/pages/main_daily_scrum.php' );
	
	

		echo '<br /><div class="center">';
		echo lang_get( 'operation_successful' ) . '<br />';
		print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
		echo '</div>';
		

	
//}
	html_page_bottom();
//}
?>