<?php
/**
 * Plugin Name: No Black Friday for WordPress
 * Description: Shows a bar at the top of your site in November, to tell visitors you don't do Black Friday deals, because your price is always the best deal.
 * Version: 1.0.3
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Author: Daan from Daan.dev
 * Author URI: https://daan.dev
 * Update URI: Dan0sz/wp-no-black-friday
 * GitHub Plugin URI: Dan0sz/wp-no-black-friday
 * Primary Branch: master
 * License: MIT
 * Text Domain: wp-no-black-friday
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'NO_BLACK_FRIDAY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once NO_BLACK_FRIDAY_PLUGIN_DIR . 'src/Bar.php';

add_action( 'plugins_loaded', function () {
	new \Daan\NoBlackFriday\Bar();
} );

add_action( 'init', function () {
	load_plugin_textdomain( 'wp-no-black-friday', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}, 1 );
