<?php
namespace Unison\Web\Mvc;

class MvcHandler {

	public function execute($controllerName) {
		$ctx = new ViewContext();
		$controller = new $controllerName($ctx);
		$ctx->controller = $controller;

		$viewResult = $controller->prepareAction();
		$page = new ViewPage($ctx);

		// TODO/ catch exception
		$content = $this->render($page, $viewResult->viewName, $viewResult->model);

		http_response_code($viewResult->statusCode);
		header('Content-Type: ' . $viewResult->contentType);
		echo $content;
	}

	private function render($page, $viewName, $model) {
		ob_start();
		$page->render($viewName, $model);
		$content = ob_get_clean();

		if ($page->layout) {
			$ctx = clone $page->viewContext;
			$layout = new ViewLayout($ctx, $page, $content);
			return $this->render($layout, $page->layout, $model);
		} else {
			return $content;
		}
	}
}

?>
