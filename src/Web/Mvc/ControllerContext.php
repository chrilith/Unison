<?php

namespace Unison\Web\Mvc;

class ControllerContext {

	public $controller;

	public $isChildAction = FALSE;

	public function __construct(ControllerContext $controllerContext = null) {
		if ($controllerContext) {
			$this->controller = $controllerContext->controller;
			$this->isChildAction = $controllerContext->isChildAction;
		}
	}

}

?>
