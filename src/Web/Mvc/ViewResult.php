<?php

namespace Unison\Web\Mvc;

class ViewResult extends ContentResult {

	public function __construct() {
		parent::__construct();
		$this->contentType = 'text/html';
	}

}

?>
