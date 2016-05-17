<?php

namespace Rest_API;

class Controller
{
	public $token = '~8m6%89rADBb1(}T';

	public $request;

	public function __construct( )
	{
		
	}
	
	public function response( $data = array(), $code = 200 )
	{
		
		sendJSON( $data, $code );
	}
	
	public function feedback( $data = array(), $code = 200 )
	{

		$_SESSION = array_merge($_SESSION, array(
			'feedback' => $data
		));

		wp_redirect($_SERVER['HTTP_REFERER']); exit;
	}

	public function getRequest(){
		return $Request = new Request();
	}
}

?>
