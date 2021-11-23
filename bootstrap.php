<?php

use Underpin\Abstracts\Underpin;
use Underpin\Factories\Observers\Loader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Underpin::attach( 'setup', new Loader( 'background_processes', [
	'update' => function ( Underpin $plugin ) {
		$plugin->loaders()->add( 'background_processes', [
			'class' => 'Underpin\Background_Processes\Loaders\Background_Processes',
		] );

		$plugin->loaders()->add( 'async_requests', [
			'class' => 'Underpin\Background_Processes\Loaders\Async_Requests',
		] );
	},
] ) );
