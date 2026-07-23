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
 * Return content and official support link for each electricity area LP.
 *
 * @param string $slug Area slug.
 * @return array
 */
function electricity_restart_area_data( $slug ) {
	$areas = array(
		'tokyo' => array(
			'name' => '東京電力エリア',
			'description' => '東京都、神奈川県、埼玉県、千葉県、栃木県、群馬県、茨城県、山梨県、静岡県（富士川以東）エリアにて電気のご案内をさせていただいております',
			'areas' => array( '東京都', '神奈川県', '埼玉県', '千葉県', '茨城県', '栃木県', '群馬県', '山梨県', '静岡県（富士川以東）' ),
			'faq' => '東京電力エリアは、東京都、神奈川県、埼玉県、千葉県、栃木県、群馬県、茨城県、山梨県、静岡県（富士川以東）になります。',
			'support' => 'https://www.tepco.co.jp/ep/support/index-j.html',
		),
		'hokkaido' => array(
			'name' => '北海道電力エリア', 'description' => '北海道エリアにて電気のご案内をさせていただいております',
			'areas' => array( '北海道' ), 'faq' => '北海道電力エリアは、北海道のみになります。',
			'support' => 'https://www.hepco.co.jp/home/move/move01.html',
		),
		'tohoku' => array(
			'name' => '東北電力エリア', 'description' => '青森県、岩手県、宮城県、秋田県、山形県、福島県、新潟県エリアにて電気のご案内をさせていただいております',
			'areas' => array( '青森県', '秋田県', '新潟県', '岩手県', '山形県', '宮城県', '福島県' ), 'faq' => '東北電力エリアは、青森県、岩手県、宮城県、秋田県、山形県、福島県、新潟県になります。',
			'support' => 'https://www.tohoku-epco.co.jp/dprivate/inquery/call/',
		),
		'hokuriku' => array(
			'name' => '北陸電力エリア', 'description' => '富山県、石川県、福井県嶺北地方および敦賀市、岐阜県飛騨市（旧神岡町全域、旧宮川村の一部のみ）および郡上市（旧白鳥町石徹白地区のみ）エリアにて電気のご案内をさせていただいております',
			'areas' => array( '富山県', '石川県', '福井県嶺北地方および敦賀市', '岐阜県飛騨市（旧神岡町全域、旧宮川村の一部のみ）および郡上市（旧白鳥町石徹白地区のみ）' ), 'faq' => '北陸電力エリアは、富山県、石川県、福井県嶺北地方および敦賀市、岐阜県飛騨市（旧神岡町全域、旧宮川村の一部のみ）および郡上市（旧白鳥町石徹白地区のみ）になります。',
			'support' => 'https://www.rikuden.co.jp/tetsuzuki/',
		),
		'chubu' => array(
			'name' => '中部電力エリア', 'description' => '長野県、愛知県、岐阜県（飛騨市、郡上市、関ケ原町を除く）、三重県（熊野市の飛鳥町、有馬町、育生町、五郷町、井戸町、金山町、神川町、木本町、紀和町、久生屋町以南の地区を除く）、静岡県の富士川以西エリアにて電気のご案内をさせていただいております',
			'areas' => array( '愛知県', '長野県', '岐阜県（飛騨市、郡上市、関ケ原町を除く）', '静岡県の富士川以西', '三重県（熊野市の飛鳥町、有馬町、育生町、五郷町、井戸町、金山町、神川町、木本町、紀和町、久生屋町以南の地区を除く）' ), 'faq' => '中部電力エリアは、長野県、愛知県、岐阜県（飛騨市、郡上市、関ケ原町を除く）、三重県（熊野市の飛鳥町、有馬町、育生町、五郷町、井戸町、金山町、神川町、木本町、紀和町、久生屋町以南の地区を除く）、静岡県の富士川以西になります。',
			'support' => 'https://miraiz.chuden.co.jp/home/procedures/',
		),
		'kansai' => array(
			'name' => '関西電力エリア', 'description' => '京都府、大阪府、滋賀県、兵庫県（赤穂市福浦を除く）、奈良県、和歌山県、福井県（三方郡美浜町以西）、三重県（新鹿町、磯崎町、大泊町、須野町、二木島里町、二木島町、波田須町、甫母町、遊木町を除く熊野市以南）、岐阜県不破郡関ケ原町の一部エリアにて電気のご案内をさせていただいております',
			'areas' => array( '京都府', '奈良県', '福井県（三方郡美浜町以西）', '大阪府', '和歌山県', '岐阜県不破郡関ケ原町の一部', '滋賀県', '兵庫県（赤穂市福浦を除く）', '三重県（新鹿町、磯崎町、大泊町、須野町、二木島里町、二木島町、波田須町、甫母町、遊木町を除く熊野市以南）' ), 'faq' => '関西電力エリアは、京都府、大阪府、滋賀県、兵庫県（赤穂市福浦を除く）、奈良県、和歌山県、福井県（三方郡美浜町以西）、三重県（新鹿町、磯崎町、大泊町、須野町、二木島里町、二木島町、波田須町、甫母町、遊木町を除く熊野市以南）、岐阜県不破郡関ケ原町の一部になります。',
			'support' => 'https://kepco.jp/faq/otoiawase/#tel',
		),
		'chugoku' => array(
			'name' => '中国電力エリア', 'description' => '広島県、山口県、島根県、鳥取県、岡山県、兵庫県赤穂市（福浦）、香川県小豆郡、香川郡直島町、愛媛県越智郡上島町、今治市（伯方町・上浦町・大三島町・宮窪町（四阪島を除く）・吉海町・関前）エリアにて電気のご案内をさせていただいております',
			'areas' => array( '広島県', '鳥取県', '山口県', '岡山県', '島根県', '兵庫県赤穂市（福浦）', '香川県小豆郡、香川郡直島町', '愛媛県越智郡上島町、今治市（伯方町・上浦町・大三島町・宮窪町（四阪島を除く）・吉海町・関前）' ), 'faq' => '中国電力エリアは、広島県、山口県、島根県、鳥取県、岡山県、兵庫県赤穂市（福浦）、香川県小豆郡、香川郡直島町、愛媛県越智郡上島町、今治市（伯方町・上浦町・大三島町・宮窪町（四阪島を除く）・吉海町・関前）になります。',
			'support' => 'https://www.energia.co.jp/office/add-sales.html',
		),
		'shikoku' => array(
			'name' => '四国電力エリア', 'description' => '香川県（小豆郡、香川郡直島町を除く）、徳島県、愛媛県（新居浜市別子山、越智郡上島町、今治市の伯方町・上浦町・大三島町・宮窪町・吉海町・関前を除く）、高知県エリアにて電気のご案内をさせていただいております',
			'areas' => array( '高知県', '徳島県', '香川県（小豆郡、香川郡直島町を除く）', '愛媛県（新居浜市別子山、越智郡上島町、今治市の伯方町・上浦町・大三島町・宮窪町・吉海町・関前を除く）' ), 'faq' => '四国電力エリアは、香川県（小豆郡、香川郡直島町を除く）、徳島県、愛媛県（新居浜市別子山、越智郡上島町、今治市の伯方町・上浦町・大三島町・宮窪町・吉海町・関前を除く）、高知県になります。',
			'support' => 'https://www.yonden.co.jp/faq/tel.html',
		),
		'kyushu' => array(
			'name' => '九州電力エリア', 'description' => '福岡県、長崎県、大分県、佐賀県、宮崎県、熊本県、鹿児島県エリアにて電気のご案内をさせていただいております',
			'areas' => array( '福岡県', '佐賀県', '鹿児島県', '長崎県', '宮崎県', '大分県', '熊本県' ), 'faq' => '九州電力エリアは、福岡県、長崎県、大分県、佐賀県、宮崎県、熊本県、鹿児島県になります。',
			'support' => 'https://customer.kyuden.co.jp/ja/moving/process.html',
		),
	);

	return isset( $areas[ $slug ] ) ? $areas[ $slug ] : $areas['tokyo'];
}

/**
 * Create the required fixed pages and assign their templates on activation.
 */
function electricity_restart_create_required_pages() {
	$pages = array(
		'company' => array( 'title' => '会社概要', 'template' => 'page-company.php' ),
		'privacy' => array( 'title' => 'プライバシーポリシー', 'template' => 'page-privacy.php' ),
		'thanks'  => array( 'title' => 'お問い合わせ完了', 'template' => 'page-thanks.php' ),
		'hokkaido' => array( 'title' => '北海道電力エリア', 'template' => 'page-area.php' ),
		'tohoku'   => array( 'title' => '東北電力エリア', 'template' => 'page-area.php' ),
		'hokuriku' => array( 'title' => '北陸電力エリア', 'template' => 'page-area.php' ),
		'chubu'    => array( 'title' => '中部電力エリア', 'template' => 'page-area.php' ),
		'kansai'   => array( 'title' => '関西電力エリア', 'template' => 'page-area.php' ),
		'chugoku'  => array( 'title' => '中国電力エリア', 'template' => 'page-area.php' ),
		'shikoku'  => array( 'title' => '四国電力エリア', 'template' => 'page-area.php' ),
		'kyushu'   => array( 'title' => '九州電力エリア', 'template' => 'page-area.php' ),
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

/**
 * Create newly added area pages once when an existing installation updates.
 */
function electricity_restart_maybe_create_area_pages() {
	$pages_version = '2.1.0';

	if ( get_option( 'electricity_restart_pages_version' ) === $pages_version ) {
		return;
	}

	electricity_restart_create_required_pages();
	update_option( 'electricity_restart_pages_version', $pages_version );
}
add_action( 'init', 'electricity_restart_maybe_create_area_pages' );

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
	$email          = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$postal         = isset( $_POST['postal'] ) ? sanitize_text_field( wp_unslash( $_POST['postal'] ) ) : '';
	$address        = isset( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';
	$building       = isset( $_POST['building'] ) ? sanitize_text_field( wp_unslash( $_POST['building'] ) ) : '';
	$room           = isset( $_POST['room'] ) ? sanitize_text_field( wp_unslash( $_POST['room'] ) ) : '';
	$privacy_agreed = isset( $_POST['privacy_agreed'] ) ? sanitize_text_field( wp_unslash( $_POST['privacy_agreed'] ) ) : '';
	$tel_digits     = preg_replace( '/\D+/', '', $tel );
	$allowed_situations = array( '電気（再開）', '電気（新規・引越し）', '電気・ガス' );

	if (
		! in_array( $situation, $allowed_situations, true ) ||
		'' === $name ||
		'' === $name_kana ||
		! preg_match( '/^[0-9]{10,11}$/', $tel_digits ) ||
		( '' !== $email && ! is_email( $email ) ) ||
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
			'希望サービス：' . $situation,
			'お名前：' . $name,
			'ふりがな：' . $name_kana,
			'電話番号：' . $tel,
			'メールアドレス：' . ( $email ?: '未入力' ),
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

	if ( $email ) {
		$customer_subject = '【電気サポート窓口】お問い合わせを受け付けました';
		$customer_body    = implode(
			"\n",
			array(
				$name . ' 様',
				'',
				'お問い合わせありがとうございます。',
				'送信いただいた内容は正常に受け付けられました。',
				'内容を確認の上、専任スタッフより順次お電話にてご連絡させていただきます。',
				'',
				'※数日経過しても連絡がない場合は、お手数ですがお電話にてお問い合わせください。',
				'',
				'電気サポート窓口',
				'電話番号：0120-186-556',
				'受付時間：10:00-19:00',
			)
		);

		wp_mail( $email, $customer_subject, $customer_body, $headers );
	}

	wp_safe_redirect( electricity_restart_page_url( 'thanks' ) );
	exit;
}
add_action( 'admin_post_electricity_restart_submit', 'electricity_restart_handle_form' );
add_action( 'admin_post_nopriv_electricity_restart_submit', 'electricity_restart_handle_form' );
