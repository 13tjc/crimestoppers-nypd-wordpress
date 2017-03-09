<?php get_header(); ?>

  <main class="main" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="hero" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/bg/nyc-hero.jpg);"></div>

    <div class="generic-content" id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?>>

      <div class="wrapper">


        <div class="page-title">

          <h1><?php the_title(); ?></h1>

        </div>

				<?php
					// the content (pretty self explanatory huh)
					the_content();

					/*
					 * Link Pages is used in case you have posts that are set to break into
					 * multiple pages. You can remove this if you don't plan on doing that.
					 *
					 * Also, breaking content up into multiple pages is a horrible experience,
					 * so don't do it. While there are SOME edge cases where this is useful, it's
					 * mostly used for people to get more ad views. It's up to you but if you want
					 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
					 *
					 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
					 *
					*/
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>


      </div>

      <?php endwhile; endif; ?>

    </div>
    
  </main>

<?php get_footer(); ?>
