<?php 
/* 
Template Name: Blog Homepage 
*/ 
?>

<?php get_header(); ?>

<div class="main" id="blog">

	<h1>UniQ Blog</h1>
	
	<div id="posts">  
		<?php query_posts('showposts=5'); ?>
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

			<div class="post-preview embellish-section">

    			<?php get_template_part( 'embellish' ); ?>
	
				<?php if ( has_post_thumbnail($thumbnail->ID)) {
				   echo '<a class="post-preview-image" href="' . get_permalink( $thumbnail->ID ) . '" title="' . esc_attr( $thumbnail->post_title ) . '">';
				   echo get_the_post_thumbnail($thumbnail->ID, 'original');
				   echo '</a>';
				 }?>
	
				<div class="post-excerpt">
					<?php the_excerpt(); ?>
				</div>
				
				<div class="post-meta">
					<span class="author">Posted by <?php the_author(); ?></span>
					<span class="date"><?php the_time(__('d/m/Y', 'blank')); ?></span>
					<span class="categories"><?php _e('Catagories:', 'blank'); ?> <?php the_category('&nbsp; '); ?></span>
				</div>
		
			</div><!--/post-preview-->
			
		<?php endwhile; ?>
	
		<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
	
		<?php else : ?>
	
		<h3>No posts to display</h3>
	
		<?php endif; ?>   
	</div><!--/posts-->

</div> <!--/blog-->

<?php get_sidebar(); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>
