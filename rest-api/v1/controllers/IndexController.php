<?php

namespace Rest_API;
use \WPMVC\Response as Response;

class IndexController extends Controller
{
	
	public function indexGET()
	{
		$Response = new Response;
		echo $Response->view('index', array('foo'=>'bar'));
	}

}



?>
