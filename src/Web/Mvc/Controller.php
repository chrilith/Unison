<?php

namespace Unison\Web\Mvc;

class Controller {

	function __construct() {
	}

	protected function partialView($viewName, $model = null) {
		return $this->view($viewName, $model);
	}

	protected function view($viewName, $model = null) {
		$result = new ViewResult();
		$result->viewName = $viewName;
		$result->model = $model;

		return $result;
	}

}

?>
