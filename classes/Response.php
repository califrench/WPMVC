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

		if( file_exists( get_template_directory() . '/' . $template . '.php' ) ){
			ob_start(); include get_template_directory() . '/' . $template . '.php'; 
			$template = ob_get_clean(); echo $template; die;
		} 
		elseif( file_exists( dirname(__DIR__) . "/{VER}}/".$template.'.php' ) ) {
			ob_start(); include dirname(__DIR__) . "/{VER}}/".$template.'.php'; 
			$template = ob_get_clean(); echo $template; die;
		}
		else {
			die('I don\'t know what to do with myself');
		}
	}
}