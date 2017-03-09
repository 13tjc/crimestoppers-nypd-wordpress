<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Hook &amp; Loop">
  <meta name="description" content="Crime Stoppers TK">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/crimestoppers.css">

  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/icon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/img/icon/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/icon/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/img/icon/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/img/icon/apple-touch-icon-152x152.png" />

  <?php wp_head(); ?>

  <!--[if lte IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/lib/placeholder.js"></script>
  <![endif]-->

  <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/crimestoppers-ie.css" />
    <script src="<?php echo get_template_directory_uri(); ?>/js/lib/respond.js"></script>
  <![endif]-->

  <title>NYPD Crime Stoppers</title>

</head>
<body>
  <div class="page">
    <div class="page__container">
      <header class="header" role="banner">
        <a class="skip-to-main" href="#main">Skip to main content</a>
        <div class="header__primary">
          <div class="header__primary__container">
            <a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">Crime Stoppers</a>
            <div class="header__contact">
              <p><a href="tel:1-800-577-8477">1-800-577-TIPS</a></p>
              <span>Call Now: 1-800-577-8477</span>
            </div>
            <button class="nav-toggle nav-toggle--open" id="open-nav" type="button"><span></span><span></span><span></span>Open navigation</button>
          </div>
        </div>
        <div class="header__secondary">
          <div class="header__secondary__container">
            <p class="header__secondary__contact">
              <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
            </p>
            <button class="nav-toggle nav-toggle--close" id="close-nav" type="button"><span></span><span></span><span></span>Close navigation</button>
            <nav class="nav" id="nav" role="navigation">
              <ul class="nav__list">
                <li class="nav__item">
                  <a class="nav__item__link" href="<?php echo esc_url( home_url( '/cases' ) ); ?>">Wanted</a>
                </li>
                <li class="nav__item">
                  <a class="nav__item__link" href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">About</a>
                </li>
                <li class="nav__item">
                  <a class="nav__item__link" data-modal="tip-modal" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>">Submit A Tip</a>
                </li>
              </ul>
            </nav>
            <?php get_search_form(); ?>
          </div>
        </div>
      </header>