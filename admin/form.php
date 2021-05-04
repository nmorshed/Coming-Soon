<h1>BW Coming Soon Settings Page</h1>
<form method="post" action="<?php echo admin_url( 'admin-post.php' ) ?>">
	<?php
	wp_nonce_field( "bwcs_settings" );
	$bwcs_enable_plugin = get_option( 'bwcs_enable_plugin' );
	$plugin_enabled = ( $bwcs_enable_plugin != 0 ) ? 'checked' : '';

	?>
	<input type="hidden" name="action" value="bwcs_admin_page">
	
	<table class="form-table" role="presentation">

		<tbody>

			<tr>
				<th scope="row">
					<label for="bwcs_enable_plugin"> <?php _e( 'Enable This Plugin', 'bwcs' ); ?> </label>
				</th>
				<td>
					<input name="bwcs_enable_plugin" type="checkbox" id="bwcs_enable_plugin" value="1" <?php echo $plugin_enabled; ?> />
					<label for="bwcs_enable_plugin">Enable</label>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="bwcs_coming_soon_page"><?php _e( 'Select Coming Soon / Maintenance Page', 'bwcs' ); ?></label>
				</th>
				<td>
					<select name="bwcs_coming_soon_page">
						<?php echo bwcs_pages_as_dropdown(); ?>
					</select>
					
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label><?php _e( 'Who can see other pages', 'bwcs' ); ?></label>
				</th>
				<td>
					<?php bwcs_roles_as_checkbox() ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label><?php _e( 'Display pages along with coming soon page', 'bwcs' ); ?></label>
				</th>
				<td>
					<?php bwcs_pages_as_checkbox() ?>
				</td>
			</tr>
			
		</tbody>
	</table>

	<?php
	submit_button( 'Save Settings' );
	?>
</form>



<?php

function bwcs_get_all_pages(){

	$pages 			= get_pages();
	$pages_in_array	= array();

	foreach ( $pages as $page ) {

		$pages_in_array[ $page->ID ] = $page->post_title;
	}

	return $pages_in_array;

}

function bwcs_pages_as_dropdown(){

	$seleced_page_ID = get_option( 'bwcs_coming_soon_page' );

	if ( empty( $seleced_page_ID ) ) {

		$seleced_page_ID = get_page_by_path( 'coming-soon' )->ID;

	}

	$pages = bwcs_get_all_pages();
	foreach ( $pages as $key => $value ) {

		$selected = ( $key == $seleced_page_ID ) ? 'selected="selected"': '';
		echo "<option value='$key' $selected> $value </option>";
	}
}


function bwcs_roles_as_checkbox(){
	
	global $wp_roles;
    $roles 			= $wp_roles->get_names();
    $selected_roles = get_option( 'bwcs_roles' );

    $selected = '';
    foreach ( $roles as $key => $value ) {

    	if ( !empty( $selected_roles ) ) {
    		$selected = ( in_array( $key, $selected_roles ) ) ? 'checked' : '';
    	}    	

    	$admin = ( $key == 'administrator' ) ? 'checked disabled' : '';    	

    	echo "<input type='checkbox' name='bwcs_roles[]' value='$key' id='role-$key' $admin $selected /> <label for='role-$key'>$value </label>";
    }

}


function bwcs_pages_as_checkbox(){

	$seleced_coming_soon_page_ID = get_option( 'bwcs_coming_soon_page' );

	if ( empty( $seleced_coming_soon_page_ID ) ) {

		$seleced_coming_soon_page_ID = get_page_by_path( 'coming-soon' )->ID;

	}

	$selected 		= '';
	$selected_pages = get_option( 'bwcs_other_pages' );
	$pages 			= bwcs_get_all_pages();
	foreach ( $pages as $key => $value ) {

		if ( $seleced_coming_soon_page_ID == $key ) {
			continue;
		}

		if ( ! empty( $selected_pages ) ) {
    		$selected = ( in_array( $key, $selected_pages ) ) ? 'checked' : '';
    	}		
		
		echo "<input type='checkbox' name='bwcs_other_pages[]' value='$key' id='page-$key' $selected /> <label for='page-$key'>$value </label>";
	}
}