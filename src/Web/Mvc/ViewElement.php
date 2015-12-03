<?php

namespace Unison\Web\Mvc;
use Unison\Web\Mvc\Php;

// TODO: move to /Php
class ViewElement {

	public $viewContext;

	public $url;

	public $html;

	public $path;

	protected $viewEngine;

	public function __construct($viewContext, $viewEngine) {
		$this->viewContext = $viewContext;
		$this->viewContext->view = $this;
		$this->viewEngine = $viewEngine;

		$this->html = new HtmlHelper($viewContext, $viewEngine);
		$this->url = new UrlHelper();
	}

	public function render($model = null) {
		ob_start();
		new Php\ViewSandboxExecutor($this, $model);
		return ob_get_clean();
	}

}

?>
