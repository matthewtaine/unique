<?php
/*
Template Name: Events Page
*/
?>

<?php get_header(); ?>


	<div id="events">	

		<h1><?php the_title(); ?></h1>

		<?php echo do_shortcode('[events_show]'); ?>

	</div> <!--end events-->

<?php get_footer(); ?>