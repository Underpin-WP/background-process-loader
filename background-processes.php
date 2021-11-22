<?php

use Underpin\Abstracts\Underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Underpin::attach( 'setup', new \Underpin\Factories\Observer( 'background_processes', [
	'update' => function ( Underpin $plugin ) {
	if ( ! defined( 'UNDERPIN_BACKGROUND_PROCESS_PATH' ) ) {
		define( 'UNDERPIN_BACKGROUND_PROCESS_PATH', trailingslashit( __DIR__ ) );
	}

	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/abstracts/Async_Request.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/abstracts/Background_Process.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/factories/Async_Request_Instance.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/factories/Background_Process_Instance.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/loaders/Async_Requests.php' );
	require_once( UNDERPIN_BACKGROUND_PROCESS_PATH . 'lib/loaders/Background_Processes.php' );


	$plugin->loaders()->add( 'background_processes', [
		'class' => 'Underpin_Background_Processes\Loaders\Background_Processes',
	] );

	$plugin->loaders()->add( 'async_requests', [
		'class' => 'Underpin_Background_Processes\Loaders\Async_Requests',
	] );
	},
] ) );
