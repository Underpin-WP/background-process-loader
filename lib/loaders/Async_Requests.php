<?php
/**
 * Background Process Loader
 *
 * @since   1.0.0
 * @package Underpin_Background_Process\Loaders
 */


namespace Underpin_Background_Processes\Loaders;

use Underpin\Abstracts\Registries\Loader_Registry;
use Underpin_Background_Processes\Abstracts\Async_Request;
use Underpin_Background_Processes\Abstracts\Background_Process;
use WP_Error;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Database
 * Database Registry
 *
 * @since   1.0.0
 * @package Underpin_Background_Processes\Loaders
 */
class Async_Requests extends Loader_Registry {

	/**
	 * @inheritDoc
	 */
	protected $abstraction_class = '\Underpin_Background_Processes\Abstracts\Async_Request';

	protected $default_factory = '\Underpin_Background_Processes\Factories\Async_Request_Instance';

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
			underpin()->logger()->log_wp_error( 'error', $instance );
			return $instance;
		}

		if ( ! empty( $args ) ) {
			$instance->data( $args );
		}

		$instance->dispatch();
	}

}

