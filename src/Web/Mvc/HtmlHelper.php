<?php

namespace Unison\Web\Mvc;

class HtmlHelper {

	private $viewContext;

	function __construct(ViewContext $viewContext) {
		$this->viewContext = $viewContext;
	}

	function action($actionName, $controllerName = null) {
		if (!$controllerName) {
			$controllerName = get_class($this->viewContext->controller);
		}
		$ctx = new ViewContext();
		$controller = new $controllerName($ctx);
		$ctx->controller = $controller;

		$viewResult = $controller->prepareAction($actionName);

		ob_start();
		$page = new ViewPage($ctx);
		$page->render($viewResult->viewName, $viewResult->model);
		return ob_get_clean();
	}

	function renderAction($actionName, $controllerName = null) {
		echo $this->action($actionName, $controllerName);
	}

	function partial($viewName, $model = null) {
		$ctx = clone $this->viewContext;
		$partial = new ViewElement($ctx);
		if ($model == null) {
			$model = $this->viewContext->view->model;
		}
		ob_start();
		$partial->render($viewName, $model);
		return ob_get_clean();
	}

	function renderPartial($viewName, $model = null) {
		echo $this->partial($viewName, $model);
	}

}

?>
