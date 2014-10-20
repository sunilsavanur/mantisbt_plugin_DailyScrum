<?php

html_page_top( );

?>

<html>
<body>

<h1 align="center">View Person wise Scrum </h1>
<form action="<?php echo plugin_page( 'person_wise_sql_view' ) ?>" method="POST" >

	<br>
	</br>
	
	<tr>
		<?php echo plugin_lang_get( 'select_team_member' )?>
		<td>
			<select <?php echo helper_get_tab_index() ?> name="p_handler_id">
				<?php //<option value="0" selected="selected"></option>?>
				<option value=<?php echo auth_get_current_user_id()?> selected="selected"></option>
				<?php print_assign_to_option_list( $f_handler_id ) ?>
			</select>
		</td>
	</tr>

<input type="submit" class="button" id="button3" value="<?php echo lang_get( 'submit_button' ) ?>" name="p_submit" />
</form>
</body>
</html>

<?php
//	echo '<br /><div class="center">';
//	echo lang_get( 'operation_successful' ) . '<br />';
//	print_bracket_link( plugin_page( 'main_daily_scrum' ), lang_get( 'proceed' ) );
//	echo '</div>';
html_page_bottom();
