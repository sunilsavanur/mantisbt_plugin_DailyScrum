<?php

html_page_top( );

$today=date('Y-m-d');

function view_date_dropdown($year_limit = 0){
        $html_output = '    <div id="date_select" >'."\n";
        $html_output .= '        <label align="center" for="date_day">Date of Scrum:</label>'."\n";

        /*days*/
        $html_output .= '           <select name="date_day" id="day_select">'."\n";
            for ($day = 1; $day <= 31; $day++) {
                $html_output .= '               <option>' . $day . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*months*/
        $html_output .= '           <select name="date_month" id="month_select" >'."\n";
        $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($month = 1; $month <= 12; $month++) {
                $html_output .= '               <option value="' . $month . '">' . $months[$month] . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*years*/
        $html_output .= '           <select name="date_year" id="year_select">'."\n";
            for ($year = 2012; $year <= (date("Y") - $year_limit); $year++) {
                $html_output .= '               <option>' . $year . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        $html_output .= '   </div>'."\n";
		
		//echo $html_ouput;
		

// <form action="ds_sql_api.php" method="POST">		
//<form action="<?php $_PHP_SELF " method="POST" name="ds_submit">
    return $html_output;
}
?>

<html>
<body>
<form action="<?php echo plugin_page( 'view_date_specific' ) ?>" method="POST" >
<h1 align="center">View Daily Scrum </h1>


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
	
	if( $access_level >= 70) // manager and administrator access
		$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where project_id=$g_project AND scrum_date='$today'";
	else /// everything else
		$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where handler_id=$user_id AND project_id=$g_project AND scrum_date='$today'";
		   
	if( $access_level == 90) // administrator	
	{
		if( $g_project == 0) // and admin selects All Projects
			$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where scrum_date='$today'";
	}	

	//$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments,riskresolution FROM `mantis_daily_scrum_table` where scrum_date='$today'";
	//echo $sql;
	
	mysql_select_db('bugtracker');
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not select row table: ' . mysql_error());
	}
	else 
	{
		//echo "Table daily scrum data row inserted successfully\n";
		// $fieldinfo=mysqli_fetch_field($retval);
		echo '<table BORDER cellpadding="2" cellspacing="5" class="db-table" align="center">';
		//echo '<tr><th>TransactionID</th><th>budID</th><th>handlerID</th><th>Date</th><th>Action</th><th>EOD status</th><th>Risks</th><th>Action Status</th>';
		echo '<tr><th>TransactionID</th><th>handlerID</th><th>Date</th><th>Action</th><th>EOD status</th><th>Risks</th><th>Action Status</th>';
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

<?php echo view_date_dropdown();
$today=date('Y-m-d');
//echo $today;
?>
	<input type="submit" class="button" align="center" value="<?php echo lang_get( 'submit_button' ) ?>" name="view_submit" />
	</form>
</body>
</html>

<?php
	//$view_dt	= $_POST['date_year'] . '-' . $_POST['date_month'] . '-' . $_POST['date_day'];
	//echo $view_dt;
	echo '<br /><div class="center">';
	echo lang_get( 'operation_successful' ) . '<br />';
	print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
	echo '</div>';
	
html_page_bottom();