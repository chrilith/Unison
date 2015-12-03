<?php

namespace Unison\Web\Mvc;

class ViewResult extends ActionResult {

	public $viewName;

	public function __construct() {
		parent::__construct();
		$this->contentType = 'text/html';
	}

	public function execute($controllerContext) {
		// Create a new context
		$ctx = new ViewContext($controllerContext);

		// Get an view engine
		$engine = new CompositeViewEngine();

		// Try to find the related view
		$result = $engine->findView($ctx, $this->viewName);

		// Render now
		return $result->view->render();
	}

}

?>
