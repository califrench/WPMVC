<?php

namespace Rest_API;

class Request {
	
	public $get	 			= array();
	public $post 			= array();
	public $params 	= array();
	public $headers			= array();
	
	public $log_id			= false;

	public function __construct() {

		global $wp;

		$url = explode( '/', trim( $wp->query_vars['api_route'], '/' ) );

		unset($url[array_search(getController(), $url)]);
		
		unset($url[array_search(getMethod(), $url)]);

		$url = array_values($url);

		$this->params = $url;
				
		$this->post = $_POST;

		$this->get = $_GET;
	}
}