<?php

require_once dirname( __FILE__ ) . '/base/Controller.php';
require_once dirname( __FILE__ ) . '/base/Model.php';

use \WPMVC\Response as Response;

class Rest_API {

	public $api_prefix_url;

	public $current_version;
	
	public function __construct() {

		$this->api_prefix_url = 'route';
		$this->current_version = 'v1';

		$this->apiInit();

		add_action( 'parse_request', array( $this, 'apiLoaded' ), 10, 1 );		
	}

	public function apiInit() {
		
		global $wp;
		
		$wp->add_query_var( 'api_route' );

		add_rewrite_rule( '^' . $this->api_prefix_url . '/?$','index.php?api_route=/','top' );
		
		add_rewrite_rule( '^' . $this->api_prefix_url . '(.*)?', 'index.php?api_route=$matches[1]','top' );
		
	}

	public function apiLoaded() {
		
		global $wp;
		
		if( empty( $wp->query_vars['api_route'] ) )
			
			return;		
		
		spl_autoload_register( array($this, 'autoloader') );

		$controller = getController();

		$action = getMethod();		

		$class_controller = ucfirst( strtolower( $controller ) ) . 'Controller';

		$new_class = '\\Rest_API\\' . $class_controller;

		$new_request = '\\Rest_API\\' . 'Request';

		$class = new $new_class();
		
		if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
		{
		    $_SERVER['REQUEST_METHOD'] = 'JSON';
		}

		$action_name = $action . $_SERVER['REQUEST_METHOD'];

		if( method_exists( $class, $action_name ) ){

			return $class->$action_name();

		} else {

			$Response = new Response;
			$Response->view('404');
		}
	}

	public function autoloader( $class_name ) {
			
		if( strpos( $class_name, 'Rest_API' ) !== false ) {
			
			$api_path = dirname( __FILE__ ) . '/' . $this->current_version;
			
			if( strpos( $class_name, 'Controller' ) !== false ) {
				
				$subpath = str_replace( 'Rest_API\\', '', $class_name );
				
				if( file_exists( $api_path . '/controllers/' . $subpath . '.php' ) ) {
					
					require_once $api_path . '/controllers/' . $subpath . '.php';
			
					return true;
				}
				else {
					
					sendJson( array( 
						'status' => 'failed', 
						'message' => 'API Controller ( ' . $class_name . ' ) not found.' 
					) );
					
				}
			}
			elseif( strpos( $class_name, 'Model' ) !== false ) {
				
				$subpath = str_replace( 'Rest_API\\', '', $class_name );
				
				if( file_exists( $api_path . '/models/' .$subpath . '.php' ) ) {
					
					require_once $api_path . '/models/' . $subpath . '.php';
			
					return true;
				}
				else {
					
					sendJson( array( 
						'status' => 'failed', 
						'message' => 'API Model ( ' . $class_name . ' ) not found.' 
					) );
					
				}
			}
			else {
				
				$subpath = str_replace( 'Rest_API\\', '', $class_name );
				
				if( file_exists( $api_path . '/' . $subpath . '.php' ) ) {
					
					require_once $api_path . '/' . $subpath . '.php';
			
					return true;
				}
				else {
					
					sendJson( array( 
						'status' => 'failed', 
						'message' => 'API Class ( ' . $class_name . ' ) not found.' 
					) );
					
				}
			}
		}
		return false;
	}
}