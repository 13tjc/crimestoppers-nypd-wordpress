<?php
/*

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
				
				 * Ah, post formats. Nature's greatest mystery (aside from the sloth).
				 *
				 * So this function will bring in the needed template file depending on what the post
				 * format is. The different post formats are located in the post-formats folder.
				 *
				 *
				 * REMEMBER TO ALWAYS HAVE A DEFAULT ONE NAMED "format.php" FOR POSTS THAT AREN'T
				 * A SPECIFIC POST FORMAT.
				 *
				 * If you want to remove post formats, just delete the post-formats folder and
				 * replace the function below with the contents of the "format.php" file.
			
				get_template_part( 'post-formats/format', get_post_format() );
			


    </div>

     endwhile; endif; 

  </div>
  
</main>

 get_footer(); 


*/?>