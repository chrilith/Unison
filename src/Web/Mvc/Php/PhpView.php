<?php

namespace Unison\Web\Mvc\Php;
use Unison\Web\Mvc;

class PhpView implements Mvc\IView {

	public $isPartial;

	public $path;

	public $viewEngine;

	/**
	 * Page object related to this view.
	 * @var Unison\Web\Mvc\Php\ViewDataAccessor
	 */
	public $page;

	/**
	 * Parent view if any. Defined for layout views.
	 * @var Unison\Web\Mvc\IView
	 */
	public $parent;

	public function __construct($viewEngine) {
		$this->viewEngine = $viewEngine;
	}

	private function executor($context, $buffer) {
		ob_start();
		$this->page = new ViewSandboxExecutor($context, $this, $buffer);
		return ob_get_clean();
	}

	public function render($context, $buffer = null) {
		// Call it before to know if a layout should be used
		$content = $this->executor($context, $buffer);

		// Do we have a layout?
		if (!(!$this->isPartial && $this->page->layout)) {
			// No...
			return $content;

		} else {
			// Create a context for the new view
			$ctx = clone $context;

			// Find the related view file
			$result = $this->viewEngine->findView($context, $this->page->layout);

			// Set the parent so that why can retrieve previously rendered sections
			$layout = $result->view;
			$layout->parent = $this;

			// Render the view
			return $layout->render($ctx, $content);
		}
	}
}

?>
