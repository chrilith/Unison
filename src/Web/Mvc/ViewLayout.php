<?php

namespace Unison\Web\Mvc;

// TODO: move to /Php
class ViewLayout extends ViewPage {

	private $buffer;

	private $parent;

	public function __construct($parent, $buffer) {
		parent::__construct($parent->viewEngine);
		$this->buffer = $buffer;
		$this->parent = $parent;
	}

	public function renderBody() {
		return $this->buffer;
	}

	public function renderSection($name, $required = true) {
		$sections = $this->parent->rendered['sections'];
		$exists = array_key_exists($name, $sections);

		if ($required && !$exists) {
			throw new \Exception('Required section "' . $name . '" was not defined.');
		}

		if (array_key_exists($name, $sections)) {
			return $sections[$name];
		}

		return '';
	}
}

?>
