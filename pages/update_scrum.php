<?php

html_page_top( );
//echo 'Hello ' . htmlspecialchars($_GET["action"]) . '!';
$the_tid=htmlspecialchars($_GET["action"]);
?>

<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if(! $conn )
	{
	  die('Could not connect: ' . mysql_error());
	}
	//$sql = "SELECT tid,handler_id,scrum_date,whatisdone,todo,impediments FROM `mantis_daily_scrum_table` where tid=$the_tid";
	$sql = "SELECT whatisdone FROM `mantis_daily_scrum_table` where tid=$the_tid";
	mysql_select_db('bugtracker');
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not insert row table: ' . mysql_error());
	}
	else 
	{
		$row = mysql_fetch_array($retval);
		$action_item = $row[0];
	}
	//echo $retval;
	
	$sql = "SELECT todo FROM `mantis_daily_scrum_table` where tid=$the_tid";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not insert row table: ' . mysql_error());
	}
	else 
	{
		$row = mysql_fetch_array($retval);
		$todo_item = $row[0];
		//echo $row[0];
	}
	
	
	$sql = "SELECT impediments FROM `mantis_daily_scrum_table` where tid=$the_tid";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not insert row table: ' . mysql_error());
	}
	else 
	{
		$row = mysql_fetch_array($retval);
		$risks_item = $row[0];
		//$risks_item = $retval;
	}
	//echo $retval;
	
	$sql = "SELECT riskresolution FROM `mantis_daily_scrum_table` where tid=$the_tid";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not insert row table: ' . mysql_error());
	}
	else 
	{
		$row = mysql_fetch_array($retval);
		$risks_resolution = $row[0];
		//$risks_item = $retval;
	}
	//echo $retval;
	
	
//	echo $action_item;
//	echo $todo_item;
//	echo $risks_item;
//	echo $risks_resolution;
?>

<html>
<body>
<h2 align="center">Update Record</h2>
<form action="<?php echo plugin_page( 'update_sql_api' ) ?>" method="post">

 <br/>
<label readonly id="styled" style="vertical-align:Top;font-family:Arial" name="the_trid" >Transaction ID:</label>
<textarea readonly id="styled" name="the_trid" style="vertical-align:Top;font-family:Arial" cols="3" rows="1"><?php echo $the_tid;?></textarea>
 <br/>
  <br/>
  <?php 
$access_level = current_user_get_access_level();
if( $access_level >= 70) // manager and administrator access
{?>
  	<tr>
		<?php echo lang_get( 'assign_to' )?>
		<td>
			<select <?php echo helper_get_tab_index() ?> name="vhandler_id">
				<?php //<option value="0" selected="selected"></option>?>
				<option value=<?php echo auth_get_current_user_id()?> selected="selected"></option>
				<?php print_assign_to_option_list( $f_handler_id ) ?>
			</select>
		</td>
	</tr>
		<?php 
}?>
	
  <br/>
<br/>
 <?php echo plugin_lang_get( 'action_items' ) ?>
 <br/>
<textarea readonly id="styled" name="action_item" style="vertical-align:Top;font-family:Arial" cols="80" rows="6" ><?php echo $action_item;?></textarea>
<br/>
<br/>

<?php echo plugin_lang_get( 'status_by_eod' )?>
</br>
<textarea id="styled" name="todo_item" style="vertical-align:top;font-family:Arial" cols="80" rows="6" ><?php echo $todo_item;?></textarea>
<br/>
<br/>

<?php echo plugin_lang_get( 'impediments' )?>

</br>
<textarea id="styled" name="risks_items" style="vertical-align:top;font-family:Arial" cols="80" rows="6" ><?php echo $risks_item;?></textarea>
<br/>
<br/>

<?php 
$access_level = current_user_get_access_level();
if( $access_level >= 70) // manager and administrator access
{?>
	<?php echo plugin_lang_get( 'Risk_Resolution' ) ?>

	<select <?php echo $risks_resolution; ?> name="risk_resolution">
		<?php 
		//print_enum_string_option_list('resolution', config_get('default_bug_resolution'));
		?>
		<option selected value="Open">Open</option>
		<option value="Close">Close</option>
	</select>
	<?php 
}
?>

<br>
</br>
<input type="submit" class="button" id="button1" name="submit2"/>
<input type="submit" class="button" id="button2" value="Delete" name="delete"/>
</form>
</body>
</html>


<?php

html_page_bottom();