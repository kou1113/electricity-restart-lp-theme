<?php
/**
 * Template Name: 会社概要
 * Template Post Type: page
 *
 * @package Electricity_Restart_LP
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="株式会社HTコネクションの会社概要です。">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'subpage' ); ?>>
  <?php wp_body_open(); ?>
  <header class="subpage-header"><div class="container header-inner">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="電気サポート窓口 トップへ"><img class="brand-mark" src="<?php echo esc_url( get_theme_file_uri( '/images/electricity-support-logo.svg' ) ); ?>" alt=""><span class="brand-copy"><b><em>電気</em><strong>サポート窓口</strong></b><small>ELECTRICITY SUPPORT DESK</small></span></a>
    <a class="back-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
  </div></header>
  <main class="document-main"><article class="container narrow document-card">
    <h1>会社概要</h1>
    <table><tbody>
      <tr><th scope="row">会社名</th><td>株式会社HTコネクション</td></tr>
      <tr><th scope="row">所在地</th><td>〒150-0031<br>東京都渋谷区桜丘町15-14 フジビル40 7階2</td></tr>
      <tr><th scope="row">支社<br>（コールセンター）</th><td>〒150-0013<br>東京都渋谷区恵比寿1-5-9 SG恵比寿ビル 5F</td></tr>
      <tr><th scope="row">代表取締役</th><td>佐々木 優士</td></tr>
      <tr><th scope="row">代理店届出番号</th><td>C2602924</td></tr>
      <tr><th scope="row">営業時間</th><td>10:00～19:00</td></tr>
      <tr><th scope="row">定休日</th><td>日曜日・祝日・年末年始</td></tr>
      <tr><th scope="row">お問い合わせ</th><td><a href="mailto:info@hikari-hikkoshi-navi.jp">info@hikari-hikkoshi-navi.jp</a></td></tr>
      <tr><th scope="row">事業内容</th><td>情報通信サービス、インターネット回線取次事業、他</td></tr>
    </tbody></table>
  </article></main>
  <footer><p>Copyright © 株式会社HTコネクション All Rights Reserved.</p></footer>
  <?php wp_footer(); ?>
</body>
</html>
