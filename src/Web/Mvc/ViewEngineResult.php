<?php

namespace Unison\Web\Mvc;

class ViewEngineResult {

	public $view;

	public $viewName;

	public function __get($prop) {
		switch ($prop) {
			case 'success':
				return ($this->view != NULL);
			default:
				throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $prop . '.');
		}
	}

	private function __construct() { }

	public static function found($view) {
		$res = new ViewEngineResult();
		$res->view = $view;

		return $res;
	}

	public static function notFound($viewName) {
		$res = new ViewEngineResult();
		$res->viewName = $viewName;

		return $res;
	}

}

?>
