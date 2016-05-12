<?php

namespace Rest_API;

class PostController extends Controller {

	public function savePOST()
	{    
		$post = array(
			'post_author'		 => 1,
      'post_content'   => '',
      'post_title'     => '',
			'post_name'			 => sanitize_title( $this->request->post['post_title'] ),
      'post_status'    => 'publish',
      'post_type'      => 'post',
      'post_excerpt'   => substr( $this->request->getParam('post_content'), 0, 200 )
		);
		
		$inserted = wp_insert_post( array_merge( $post, $this->request->getParams() ), TRUE );
		
		if( ! is_object( $inserted ) ){
			
			$this->response( array( 'status' => 1, 'msg' => 'Post successfully updated.' ) );
			
		}
		
		$this->response( array( 'status' => 0, 'msg'=>'Something went wrong', 'data' => $inserted->errors ) );
	}
	
	public function deletePOST(){
		
		$deleted = wp_delete_post( $this->request->post['ID'] );
		
		if( is_object( $deleted ) ){
			
			$this->response( array( 'status' => 1, 'msg' => 'Post deleted successfully.' ) );
			
		}
		
		$this->response( array( 'status' => 0, 'msg' => 'Something went wrong' ) );
	}
	
	public function metaPOST(){
		
		
		
	}
	
	public function testGET(){
		$this->response( array( 'status' => 1, 'msg' => 'Successful test.' ) );
	}

}


 ?>