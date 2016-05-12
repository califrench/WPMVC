<?php

namespace Rest_API;

class Controller
{
	
	public $request = null;
	
	public function __construct( $request )
	{
		$this->request = $request;
	}
	
	public function response( $data = array(), $code = 200 )
	{
		if( LOG_API_CALLS )
		{
			$this->request->updateLog( array( 'response' => $data, 'code' => $code ) );
		}
		
		sendJSON( $data, $code );
	}

}

?>
