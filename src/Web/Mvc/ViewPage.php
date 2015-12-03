<?php

namespace Unison\Web\Mvc;

// TODO: move to /Php
class ViewPage extends ViewElement {

	public $layout;

	public $rendered;

	public function __construct($viewContext, $viewEngine) {
		parent::__construct($viewContext, $viewEngine);
		$this->rendered = array('sections' => array());
	}

	public function defineSection($name, $renderer) {
		ob_start();
		$renderer();
		$this->rendered['sections'][$name] = ob_get_clean();
	}

	public function render() {
		$content = parent::render();

		if ($this->layout) {
			$ctx = clone $this->viewContext;
			$layout = new ViewLayout($ctx, $this, $content);
			$layout->path = UNISON_MVC_ROOT . 'Views/' . $this->layout . '.php';	// TODO: use viewEngine

			return $layout->render();

		} else {
			return $content;
		}
	}

}

?>
