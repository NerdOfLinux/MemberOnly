<?php
  function __construct() {
    // Hook into the admin menu
    add_action( 'admin_menu', array( $variables, 'settings_page' ) );
  }
  function settings_page() {
    //Create the menu item and page
    $page_title = "Member Only Content Settings Page";
    $menu_title = "Member Only Content";
    $capability = "manage_options";
    $slug = "member_only";
    $callback = array( $variables, 'settings_page_content' );
    $icon = 'dashicons-admin-plugins';
    $position = 100;
  }
  /* Create the page*/
  function settings_page_content() {
    echo "Test of settings page."; 
  }
?>
