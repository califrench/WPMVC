<?php

namespace Rest_API;

class IndexController extends Controller
{
	
	public function indexGET()
	{
		$this->response( array( 'status' => 'success', 'data' => array() ) );
	}

}



?>
