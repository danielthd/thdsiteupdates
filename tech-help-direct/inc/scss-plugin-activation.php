<?php
/**
 * WP-SCSS customizations
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

// Always recompile in the Customizer or in dev/test environment
$dev_env = defined( 'WP_ENV' ) && WP_ENV === 'test';
if ( ( $dev_env || is_customize_preview() ) && ! defined( 'WP_SCSS_ALWAYS_RECOMPILE' ) ) {
  define( 'WP_SCSS_ALWAYS_RECOMPILE', true );
}

// Reset WP-SCSS options, if a user tries to modify them via WP-SCSS settings page
add_action( 'current_screen', 'pwa_reset_wpscss_options' );
function pwa_reset_wpscss_options() {
  $current_screen = get_current_screen();
  if ( $current_screen->id === 'settings_page_wpscss_options' ) {
    // Check if DEV
    $dev_env = defined( 'WP_ENV' ) && WP_ENV === 'test';
    // Get WP-SCSS options
    $wpscss_options = get_option( 'wpscss_options' );

    // SCSS Location
    $wpscss_options['scss_dir'] = '/scss/';
    // CSS Location
    $wpscss_options['css_dir'] = '/css/';
    // Compiling Mode
    $wpscss_options['compiling_options'] = 'Leafo\ScssPhp\Formatter\\' . ( $dev_env ? 'Expanded' : 'Crunched' );
    // Source Map Mode
    $wpscss_options['sourcemap_options'] = 'SOURCE_MAP_FILE';
    // Error Display
    $wpscss_options['errors'] = 'hide';
    // Enqueue Stylesheets
    $wpscss_options['enqueue'] = 0;

    // Update WP-SCSS options
    update_option( 'wpscss_options', $wpscss_options );
  }
}

// Setup SCSS variables
add_filter( 'wp_scss_variables', 'pwa_set_wp_scss_variables' );
function pwa_set_wp_scss_variables() {
  // Create array of default CSS vars
  $default_css_vars = array(
//    'accent_color'                                => '#0071bc',
  );

  // Retrieve all theme modification values for the current theme
  $mods = get_theme_mods();
  if ( ! $mods ) {
    return;
  }

  // Prepare the array
  $variables = array();

  // Loop through each default setting and setup CSS variables to values from Customizer or set defaults
  foreach( $default_css_vars as $setting => $default_value ) {
    $variables[ $setting ] = array_key_exists( $setting, $mods ) ? $mods[ $setting ] : $default_value;
  }
  return $variables;
}
