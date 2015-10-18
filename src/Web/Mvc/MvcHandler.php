<?php
namespace Unison\Web\Mvc;

class MvcHandler {

	private $viewResult;

	private $html;
	private $url;

	/**
	 * Page pendering state.
	 * @var boolean
	 */
	private $rendering;

	/**
	 * Rendered page elements (body, sections...).
	 * @var array
	 */
	private $rendered;

	/**
	 * Models of the current page and related blocks.
	 * @var object
	 */
	private $modelStack;

	private $controllerManager;

	public function __construct() {
		$this->controllerManager = new ControllerManager();

		$this->html = new HtmlHelper($this);
		$this->url = new UrlHelper($this);

		$this->modelStack = array();
		$this->rendered = array('sections' => array());
	}

	/* REGION RENDERING */

	/**
	 * To be called in a layout to render the main content of an action view.
	 */
	private function templateRenderBody() {
		echo $this->rendered['body'];
	}

	/**
	 * To be called in a layout to render a section content.
	 * @param  string $name
	 *         Nmae of the scetion to render.
	 * @param  boolean $required
	 *         Whether the section is required.
	 */
	private function templateRenderSection($name, $required) {
		$sections = $this->rendered['sections'];
		$exists = array_key_exists($name, $sections);

		if ($required && !$exists) {
			throw new \Exception('Required section "' . $name . '" was not defined.');
		}

		if (array_key_exists($name, $sections)) {
			echo $sections[$name];
		}
	}

	/**
	 * Renders the current page.
	 */
	private function doBodyRendering($layout) {
		ob_start();
		$ctx = $this->viewResult;
		$this->executeView($ctx->viewName, $ctx->model);
		$this->rendered['body'] = ob_get_clean();

		if ($layout) {
			$this->executeView($layout);
		} else {
			$this->templateRenderBody();
		}
	}

	/**
	 * Registers a section handler.
	 * 
	 * @param  string $name
	 *         Name of the section.
	 * @param  function $func
	 *         Code renderer. 
	 */
	private function doSectionRendering($name, $func) {
		ob_start();
		$func();
		$this->rendered['sections'][$name] = ob_get_clean();
	}

	/**
	 * Executes an action in the passed controller.
	 * 
	 * @param  string $actionName
	 *         Name of the action to execute.
	 * @param  string [$controllerName]
	 *         Controller to be used to execute the action.
	 */
	public function doActionRendering($actionName, $controllerName) {
		// Pushs contextual controller
		$man = $this->controllerManager;
		$controllerName = $man->append($controllerName);

		$controller = $man->controllerInstance($controllerName);
		$ctx = $this->prepareAction($controller, $actionName);

		// Rendering...
		ob_start();
		$this->executeView($ctx->viewName, $ctx->model);
		$content = ob_get_clean();

		// Done.
		$man->remove();
		return $content;
	}

	public function doPageRendering($controllerName, $layout) {
		// Pushs contextual controller
		$man = $this->controllerManager;
		$man->append($controllerName);

		$controller = $man->controllerInstance($controllerName);
		$this->viewResult = $this->prepareAction($controller);

		// Rendering...
		$this->doBodyRendering($layout);

		// Done.
		$man->remove();
	}

	/* ENDREGION RENDERING */

	/**
	 * Executes the action based on requested the PHP script.
	 * This is the method to call from a 'page' PHP script.
	 * 
	 * @param  string $controller
	 *         Controller to be used to execute the action.
	 * @param  string $layout
	 *         Name of the layout to use if any.
	 */
	public function page($controllerName, $layout = null) {
		if ($this->rendering) {
			throw new \Exception('Page is already rendering. Cannot call page() twice.');
		}
		$this->rendering = true;
		$this->doPageRendering($controllerName, $layout);
		$this->rendering = false;

	}

	private function prepareAction($controller, $action = null) {
		$file = explode('/', $action ? $action : $_SERVER["SCRIPT_FILENAME"]);
		$action = end($file);

		// Gets action name
		$cut = strrpos($action, '.');
		if ($cut !== false) {
			$action = substr($action, 0, $cut);
		}

		return call_user_func_array(array($controller, $action), func_get_args());	// FIXME: func_get_args
	}

	/**
	 * Executes the view rendering of a view using the specified model.
	 * 
	 * @param  string $name
	 *         View name.
	 * @param  object $model
	 *         Model to be used by the view.
	 */
	private function executeView($name, $model = null) {
		// Pushes the model so that it will be accessible by child views/actions
		$this->pushModel($model);

		// Adds peudo-superglobals to the view env
		extract($this->getPseudoGlobals());

		// Executes the view code
		include MVC_ROOT . 'Views/' . $name . '.php';

		// Frees the model
		$this->restoreModel();
	}

	private function getPseudoGlobals() {
		return array(
			'_Html' => $this->html,
			'_Model' => $this->getModel(),
			'_Url' => $this->url,

			'_RenderBody' => function() { $this->templateRenderBody(); },
			'_RenderSection' => function($name, $required = true) { $this->templateRenderSection($name, $required); },
			'_Section' => function($name, $func) { $this->doSectionRendering($name, $func); }
		);
	}

	private function pushModel($model) {
		// If no model is specified, inherit the previous model
		if ($model == null) {
			$model = end($this->modelStack);
		}

		// Save the model...
		array_push($this->modelStack, $model);

		// ...and return it
		return $model;
	}

	private function getModel() {
		$last = end($this->modelStack);
		return $last !== false ? $last : $this->viewResult->model;
	}

	private function restoreModel() {
		array_pop($this->modelStack);
		return $this->getModel();
	}

}

?>
