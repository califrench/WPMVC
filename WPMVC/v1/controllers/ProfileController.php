<?php

namespace Rest_API;

class ProfileController extends UserController
{
	
	public function indexPOST()
	{
		$model = new UserModel();
		$this->response( array( 'status' => 'success', 'data' => $model->getMetas( $this->user_id ) ) );
	}
	
}

?>
