<?php

namespace Underpin_Background_Processes\Abstracts;


use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Async_Request extends \WP_Async_Request {

	abstract function task_action();

	protected function handle() {
		$result = $this->task_action();

		if ( is_wp_error( $result ) ) {
			underpin()->logger()->log_wp_error( 'error', $result );
		} else {
			underpin()->logger()->log(
				'info',
				'async_request_complete',
				'An async request completed',
				[ 'action' => $this->action ]
			);
		}

		return $result;
	}

}