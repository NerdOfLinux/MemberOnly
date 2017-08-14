<?php
 /*
  Plugin Name: Member Only Content
  Plugin URI: https://gateblogs.com
  Description: A simple plugin to create member only content
  Version: 0.1
  Author: NerdOfLinux
  Author URI: https://gateblogs.com
  License: MIT
 */
class member_only {
 /* Include settings.php */
require("settings.php");
 add_filter( 'the_content', 'post_filter' );
 /* Create the function */
 public function post_filter( $content ) {
     /* Create categories that are member only*/
     $categories = array(
         'premium',
     );
     /* If the post is in the category */
     if ( in_category( $categories ) ) {
         /* If the user is logged in, then show the content*/
         if ( is_user_logged_in() ) {
             return $content;
         /* Else tell the user to log in */
         } else {
             /* $link = get_the_permalink();
             $link = str_replace(':', '%3A', $link);
             $link = str_replace('/', '%2F', $link);
             $content = "<p>Sorry, this post is only available to members. <a href=\"gateblogs.com/login?redirect_to=$link\">Sign in/Register</a></p>"; */
             $content= "<p> Sorry, this post is member only. <p>";
             return $content;
         }
     } else {
          return $content;
     }
 }
}
new member_only();
?>
