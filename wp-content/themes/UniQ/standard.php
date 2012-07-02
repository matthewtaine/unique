<?php
/*
Template Name: Standard Page
*/
?>

<?php get_header(); ?>


	<div class="standard-page">	

		<h1><?php the_title(); ?></h1>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="embellish-section">
    			<?php get_template_part( 'embellish' ); ?>
			<?php the_content(); ?>
		</div>

		<?php endwhile; endif; ?>
	</div>

	</div> <!--end page-wrap-->

<?php get_footer(); ?>