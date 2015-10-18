<?php

namespace Unison\Initialization;

class AutoLoader {

	private static $instance = null;

	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new AutoLoader();
		}
		return self::$instance;
	}

	private $paths;

	private function __construct() {
		$this->paths = array('__any' => array());
	}

	public function register() {
		static $initialized = false;
		if (!$initialized) {
			spl_autoload_register(array($this, 'autoload'));
			$initialized = true;
		}
	}

	public function path($path) {
		// TODO: prevent duplicates with missing ending /
		array_push($this->paths['__any'], $path);
	}

	public function ns($ns, $path) {
		if (!array_key_exists($ns, $this->paths)) {
			$this->paths[$ns] = array();
		}

		array_push($this->paths[$ns], $path);	
	}

	private function searchFile($ns, $file) {
		if (!array_key_exists($ns, $this->paths)) {
			$ns = '__any';
		}

		$paths = $this->paths[$ns];

		foreach ($paths as $path) {
			// Search Path+NS+File
			$fileName = $path . $file;
			if (is_readable($fileName)) {
				return $fileName;
			}

			// Search Path+File
			if (($last = strrpos($file, DIRECTORY_SEPARATOR)) !== FALSE) {
				$fileName = $path . substr($file, $last + 1);
				if (is_readable($fileName)) {
					return $fileName;
				}				
			}
		}

		return $file;
	}

	private function autoload($className) {

		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';

		if (($lastPos = strrpos($className, '\\')) !== FALSE) {
	        $namespace = substr($className, 0, $lastPos);
	        $className = substr($className, $lastPos + 1);
	        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	    }
	    $fileName = $this->searchFile($namespace, $fileName . $className . '.php');

    	require $fileName;
	}

}

?>
