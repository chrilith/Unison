<?php

namespace Unison\Web\Mvc\Php;
use Unison\Web\Mvc;

class PhpViewEngine implements Mvc\IViewEngine {

	/**
	 * Extension used by a view file.
	 * @var string
	 */
	private static $viewExtension = '.php';

	/**
	 * Searches for a view file.
	 *
	 * @param  string $viewName
	 *         Name or relative path to the view file.
	 * @return ViewEngineResult
	 *         New object holding search result status.
	 */
	public function findView($context, $viewName) {
		return $this->internalFindView($context, $viewName, FALSE);
	}

	public function findPartialView($context, $viewName) {
		return $this->internalFindView($context, $viewName, TRUE);
	}

	protected function internalFindView($context, $viewName, $isPartial) {
		// Expected file extension
		$ext = PhpViewEngine::$viewExtension;

		// Try to find the extension
		$pos = strrpos($viewName, $ext);

		// If not found, add it
		if ( $pos === FALSE || $pos != (strlen($viewName) - strlen($ext)) ) {
			$viewName .= $ext;
		}

		// Let's check that we can find the expected view...
		$location = UNISON_MVC_ROOT . 'Views/' . $viewName;

		if (is_readable($location)) {
			$view = new PhpView($this);
			$view->isPartial = $isPartial;
			$view->path = $location;

			return Mvc\ViewEngineResult::found($view);
		} else {
			return Mvc\ViewEngineResult::notFound($viewName);
		}		
	}

}

?>
