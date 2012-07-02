<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<link rel="shortcut icon" href="/favicon.ico">	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<div id="page-wrap">

		<div id="header"></div>

			<ul id="header-nav">
				<li><a href="/" title="" id="">Home</a></li>
				<li><a href="/events" title="" id="">UniQ Events</a></li>
				<li><a href="/blog" title="" id="">The Blog</a></li>
				<li><a href="/the-girls-group" title="" id="">The Girls Group</a></li>
				<li><a href="/gender-club-society" title="" id="">The Gender Club Society</a></li>
				<li><a href="/queer-officer" title="" id="">VUWSA Queer Officer</a></li>
				<li><a href="/contact" title="" id="">Contact</a></li>
			</ul>
			
			<div id="header-nav">
				<!--<? wp_nav_menu(array('menu' => 'Header Nav Menu' )); ?>-->
			</div>
