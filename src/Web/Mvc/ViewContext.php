<?php

namespace Unison\Web\Mvc;

class ViewContext {

	public $controller;

	public $view;

	public $isChildAction;

	// Late binding to the viewData controller. Could also be set directly
	// in the constructor adding a viewData property to this class.
	public function __get($prop) {
		switch ($prop) {
			case 'viewData':
				return $this->controller->viewData;
			default:
				throw new \Exception('No "' . $prop . '" property found on "ViewContext".');
		}
	}

	public function __clone() {
		$this->view = null;
	}

}

?>
