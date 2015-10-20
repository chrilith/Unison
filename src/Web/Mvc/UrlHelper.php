<?php

namespace Unison\Web\Mvc;

class UrlHelper {

	public function __construct() { }

	public function content($location) {
		if (strpos($location, '~/') === 0) {
			$location = UNISON_WEB_ROOT . substr($location, 2);
		}
		return $location;
	}

}

?>
