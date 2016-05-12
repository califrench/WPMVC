<?php

/*
Plugin Name: RestAPI
Description: REST API for Wordpress
Version: 1.0.0
Author: Jacob Ross
Author URI: http://jakesmakes.com
*/

require_once dirname( __FILE__ ) . '/includes/Controller.php';
require_once dirname( __FILE__ ) . '/includes/Request.php';
require_once dirname( __FILE__ ) . '/includes/Model.php';
require_once dirname( __FILE__ ) . '/includes/Validate.php';

define( 'LOG_API_CALLS', true );

class Rest_API {

	public $api_prefix_url = 'api';
	
	public $available_api_versions = array( 'v1' );
	
	public function __construct() {
		
		$GLOBALS['plugin-path'] = dirname( __FILE__ );
		
		$GLOBALS['plugin-url'] 	= plugins_url() . '/api';

		$this->apiInit();

		add_action( 'parse_request', array( $this, 'apiLoaded' ), 10, 1 );		
	}

	public function apiInit() {
		
		global $wp;
		
		$wp->add_query_var( 'api_route' );
		
		add_rewrite_rule( '^' . $this->api_prefix_url . '/?$','index.php?api_route=/','top' );
		
		add_rewrite_rule( '^' . $this->api_prefix_url . '(.*)?','index.php?api_route=$matches[1]','top' );
		
	}

	public function apiLoaded() {
		
		global $wp;
		
		if( empty( $wp->query_vars['api_route'] ) )
			
			return;
		
		
		spl_autoload_register( 'autoloader' );

		//log this call to the api
		$log_id = LOG_API_CALLS ? $this->logCall() : false;

		$path = explode( '/', trim( $wp->query_vars['api_route'], '/' ) );

		
		if( empty( $path[0] ) ||
		
			! in_array( $path[0], $this->available_api_versions ) ||
			
			! is_dir( $GLOBALS['plugin-path'] . '/' . $path[0] ) ) {
				
				echo 'No api version found';
				
				die;	
					
		}
		
		$GLOBALS['api-version'] = $path[0];

		$controller = 'index';
		
		$action 	= 'index';

		if( count( $path ) != 1 ) {
			
			$controller = $path[1];
			
			if( @$path[2] ) {
				
				$action = $path[2];
				
			}
		}

		$class_controller = ucfirst( strtolower( $controller ) ) . 'Controller';

		$path = array_slice( $path, 3 );
		
		$new_class = '\\Rest_API\\' . $class_controller;
		
		$new_request = '\\Rest_API\\' . 'Request';
		
		$class = new $new_class( new $new_request( array_values( $path ), $log_id ) );
		
		$action_name = $action . $_SERVER['REQUEST_METHOD'];

		return $class->$action_name();
	}

	public static function activatePlugin() {
		global $wpdb;
		
		//create all the necessary db tables
		//create the logs table
		$wpdb->query( 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'apilogs (
						  log_id int(10) unsigned NOT NULL AUTO_INCREMENT,
						  token varchar(255) DEFAULT NULL,
						  url varchar(500) DEFAULT NULL,
						  method varchar(32) DEFAULT NULL,
						  data mediumtext DEFAULT NULL,
						  output mediumtext DEFAULT NULL,
						  created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY ( log_id )
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1' );

		//create the apitokens
		$wpdb->query( 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'apitokens (
						  token_id int(10) unsigned NOT NULL AUTO_INCREMENT,
						  token varchar(64) NOT NULL,
						  user_id int(10) unsigned NOT NULL,
						  expires datetime DEFAULT NULL,
						  lastused datetime DEFAULT NULL,
						  PRIMARY KEY ( token_id ),
						  KEY token ( token),
						  KEY expires ( expires )
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1' );

		//create other tables needed if any
		update_permalinks();
	}
	
	public static function deactivatePlugin() {
		
	}
		
	public function logCall() {
		
		global $wpdb;
		
		$wpdb->insert( 
			$wpdb->prefix . 'apilogs', 
			array( 
				'token' 	=> @$_SERVER['HTTP_TOKEN'], 
				'url' 		=> $_SERVER['REQUEST_URI'],
				'method' 	=> $_SERVER['REQUEST_METHOD'],
				'data'		=> json_encode( array(
									'server' 	=> $_SERVER,
									'get'		=> $_GET,
									'post'		=> $_POST,
									'files'		=> $_FILES
								) ),
				'created'	=> date( 'Y-m-d H:i:s' )
			), 
			array( 
				'%s', 
				'%s',
				'%s',
				'%s',
				'%s' 
			) 
		);
		
		return $wpdb->insert_id;

	}

}

add_action( 'init',  'initializeApi' );


function initializeApi() {
	new Rest_API();
}

//activate plugin hook
register_activation_hook( __FILE__, array( 'Rest_API', 'activatePlugin' ) );

function sendJSON( $data = array(), $code = 200 ) {
	http_response_code( $code );
	header( 'Content-Type: application/json' );
	echo json_encode( $data );
	die;
}

function autoloader( $class_name ) {
		
	if( strpos( $class_name, 'Rest_API' ) !== false ) {
		
		$api_path = $GLOBALS['plugin-path'] . '/' . $GLOBALS['api-version'];
		
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

function update_permalinks() {
    
	global $wp_rewrite;
	
	$wp_rewrite->set_permalink_structure('/%postname%/');
	
	$wp_rewrite->flush_rules();
		
}