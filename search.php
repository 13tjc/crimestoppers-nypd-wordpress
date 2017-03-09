<?php get_header(); ?>

<main class="main" role="main">

  <?php
    $query = get_search_query();
    $check = esc_attr($query);
   if(empty($check)){?>

    <div class="no-results">

      <h1 class="no-results__title">
        Your search <span class="no-results__title__term"><?php echo esc_attr(get_search_query()); ?></span> returned no results.
      </h1>

      <div class="no-results__content">

        <p>Please try using our search bar if you need help finding the page you are looking for.</p>

        <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">

          <div class="searchbox">
            <input class="field__input searchbox__input" id="search-field" name="s" type="search" placeholder="Search"  type="search" id="s" name="s" >
            <button class="searchbox__button" type="submit" id="searchsubmit" >Search</button>
          </div>

        </form>

      </div>

    </div>

  <?php } else { ?>

    <?php if ( have_posts() ) : ?>

      <div class="search-results">

        <div class="wrapper">

          <div class="search-results__header">
            <h1 class="search-results__title">
              <?php
                global $wp_query;
                $scount = $wp_query->found_posts; 
              ?>
              <?php echo $scount; ?> results for: <span class="search-results__title__term"><?php echo esc_attr(get_search_query()); ?></span>
            </h1>
            <?php
              if (function_exists(custom_pagination)) {
                custom_pagination($the_query->max_num_pages,"",$paged);
              }
            ?>
          </div>

          <ul class="results-listing">

            <?php 
              while ( have_posts() ) : the_post();
              $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            ?>

              <?php if( has_term( 'Wanted', 'custom_cri' ) ) { ?>

                <li class="results-listing__item results-listing__item--crime">

                  <div class="card card--wanted">
                    <div class="card__profile">
                      <div class="card__type">Wanted</div>
                      <a href="<?php the_permalink(); ?>">
                        <div class="card__photo">
                          <img class="card__photo__img" src="<?php echo $url; ?>" alt="<?php the_field('feat_text') ?>" />
                        </div>
                      </a>
                      <div class="card__label"><?php the_field('feat_text') ?></div>
                    </div>
                    <div class="card__details">
                      <div class="card__crime">
                        <?php
                          $terms = wp_get_post_terms($post->ID, 'custom_cat');
                          $count = count($terms);
                          if ( $count > 0 ) {
                            foreach ( $terms as $term ) {
                              echo $term->name;
                            }
                          }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="results-listing__item__container">
                    <div class="results-listing__item__title">
                      <a href="<?php the_permalink(); ?>">Crime - <?php the_field('reference_id'); ?></a>
                    </div>
                    <div class="results-listing__item__date">
                      <?php printf( __( 'REPORTED: %1$s   %2$s', 'bonestheme' ), '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>', '<span></span>'); ?>
                    </div>
                    <div class="results-listing__item__content">
                      <?php the_excerpt(); ?> 
                      <a href="<?php the_permalink(); ?>"> ... </a>	
                    </div>
                    <div class="results-listing__item__url">
                      <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
                    </div>
                  </div>

                </li>

              <?php } elseif ( has_term( 'Victim', 'custom_cri' ) )  { ?>

                <li class="results-listing__item results-listing__item--crime">

                  <div class="card card--victim">
                    <div class="card__profile">
                      <div class="card__type">Victim</div>
                      <a href="<?php the_permalink(); ?>">
                        <div class="card__photo">
                          <img class="card__photo__img" src="<?php echo $url; ?>" alt="<?php the_field('feat_text') ?>" />
                        </div>
                      </a>
                      <div class="card__label"><?php the_field('feat_text') ?></div>
                    </div>
                    <div class="card__details">
                      <div class="card__crime">
                        <?php
                          $terms = wp_get_post_terms($post->ID, 'custom_cat');
                          $count = count($terms);
                          if ( $count > 0 ) {
                            foreach ( $terms as $term ) {
                              echo $term->name;
                            }
                          }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="results-listing__item__container">
                    <div class="results-listing__item__title">
                      <a href="<?php the_permalink(); ?>">Crime - <?php the_field('reference_id'); ?></a>
                    </div>
                    <div class="results-listing__item__date">
                      <?php printf( __( 'REPORTED: %1$s   %2$s', 'bonestheme' ), '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>','<span></span>');?>
                    </div>
                    <div class="results-listing__item__content">
                      <?php the_excerpt(); ?> 
                      <a href="<?php the_permalink(); ?>"> ... </a>
                    </div>
                    <div class="results-listing__item__url">
                      <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
                    </div>
                  </div>

                </li>

              <?php } elseif ( has_term( '', 'custom_cri' ) )  { ?>

                <li class="results-listing__item results-listing__item--crime">

                  <div class="card card--wanted">
                    <div class="card__profile">
                      <div class="card__type">
                        <?php
                          $terms = wp_get_post_terms($post->ID, 'custom_cri');
                          $count = count($terms);
                          if ( $count > 0 ) {
                            foreach ( $terms as $term ) {
                              echo $term->name . " ";
                            }
                          }
                        ?>
                      </div>
                      <a href="<?php the_permalink(); ?>">
                        <div class="card__photo">
                          <img class="card__photo__img" src="<?php echo $url; ?>" alt="<?php the_field('feat_text') ?>" />
                        </div>
                      </a>
                      <div class="card__label"><?php the_field('feat_text') ?></div>
                    </div>
                    <div class="card__details">
                      <div class="card__crime">
                        <?php
                          $terms = wp_get_post_terms($post->ID, 'custom_cat');
                          $count = count($terms);
                          if ( $count > 0 ) {
                            foreach ( $terms as $term ) {
                              echo $term->name;
                            }
                          }
                          ?>
                      </div>
                    </div>
                  </div>

                  <div class="results-listing__item__container">
                    <div class="results-listing__item__title">
                      <a href="<?php the_permalink(); ?>">Crime - <?php the_field('reference_id'); ?></a>
                    </div>
                    <div class="results-listing__item__date">
                      <?php printf( __( 'REPORTED: %1$s   %2$s', 'bonestheme' ),'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>','<span></span>'); ?>
                    </div>
                    <div class="results-listing__item__content">
                      <?php the_excerpt(); ?> 
                      <a href="<?php the_permalink(); ?>"> ... </a>
                    </div>
                    <div class="results-listing__item__url">
                      <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
                    </div>
                  </div>

                </li>

              <?php } else { ?>

                <li class="results-listing__item">

                  <div class="results-listing__item__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </div>
                  <div class="results-listing__item__content">
                    <?php the_excerpt(); ?> 
                    <a href="<?php the_permalink(); ?>"> ... </a>
                  </div>
                  <div class="results-listing__item__url">
                    <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
                  </div>

                </li>

              <?php } ?>

            <?php endwhile; ?>

          </ul>

          <div class="search-results__footer">
            <?php
              if (function_exists(custom_pagination)) {
                custom_pagination($the_query->max_num_pages,"",$paged);
              }
            ?>
          </div>

        </div>

      </div>

    <?php else: ?>

      <div class="no-results">

        <h1 class="no-results__title">
          Your search <span class="no-results__title__term"><?php echo esc_attr(get_search_query()); ?></span> returned no results.
        </h1>

        <div class="no-results__content">

          <p>Please try using our search bar if you need help finding the page you are looking for.</p>

          <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">

            <div class="searchbox">
              <input class="field__input searchbox__input" id="search-field" name="s" type="search" placeholder="Search"  type="search" id="s" name="s" >
              <button class="searchbox__button" type="submit" id="searchsubmit" >Search</button>
            </div>

          </form>

        </div>

      </div>

    <?php endif; ?>

  <?php } ?>

</main>

<?php get_footer(); ?>
