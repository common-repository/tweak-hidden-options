<?php
/**
 * Add the options page to the settings menu
 */
function tho_add_settings_menu(){
	//Create a new link to the settings menu
	//Returns the suffix of the page that can later be used in the actions etc
	$page = add_options_page(
		'Tweak Hidden Options', //name of the options page
		'Tweak Hidden Options', //link of the menu
		'manage_options', //the permissions that the users has to have to access this page
		'tweak-hidden-options', //the menu link
		'tho_display_options_page' //the function that is going to be called if the created page is loaded
	);
	//If the form was submitted
	if( isset($_POST['tho_options_save']) ){
		//Add the action to the plugin head to call tho_save_options
		add_action("admin_head-$page", 'tho_save_options');
	}
}
add_action( 'admin_menu', 'tho_add_settings_menu' );

/**
 * Displays the option page
 */
function tho_display_options_page(){
	$options = tho_get_available_options();
	?>
	<div class="wrap">
		<div class="wpsos-global-notification">By using this plugin, you’re eligible for a 5% discount on <a href="http://www.wpsos.io/pricing">WPSOS' security services</a>: virus cleanup, site securing and security maintenance!</div>
		<h1>Tweak Hidden Options of WordPress</h1>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<?php if( isset( $_POST['tho_options_save'] ) ):?>
				<div class="updated"><p><strong><?php _e( 'Options saved.' ); ?></strong></p></div>
			<?php endif; ?>
			<?php wp_nonce_field( 'tho-save-options' ); ?>
			<table class="form-table">
				<tr>
					<th>Option</th><th>Value</th>
				</tr>	
				<?php 
				//Render all the options that are available for change
				foreach( $options as $option => $values ): ?>
				<tr>
					<td><label for="<?php echo $option; ?>"><?php echo $option; ?></label></td>
					<td>
						<select id="<?php echo $option; ?>" name="<?php echo $option; ?>">
							<?php
							//Mark as if the default option should be selected
							$default_option = true;
							//Render all the values
							foreach( $values as $name => $value ):
								//If some other option is choosed
								if( get_option( $option ) == $name ):
									//Then the default (empty) option is false
									$default_option = false;
								endif;
								?>
								<option value="<?php echo $name; ?>" <?php echo get_option( $option ) == $name ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
							<?php endforeach; ?>
							<option value="" <?php echo $default_option ? 'selected="selected"' : ''; ?>>--</option>
						</select>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<p>
				<input type="submit" value="Save options" name="tho_options_save">
			</p>
		</form>
	</div>
	<?php
}
add_action( 'admin_head', 'tho_display_custom_css' );
function tho_display_custom_css(){ 
$output='<style>
.wpsos-global-notification {
    padding: 1px 10px;
    background: #fff;
    height: 30px;
    line-height: 30px;
}

.wpsos-global-notification a {
	color: #17a05e;
	font-weight: bold;
}
</style>';
echo $output;
}
?>