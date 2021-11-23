<?php


namespace Underpin\Background_Processes\Abstracts;


use Underpin\Loaders\Logger;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Background_Process extends \WP_Background_Process {

	abstract protected function task_action( $item );

	public function push_to_queue( $data ) {
		$result = parent::push_to_queue( $data );

		Logger::log( 'info',
			'background_process_item_queued',
			'A background process item has been queued for processing',
			[
				'data' => $data,
				'item' => $this->action,
			] );

		return $result;
	}

	protected function task( $item ) {
		$item = $this->task_action( $item );
		Logger::log(
			'debug',
			'background_task_ran',
			'A background task step ran.',
			[ 'item' => $item ]
		);

		if ( is_wp_error( $item ) ) {
			Logger::log_wp_error( 'error', $item );
			$item = false;
		}

		return $item;
	}

	protected function complete() {
		parent::complete();

		Logger::log(
			'info',
			'background_task_complete',
			'A background task completed',
			[ 'action' => $this->action ]
		);

	}

}