<?php

namespace Rest_API;

class IndexController extends Controller
{
	
	public function indexGET()
	{
		echo $Response->view('index', array('foo'=>'bar'));
	}

}



?>
