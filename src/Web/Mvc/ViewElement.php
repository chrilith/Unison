<?php

namespace Unison\Web\Mvc;
use Unison\Web\Mvc\Php;

// TODO: move to /Php
class ViewElement {

	public $path;

	public $viewEngine;

	public function __construct($viewEngine) {
		$this->viewEngine = $viewEngine;
	}

	public function render($context) {
		ob_start();
		new Php\ViewSandboxExecutor($context, $this);
		return ob_get_clean();
	}

}

?>
