<?php

namespace Unison\Web\Mvc;

class ViewContext extends ControllerContext {

	public $view;

	public $viewData;

	public function __construct(ControllerContext $controllerContext = null) {
		parent::__construct($controllerContext);
		$this->viewData = $this->controller ? $this->controller->viewData : array();
	}

	public function __clone() {
		// Keep in mind that viewData is an array and arrays are structs in PHP
		$this->view = null;
	}

}

?>
