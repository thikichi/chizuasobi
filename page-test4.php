<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no,address=no,email=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="<?php bloginfo('rss2_url'); ?>" rel="alternate" type="application/rss+xml" title="RSSフィード">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>







<?php wp_footer(); ?>
</body>
</html>