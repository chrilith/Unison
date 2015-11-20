<?php
namespace Unison\Web\Mvc;

class MvcHandler {

	public function execute($controllerName, $actionName = null) {
		$controller = new $controllerName();
		$actionResult = $controller->executeAction($actionName);

		// TODO/ catch exception
		$content = $actionResult->execute($controller->controllerContext);

		http_response_code($actionResult->statusCode);
		header('Content-Type: ' . $actionResult->contentType);
		echo $content;
	}
}

?>
