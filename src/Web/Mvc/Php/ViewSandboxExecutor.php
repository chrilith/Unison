<?php

namespace Unison\Web\Mvc\Php;

class ViewSandboxExecutor extends ViewDataAccessor {

	public function __construct() {
		// Base class to allow pseudo-sandboxed execution
		parent::__construct(func_get_arg(0), func_get_arg(1), func_get_arg(2));

		// Exectue the view
		include func_get_arg(1)->path;
	}

}

?>
