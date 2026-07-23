<?php
/**
 * Template Name: お問い合わせ完了
 * Template Post Type: page
 *
 * @package Electricity_Restart_LP
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,follow">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'subpage' ); ?>>
  <?php wp_body_open(); ?>
  <header class="subpage-header"><div class="container header-inner">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="電気サポート窓口 トップへ"><img class="brand-mark" src="<?php echo esc_url( get_theme_file_uri( '/images/electricity-support-logo.svg' ) ); ?>" alt=""><span class="brand-copy"><b><em>電気</em><strong>サポート窓口</strong></b><small>ELECTRICITY SUPPORT DESK</small></span></a>
    <a class="back-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
  </div></header>
  <main class="document-main thanks-main">
    <article class="container narrow document-card thanks-card">
      <span class="thanks-icon" aria-hidden="true">✓</span>
      <h1>お問い合わせを受け付けました</h1>
      <p>送信いただきありがとうございます。内容を確認後、担当スタッフよりお電話でご連絡します。</p>
      <p class="thanks-note">営業時間外に送信された場合は、翌営業日以降のご連絡となる場合があります。</p>
      <a class="thanks-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
    </article>
  </main>
  <footer><p>Copyright © 株式会社HTコネクション All Rights Reserved.</p></footer>
  <?php wp_footer(); ?>
</body>
</html>
