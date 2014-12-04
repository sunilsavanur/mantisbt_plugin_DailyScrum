<?php

html_page_top( );
	$view_dt	= $_POST['date_year'] . '-' . $_POST['date_month'] . '-' . $_POST['date_day'];
	//echo $_POST['p_handler_id'];
	$team_member = $_POST['p_handler_id'];
//	echo $view_dt;
?>

<html>
<body>

<h1 align="center">View Person Wise Scrum </h1>


</br>
<?php
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
	$access_level = current_user_get_access_level();
	//echo $access_level;
	$user_id = auth_get_current_user_id();	
	//echo $user_id;
	
	$g_project = helper_get_current_project();
	//echo $g_project;
	
	if( !isset($_POST['p_handler_id']) )
	{
		echo '<br /><div class="center">';
		echo  'Please select team member again !' . '<br />';
		print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
		echo '</div>';
		exit();
	}
	
	if( $access_level >= 70) // manager and administrator access
		$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where project_id=$g_project AND handler_id=$team_member ORDER BY tid DESC LIMIT 100";
		   
	if( $access_level == 90) // administrator	
	{
		if( $g_project == 0) // and admin selects All Projects
			$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where handler_id=$team_member ORDER BY tid DESC LIMIT 100";
	}	

	//$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where scrum_date='$today'";
	//echo $sql;
	
	mysql_select_db('bugtracker');
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not select row table: ' . mysql_error());
	  echo $sql;
	  print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
	}
	else 
	{
		//echo "Table daily scrum data row inserted successfully\n";
		// $fieldinfo=mysqli_fetch_field($retval);
		echo '<table BORDER cellpadding="2" cellspacing="5" class="db-table" align="center">';
		//echo '<tr><th>TransactionID</th><th>budID</th><th>handlerID</th><th>Date</th><th>Action</th><th>EOD status</th><th>Risks</th><th>Action Status</th>';
		echo '<tr><th>TransactionID</th><th>handlerID</th><th>Date</th><th>Action</th><th>EOD status</th><th>Remarks/Risks</th><th>Action Status</th>';
		while($row2 = mysql_fetch_row($retval)) {
			echo '<tr>';
			foreach($row2 as $key=>$value) {
			//echo $key;
			
				if($key == 1)
					$value =  user_get_name( $value );  // overwrite handler_id with actual names to be displayed in columns
				if($key == 0)
				{
					
					echo '<td>',"<a href=plugin.php?page=DailyScrum/update_scrum.php&action=$value>" . $value . "</a>",'</td>';
					//echo '<td>',"<a href='".$value."'>plugin_page( 'update_scrum' )</a>",'</td>';
					//echo '<td>',"<a href=>" . $value . "</a>",'</td>';
					//<a href='#'>" . $value . "</a>
					
				}
				else {
					echo '<td>',$value,'</td>';
				}
			}
			echo '</tr>';
		}
		echo '</table><br />';
	
	}
	
	mysql_close($conn);
?>

</body>
</html>

<?php

	echo '<br /><div class="center">';
	echo lang_get( 'operation_successful' ) . '<br />';
	print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
	echo '</div>';
	
html_page_bottom();