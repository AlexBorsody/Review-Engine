<?php
function string_override_menu() {
//add_options_page('Strintg Override Options', 'String Override', 'manage_options', 'string-override-listing', 'string_override_options');
add_menu_page('Strings List', 'String Override', 'manage_options','string-override', 'string_override_action');
add_submenu_page( 'my-top-level-handle', 'Page title', 'Sub-menu title', 'manage_options', 'my-submenu-handle', 'my_magic_function');
}
add_action('admin_menu', 'string_override_menu');