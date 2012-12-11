<?php

/**
 * This class Environment manipulate many resources. Example: redir and not-found
 * @author acarmona <ariovaldo.carmona@gmail.com>
 */
class Environment {

	public function __construct () {
	}

	/**
	 * Disable variables created by disableRegisterGlobals - Use only if you cannot change server configuration
	 * This function going to called before session_start if it is necessary
	 * Source
	 * @link http://www.php.net/manual/en/security.globals.php
	 * @link http://pear.php.net/package/PHP_Compat/docs/1.6.0a1/__filesource/fsource_PHP_Compat__PHP_Compat-1.6.0a1CompatEnvironmentregister_globals_off.php.html
	 */
	public static function disableRegisterGlobals () {
		if ( ini_get ( 'register_globals' ) ) {
			$exclude = array (
				'GLOBALS' ,
				'_GET' ,
				'_POST' ,
				'_COOKIE' ,
				'_REQUEST' ,
				'_SERVER' ,
				'_ENV' ,
				'_FILES' ,
				'_SESSION'
			) ;

			$content = array_merge (
				$_GET ,
				$_POST ,
				$_COOKIE ,
				$_FILES ,
				$_SERVER ,
				$_ENV ,
				isset ( $_SESSION ) && is_array ( $_SESSION ) ? $_SESSION : array ()
			) ;

			foreach ( $content as $k => $v ) {
			    if ( ! in_array ( $k , $exclude ) && isset ( $GLOBALS[$k] ) ) {
			        unset ( $GLOBALS[$k] ) ;
			    }
			}
		}
	}

	/**
	 * Disable disableMagicQuotes in runtime - Use only if you cannot change server configuration
	 * Source @link http://www.php.net/manual/en/security.magicquotes.disabling.php
	 */
	public static function disableMagicQuotes () {
		if ( get_magic_quotes_gpc () ) {
			function stripslashes_deep ( $value ) {
				$value = is_array ( $value ) ? array_map ( 'stripslashes_deep' , $value ) : stripslashes ( $value ) ;
				return $value ;
			}

			$_GET = array_map ( 'stripslashes_deep' , $_GET ) ;
			$_POST = array_map ( 'stripslashes_deep' , $_POST ) ;
			$_COOKIE = array_map ( 'stripslashes_deep' , $_COOKIE ) ;
			$_REQUEST = array_map ( 'stripslashes_deep' , $_REQUEST ) ;
		}

		set_magic_quotes_runtime ( 0 ) ;
		ini_set ( 'magic_quotes_sybase' , 'Off' ) ;
	}

	/**
	 * Display default error if to occur any critical error with [database|template]
	 * @param string $error_file path with error template
	 */
	public static function displayError ( $error_file = null ) {
		header ( 'HTTP/1.1 500 Internal Server Error' ) ;

		if ( ! is_null ( $error_file ) && is_file ( $error_file ) ) {
			require $error_file ;
		}
		else {
			echo '<html><head><title>500 Internal Server Error</title></head><body><p>500 Internal Server Error</p>
			<!--WEPAPP - ' . date ( 'Y-m-d H:i:s' ) . '--></body></html>' ;
		}

		exit ;
	}

	/**
	 * Display default error if to occur any critical error with [database|template]
	 * @param string $not_found_file path with page template
	 */
	public static function displayNotFound ( $not_found_file = null ) {
		header ( 'HTTP/1.0 404 Not Found' ) ;

		if ( ! is_null ( $not_found_file ) && is_file ( $not_found_file ) ) {
			require $not_found_file ;
		}
		else {
			echo '<html><head><title>404 Not Found</title></head><body><p>404 Not Found</p>
			<!--WEPAPP - ' . date ( 'Y-m-d H:i:s' ) . '--></body></html>' ;
		}

		exit ;
	}

	/**
	 * Display maintenance page if file exists [maintenance.txt] in config directory
	 * @param string $maintenance_file file for show maintenance page
	 * @param string $maintenance_template path with template
	 */
	public static function isMaintenance ( $maintenance_file , $maintenance_template = null ) {
		if ( is_file ( $maintenance_file ) ) {

			header ( 'HTTP/1.1 503 Service Temporarily Unavailable' ) ;
			header ( 'Retry-After: 60' ) ;

			if ( ! is_null ( $maintenance_template ) && is_file ( $maintenance_template ) ) {
				require $maintenance_template ;
			}
			else {
				echo '<html><head><title>503 Service Temporarily Unavailable</title></head><body><p>503 Service Temporarily Unavailable</p>
				<!--WEPAPP - ' . date ( 'Y-m-d H:i:s' ) . '--></body></html>' ;
			}

			exit ;
		}
	}

	public static function noCache () {
		header ( 'Expires: Mon, 01 Jan 2007 01:00:00 GMT' ) ;
		header ( 'Cache-Control: no-store, no-cache, must-revalidate' ) ;
		header ( 'Cache-Control: post-check=0, pre-check=0' , false ) ;
		header ( 'Pragma: no-cache' ) ;
	}

	/*
	 * Redirect with HTTP Code correct
	 * @param string $url location used in header
	 * @param integer $header http code will send for client
	 */
	public static function redir ( $url , $header = 301 ) {
		if ( $header == 302 ) {
			header ( 'Location: ' . $url , true , 302 ) ;
		}
		else {
			header ( 'Location: ' . $url , true , 301 ) ;
		}

		exit ;
	}

	/**
	 * @param int $start
	 * @param int $end
	 * @param bool $console If will displayed on Firebux Console
	 */
	public static function displayExecutionTime ( $environment , $start , $end , $console = true ) {
		if ( $environment == 'dev' ) {
			if ( $console ) {
				echo sprintf ( "\n\n<script language=\"javascript\" type=\"text/javascript\"><!--\n\nconsole.log ( \"Execution time: %s.\" ) ;\n\n//--></script>\n\n" , ( $end - $start ) ) ;
			}
			else {
				echo sprintf ( '<p>Execution time: %s</p>' , ( $end - $start ) ) ;
			}
		}
	}

	/**
	 * Check environment variable for get remote address
	 * Verify:
	 *		$_SERVER['REMOTE_ADDR']
	 *		$_SERVER['HTTP_X_FORWARDED_FOR']
	 *
	 * @return string $address
	 */
	public static function getRemoteAddress () {
		$address = '' ;

		if ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$list = explode ( ',' , $_SERVER['HTTP_X_FORWARDED_FOR'] ) ;

			if ( ! empty ( $list ) ) {
				$address = trim ( $list[0] ) ;
			}
		}
		elseif ( isset ( $_SERVER['REMOTE_ADDR'] ) ) {
			$address = $_SERVER['REMOTE_ADDR'] ;
		}

		return $address ;
	}
}
