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
		$ctx = clone $this->viewContext;
		$partial = new ViewElement($ctx, $this->viewEngine);
		$partial->path = UNISON_MVC_ROOT . 'Views/' . $viewName . '.php';	// TODO: use viewEngine

		if ($model == null) {
			$model = $this->viewContext->viewData["Model"];
		}

		return $partial->render($model);
	}

	function partial($viewName, $model = null) {
		echo $this->renderPartial($viewName, $model);
	}

}

?>
