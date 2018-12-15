<?php
/**
 * Custom child theme functions
 * 
 * @author    Alex Kladov
 * @company   Tech Help Direct
 * @copyright Copyright © 2018 Tech Help Direct
 * @version   1.0.0
 * @link      https://techhelpdirect.com.au/
 */

// Prevent file from being accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  die();
}

define( 'PWA_CLIENT_NAME', 'Tech Help Direct' );
define( 'PWA_CLIENT_DOMAIN', 'tech_help_direct' );
define( 'PARENT_THEME_DIR', get_template_directory() );
define( 'PARENT_THEME_DIR_URI', get_template_directory_uri() );
define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'CHILD_THEME_DIR_URI', get_stylesheet_directory_uri() );
define( 'CHILD_THEME_INCLUDES_DIR', CHILD_THEME_DIR . '/inc' );

// Add front-end CSS & JS with ?ver=FILE_MTIME timestamp
add_action( 'wp_enqueue_scripts', 'pwa_enqueue_child_styles_and_scripts' );
function pwa_enqueue_child_styles_and_scripts() {
  // CSS
  $parent_style = 'bridge-style';
  wp_enqueue_style( $parent_style, PARENT_THEME_DIR_URI . '/css/stylesheet.min.css', array(), filemtime( PARENT_THEME_DIR . '/style.css' ), false);
  wp_enqueue_style( PWA_CLIENT_DOMAIN . '-style', CHILD_THEME_DIR_URI . '/css/style.css', array( $parent_style ), filemtime( CHILD_THEME_DIR . '/css/style.css' ), false);

  // JS
//  wp_enqueue_script( PWA_CLIENT_DOMAIN . '-js', CHILD_THEME_DIR_URI . '/js/custom.js', array( 'jquery' ), filemtime( CHILD_THEME_DIR . '/js/custom.js' ), false);
}

// Required Plugins
require_once( CHILD_THEME_INCLUDES_DIR . '/tgm-plugin-activation.php' );

// SCSS Complier
require_once( CHILD_THEME_INCLUDES_DIR . '/scss-plugin-activation.php' );
