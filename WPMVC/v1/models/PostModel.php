<?php
class PostModel {
  public function add( $post_array ){
    $post = array(
      'post_content'   => [ <string> ] // The full text of the post.
      'post_title'     => [ <string> ] // The title of your post.
      'post_status'    => 'publish'
      'post_type'      => [ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ] // Default 'post'.
      'post_author'    => [ <user ID> ] // The user ID number of the author. Default is the current user ID.
      'ping_status'    => [ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
      'post_parent'    => [ <post ID> ] // Sets the parent of the new post, if any. Default 0.
      'menu_order'     => [ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
      'to_ping'        => // Space or carriage return-separated list of URLs to ping. Default empty string.
      'pinged'         => // Space or carriage return-separated list of URLs that have been pinged. Default empty string.
      'post_password'  => [ <string> ] // Password for post, if any. Default empty string.
      'guid'           => // Skip this and let Wordpress handle it, usually.
      'post_content_filtered' => // Skip this and let Wordpress handle it, usually.
      'post_excerpt'   => [ <string> ] // For all your post excerpt needs.
      'post_date'      => [ Y-m-d H:i:s ] // The time post was made.
      'post_date_gmt'  => [ Y-m-d H:i:s ] // The time post was made, in GMT.
      'comment_status' => [ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
      'post_category'  => [ array(<category id>, ...) ] // Default empty.
      'tags_input'     => [ '<tag>, <tag>, ...' | array ] // Default empty.
      'tax_input'      => [ array( <taxonomy> => <array | string>, <taxonomy_other> => <array | string> ) ] // For custom taxonomies. Default empty.
      'page_template'  => [ <string> ] // Requires name of template file, eg template.php. Default empty.
      );
  }

  public function edit(){
    $post = array(
      'ID'             => [ <post id> ] // Are you updating an existing post?
      'post_content'   => [ <string> ] // The full text of the post.
      'post_name'      => [ <string> ] // The name (slug) for your post
      'post_title'     => [ <string> ] // The title of your post.
      'post_status'    => [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | custom registered status ] // Default 'draft'.
      'post_type'      => [ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ] // Default 'post'.
      'post_author'    => [ <user ID> ] // The user ID number of the author. Default is the current user ID.
      'ping_status'    => [ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
      'post_parent'    => [ <post ID> ] // Sets the parent of the new post, if any. Default 0.
      'menu_order'     => [ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
      'to_ping'        => // Space or carriage return-separated list of URLs to ping. Default empty string.
      'pinged'         => // Space or carriage return-separated list of URLs that have been pinged. Default empty string.
      'post_password'  => [ <string> ] // Password for post, if any. Default empty string.
      'guid'           => // Skip this and let Wordpress handle it, usually.
      'post_content_filtered' => // Skip this and let Wordpress handle it, usually.
      'post_excerpt'   => [ <string> ] // For all your post excerpt needs.
      'post_date'      => [ Y-m-d H:i:s ] // The time post was made.
      'post_date_gmt'  => [ Y-m-d H:i:s ] // The time post was made, in GMT.
      'comment_status' => [ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
      'post_category'  => [ array(<category id>, ...) ] // Default empty.
      'tags_input'     => [ '<tag>, <tag>, ...' | array ] // Default empty.
      'tax_input'      => [ array( <taxonomy> => <array | string>, <taxonomy_other> => <array | string> ) ] // For custom taxonomies. Default empty.
      'page_template'  => [ <string> ] // Requires name of template file, eg template.php. Default empty.
    );
  }
}
?>