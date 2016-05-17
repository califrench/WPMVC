<?php

namespace WPMVC;

class Response
{

	public static function json( $data = array(), $code = 200 ) {
		http_response_code( $code );
		header( 'Content-Type: application/json' );
		echo json_encode( $data );
		die;
	}

	public static function view($template, $data=array()){
		$path = dirname(__DIR__) . "/rest-api/v1/views/".$template.'.php';

		if( file_exists( $path ) ){
			ob_start(); include $path; 		
			$template = ob_get_clean(); echo $template; die();
		}
		else {
			die('I don\'t know what to do with myself');
		}
	}
}