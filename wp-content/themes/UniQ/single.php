<?php get_header(); ?>

<div class="main" id="single">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<h2><?php the_title(); ?></h2>

		<div class="post embellish-section" id="post-<?php the_ID(); ?>">
			
			<?php get_template_part( 'embellish' ); ?>	

			<div class="entry">
				
				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
				
				<?php the_tags( 'Tags: ', ', ', ''); ?>

			</div>

			<div class="post-meta">
				<span class="author">Posted by <?php the_author(); ?></span>
				<span class="date"><?php the_time(__('d/m/Y', 'blank')); ?></span>
				<span class="categories"><?php _e('Catagories:', 'blank'); ?> <?php the_category('&nbsp; '); ?></span>

				<?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'comments-link', ''); ?> 
				<?php edit_post_link('Edit post','<p>','</p>'); ?>
			</div>

		</div>

		<div id="post-navigation">
			<span id="previous"><?php previous_post('%','Previous Post', 'no'); ?></span>
			<span id="next"><?php next_post('%','Next Post', 'no'); ?></span>
		</div>

		<div id="comment-section">
			<?php comments_template(); ?>
		</div>

	<?php endwhile; endif; ?>

</div> <!--/single-->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>