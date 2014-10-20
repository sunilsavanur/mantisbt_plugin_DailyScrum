

<?php
//require_once( 'ds_sql_api.php' );
html_page_top( );

?>

<html>
<body>
<h2 align="center">Daily Scrum</h2>

</body>
</html>

<h2 align="center"><?php
print_bracket_link( plugin_page( 'new_scrum' ), plugin_lang_get( 'new_scrum' ) );
print_bracket_link( plugin_page( 'daily_scrum_view_menu' ), plugin_lang_get( 'daily_scrum_view_menu' ) );
print_bracket_link( plugin_page( 'view_all_scrums' ), plugin_lang_get( 'view_all_scrums' ) );
?>
</br>
</br>
<?php
$access_level = current_user_get_access_level();
if( $access_level >= 70) // manager and administrator access
{
print_bracket_link( plugin_page( 'view_risks' ), plugin_lang_get( 'view_impendiments' ) );
print_bracket_link( plugin_page( 'view_two_weeks' ), plugin_lang_get( 'two_weeks_assignments' ) );
print_bracket_link( plugin_page( 'view_person_wise' ), plugin_lang_get( 'person_wise_assignments' ) );
print_bracket_link( plugin_page( 'install_db_ds' ), plugin_lang_get( 'install_db_ds' ) );
}

?></h2>

	
<?php

html_page_bottom();