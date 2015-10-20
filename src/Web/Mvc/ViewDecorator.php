<?php

namespace Unison\Web\Mvc;

abstract class ViewDecorator {
	private $parent;

	public function __construct(ViewElement $parent) {
		$this->parent = $parent;
	}

	public function render($viewName, $model) {
		$this->parent->model = $model;
	}

	public function __get($prop) {
		switch ($prop) {
			case 'html':
			case 'model':
			case 'url':
			case 'viewContext':
			case 'layout':
				return $this->parent->{$prop};
			case 'viewData':
				return $this->parent->viewContext->viewData;
			default:
				return null;
		}
	}

	public function __call($name, $args) {
		switch ($name) {
			case 'section':
			case 'renderSection':
			case 'renderBody':
				call_user_func_array(array(&$this->parent, $name), $args);
				break;
		}
	}

	public function __set($prop, $value) {
		switch ($prop) {
			case 'layout':
				$this->parent->{$prop} = $value;
		}
	}
}

?>
