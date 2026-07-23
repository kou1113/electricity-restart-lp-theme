<?php
/**
 * Template Name: 電力エリアLP
 * Template Post Type: page
 *
 * @package Electricity_Restart_LP
 */

defined( 'ABSPATH' ) || exit;

$electricity_restart_area_slug = (string) get_post_field( 'post_name', get_queried_object_id() );

require get_theme_file_path( '/index.php' );
