<?php
/**
 * Background Process Loader
 *
 * @since   1.0.0
 * @package Underpin\Background_Process\Loaders
 */


namespace Underpin\Background_Processes\Loaders;

use Underpin\Abstracts\Registries\Object_Registry;
use Underpin\Loaders\Logger;
use Underpin\Background_Processes\Abstracts\Async_Request;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Database
 * Database Registry
 *
 * @since   1.0.0
 * @package Underpin\Background_Processes\Loaders
 */
class Async_Requests extends Object_Registry {

	/**
	 * @inheritDoc
	 */
	protected $abstraction_class = '\Underpin\Background_Processes\Abstracts\Async_Request';

	protected $default_factory = '\Underpin\Background_Processes\Factories\Async_Request_Instance';

	/**
	 * @inheritDoc
	 */
	protected function set_default_items() {
	}

	/**
	 * Retrieves a registered background process.
	 *
	 * @param string $key The identifier for the item.
	 *
	 * @return Async_Request|WP_Error the background process.
	 */
	public function get( $key ) {
		return parent::get( $key );
	}

	public function dispatch( $key, $args = [] ) {
		$instance = $this->get( $key );

		if ( is_wp_error( $instance ) ) {
			Logger::log_wp_error( 'error', $instance );
			return $instance;
		}

		if ( ! empty( $args ) ) {
			$instance->data( $args );
		}

		$instance->dispatch();
	}

}

