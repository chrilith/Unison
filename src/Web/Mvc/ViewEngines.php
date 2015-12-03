<?php

namespace Unison\Web\Mvc;

class ViewEngines {

	public static $engines = array();

	public static function add($engine) {
		ViewEngines::$engines[] = $engine;
	}

	public static function clear() {
		ViewEngines::$engines = array();
	}

}

// Static initialization
ViewEngines::add(new Php\PhpViewEngine());

?>
