<?php

namespace Unison\Web\Mvc;

abstract class ViewDecorator {
	private $parent;

	public function __construct(ViewElement $parent) {
		$this->parent = $parent;
	}

	public function render($viewName, $model) {
		$this->parent->viewContext->viewData["Model"] = $model;
	}

	public function __get($prop) {
		switch ($prop) {
			case 'html':
			case 'url':
			case 'viewContext':
			case 'layout':
				return $this->parent->{$prop};
			case 'model':
				return $this->parent->viewContext->viewData["Model"];
			case 'viewData':
				return $this->parent->viewContext->viewData;
			default:
				throw new \Exception('Undefined property: ' . get_class($this->parent) . '::$' . $prop . '.');
		}
	}

	public function __call($name, $args) {
		switch ($name) {
			case 'defineSection':
				call_user_func_array(array(&$this->parent, $name), $args);
				break;
			case 'renderSection':
			case 'renderBody':
				return call_user_func_array(array(&$this->parent, $name), $args);
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
