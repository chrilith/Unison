<?php

namespace Unison\Web\Mvc;

class ContentResult extends ActionResult {

	public $content;

	public function __construct($content) {
		parent::__construct();
		$this->statusCode = 200;
		$this->contentType = 'text/plain';
		$this->content = $content;
	}

	public function execute($controller) {
		return $this->content;
	}

}

?>
