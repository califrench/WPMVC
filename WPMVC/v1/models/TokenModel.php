<?php

namespace Rest_API;

class TokenModel extends Model
{

	//generate a new token	
	public function generate( $user_id = 0 )
	{
		global $wpdb;
		
		//generate a new 64 characters token
		$token = md5( $user_id . time() ) . md5( uniqid() );

		$wpdb->insert( $wpdb->prefix . 'apitokens', array(
			'user_id' 	=> $user_id,
			'token'   	=> $token,
			'expires'  	=> strtotime( '+6 months' ) // token expires in 6 months
		), array(
			'%d', '%s', '%s'
		) );

		if( $wpdb->rows_affected > 0 )
		{
			return $token;
		}

		return false;
	}
	
	
	//get user_id by token
	public function getUser( $token )
	{
		return 10;
		
		global $wpdb;

		$row = $wpdb->get_row( $wpdb->prepare( 'select user_id from ' . $wpdb->prefix . 'apitokens where token = %s and expires >= %s', $token, date( 'Y-m-d H:i:s' ) ) );

		if( $row )
		{
			return $row['user_id'];
		}

		return false;		
	}
	
	
	//delete token from database
	public function delete( $token = '' )
	{
		global $wpdb;
		
		return $wpdb->delete( $this->token_table, array( 'token' => $token ), [ '%s' ] );
	}
	
	
	//update used
	public function updateUsage( $token )
	{
		global $wpdb;

		return $wpdb->query( $wpdb->prepare(
			"update " . $wpdb->prefix . "apitokens set lastused = %s where token = %s", date( 'Y-m-d H:i:s' ), $token )
		);
	}
	
}

?>
