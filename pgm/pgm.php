<?php

if ( function_exists( 'spl_autoload_register' ) ) {

	function pronamic_google_maps_autoload( $name ) {
		$name = str_replace( '\\', DIRECTORY_SEPARATOR, $name );
		$name = str_replace( '_',  DIRECTORY_SEPARATOR, $name );

		$file = plugin_dir_path( __FILE__ ) . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';

		if ( is_file( $file ) ) {
			require_once $file;
		}
	}

	spl_autoload_register( 'pronamic_google_maps_autoload' );

	require_once 'includes/functions.php';

	Pronamic_Google_Maps_Maps::bootstrap( __FILE__ );

}
