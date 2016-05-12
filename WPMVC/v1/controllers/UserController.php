<?php

namespace Rest_API;

class UserController extends Controller
{
	
	public $user_id;
	
	public function __construct( $request )
	{
		parent::__construct( $request );
		
		//check user access by getting the token from header etc
		
		$token = new TokenModel();
		
		$this->user_id = $token->getUser( $request->getHeader( 'token' ) );
		
		if( ! $this->user_id )
		{
			$this->response( array( 'status' => 'failed', 'message' => 'Please login.' ) );
		}

		//update usage
		$token->updateUsage( $request->getHeader( 'token' ) );
	}
	
}

?>
