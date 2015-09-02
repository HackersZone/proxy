<?php
	define("VERSION", "3.0");

	define("SESSION_KEY", "proxy_session_key");

	define("CONNECTION_ERROR",   -1);
	define("NO_USER_INPUT",      -2);
	define("LOGIN_REQUIRED",     -3);
	define("INTERNAL_ERROR",     -4);
	define("FORBIDDEN_HOSTNAME", -5);
	define("LOOPBACK",           -6);
	define("LOCAL_FILE",         -7);

	define("DOT_REPLACEMENT", "_");

	$proxy_pages = array("disclaimer");

	list($_CONFIG["proxy_prefix"], $_CONFIG["proxy_basename"]) = explode(".", $_CONFIG["proxy_hostname"], 2);

	$_CONFIG["local_files"] = array(
		"tunnel.png"  => "image/png",
		"favicon.ico" => "image/x-icon",
		"robots.txt"  => "text/plain");

	/* Class autoloader
	 */
	function __autoload($class_name) {
		$file = "libraries/".strtolower($class_name).".php";
		if (file_exists($file)) {
			require($file);
		}
	}

	/* Function gzdecode()
	 */
	if (function_exists("gzdecode") == false) {
		function gzdecode($data) {
			$file = tempnam("/tmp", "gzip");

			@file_put_contents($file, $data);
			ob_start();
			readgzfile($file);
			$data = ob_get_clean();
			unlink($file);

			return $data;
		}
	}

	/* Suppress error messages
	 */
	function error_handler($error) {
	}
	set_error_handler("error_handler", E_ALL);
?>
