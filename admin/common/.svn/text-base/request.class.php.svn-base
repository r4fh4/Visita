<?php

/**
 * @author acarmona <ariovaldo.carmona@gmail.com>
 * @author Igor Escobar <blog@igorescobar.com>
 */
class Request {
	private $url = '' ;
	private $baseUri = '' ;
	private $pathInfo = '' ;
	private $rewrite = true ;

	public function __construct ( $rewrite = true ) {
		$this->rewrite = $rewrite ;

		/**
		 * Check if PATH_INFO|SCRIPT_NAME is empty then check "ORIG_*"
		 * See links for more details
		 * @link http://bugs.php.net/bug.php?id=23800, http://bugs.php.net/bug.php?id=34554, http://bugs.php.net/bug.php?id=31843
		 */
		if ( empty ( $_SERVER['PATH_INFO'] ) && ! empty ( $_SERVER['ORIG_PATH_INFO'] ) ) {
			$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'] ;
		}
		if ( ! empty ( $_SERVER['ORIG_SCRIPT_NAME'] ) && ( $_SERVER['SCRIPT_NAME'] != $_SERVER['ORIG_SCRIPT_NAME'] ) ) {
			$_SERVER['SCRIPT_NAME'] = $_SERVER['ORIG_SCRIPT_NAME'] ;
		}			
	}

	public function getBaseUri () {
		if ( ! empty ( $this->baseUri ) ) {
			return $this->baseUri ;
		}

		// schema://host:port]
		$tmp_host = explode ( ':' , strtolower ( $_SERVER['HTTP_HOST'] ) ) ;
		$tmp_domain = null ;
		if ( ! empty ( $_SERVER['HTTPS'] ) && ( strtolower ( $_SERVER['HTTPS'] ) != 'off' ) ) {
			if ( ( isset ( $tmp_host[1] ) && ( $tmp_host[1] == 443 ) ) || ! isset ( $tmp_host[1] ) )	{
				$tmp_domain = 'https://' . $tmp_host[0] ;
			}
			else {
				$tmp_domain = 'https://' . $tmp_host[0] . ':' . $tmp_host[1] ;
			}
		}
		else {
			if ( ( isset ( $tmp_host[1] ) && ( $tmp_host[1] == 80 ) ) || ! isset ( $tmp_host[1] ) ) {
				$tmp_domain = 'http://' . $tmp_host[0] ;
			}
			else {
				$tmp_domain = 'http://' . $tmp_host[0] . ':' . $tmp_host[1] ;
			}
		}
		$this->baseUri = trim ( $tmp_domain , '/' ) . '/' ;
		return $this->baseUri ;
	}

	public function getPathInfo () {
		if ( ! empty ( $this->pathInfo ) ) {
			return $this->pathInfo ;
		}

		if ( empty ( $_SERVER['PATH_INFO'] ) ) {
			return '' ;
		}

		if ( defined ( 'ACTIVE_WEBAPP' ) ) {

			$replaces[] = '/\/tools\//';
			$replaces[] = '/\/ferramentas\//';
			$replaces[] = '/(\?(.+))/';
			
			$levels = $this->normalizePath ( preg_replace ($replaces, '', $_SERVER['REQUEST_URI'] ) ) ;

		} else {
		
			$levels = $this->normalizePath ( $_SERVER['PATH_INFO'] ) ;
		
		}
		
		$tmp_url = implode ( '/' , $levels ) ;

		if ( ( $_SERVER['PATH_INFO'] != '/' ) && ( $_SERVER['PATH_INFO'] != '/' . WEBAPP_APP_WRAPPER . '/' ) && ( $_SERVER['PATH_INFO'][strlen ( $_SERVER['PATH_INFO'] ) - 1] == '/' ) ) {
			$tmp_url .= '/' ;
		}

		if ( ! empty ( $tmp_url ) ) {
			$this->pathInfo = $tmp_url ;
		}
		return $this->pathInfo ;
	}

	public function getUrl () {
		if ( ! empty ( $this->url ) ) {
			return $this->url ;
		}

		if ( empty ( $_SERVER['SCRIPT_NAME'] ) ) {
			return '' ;
		}

		$levels = $this->normalizePath ( $_SERVER['SCRIPT_NAME'] ) ;
		$tmp_url = implode ( '/' , $levels ) ;

		if ( ! empty ( $tmp_url ) ) {
			if ( ! $this->rewrite ) {
				$this->url = str_replace ( WEBAPP_APP_WRAPPER , '' , $tmp_url ) . '/' . WEBAPP_APP_WRAPPER . '/' ;
			}
			else {
				$this->url = $tmp_url . '/' ;
			}
		}
		else {
			if ( ! $this->rewrite ) {
				$this->url = WEBAPP_APP_WRAPPER . '/' ;
			}
		}
		return $this->url ;
	}

	private function normalizePath ( $list , $script = false ) {
		if ( empty ( $list ) ) {
			return $list ;
		}

		$new_list = array () ;
		$tmp = explode ( '/' , trim ( trim ( $list ) , '/' ) ) ;

		foreach ( $tmp as $key => $value ) {

			$value = preg_replace_callback (
				'/%([0-9a-f]{2})/' ,
				create_function (
					'$matches' ,
					'$str = strtoupper ( $matches[0] ) ;
					$tmp = intval ( hexdec ( $str ) ) ;
					$tmp = chr ( $tmp ) ;
					if ( preg_match ( "/^[a-zA-Z0-9._~-]$/" , $tmp )  ) {
						$str = $tmp ;
					}
					return $str ;'
				) ,
				$value
			) ;			
			
			if ( $value == '..' ) {
				$count = count ( $new_list ) - 1 ;
				if ( isset ( $new_list[$count] ) && ( $new_list[$count] != '..' ) ) {
					array_pop ( $new_list ) ;
				}
			}
			elseif ( ! empty ( $value ) && ( $value != '.' ) && ( ( $value != WEBAPP_APP_WRAPPER ) || $script ) ) {
				array_push ( $new_list , $value ) ;
			}
		}
	
		return array_values ( $new_list ) ;
	}

	public function getLevelsPathInfo () {
		$tmp_path = trim ( $this->getPathInfo () , '/' ) ;
		if ( ! empty ( $tmp_path ) ) {
			return explode ( '/' , $tmp_path ) ;
		}
		return array () ;
	}
}
