<?php
/**
 * Theme setup, assets, required pages, and secure form processing.
 *
 * @package Electricity_Restart_LP
 */

defined( 'ABSPATH' ) || exit;

function electricity_restart_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'electricity_restart_theme_setup' );

function electricity_restart_enqueue_assets() {
	$style_path  = get_theme_file_path( '/style.css' );
	$script_path = get_theme_file_path( '/script.js' );

	wp_enqueue_style(
		'electricity-restart-style',
		get_stylesheet_uri(),
		array(),
		file_exists( $style_path ) ? (string) filemtime( $style_path ) : '1.0.0'
	);

	wp_enqueue_script(
		'electricity-restart-script',
		get_theme_file_uri( '/script.js' ),
		array(),
		file_exists( $script_path ) ? (string) filemtime( $script_path ) : '1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'electricity_restart_enqueue_assets' );

/**
 * Return a fixed-page permalink with a slug fallback.
 *
 * @param string $slug Page slug.
 * @return string
 */
function electricity_restart_page_url( $slug ) {
	$page = get_page_by_path( sanitize_title( $slug ), OBJECT, 'page' );

	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * Create the required fixed pages and assign their templates on activation.
 */
function electricity_restart_create_required_pages() {
	$pages = array(
		'company' => array( 'title' => '会社概要', 'template' => 'page-company.php' ),
		'privacy' => array( 'title' => 'プライバシーポリシー', 'template' => 'page-privacy.php' ),
		'thanks'  => array( 'title' => 'お問い合わせ完了', 'template' => 'page-thanks.php' ),
	);

	foreach ( $pages as $slug => $page_data ) {
		$page    = get_page_by_path( $slug, OBJECT, 'page' );
		$page_id = $page instanceof WP_Post ? $page->ID : wp_insert_post(
			array(
				'post_title'  => $page_data['title'],
				'post_name'   => $slug,
				'post_status' => 'publish',
				'post_type'   => 'page',
			)
		);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
		}
	}

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'electricity_restart_create_required_pages' );

function electricity_restart_error_redirect() {
	wp_safe_redirect( add_query_arg( 'contact_error', '1', home_url( '/' ) ) . '#form' );
	exit;
}

/**
 * Handle submissions from both logged-in and logged-out visitors.
 */
function electricity_restart_handle_form() {
	if (
		! isset( $_POST['electricity_restart_nonce'] ) ||
		! wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['electricity_restart_nonce'] ) ),
			'electricity_restart_submit'
		)
	) {
		electricity_restart_error_redirect();
	}

	if ( ! empty( $_POST['website'] ) ) {
		electricity_restart_error_redirect();
	}

	$situation      = isset( $_POST['situation'] ) ? sanitize_text_field( wp_unslash( $_POST['situation'] ) ) : '';
	$name           = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$name_kana      = isset( $_POST['name_kana'] ) ? sanitize_text_field( wp_unslash( $_POST['name_kana'] ) ) : '';
	$tel            = isset( $_POST['tel'] ) ? sanitize_text_field( wp_unslash( $_POST['tel'] ) ) : '';
	$postal         = isset( $_POST['postal'] ) ? sanitize_text_field( wp_unslash( $_POST['postal'] ) ) : '';
	$address        = isset( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';
	$building       = isset( $_POST['building'] ) ? sanitize_text_field( wp_unslash( $_POST['building'] ) ) : '';
	$room           = isset( $_POST['room'] ) ? sanitize_text_field( wp_unslash( $_POST['room'] ) ) : '';
	$privacy_agreed = isset( $_POST['privacy_agreed'] ) ? sanitize_text_field( wp_unslash( $_POST['privacy_agreed'] ) ) : '';
	$tel_digits     = preg_replace( '/\D+/', '', $tel );
	$allowed_situations = array( '解約された', '新居先で電気を使いたい' );

	if (
		! in_array( $situation, $allowed_situations, true ) ||
		'' === $name ||
		'' === $name_kana ||
		! preg_match( '/^[0-9]{10,11}$/', $tel_digits ) ||
		'1' !== $privacy_agreed
	) {
		electricity_restart_error_redirect();
	}

	$subject = '【電気サポート窓口】Webから新しい相談がありました';
	$body    = implode(
		"\n",
		array(
			'電気サポート窓口LPから新しい相談がありました。',
			'',
			'現在の状況：' . $situation,
			'お名前：' . $name,
			'ふりがな：' . $name_kana,
			'電話番号：' . $tel,
			'郵便番号：' . ( $postal ?: '未入力' ),
			'住所：' . ( $address ?: '未入力' ),
			'マンション・建物名：' . ( $building ?: '未入力' ),
			'号室：' . ( $room ?: '未入力' ),
			'',
			'送信日時：' . wp_date( 'Y-m-d H:i:s' ),
		)
	);

	$recipient = apply_filters(
		'electricity_restart_form_recipient',
		array(
			'sakai_tatunori@appdate-hd.co.jp',
		)
	);
	$headers   = array( 'Content-Type: text/plain; charset=UTF-8' );

	if ( ! wp_mail( $recipient, $subject, $body, $headers ) ) {
		electricity_restart_error_redirect();
	}

	wp_safe_redirect( electricity_restart_page_url( 'thanks' ) );
	exit;
}
add_action( 'admin_post_electricity_restart_submit', 'electricity_restart_handle_form' );
add_action( 'admin_post_nopriv_electricity_restart_submit', 'electricity_restart_handle_form' );
