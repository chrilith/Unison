<?php

namespace Unison\Web\Mvc;

class ViewEnginePage extends ViewDecorator {

	public function render($viewName, $model) {
		parent::render($viewName, $model);
		include UNISON_MVC_ROOT . 'Views/' . $viewName . '.php';
	}
}

?>
