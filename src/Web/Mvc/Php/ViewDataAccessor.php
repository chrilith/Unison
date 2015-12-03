<?php

namespace Unison\Web\Mvc\Php;

class ViewDataAccessor {

	private $parent;

	protected function __construct($parent, $model) {
		$this->parent = $parent;
		if ($model != null) {
			$this->parent->viewContext->viewData["Model"] = $model;
		}
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
				throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $prop . '.');
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
			default:
				throw new \Exception('Undefined method: ' . get_class($this) . '::$' . $prop . '.');
		}
	}

	public function __set($prop, $value) {
		switch ($prop) {
			case 'layout':
				$this->parent->{$prop} = $value;
				break;
			default:
				throw new \Exception('Undefined setter: ' . get_class($this) . '::$' . $prop . '.');
		}
	}

}


?>
