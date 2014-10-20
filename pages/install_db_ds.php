<?php

html_page_top( );

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
echo 'Connected successfully';
$sql = 'CREATE TABLE mantis_daily_scrum_table( '.
       'tid INT NOT NULL AUTO_INCREMENT, '.
	   'project_id INT NOT NULL, '.
	   'handler_id INT NOT NULL, '.
	   'scrum_date    date NOT NULL, '.
       'whatisdone VARCHAR(255) NOT NULL UNIQUE, '.
       'todo  VARCHAR(767) NOT NULL, '.
	   'impediments  VARCHAR(767) NOT NULL, '.
	   'riskresolution  VARCHAR(10) NOT NULL, '.
       'primary key ( tid ))';

mysql_select_db('bugtracker');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not create table: ' . mysql_error());
}
echo " Table employee created successfully. \n";


//$sql ="update `mantis_config_table` set value=1 where config_id='plugin_DailyScrum_schema'";
//$retval = mysql_query( $sql, $conn );
//printf("Records affected: %d\n", mysql_affected_rows());

mysql_close($conn);
?>
<?php
	//echo '<br /><div class="center">';
	echo lang_get( 'operation_successful' ) . '<br />';
	print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
	echo '</div>';
	
html_page_bottom();