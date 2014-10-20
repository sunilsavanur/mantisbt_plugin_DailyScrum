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
	   'bug_id INT NOT NULL, '.
	   'handler_id INT NOT NULL, '.
	   'scrum_date    timestamp(6) NOT NULL, '.
       'whatisdone VARCHAR(200) NOT NULL, '.
       'todo  VARCHAR(200) NOT NULL, '.
	   'impediments  VARCHAR(200) NOT NULL, '.
       'primary key ( tid ))';

mysql_select_db('bugtracker');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not create table: ' . mysql_error());
}
echo "Table employee created successfully\n";
mysql_close($conn);


html_page_bottom();