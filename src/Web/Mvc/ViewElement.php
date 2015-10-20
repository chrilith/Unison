<?php

namespace Unison\Web\Mvc;

class ViewElement {

	public $viewContext;

	public $url;

	public $html;

	public function __construct($viewContext) {
		$this->viewContext = $viewContext;
		$this->viewContext->view = $this;
		$this->html = new HtmlHelper($viewContext);
		$this->url = new UrlHelper($viewContext);
	}

	public function render($viewName, $model = null) {
		(new ViewEnginePage($this))->render($viewName, $model);
	}

}

?>
