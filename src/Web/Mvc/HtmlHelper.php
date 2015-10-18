<?php

namespace Unison\Web\Mvc;

class HtmlHelper {

	var $mvc;

	function __construct($parent) {
		$this->mvc = $parent;
	}

	function action($actionName, $controllerName = null) {
		return $this->mvc->doActionRendering($actionName, $controllerName);
	}

	function renderAction($actionName, $controllerName = null) {
		echo $this->action($actionName, $controllerName);
	}

	function partial($viewName, $model = null) {
		$this->mvc->executeView($viewName, $model);
	}

}

?>
