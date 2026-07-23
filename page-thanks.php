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
      <h1>お問い合わせありがとうございます</h1>
      <p>送信いただいた内容は正常に受け付けられました。<br>内容を確認の上、専任スタッフより順次お電話にてご連絡させていただきます。</p>
      <p class="thanks-note">※数日経過しても連絡がない場合は、お手数ですがお電話にてお問い合わせください。</p>
      <a class="thanks-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
    </article>
  </main>
  <footer><p>Copyright © 株式会社HTコネクション All Rights Reserved.</p></footer>
  <?php wp_footer(); ?>
</body>
</html>
