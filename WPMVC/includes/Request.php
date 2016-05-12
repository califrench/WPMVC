<?php
namespace Rest_API;	
class Request {
	
	public $get	 			= array();
	public $post 			= array();
	public $parsed_params 	= array();
	public $headers			= array();
	
	public $log_id			= false;

	public function __construct( $url = array(), $log_id = false ) {
		
		if( $url )
		{
			for( $i = 0; $i < count( $url ); $i++ )
			{
				if( fmod( $i, 2 ) )
				{
					$this->parsed_params[$url[$i-1]] = $url[$i];
				}
				else
				{
					$this->parsed_params[$url[$i]] = '';
				}
			}
		}
	
		$this->getAllHeaders();
				
		$this->post = $_POST;
		$this->get  = $_GET;
		
		$this->log_id 	= $log_id;
	}


	public function getParam( $name, $default_value = '' ) {
		
		if( empty( $this->parsed_params[$name] ) )
		{
			return $default_value;
		}

		return $this->parsed_params[$name];
	}
	
	
	public function getParams() {
		return array_merge($this->parsed_params, $this->post, $this->get);
	}
	
	
	public function getHeader( $name ) {
		return empty( $this->headers[$name] ) ? NULL : $this->headers[$name];
	}
	
	
	/**
	 * Returns an associative array of all the header names and values of this
	 * request
	 * 
	 * @return array
	 */
	protected function getAllHeaders() {
		$this->headers = getallheaders();

		return $this->headers;
	}
	
	
	//update log with output
	public function updateLog( $data = array() ) {
		global $wpdb;
		
		if( ! $this->log_id ) return;
		
		return $wpdb->update( 
			$wpdb->prefix . 'apilogs', 
			array( 
				'output' => json_encode( $data ),
			), 
			array( 'log_id' => $this->log_id ), 
			array( 
				'%s'
			)
		);
	}

}

?>
