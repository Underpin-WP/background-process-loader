<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'underpin/before_setup', function ( $file, $class ) {
	if ( ! defined( 'UNDERPIN_BACKGROUND_PROCESS_PATH' ) ) {
		define( 'UNDERPIN_BACKGROUND_PROCESS_PATH', trailingslashit( __DIR__ ) );
	}

	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/abstracts/Async_Request.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/abstracts/Background_Process.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/factories/Async_Request_Instance.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/factories/Background_Process_Instance.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/loaders/Async_Requests.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/loaders/Background_Processes.php' );


	Underpin\underpin()->get( $file, $class )->loaders()->add( 'background_processes', [
		'registry' => 'Underpin_Background_Processes\Loaders\Background_Processes',
	] );

	Underpin\underpin()->get( $file, $class )->loaders()->add( 'async_requests', [
		'registry' => 'Underpin_Background_Processes\Loaders\Async_Requests',
	] );

}, 20, 2 );

