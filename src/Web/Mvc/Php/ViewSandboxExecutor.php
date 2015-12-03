<?php

namespace Unison\Web\Mvc\Php;

class ViewSandboxExecutor extends ViewDataAccessor {

	public function __construct() {
		parent::__construct(func_get_arg(0), func_get_arg(1));
		include func_get_arg(0)->path;
	}

}

?>
