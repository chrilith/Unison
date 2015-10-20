<?php

namespace Unison\Web\Mvc;

class ViewLayout extends ViewPage {

	private $buffer;

	private $parent;

	public function __construct($viewContext, $parent, $buffer) {
		parent::__construct($viewContext);
		$this->buffer = $buffer;
		$this->parent = $parent;
	}

	public function renderBody() {
		echo $this->buffer;
	}

	public function renderSection($name, $required = true) {
		$sections = $this->parent->rendered['sections'];
		$exists = array_key_exists($name, $sections);

		if ($required && !$exists) {
			throw new \Exception('Required section "' . $name . '" was not defined.');
		}

		if (array_key_exists($name, $sections)) {
			echo $sections[$name];
		}
	}
}

?>
