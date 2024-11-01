<?php
//If the option gzipcompression is set to true
if( get_option( 'gzipcompression' ) ) {
	//Add the gzip compression function to init tag
	add_action( 'init', 'tho_gzip_compression' );
}

/**
 * Add gzip compression
 */
function tho_gzip_compression() {
	ob_start( 'ob_gzhandler' );
}
/**
 * Save the options from the POST request
 */
function tho_save_options(){
	check_admin_referer( 'tho-save-options' );
	$options = tho_get_available_options();
	//Render all the available plugin options
	foreach( $options as $name => $values ){
		//update options of everything submitted by form
		update_option( $name, $_POST[$name] );
	}
}

/**
 * Get available options
 */
function tho_get_available_options() {
	return array(
			'comment_order' => array( 'asc' => __( 'Ascending' ), 'desc' => __( 'Descending' ) ),
			'gzipcompression' => array( '0' => __( 'Disabled' ), '1' => __( 'Enabled' ) ),
			'image_default_align' => array( 'left'=>__( 'Left' ), 'center'=>__( 'Center' ), 'right' => __( 'Right' ), 'none' => __( 'None' ) ),
			'image_default_size' => array( 'thumbnail' => __( 'Thumbnail' ), 'full' => __( 'Full size' ), 'medium' => __( 'Medium size' ), 'large' => __( 'Large size' ) ),
			'image_default_link_type' => array( 'file' => __( 'File' ), 'post' => __( 'Post' ), 'custom' => __( 'Custom' ), 'none' => __( 'None' ) )		
	);
}

/**
 * Add links to WPSOS
 */
function wpsos_tho_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'tweak-hidden-options.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="http://www.wpsos.io/wordpress-plugin-tweak-hidden-options/">' . __( 'Plugin details' ) . '</a>' ) );
		$links = array_merge( $links, array( '<a href="http://www.wpsos.io/">WPSOS - WordPress Security & Hack Repair</a>' ) );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'wpsos_tho_set_plugin_meta', 10, 2 );
?>