<?php

namespace Rest_API;

class UserModel extends Model
{
	
	public function getMetas( $user_id )
	{		
		global $wpdb;

		return $this->query( "select * from " . $wpdb->prefix . "usermeta where user_id = %d", array( $user_id ) );
	}
	
	public function getUser( $user ){

		global $wpdb;


		if( filter_var( $user, FILTER_VALIDATE_EMAIL ) ) {
			$type = 'user_email';
			$placeholder = '%s';
		} elseif( is_numeric($user) ) {
			$type = 'ID';
			$placeholder = '%d';
		}

		if( $results = $wpdb->get_row( $wpdb->prepare("
			SELECT * FROM `{$wpdb->prefix}users` WHERE `{$type}` = {$placeholder}
		", $user)) ){
			return $results;
		} else {
			return false;
		}
	}

	
}

?>
