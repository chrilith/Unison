<?php

namespace Unison\Web\Mvc;

/**
 * Defines the contract for a view engine.
 */
interface IViewEngine {

	/**
	 * Finds the specified view.
	 *
	 * @param string  $viewName
	 *        View name.
	 * @return ViewEngineResult
	 *         A result representing the result of locating the view.
	 */
	public function findView($context, $viewName);

	/**
	 * Finds the specified partial view.
	 *
	 * @param string  $viewName
	 *        View name.
	 * @return ViewEngineResult
	 *         A result representing the result of locating the view.
	 */
	public function findPartialView($context, $viewName);

}

?>
