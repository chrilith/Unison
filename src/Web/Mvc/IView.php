<?php

namespace Unison\Web\Mvc;

interface IView {
	// PHP doesn't raise when accessing a property on interface...

	// IPage $page { get; }

	// IView $parent { get; set; }

	public function render($context, $buffer = null);
}

?>
