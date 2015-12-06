<?php

namespace Unison\Web\Mvc;

class HtmlHelper {

	private $viewContext;

	private $viewEngine;

	function __construct(ViewContext $viewContext) {
		$this->viewContext = $viewContext;
		// We can render any type of view
		$this->viewEngine = new CompositeViewEngine();
	}

	function action($actionName, $controllerName = null) {
		if (!$controllerName) {
			$controllerName = get_class($this->viewContext->controller);
		}
		$controller = new $controllerName();
		$controller->controllerContext->isChildAction = true;
		$actionResult = $controller->executeAction($actionName);

		return $actionResult->execute($controller->controllerContext);
	}

	function renderAction($actionName, $controllerName = null) {
		echo $this->action($actionName, $controllerName);
	}

	function partial($viewName, $model = null) {
		$result = $this->viewEngine->findPartialView($this->viewContext, $viewName);
		$partial = $result->view;

		$ctx = clone $this->viewContext;
		if ($model != null) {
			$ctx->viewData["Model"] = $model;
		}
		return $partial->render($ctx);
	}

	function renderPartial($viewName, $model = null) {
		echo $this->partial($viewName, $model);
	}

}

?>
