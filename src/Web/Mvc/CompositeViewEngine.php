<?php

namespace Unison\Web\Mvc;

class CompositeViewEngine implements IViewEngine {

	private $viewEngines;

	public function __construct() {
		$this->viewEngines = ViewEngines::$engines;
	}

	public function findView($context, $viewName) {
		return $this->internalFindView($context, $viewName, FALSE);
	}

	public function findPartialView($context, $viewName) {
		return $this->internalFindView($context, $viewName, TRUE);
	}

	private function internalFindView($context, $viewName, $isPartial) {

		foreach ($this->viewEngines as $engine) {
			$result = $isPartial ?
				$engine->findPartialView($context, $viewName) :
				$engine->findView($context, $viewName);

			if ($result->success) {
				return $result;
			}
		}

		return ViewEngineResult::notFound($viewName);
	}

}

?>
