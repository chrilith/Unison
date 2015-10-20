<?php

namespace Unison\Web\Mvc;

class ViewResult extends ActionResult {

	public $viewName;

	public function __construct() {
		parent::__construct();
		$this->contentType = 'text/html';
	}

	public function execute($controller) {
		$ctx = new ViewContext($controller->viewData);
		$page = new ViewPage($ctx);

		return $this->render($page, $this->viewName, $page->viewContext->viewData["Model"]);
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
