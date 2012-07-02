<?php get_header(); ?>

<div class="main" id="home">

    <h1>Welcome to UniQ Victoria !</h1>

    <div class="embellish-section">

        <?php get_template_part( 'embellish' ); ?>

    	<?php if (function_exists('iinclude_page')) ?>
    		<div class="home-section" id="welcome">
    			<?php echo iinclude_page('welcome'); ?>
    		</div>
    		<div class="home-section" id="team">
    			<?php echo iinclude_page('the-team'); ?>
    		</div>
    		<div class="home-section" id="mascot">
    			<?php echo iinclude_page('our-mascot'); ?>
    		</div>
    		<div class="home-section" id="constitution">
    			<?php echo iinclude_page('constitution'); ?>
    		</div>		
    	<?php end ?>

    </div> <!--/embellish-section-->

</div> <!--/main-->

    <div class="sidebar" id="social-sidebar">

        <!--Blog Feed-->
        <div id="blog" class="social-section">
            <a href="/blog" class="social-icon-link">blog</a>
            <h4>Blog</h4>
                <?php $args = array( 'numberposts' => 4 ); $lastposts = get_posts( $args ); foreach($lastposts as $post) : setup_postdata($post); ?>
                    <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="date"><?php echo get_the_date('d/m/Y'); ?></span></p>
                <?php endforeach; ?>
            <a class="social-follow-link" href="/blog">read our blog</a>
            <span class="social-follow-link"><a href="/blog">read our blog</a></span>
        </div>

        <!--Twitter Feed-->
        <div id="twitter" class="social-section">
            <a href="http://twitter.com/uniqvictoria" class="social-icon-link">twitter</a>
            <h4>Tweets</h4>
            <div id="tweet-list"></div>
            <span class="social-follow-link"><a href="http://twitter.com/intent/user?screen_name=UniQVictoria">follow us on twitter</a></span>
        </div>

        <script type="text/javascript">
        /* <![CDATA[ */
            jQuery(function($){
                $("#tweet-list").tweet({
                    template: "{avatar}{join}{text}{time}",
                    filter: function(t){ return ! /^@\w+/.test(t.tweet_raw_text); },
                    fetch: 20,
                    username: "uniqvictoria",
                    count: 3,
                    retweets: true, 
                    loading_text: "loading tweets..."
                });
            });
        /* ]]> */
        </script>

        <!--Facebook Feed-->
        <div id="facebook" class="social-section">
            <a href="http://facebook.com/uniqvictoria" class="social-icon-link">facebook</a>
            <h4>Facebook</h4>
            <?php fb_feed(); ?>
            <span class="social-follow-link"><a href="http://www.facebook.com/uniqvictoria/">join us on facebook</a></span>
        </div> 

        <!--Tumblr Feed-->
        <div id="tumblr" class="social-section">
            <a href="" class="social-icon-link">tumblr</a>
            <h4>Tumblr</h4>
            <ul id="tumblr-posts"></ul>
            <span class="social-follow-link"><a href="">follow our tumblr</a></span>
        </div> 

         <script type="text/javascript">
            /* <![CDATA[ */  
                jQuery(function($){
                    $("#tumblr-posts").tumblrRss({
                        username: "uniqvictoria", 
                        template: '<li class="tumblr-rss-entry"> <span class="regularTitle">{entry.regular-title}</span> <a href="{entry.link-url}" class="link">{entry.link-text}</a> <span class="date">{entry.date}</span> <a href="{entry.url-with-slug}" class="postLink">View Post</a> </li>',
                        limit: 4,
                    });
                });
            /* ]]> */
        </script>

    </div> <!--/sidebar-->

    <div class="clearfix"></div>

<?php get_footer(); ?>