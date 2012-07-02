<?php
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}

	// Load jQuery Tweet
  	wp_register_script('tweet', get_bloginfo('template_directory') . "/js/jquery.tweet.js");
   	wp_enqueue_script('tweet');

   	// Load jQuery Tumblr
  	wp_register_script('tumblr', get_bloginfo('template_directory') . "/js/jquery.tumblr.js");
   	wp_enqueue_script('tumblr');
	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
	add_theme_support( 'post-thumbnails' );
   
   	if (function_exists('register_nav_menus')) {
	register_nav_menus(
		array(
			'main_nav' => 'Main navigation Menu'
	   	));
	}
	
	// Comment Template
   function mytheme_comment($comment, $args, $depth) {
	  $GLOBALS['comment'] = $comment; ?>
	  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		 <div id="comment-<?php comment_ID(); ?>">
			
			<div class="comment-body">
			   <?php comment_text(); ?>
			</div>
	  
			<div class="comment-meta">
			   <span class="comment-author"><?php printf(get_comment_author()); ?></span>
			   <span class="comment-date"><?php printf(get_comment_date('d/m/Y')); ?></span>
			   <span class="comment-edit-link"><?php edit_comment_link(__('Edit'),'  ','') ?></span>
			   <?php if ($comment->comment_approved == '0') : ?>
				  <em><?php _e('Your comment is awaiting moderation.') ?></em>
			   <?php endif; ?>
			</div>
 
		 </div>
   <?php
	}
	
	// Puts link in excerpts more tag
   function new_excerpt_more($more) {
		 global $post;
	  return ' ... <a class="moretag" href="'. get_permalink($post->ID) . '"> Read More</a>';
   }
   add_filter('excerpt_more', 'new_excerpt_more');
   
   function new_excerpt_length( $length ) {
	  return 50;
   }
   add_filter( 'excerpt_length', 'new_excerpt_length' );




   // Custom Post Type for Location Posts
   add_action( 'init', 'register_cpt_projects' );
   
   function register_cpt_projects() {
   
	   $labels = array( 
		   'name' => _x( 'Projects', 'projects' ),
		   'singular_name' => _x( 'Projects', 'projects' ),
		   'add_new' => _x( 'Add New', 'projects' ),
		   'add_new_item' => _x( 'Add New Project', 'projects' ),
		   'edit_item' => _x( 'Edit Project', 'projects' ),
		   'new_item' => _x( 'New Project', 'projects' ),
		   'view_item' => _x( 'View Project', 'projects' ),
		   'search_items' => _x( 'Search Project', 'projects' ),
		   'not_found' => _x( 'No project found', 'projects' ),
		   'not_found_in_trash' => _x( 'No project found in Trash', 'projects' ),
		   'parent_item_colon' => _x( 'Parent Project:', 'projects' ),
		   'menu_name' => _x( 'Projects', 'projects' ),
	   );
   
	   $args = array( 
		   'labels' => $labels,
		   'hierarchical' => false,	   
		   'supports' => array( 'title', 'editor', 'thumbnail' ),
		   'taxonomies' => array( 'post_tag' ),
		   'public' => true,
		   'show_ui' => true,
		   'show_in_menu' => true,
		   'menu_position' => 5,		   
		   'show_in_nav_menus' => true,
		   'publicly_queryable' => true,
		   'exclude_from_search' => true,
		   'has_archive' => false,
		   'query_var' => true,
		   'can_export' => false,
		   'rewrite' => true,
		   'capability_type' => 'post',
	   );
   
	   register_post_type( 'projects', $args );
   }

	// Wigetize!
	if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'Home Sidebar Widgets',
		'id'   => 'home-sidebar-widgets',
		'description'   => 'Home page widget area.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

	register_sidebar(array(
		'name' => 'Blog Sidebar Widgets',
		'id'   => 'blog-sidebar-widgets',
		'description'   => 'Blog home widget area.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

?>