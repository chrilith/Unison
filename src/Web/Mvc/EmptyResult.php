<?php

namespace Unison\Web\Mvc;

class EmptyResult extends ActionResult {

	public function __construct() {
		parent::__construct();
		$this->statusCode = 204;
	}

	public function execute($controller) { }
}

?>
