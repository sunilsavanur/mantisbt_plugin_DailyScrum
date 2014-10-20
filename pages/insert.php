<?php

html_page_top( );

?>

<html>
<body>
 
 
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
	echo 'Connected successfully';

	$sql = "INSERT INTO mantis_daily_scrum_table ".
		   "(handler_id,scrum_date, whatisdone, todo, impediments) ".
		   "VALUES ".
		   "('$assign_to','$date','$_POST[fname]','$_POST[lname]','$impediments')";
		   
	mysql_select_db('bugtracker');
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not insert row table: ' . mysql_error());
	}
	echo "Table daily scrum data row inserted successfully\n";
	mysql_close($conn);
?>
</body>
</html>

<?php

html_page_bottom();