<?php

namespace Unison\Web\Mvc;

// TODO: move to /Php
class ViewPage extends ViewElement {

	public $layout;

	public $rendered;

	public function __construct($viewEngine) {
		parent::__construct($viewEngine);
		$this->rendered = array('sections' => array());
	}

	public function defineSection($name, $renderer) {
		ob_start();
		$renderer();
		$this->rendered['sections'][$name] = ob_get_clean();
	}

	public function render($context) {
		// Call it before to know if a layout should be used
		$content = parent::render($context);

		if ($this->layout) {
			$ctx = clone $context;
			$layout = new ViewLayout($this, $content);
			$layout->path = UNISON_MVC_ROOT . 'Views/' . $this->layout . '.php';	// TODO: use viewEngine

			return $layout->render($ctx);

		} else {
			return $content;
		}
	}

}

?>
