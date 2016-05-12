<?php

namespace Rest_API;

class AuthController extends Controller
{
	
	public function loginPOST()
	{
		$user = wp_authenticate( @$this->request->post['username'], @$this->request->post['password'] );

		//wordpress failed to authenticate
		if( is_wp_error( $user ) )
		{
			$this->response( array( 'status' => 'failed', 'message' => 'Email or password is not valid.' ) );
		}

		//generate a token
		$token = new TokenModel();
		$token = $token->generate( $user->ID );

		if( ! $token )
		{
			$this->response( array( 'status' => 'failed', 'message' => 'We couldn\'t generate an authentification token.' ) );
		}

		$this->response( array( 'status' => 'success', 'data' => array( 'token' => $token, 'user_id' => $user->ID, 'user_name' => $user->display_name ) ) );
	}


	public function logoutGET()
	{
		if( $this->request->getHeader( 'token' ) )
		{
			$token = new TokenModel();
			$token->delete( $this->request->getHeader( 'token' ) );
		}

		$this->response( array( 'status' => 'success', 'message' => 'Logout successfully.' ) );
	}

}

?>
