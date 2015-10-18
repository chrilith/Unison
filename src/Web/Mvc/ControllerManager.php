<?php

namespace Unison\Web\Mvc;

class ControllerManager {

	private $stack;

	/**
	 * List of instanciated controllers.
	 * @var array
	 */
	private $controllers;

	public function __construct() {
		$this->controllers = array();
		$this->stack = array();
	}

	public function append($controllerName) {
		$controllerName = $controllerName ? $controllerName : end($this->stack);
		array_push($this->stack, $controllerName);

		return $controllerName;
	}

	public function remove() {
		array_pop($this->stack);
	}

	/**
	 * Returns the requested controller instance from the pool.
	 * If a controller instance isn't in the pool, a new instance is created.
	 * 
	 * @param  string $name
	 *         Name of the controller
	 * @return Controller
	 *         Controller instance
	 */
	public function controllerInstance($name) {
		// FIXME: class name is cas insensitive, register the controller name as lcase
		if (!isset($this->controllers[$name])) {
			$this->controllers[$name] = new $name;
		}
		return $this->controllers[$name];
	}
}

?>
