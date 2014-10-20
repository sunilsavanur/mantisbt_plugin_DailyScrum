

<?php
//require_once( 'ds_sql_api.php' );
html_page_top( );

?>
<?php

	$g_access_level = current_user_get_access_level();	
	//echo $g_access_level;
	
	if( $g_access_level < 70)
	{
		echo '<br /><div class="center">';
		//echo lang_get( 'operation_successful' ) . '<br />';
		echo "You are not authorised for this operation" . '<br />';
		print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
		echo '</div>';
		exit();
	}
	
function date_dropdown($year_limit = 0){
        $html_output = '    <div id="date_select" >'."\n";
        $html_output .= '        <label for="date_day">Date of Scrum:</label>'."\n";

        /*days*/
        $html_output .= '           <select name="date_day" id="day_select">'."\n";
            for ($day = 1; $day <= 31; $day++) {
                $html_output .= '               <option value=date("d");>' . $day . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*months*/
        $html_output .= '           <select name="date_month" id="month_select" >'."\n";
        $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($month = 1; $month <= 12; $month++) {
               // $html_output .= '               <option value="' . $month . '">' . $months[$month] . '</option>'."\n";
			    $html_output .= '               <option value=date("F");>' . $months[$month] . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*years*/
        $html_output .= '           <select name="date_year" id="year_select">'."\n";
            for ($year = 2012; $year <= (date("Y") - $year_limit); $year++) {
                $html_output .= '               <option value=date("Y");>' . $year . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        $html_output .= '   </div>'."\n";
		
		//echo $html_ouput;
		

// <form action="ds_sql_api.php" method="POST">		
//<form action="<?php $_PHP_SELF " method="POST" name="ds_submit">
    return $html_output;
}
?>


<?php ?>
<form action="<?php echo plugin_page( 'ds_sql_api' ) ?>" method="POST" >
		<!-- Start date -->

	
<?php 
$date_day=date("d");
$date_month=date("F");
$date_year=date("Y");
echo date_dropdown();?>

	<br>
	</br>
	
	<tr>
		<?php echo lang_get( 'assign_to' )?>
		<td>
			<select <?php echo helper_get_tab_index() ?> name="handler_id">
				<?php //<option value="0" selected="selected"></option>?>
				<option value=<?php echo auth_get_current_user_id()?> selected="selected"></option>
				<?php print_assign_to_option_list( $f_handler_id ) ?>
			</select>
		</td>
	</tr>

	<br>
	</br>
	
	<tr>
		<?php echo plugin_lang_get( 'action_items' ) ?> 
		</br>
		<td class=row-label align=left valign=top>
			<span class="required">*</span><?php print_documentation_link( 'description' ) ?>
		</td>
		<td>
			<textarea <?php echo helper_get_tab_index() ?> name="what_description" style="vertical-align:top;font-family:Arial" cols="80" rows="6"><?php echo string_textarea( $f_description ) ?></textarea>
		</td>
	</tr>
	
	
	<br>
	</br>
	
	<tr>
		<?php echo plugin_lang_get( 'status_by_eod' )?>
		</br>
		<td>
			<span class="required">*</span><?php print_documentation_link( 'description' ) ?>
		</td>
		<td>
			<textarea <?php echo helper_get_tab_index() ?> name="todo_description" style="vertical-align:top;font-family:Arial" cols="80" rows="6"><?php echo string_textarea( $f_description ) ?></textarea>
		</td>
	</tr>
	
	<br>
	</br>
	
	<tr>
		<?php echo plugin_lang_get( 'impediments' )?>
		</br>
		<td>
			<span class="required">*</span><?php print_documentation_link( 'description' ) ?>
		</td>
		<td>
			<textarea <?php echo helper_get_tab_index() ?> name="impediments_description" style="vertical-align:top;font-family:Arial" cols="80" rows="6"><?php echo string_textarea( $f_description ) ?></textarea>
		</td>
	</tr>
	
	<br>
	</br>
	
	
	<tr>
		<?php echo plugin_lang_get( 'Risk_Resolution' ) ?>
		<td>
			<select <?php echo helper_get_tab_index() ?> name="risk_resolution">
				<?php 
				$access_level = current_user_get_access_level();
				if( $access_level >= 70) // manager and administrator access
				{
					$action_close_html_output = '    <option value="Open">Open</option>'."\n";
					$action_close_html_output .= '   <option value="Close">Close</option>'."\n";
				}
				else
				{
					$action_close_html_output = '    <option value="NA">Open</option>'."\n";
				}
				echo $action_close_html_output;
				?>
			</select>
		</td>
	</tr>
	
	<br>
	</br>
	
	
	<input type="submit" class="button" value="<?php echo lang_get( 'submit_button' ) ?>" name="ds_submit" />
	</form>
	
	<br>
	</br>
	

	 <?php	$t_username = current_user_get_field( 'username' );
	$t_access_level = get_enum_element( 'access_levels', current_user_get_access_level() );
	$t_now = date( config_get( 'complete_date_format' ) );
	$t_realname = current_user_get_field( 'realname' );
	
//	echo $t_username;
//	echo "  ";
//	echo $t_access_level;
//	echo "  ";
//	echo current_user_get_access_level();
//	echo "<br />";

	?>	
	<br>
	</br>
	
	<?php     
//	echo "Daily Scurm ". $_POST['handler_id']. "<br />";
//	echo "What was done  ". $_POST['what_description'].  "<br />";
//	echo "Today s plan  ". $_POST['todo_description'].  "<br />";
//	echo "Risks are ". $_POST['impediments_description'].  "<br />";
//	echo "date ". $_POST['date_day'].  "<br />";
//	echo "month ". $_POST['date_month'].  "<br />";
//	echo "Year ". $_POST['date_year'].  "<br />";
//	echo "Year ". $_POST['risk_resolution'].  "<br />";

	$dt	= $_POST['date_year'] . '-' . $_POST['date_month'] . '-' . $_POST['date_day'];
//	echo $dt;
//	echo "whole date ". $_POST['dt'].  "<br />";
	//$submit = isset( $_POST['ds_submit'] );
//	echo $submit. "<br />";
	
//	daily_scrum_insert_record($_POST['handler_id'], $dt, $_POST['what_description'] , $_POST['todo_description'], $_POST['impediments_description'] );
	 exit();
	 ?>
	 

	
<?php

html_page_bottom();