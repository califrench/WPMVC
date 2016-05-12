<?php

namespace Rest_API;

class UserModel extends Model
{
	
	public function getMetas( $user_id )
	{		
		global $wpdb;

		return $this->query( "select * from " . $wpdb->prefix . "usermeta where user_id = %d", array( $user_id ) );
	}
	
	
}

?>
