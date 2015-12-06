<?php

namespace Unison\Web\Mvc\Php;
use Unison\Web\Mvc;

class ViewDataAccessor implements Mvc\IPage {

	public $viewContext;

	public $html;

	public $url;

	public $layout;

	private $view;

	private $renderedSections;

	private $renderedBody;

	protected function __construct($context, $view, $buffer) {
		$this->viewContext = $context;
		$this->view = $view;

		$this->url = new Mvc\UrlHelper();
		$this->html = new Mvc\HtmlHelper($context);

		$this->renderedBody = $buffer;
		$this->renderedSections = array();
	}

	public function __get($prop) {
		switch ($prop) {
			case 'model':
				return $this->viewContext->viewData["Model"];
			case 'viewData':
				return $this->viewContext->viewData;
			default:
				throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $prop . '.');
		}
	}

	public function getSection($name) {
		$exists = array_key_exists($name, $this->renderedSections);
		return $exists ? $this->renderedSections[$name] : NULL;
	}

	public function renderBody() {
		echo $this->renderedBody;
	}

	public function defineSection($name, $renderer) {
		ob_start();
		$renderer();
		$this->renderedSections[$name] = ob_get_clean();
	}

	public function renderSection($name, $required = TRUE) {
		$parent = $this->view->parent;
		if (!$parent) {
			throw new \Exception('Cannot render section "' . $name . '" in a top level view.');
		}

		$content = $parent->page->getSection($name);
		if ($required && $content === NULL) {
			throw new \Exception('Required section "' . $name . '" was not defined.');
		}

		echo $content;
	}
}


?>
