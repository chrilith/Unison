<?php

namespace Unison\Web\Mvc\Php;
use Unison\Web\Mvc;

class ViewDataAccessor {

	public $viewContext;

	public $html;

	public $url;

	private $parent;

	protected function __construct($context, $parent) {
		$this->parent = $parent;
		$this->viewContext = $context;

		$this->url = new Mvc\UrlHelper();
		$this->html = new Mvc\HtmlHelper($context, $parent->viewEngine);
	}

	public function __get($prop) {
		switch ($prop) {
			case 'layout':
				return $this->parent->{$prop};
			case 'model':
				return $this->viewContext->viewData["Model"];
			case 'viewData':
				return $this->viewContext->viewData;
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
