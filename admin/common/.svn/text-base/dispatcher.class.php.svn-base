<?php
/**
 * This class Dispatcher, dispatch one request to correct handler (class/method) with args
 *
 */
class Dispatcher {

	private $uri = '' ;
	private $rules = array () ;
	private $classArgs = array () ;

	public function __construct ( $uri , $args = array () ) {
		$this->classArgs = $args ;
		$this->uri = $uri ;
	}

	public function rules ( $http_method , $url_pattern , $class , $method , $action = null , $args = array () ) {
		if ( ( $http_method === 'POST' || $http_method === 'GET' ) && ! empty ( $method ) && ! empty ( $class ) ) {
			$this->rules[] = array ( $http_method , $url_pattern , $class , $method , $action , $args ) ;
		}
	}

	public function exec () {
		$server_method = $_SERVER['REQUEST_METHOD'] ;

		if ( ! empty ( $server_method ) ) {
			foreach ( $this->rules as $entry ) {
				if ( $server_method === $entry[0] ) {
					if ( ! empty ( $entry[4] ) && ( ( $entry[0] == 'GET' && ! isset ( $_GET[$entry[4]] ) ) || ( $entry[0] == 'POST' && ! isset ( $_POST[$entry[4]] ) ) ) ) {
						continue ;
					}
					
					if ( preg_match ( '/^' . ereg_replace ( '/' , '\/' , $entry[1] ) . '$/' , $this->uri , $matches ) ) {
						$class_name = $entry[2] . '_controller' ;
						if ( class_exists ( $class_name ) ) {
							if ( empty ( $this->classArgs ) ) {
								$class = new $class_name ;
							}
							else {
								$class = new $class_name ( $this->classArgs ) ;
							}
							if ( method_exists ( $class , $entry[3] ) ) {
								$method = $entry[3] ;

								$matches['server_uri'] = $this->uri ;

								if ( empty ( $entry[5] ) ) {
									$class->{$method}( $matches ) ;
								}
								else {
									$class->{$method}( $matches , $entry[5] ) ;
								}
								return true ;
							}
						}
					}
				}
			}
		}
		return false ;
	}
}

