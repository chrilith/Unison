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
	private $prefixes;

	private function __construct() {
		$this->paths = array('__any' => array());
		$this->prefixes = array();
	}

	public function register() {
		static $initialized = false;
		if (!$initialized) {
			spl_autoload_register(array($this, 'autoload'));
			$initialized = true;
		}
	}

	private function append(&$array, $key, $value) {
		if (!array_key_exists($key, $array)) {
			$array[$key] = array();
		}

		if (substr($value, -1) != DIRECTORY_SEPARATOR) {
			$value .= DIRECTORY_SEPARATOR;
		}

		array_push($array[$key], $value);
	}

	/**
	 * Sets the default search path if no ns() or prefix() keys match the requested namespace.
	 *
	 * @param  string $path
	 */
	public function path($path) {
		$this->ns('__any', $path);
	}

	public function ns($ns, $path) {
		$this->append($this->paths, $ns, $path);
	}

	public function prefix($prefix, $path) {
		$this->append($this->prefixes, $prefix, $path);
	}

	/**
	 * Searchs for a path replacement matching a namespace prefix iterating on the namespace elements.
	 *
	 * @param  string $ns   Namespace to resolve.
	 * @param  string $file Filename to find.
	 *
	 * @return string|boolean
	 *         Path to the class file or FALSE if not found.
	 */
	private function searchPrefix($ns, $file) {
		$pos = $len = strlen($ns);

		do {
			$key = substr($ns, 0, $pos);
			$part = str_replace('\\', DIRECTORY_SEPARATOR, substr($ns, $pos + 1)) . DIRECTORY_SEPARATOR;

			if (array_key_exists($key, $this->prefixes)) {
				$paths = $this->prefixes[$key];

				foreach ($paths as $path) {
					$fileName = $path . $part . $file;
					if (is_readable($fileName)) {
						return $fileName;
					}
				}
			}

		} while (($pos = strrpos($ns, '\\', $pos - $len - 1)) !== FALSE);

		return FALSE;
	}

	private function searchNamespace($ns, $file) {
		if (!array_key_exists($ns, $this->paths)) {
			$ns = '__any';
		}

		$paths = $this->paths[$ns];

		foreach ($paths as $path) {
			// Search Path + (NS Path + File)
			$fileName = $path . $file;
			if (is_readable($fileName)) {
				return $fileName;
			}

			// Search Path + (File)
			if (($last = strrpos($file, DIRECTORY_SEPARATOR)) !== FALSE) {
				$fileName = $path . substr($file, $last + 1);
				if (is_readable($fileName)) {
					return $fileName;
				}				
			}
		}

		return FALSE;
	}

	private function autoload($className) {

		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';

		// For Foo\Bar\MyClass
		if (($lastPos = strrpos($className, '\\')) !== FALSE) {
	        $namespace = substr($className, 0, $lastPos);	// => Foo\Bar
	        $className = substr($className, $lastPos + 1);	// => MyClass
	        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;	// => Foo/Bar/
	    }

	    // ("Foo\Bar", "Foo/Bar/MyClass.php")
	    $fileName = $this->searchNamespace($namespace, $fileName . $className . '.php');
	    if ($fileName === FALSE) {
	    	$fileName = $this->searchPrefix($namespace, $className . '.php');
	    }
	    if ($fileName === FALSE) {
	    	throw new \Exception('Cannot find class "' . $namespace . '\\' . $className . '".');
	    }
	    // Try to load the class if any
	    require $fileName;
	}

}

?>
