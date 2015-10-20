<?php

namespace Unison\Web\Mvc;

class ViewContext {

	public $view;

	public $viewData;

	public $isChildAction;

	public function __construct($viewData) {
		$this->viewData = $viewData ? $viewData : array();
	}

	public function __clone() {
		// Keep in mind that viewData is an array and arrays are structs in PHP
		$this->view = null;
	}

}

?>
