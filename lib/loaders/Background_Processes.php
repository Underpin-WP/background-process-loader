<?php
/**
 * Background Process Loader
 *
 * @since   1.0.0
 * @package Underpin_Background_Process\Loaders
 */


namespace Underpin_Background_Processes\Loaders;

use Underpin\Abstracts\Registries\Object_Registry;
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
class Background_Processes extends Object_Registry {

	/**
	 * @inheritDoc
	 */
	protected $abstraction_class = '\Underpin_Background_Processes\Abstracts\Background_Process';

	protected $default_factory = '\Underpin_Background_Processes\Factories\Background_Process_Instance';

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
	 * @return Background_Process|WP_Error the background process.
	 */
	public function get( $key ) {
		return parent::get( $key );
	}

	public function enqueue( $key, $data ) {
		$instance = $this->get( $key );

		if ( is_wp_error( $instance ) ) {
			underpin()->logger()->log_wp_error( 'error', $instance );
		}

		return $instance->push_to_queue( $data );
	}

	public function dispatch( $key ) {
		$instance = $this->get( $key );

		if ( is_wp_error( $instance ) ) {
			underpin()->logger()->log_wp_error( 'error', $instance );
			return $instance;
		}

		return $instance->save()->dispatch();
	}

}