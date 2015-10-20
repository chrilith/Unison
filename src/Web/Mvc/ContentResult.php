<?php

namespace Unison\Web\Mvc;

class ContentResult extends ActionResult {

	public $viewName;

	public $model;

	public function __construct() {
		parent::__construct();
		$this->statusCode = 200;
		$this->contentType = 'text/plain';
	}

}

?>
