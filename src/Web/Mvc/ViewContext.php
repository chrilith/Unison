<?php

namespace Unison\Web\Mvc;

class ViewContext {

	public $controller;

	public $viewData;

	public $view;

	public $isChildAction;

	public function __clone() {
		$this->view = null;
	}

}

?>
