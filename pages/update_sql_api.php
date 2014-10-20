<?php
//function daily_scrum_insert_record($assign_to = 0, $date = 0, $action_items = 0 , $done = 0, $impediments = 0, $ds_submit_button){
html_page_top( );

//echo $risks_item;
//$the_risk=htmlspecialchars($_GET["risks_item"]);

//	echo "Transaction ID ". $_POST['the_tid']. "<br />";
//	echo "What was done  ". $_POST['action_item'].  "<br />";
//	echo "Today s plan  ". $_POST['todo_item'].  "<br />";
//	echo "Risks are ". $_POST['risks_item'].  "<br />";
//	echo "Risks are ". $risks_item.  "<br />";
//	echo "Risks Resolution ". $_POST['risks_resolution'].  "<br />";
//	echo "Risks Resolution ". $_POST['risk_resolution'].  "<br />";

	$the_trid=(int)$_POST['the_trid'];
	$the_todo=$_POST['todo_item'];
	$the_risk=$_POST['risks_items'];
	$the_resolution=$_POST['risk_resolution'];
	$the_handler_id=$_POST['vhandler_id'];
	
//	echo $the_trid;
//	echo "";
//	echo $the_todo;
//	echo "";
//	echo $the_risk;
//	echo "";
//	echo $the_resolution;
//	echo $_POST['delete'];
	
	
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if(! $conn )
	{
	  die('Could not connect: ' . mysql_error());
	}
//	echo 'Connected successfully';
//	echo " ";

	$access_level = current_user_get_access_level();


	//$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where project_id=$g_project";		   
	
	if ( isset( $_POST['delete'] ) ) 
	{
		if( $access_level >= 70) // manager and administrator access
		{
			echo "Deleting the record...   " ;
			$sql = "DELETE FROM mantis_daily_scrum_table WHERE tid=$the_trid" ; // Delete
		}
		else
		{
			echo "Can not delete the record...   " ;
			echo '<br /><div class="center">';
			//echo lang_get( 'operation_successful' ) . '<br />';
			print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
			echo '</div>';
			exit();
		}
		
	}
	else // It is update operation
	{
		if( $access_level >= 70) // manager and administrator access
		{
			$sql = "UPDATE mantis_daily_scrum_table SET todo = '$the_todo', impediments = '$the_risk', riskresolution = '$the_resolution' WHERE tid=$the_trid" ;
		}
		else
		{
			$sql = "UPDATE mantis_daily_scrum_table SET todo = '$the_todo', impediments = '$the_risk' WHERE tid=$the_trid" ;
		}
	}
	
	mysql_select_db('bugtracker');
	//echo $sql;
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		echo $sql;
	  die('Could not UPDATE row table: ' . mysql_error());
	}
//	echo "Table daily scrum data row updated successfully\n";
	// Commit transaction
	printf("Records affected: %d\n", mysql_affected_rows());
	mysql_close($conn);

	echo '<br /><div class="center">';
	echo lang_get( 'operation_successful' ) . '<br />';
	print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
	echo '</div>';
		

	html_page_bottom();

?>