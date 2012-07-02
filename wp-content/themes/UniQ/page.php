<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div class="post embellish-section" id="post-<?php the_ID(); ?>">
			
			<?php get_template_part( 'embellish' ); ?>	

			<div class="entry">

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

			</div>

			<?php edit_post_link('Edit this page.', '<p>', '</p>'); ?>

		</div>

		<?php endwhile; endif; ?>

<?php get_footer(); ?>