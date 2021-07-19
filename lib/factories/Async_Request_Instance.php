<?php

namespace Underpin_Background_Processes\Factories;


use Underpin\Traits\Instance_Setter;
use Underpin_Background_Processes\Abstracts\Async_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Async_Request_Instance extends Async_Request {

	use Instance_Setter;

	protected $task_action_callback;

	public function __construct( array $args = [] ) {
		$this->set_values( $args );
		parent::__construct();
	}

	function task_action() {
		return $this->set_callable( $this->task_action_callback );
	}

}