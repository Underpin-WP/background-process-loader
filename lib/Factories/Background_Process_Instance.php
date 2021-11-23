<?php

namespace Underpin\Background_Processes\Factories;


use Underpin\Traits\Instance_Setter;
use Underpin\Background_Processes\Abstracts\Background_Process;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Background_Process_Instance extends Background_Process {

	use Instance_Setter;

	protected $task_action_callback;

	public function __construct( array $args = [] ) {
		$this->set_values( $args );
		parent::__construct();
	}

	protected function task_action( $item ) {
		return $this->set_callable( $this->task_action_callback, $item );
	}

}