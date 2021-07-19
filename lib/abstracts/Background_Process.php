<?php


namespace Underpin_Background_Processes\Abstracts;

use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Background_Process extends \WP_Background_Process {

	abstract protected function task_action( $item );

	public function push_to_queue( $data ) {
		$result = parent::push_to_queue( $data );

		underpin()->logger()->log( 'info',
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
		underpin()->logger()->log(
			'debug',
			'background_task_ran',
			'A background task step ran.',
			[ 'item' => $item ]
		);

		if ( is_wp_error( $item ) ) {
			underpin()->logger()->log_wp_error( 'error', $item );
			$item = false;
		}

		return $item;
	}

	protected function complete() {
		parent::complete();

		underpin()->logger()->log(
			'info',
			'background_task_complete',
			'A background task completed',
			[ 'action' => $this->action ]
		);

	}

}