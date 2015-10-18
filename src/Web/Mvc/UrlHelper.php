<?php

namespace Unison\Web\Mvc;

class UrlHelper {

	var $mvc;

	function __construct($parent) {
		$mvc = $parent;
	}

	function content($location) {
		if (strpos($location, '~/') === 0) {
			$location = WEB_ROOT . substr($location, 2);
		}
		return $location;
	}

}

?>
