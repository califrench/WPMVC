<?php

namespace Rest_API;

use \Response\Response as Response;

class AccountController extends Controller
{
	
	public $user_id;
	
	public function __construct()
	{
		if( ! is_user_logged_in() )
		{
			$this->response( array( 'status' => 'failed', 'message' => 'Please login.' ) );
		}

		$this->request = parent::getRequest();
	}
	
	public function indexGet(){
		echo $Response->view('campaign', array('campaigns'=>$campaigns));
	}

}

?>
