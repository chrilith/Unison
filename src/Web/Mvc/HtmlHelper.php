<?php

namespace Unison\Web\Mvc;

class HtmlHelper {

	private $viewContext;

	function __construct(ViewContext $viewContext) {
		$this->viewContext = $viewContext;
	}

	function renderAction($actionName, $controllerName = null) {
		if (!$controllerName) {
			$controllerName = get_class($this->viewContext->controller);
		}
		$controller = new $controllerName();
//		$ctx->isChildAction = true;
		$actionResult = $controller->executeAction($actionName);

		return $actionResult->execute($controller);
	}

	function action($actionName, $controllerName = null) {
		echo $this->renderAction($actionName, $controllerName);
	}

	function renderPartial($viewName, $model = null) {
		$ctx = clone $this->viewContext;
		$partial = new ViewElement($ctx);
		if ($model == null) {
			$model = $this->viewContext->view->model;
		}
		ob_start();
		$partial->render($viewName, $model);
		return ob_get_clean();
	}

	function partial($viewName, $model = null) {
		echo $this->renderPartial($viewName, $model);
	}

}

?>
