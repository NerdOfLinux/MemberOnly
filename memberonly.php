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
    /* Create blank array */
    public function __construct() {
        //$this = [];
        // Hook into the admin menu
        add_action( 'admin_menu', array( $this, 'settings_page' ) );
    }
    public function settings_page() {
        //Create the menu item and page
        $parent_slug = "member_only";
        $page_title = "Member Only Content Settings Page";
        $menu_title = "Member Only Content";
        $capability = "manage_options";
        $slug = "member_only";
        $callback = array( $this, 'settings_page_content' );
        add_submenu_page( "options-general.php", $page_title, $menu_title, $capability, $slug, $callback );
    }
    /* Create the page*/
    public function settings_page_content() { ?>
        <div class="wrap">
            <h2> Member Only Content </h2>Content
            <form method="post" action="options.php">
                <?php
                    settings_fields("member_only_fields");
                    do_settings_sections("member_only_fields");
                    submit_button();
                ?>
            </form>
    <?php
    }
}
new member_only();
add_filter( 'the_content', 'post_filter' );
/* Create the function */
function post_filter( $content ) {
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
?>
