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
	
	public function insert( $table, $data, $prepared_values = array() )
	{
		global $wpdb;
		
		$data = array_merge($data, array(
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time())
		));

		array_push($prepared_values, '%s', '%s');

		if( $wpdb->insert( $table, $data, $prepared_values ) ){
			return $wpdb->insert_id;
		}
		
		return false;
	}
	
	public function update( $table, $data, $where, $format = null, $where_format = null )
	{
		global $wpdb;
		
		$data = array_merge($data, array(
			'updated_at' => date('Y-m-d H:i:s', time())
		));

		array_push($format, '%s');

		if( $wpdb->update( $table, $data, $where, $format, $where_format ) ){
			return $wpdb->insert_id;
		}
	}
	
	
	public function get_results( $sql, $prepared_values = array() )
	{
		global $wpdb;
		
		if( $prepared_values )
		{
			return $wpdb->get_results( $wpdb->prepare( $sql, $prepared_values ) );
		}
		
		return $wpdb->get_results( $sql );
	}
	
	public function get_row( $sql, $prepared_values = array() )
	{
		global $wpdb;
		
		if( $prepared_values )
		{
			return $wpdb->get_row( $wpdb->prepare( $sql, $prepared_values ));
		}
		
		return $wpdb->get_row( $sql );
	}
	
}

?>
