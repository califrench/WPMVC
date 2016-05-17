<?php

function pre($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function api_action($path){

  return get_bloginfo('url') . '/route/' .$path;
}

function getController(){

  global $wp;

  $path = explode( '/', trim( $wp->query_vars['api_route'], '/' ) );

  $controller = 'index';

  if( count($path) ){

    if( isset($path[0]) ) {
      
      $controller = $path[0];
      
    }
  }

  return $controller;
}

function getMethod(){

  global $wp;
  
  $path = explode( '/', trim( $wp->query_vars['api_route'], '/' ) );
    
  $action   = 'index';

  if( count( $path ) ) {
    
    if( isset($path[1]) ) {
      
      $action = $path[1];
      
    }
  }

  return $action;
}

function unslug($slug){
  
  $slug = explode('-', $slug);
  
  $arr = array();
  
  foreach($slug as $s){
    $arr[] = ucfirst($s);
  }
  
  return implode(' ', $arr);
}