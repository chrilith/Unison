<?php

namespace Unison\Web\Mvc;

class ViewResult {

	public $statusCode;

	public $contentType;

	public $viewName;

	public $model;

	public function __construct() {
		$this->statusCode = 200;
		$this->contentType = 'text/html';
	}

}

?>
