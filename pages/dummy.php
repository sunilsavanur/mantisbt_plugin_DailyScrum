<?php

html_page_top( );

?>


<html>
<body>
<h1>A small example page to insert some data in to the MySQL database using PHP</h1>
<form action="<?php echo plugin_page( 'insert' ) ?>" method="post">
Firstname: <input type="text" name="fname" /><br><br>
Lastname: <input type="text" name="lname" /><br><br>
 
<input type="submit" name="submit1"/>
</form>
</body>
</html>

<?php

html_page_bottom();