<?php

namespace Unison\Web\Mvc;

class Controller {

	public $viewData;

	public function __construct() {
		$this->viewData = array();
	}

	public function executeAction($action = null) {
		$file = explode('/', $action ? $action : $_SERVER["SCRIPT_FILENAME"]);
		$action = end($file);

		// Gets action name
		$cut = strrpos($action, '.');
		if ($cut !== false) {
			$action = substr($action, 0, $cut);
		}

		return call_user_func_array(array($this, $action), func_get_args());	// FIXME: func_get_args
	}

	protected function view($viewName, $model = null) {
		$result = new ViewResult();
		$result->viewName = $viewName;
		$this->viewData["Model"] = $model;

		return $result;
	}
}

?>
