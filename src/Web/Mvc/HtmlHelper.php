<?php

namespace Unison\Web\Mvc;

class HtmlHelper {

	private $viewContext;

	private $viewEngine;

	function __construct(ViewContext $viewContext, $viewEngine) {
		$this->viewContext = $viewContext;
		$this->viewEngine = $viewEngine;
	}

	function renderAction($actionName, $controllerName = null) {
		if (!$controllerName) {
			$controllerName = get_class($this->viewContext->controller);
		}
		$controller = new $controllerName();
		$controller->controllerContext->isChildAction = true;
		$actionResult = $controller->executeAction($actionName);

		return $actionResult->execute($controller->controllerContext);
	}

	function action($actionName, $controllerName = null) {
		echo $this->renderAction($actionName, $controllerName);
	}

	function renderPartial($viewName, $model = null) {
		$result = $this->viewEngine->findPartialView($this->viewContext, $viewName);
		$partial = $result->view;

		$ctx = clone $this->viewContext;
		if ($model != null) {
			$ctx->viewData["Model"] = $model;
		}
		return $partial->render($ctx);
	}

	function partial($viewName, $model = null) {
		echo $this->renderPartial($viewName, $model);
	}

}

?>
