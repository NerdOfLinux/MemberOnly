<?php
/* The settings page */
class Member_Only {
    public function __construct() {
        /* Hook into the admin menu */
        add_action( 'admin_menu', array( $this, 'settings_page' ) );
        add_action( 'admin_init', array( $this, 'setup_init' ) );
    }
    public function settings_page() {
        /* Create the menu item and page */
        $parent_slug = "member_only_fields";
        $page_title = "Member Only Content Settings Page";
        $menu_title = "Member Only Content";
        $capability = "manage_options";
        $slug = "member_only_fields";
        $callback = array( $this, 'settings_page_content' );
        add_submenu_page( "options-general.php", $page_title, $menu_title, $capability, $slug, $callback );
    }
    /* Create the page */
    public function settings_page_content() { ?>
        <div class="wrap">
        <h2> Member Only Content </h2>
        <form method="post" action="options.php">
        <?php
        settings_fields("member_only_fields");
        do_settings_sections("member_only_fields");
        submit_button();
        ?>
        </form>
    <?php }
    /* Setup section_callback */
    public function section_callback( $arguments ) {
        /* Set up input*/
        switch( $arguments['id'] ){
            case "categories" :
                echo "Categories that will trigger the member only message(use the slugs and seperate multiple category slugs with commas and NO SPACES)";
                break;
            case "loginURL":
                echo "The login URL of your site. ";
                break;
            case "redirect":
                echo "Check the box to redirect the user after they login:";
                break;
            case "message":
                echo "The message to show to not signed in users(you can use HTML). Use [sign_in] for your sign in link.";
                break;
            case "loginText":
                echo "The hyperlinked text that leads to your login page.";
                break;
            case "redirectTitle":
                echo "Check the box to redirect users that visit the post."
                break;
        }
    }
    /* Register settings */
    public function setup_init() {
        register_setting("member_only_fields", "categories");
        add_settings_section("categories", "Member Only Categories: ", array($this, 'section_callback'), "member_only_fields");
        add_settings_field( 'categories', 'Categories: ', array( $this, 'field_callback' ), 'member_only_fields', 'categories', array( 'context' => 'categories') );
        
        register_setting("member_only_fields", "loginURL");
        add_settings_section("loginURL", "Login URL: ", array($this, 'section_callback'), "member_only_fields");
        add_settings_field( 'loginURL', 'Login URL: ', array( $this, 'field_callback' ), 'member_only_fields', 'loginURL',  array( 'context' => 'loginURL'));
        
        register_setting("member_only_fields", "loginText");
        add_settings_section("loginText", "Login Text: ", array($this, 'section_callback'), "member_only_fields");
        add_settings_field( 'loginText', 'Login Text: ', array( $this, 'field_callback' ), 'member_only_fields', 'loginText',  array( 'context' => 'loginText'));
        
        register_setting("member_only_fields", "redirect");
        add_settings_section("redirect", "Redirect User: ", array($this, 'section_callback'), "member_only_fields");
        add_settings_field( 'redirect', 'Redirect User?: ', array( $this, 'field_callback' ), 'member_only_fields', 'redirect',  array( 'context' => 'redirect'));
        
        register_setting("member_only_fields", "message");
        add_settings_section("message", "Message: ", array($this, 'section_callback'), "member_only_fields");
        add_settings_field( 'message', 'Message: ', array( $this, 'field_callback' ), 'member_only_fields', 'message',  array( 'context' => 'message'));
        
        register_setting("member_only_fields", "redirectTitle");
        add_settings_section("redirectTitle", "Redirect Post: ", array($this, 'section_callback'), "member_only_fields");
        add_settings_field( 'redirectTitle', 'Redirect Post?: : ', array( $this, 'field_callback' ), 'member_only_fields', 'redirectTitle',  array( 'context' => 'redirectTitle'));
    }
    /* Create input fields*/
    public function field_callback ( $args ) {
        if ( "categories" === $args[ 'context' ]){
            echo "<textarea name=\"categories\" id=\"categories\" type=\"text\" wrap=\"hard\" rows=\"4\" cols=\"50\">" .get_option("categories", "member-only"). "</textarea>";
        }else if ( "loginURL" === $args['context']){
            echo "<input name=\"loginURL\" id=\"loginURL\" type=\"text\" value=\"" .get_option("loginURL", "/wp-login.php"). "\"\>";
        }else if ( "redirect" === $args['context']){
            $options = get_option( 'redirect' );
            echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirect\" value=\"1\"" . checked( 1, $options['redirect'], false ) . "/>";
        }else if ( "message" === $args['context']) {
            echo "<textarea name=\"message\" id=\"message\" type=\"text\" wrap=\"hard\" rows=\"4\" cols=\"50\">" .get_option("message", "Sorry, this post is for members only.  [sign_in]"). "</textarea>";
        }else if ( "loginText" === $args['context']){
            echo "<input name=\"loginText\" id=\"loginText\" type=\"text\" value=\"" .get_option("loginText", "Sign In/Register."). "\"\>";}else if ("redirectTitle" === $args['context']) {
            echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirectTitle\" value=\"1\"" . checked( 1, $options['redirectTitle'], false ) . "/>";
        }
    }
}
new member_only(); ?>
