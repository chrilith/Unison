<?php

namespace Unison\Web\Mvc;

class ViewResult extends ActionResult {

	public function __construct() {
		parent::__construct();
		$this->statusCode = 204;
	}

}

?>
