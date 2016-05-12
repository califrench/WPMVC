<?php

namespace Rest_API;

class Model
{	
	
	public function execute( $sql, $prepared_values = array() )
	{
		global $wpdb;
		
		if( $prepared_values )
		{
			return $wpdb->query( $wpdb->prepare( $sql, $prepared_values ) );
		}
		
		return $wpdb->query( $sql );
	}
	
	
	public function query( $sql, $prepared_values = array() )
	{
		global $wpdb;
		
		if( $prepared_values )
		{
			return $wpdb->get_results( $wpdb->prepare( $sql, $prepared_values ), ARRAY_A );
		}
		
		return $wpdb->get_results( $sql, ARRAY_A );
	}
	
}

?>
