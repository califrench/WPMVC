<?php

namespace Rest_API;

class AuthController extends Controller
{
	
	public function loginPOST()
	{

		$UserModel = new UserModel();

		$user = $UserModel->getUser($_POST['user_email']);

		$user = wp_authenticate( $user->user_email, $this->request->post['user_password'] );

		//wordpress failed to authenticate
		if( is_wp_error( $user ) )
		{
			$this->feedback( array( 'message' => 'Email or password is not valid.' ) );
		}

		$_SESSION['user'] = (array) $user->data;

		wp_clear_auth_cookie();
		wp_set_auth_cookie( $user->data->ID, false );
		wp_set_current_user( $user->data->ID );

		wp_redirect(get_bloginfo('url')); exit;
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


	public function registerPOST(){

		$Validate = new \WPMVC\Validate();

		$Validate->init($_POST, array(
			'user_password' 	=> array('min[8]'=>'Your password should be more than 8 characters'),
			'confirm_password' 	=> array('match['.$_POST['user_password'].']' => 'Your passwords don\'t match'),
			'user_email'		=> array('user' => 'This email is already registered. <a href="'.get_bloginfo('url').'/sign-in">Sign In</a> or <a href="'.get_bloginfo('url').'/reset-password">Reset Password</a>')
		));

		if( !empty($error = $Validate::$error) )
		{
			$this->feedback(array('validation'=>$error));
		}

		$user_id = wp_create_user($_POST['user_email'],$_POST['user_password'],$_POST['user_email']);
				

		wp_clear_auth_cookie();
		wp_set_auth_cookie( $user_id, false );
		wp_set_current_user( $user_id );
		wp_redirect(get_bloginfo('url'). 'route/account'); exit;
	}
}

?>
