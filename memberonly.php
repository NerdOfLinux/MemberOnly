<?php
/*
 Plugin Name: Member Only Content
 Plugin URI: https://nerdoflinux.github.io/plugins/memberonly.html
 Description: A simple plugin to create member only content
 Version: 0.2
 Author: NerdOfLinux, NerdOfCode
 Author URI: https://gateblogs.com/user/nerdoflinux
 License: GPL
 */
/* Include the settings page */
include("memberonly-settings.php");
/* Adds WordPress filter for Content */
add_filter( 'the_content', 'post_filter' );
/* Create the function */
function post_filter( $content ) {
    /* Get variables or use defaults */
    /* Get_option from WordPress DB */
    $redirect = get_option("redirect");
    $login_link = get_option("loginURL", "/wp-login.php");
    $member_categories = get_option("categories", "member-only");
    $message = get_option("message", "Sorry, this post is for members only.  [sign_in]");
    $loginText = get_option("loginText", "Sign In/Register.");
    /* Create categories that are member only*/
    $categories = explode(",", $member_categories);
    /* If the post is in the category */
    if ( in_category( $categories ) ) {
	if ( is_user_logged_in() ){
		return $content;	
	} else {
            $content = "";
            if ( $redirect ){
                $link = get_the_permalink();
		/* Make new link acceptable for URL // %3A is equal to a colon */
                $link = str_replace(':', '%3A', $link);
		/* Make new link acceptable for URL // %2F is equal to / */
                $link = str_replace('/', '%2F', $link);
		/* Use shortcode to place link */
                $loginMessage = str_replace('[sign_in]', "<a href=\"$login_link?redirect_to=$link\">$loginText</a></p>", $message);
                $content = "<p>$loginMessage</p>";
            } else {
		/* Use shortcode to place link */
                $loginMessage = str_replace('[sign_in]', "<a href=\"$login_link\">$loginText</a></p>", $message);
		/* Set new content equal to login message */
                $content = "<p>$loginMessage</p>"; }
        /* Return the new content information */    
	return $content; }
        /* If the post is not in the category */
    } else {
           return $content;
       }
}
?>
