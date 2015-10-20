<?php

namespace Unison\Web\Mvc;

class ViewPage extends ViewElement {

	public $layout;

	public $rendered;

	public function __construct($viewContext) {
		parent::__construct($viewContext);
		$this->rendered = array('sections' => array());
	}

	public function defineSection($name, $renderer) {
		ob_start();
		$renderer();
		$this->rendered['sections'][$name] = ob_get_clean();
	}

}

?>
