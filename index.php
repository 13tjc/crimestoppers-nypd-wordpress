<?php get_header(); ?>
<main class="main" role="main">
        <div class="homepage">
          <div class="hp-hero">
            <div class="hp-hero__content">
              <div class="hp-hero__content__container">
                <p class="hp-hero__title">Your City. Your Call</p>
                <p class="hp-hero__text">You don't have to give your name. <br>Help Solve a crime. Receive up to $<?php echo get_option('global_reward'); ?></p> 
                <a class="btn hp-hero__btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" type="button">Submit a Tip &rsaquo;</a>
              </div>
            </div>
            <div class="hp-hero__callouts"> 
              <div class="hp-hero__callouts__container">
                <div class="hp-hero__callout">
                  <div class="hp-hero__callout__image">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon/devices-icon.png" alt="Devices"/>
                  </div>
                  <p class="hp-hero__callout__title">4 Ways to Submit</p>
                  <p class="hp-hero__callout__text">Call, text, online, &amp; mobile app.</p>
                </div>
                <div class="hp-hero__callout">
                  <div class="hp-hero__callout__image">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon/anonymous-icon.png" alt="Anonymous"/>
                  </div>
                  <p class="hp-hero__callout__title">Always Anonymous</p>
                  <p class="hp-hero__callout__text">No Cops. No Names. No Courts.</p>
                </div>
                <div class="hp-hero__callout">
                  <div class="hp-hero__callout__image">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon/reward-icon.png" alt="Reward"/>
                  </div>
                  <p class="hp-hero__callout__title">Collect A Reward</p>
                  <p class="hp-hero__callout__text">Receive an award up to $<?php echo get_option('global_reward'); ?>.</p> 
                  <p><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">Learn More &rsaquo;</a></p>
                </div>
              </div>
            </div>
          </div>
          <div class="hp-stats">
            <div class="wrapper">
              <div class="hp-stats__header">
                <p>Your tips have been making a difference across the five boroughs for the past five years</p>
              </div>
              <ul class="hp-stats__list">
                <li class="hp-stats__stat">
                  <p class="hp-stats__stat__num"><?php echo get_option('suspects_arrested'); ?> <span>+</span></p>
                  <p class="hp-stats__stat__label"><?php echo get_option('suspects_arrested_title'); ?></p>
                </li>
                <li class="hp-stats__stat">
                  <p class="hp-stats__stat__num"><?php echo get_option('murder_cases'); ?> <span>+</span></p>
                  <p class="hp-stats__stat__label"><?php echo get_option('murder_cases_title'); ?></p>
                </li>
                <li class="hp-stats__stat">
                  <p class="hp-stats__stat__num"><?php echo get_option('solved_robberies'); ?> <span>+</span></p>
                  <p class="hp-stats__stat__label"><?php echo get_option('solved_robberies_title'); ?></p>
                </li>
                <li class="hp-stats__stat">
                  <p class="hp-stats__stat__num">$<?php echo get_option('paid_rewards'); ?>m <span>+</span></p>
                  <p class="hp-stats__stat__label"><?php echo get_option('paid_rewards_title'); ?></p>
                </li>
              </ul>
            </div>
          </div>
          
          <?php      

                $args = array(
                    'post_type' => 'cases',   
                    'posts_per_page' => 1,
                    'orderby' => 'modified',
                    'meta_query' => array(
                        array(
                          'key' => 'featured_hp_video',
                          'value' => '1',
                          'compare' => '=='
                        )
                      )
                );
                $fv_query = new WP_Query($args); 
                  while ($fv_query -> have_posts()) : $fv_query -> the_post(); 
     
                  $iframe = get_field('video_url', false, false);
                  preg_match('/src="(.+?)"/', $iframe, $matches);
                  $src = $matches[1];              
          ?>
          <?php //var_dump( get_field('featured_hp_video') );
          if (get_field( 'featured_hp_video' )){
          ?>
          <div class="featured-item">
            <div class="wrapper">
              <div class="featured-item__asset">
                <div class="featured-item__asset__video">

                  <?php
                  if (get_field('video_format') == 'Other') {
                      $video_src_url = $src;
                  } else {
                      $video_src_url = get_field('video_url');
                  }
              
                    if (get_field('video_format') == 'Youtube'){

                        echo wp_oembed_get( get_field( 'video_url' ) ); 

                    } elseif(get_field('video_format') == 'Other') { ?>

                      <div class="featured-video" data-video-url="<?php echo $src; ?>">

                        <div class="featured-video__placeholder">
                          <span>Play</span>
                          <div>
                            <p><strong>Video</strong> <?php the_title(); ?></p>
                          </div>
                        </div>

                      </div>

                  <?php } else {

                        $thevid = get_field('video_url');
                        echo $thevid;
                  } ?>
                </div>
              </div>
              <div class="featured-item__content">
                <p class="featured-item__title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></p>
                <div class="featured-item__description">
                  <p><?php the_excerpt(); ?></p>
                </div>
                <a class="featured-item__cta" href="<?php the_permalink(); ?>">View more details &rsaquo;</a>
                <div class="featured-item__share">
                  <p class="featured-item__share__label">Share this Video</p>
                  <ul class="share">
                    <li class="share__item">
                      <a class="share__item__link share__item__link--twitter" href="http://twitter.com/share?text=<?php echo $video_src_url; ?>&amp;url=<?php echo get_field( 'video_url' ); ?> target='_blank' ">Twitter</a>
                    </li>
                    <li class="share__item">
                      <a class="share__item__link share__item__link--facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $video_src_url; ?> target='_blank' ">Facebook</a>
                    </li>
                    <li class="share__item">
                      <a class="share__item__link share__item__link--gplus" href="https://plus.google.com/share?url=<?php echo $video_src_url; ?>">Google+</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php }
            endwhile;
            wp_reset_postdata(); 
          ?>
          <div class="featured-crimes">
            <div class="featured-crimes__container">
              <div class="featured-crimes__header">
                <h2 class="featured-crimes__title">Most wanted by borough</h2>
                <div class="crime-legend">
                  <ul class="crime-legend__list">
                    <li class="crime-legend__item crime-legend__item--suspect">Suspect Pictured</li>
                    <li class="crime-legend__item crime-legend__item--victim">Vicitim Pictured</li>
                  </ul>
                </div>
              </div>
              <div class="crimes-slider slick-slider">
                <?php 
                $args = array(
                            'post_type' => 'cases',   
                            'posts_per_page' => 8,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                        );
                $crimes_query = new WP_Query($args); 
                   while ($crimes_query -> have_posts()) : $crimes_query -> the_post(); 
                        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                        $reward = get_field('reward');
                        $stock_reward =  "$" . get_option('global_reward');
                ?>

      <?php

           if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ 
                              echo " ";
            } else {  ?>

                <?php if( has_term( 'Wanted', 'custom_cri' ) ) { ?>
                <div class="crimes-slider__slide">
                  <p class="crimes-slider__slide__title">
                    <?php
                              $terms = wp_get_post_terms($post->ID, 'custom_boro');
                              $count = count($terms);
                              if ( $count > 0 ) {
                                  foreach ( $terms as $term ) {
                                      echo $term->name;
                                  }
                              }
                        ?>
                  </p>
                  <div class="card card--wanted">
                    <div class="card__profile">
                      <div class="card__type">Wanted</div>
                      <a href="<?php the_permalink(); ?>">
                            <div class="card__photo">
                              <img class="card__photo__img" src="<?php echo $url; ?>" alt="Name of person" />
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
                       <div class="card__reward">Reward up to <span class="card__reward__value">
                          <?php  if ($reward == null) { echo $stock_reward; } else { echo "$".$reward; } ?>
                          </span></div>

                          <a class="btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

                    </div>
                  </div>
                </div>
               <?php } elseif ( has_term( 'Victim', 'custom_cri' ) )  { ?>
                <div class="crimes-slider__slide">
                  <p class="crimes-slider__slide__title">
                    <?php
                        $terms = wp_get_post_terms($post->ID, 'custom_boro');
                        $count = count($terms);
                        if ( $count > 0 ) {
                            foreach ( $terms as $term ) {
                                echo $term->name;
                            }
                        }
                    ?>
                  </p>
                  <div class="card card--victim">
                    <div class="card__profile">
                      <div class="card__type">Victim</div>
                      <a href="<?php the_permalink(); ?>">
                        <div class="card__photo">
                          <img class="card__photo__img" src="<?php echo $url; ?>" alt="Name of person" />
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
                       <div class="card__reward">Reward up to <span class="card__reward__value">
                          <?php  if ($reward == null) { echo $stock_reward; } else { echo "$".$reward; } ?>
                          </span></div>

                        <a class="btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

                    </div>
                  </div>
                </div>
          <?php } else { ?> 
          <div class="crimes-slider__slide">
            <p class="crimes-slider__slide__title">
              <?php
                  $terms = wp_get_post_terms($post->ID, 'custom_boro');
                  $count = count($terms);
                  if ( $count > 0 ) {
                      foreach ( $terms as $term ) {
                          echo $term->name;
                      }
                  }
              ?>
            </p>
                    <div class="card card--wanted">
                      <div class="card__profile">
                        <div class="card__type">
                          <?php
                              $terms = wp_get_post_terms($post->ID, 'custom_cri');
                              $count = count($terms);
                              if ( $count > 0 ) {
                                  foreach ( $terms as $term ) {
                                      echo $term->name;
                                  }
                              }
                            ?>
                        </div>
                        <a href="<?php the_permalink(); ?>">
                              <div class="card__photo">
                                <img class="card__photo__img" src="<?php echo $url; ?>" alt="Name of person" />
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
                          <div class="card__reward">Reward up to <span class="card__reward__value">
                            <?php  if ($reward == null) { echo $stock_reward; } else { echo "$".$reward; } ?>
                            </span>
                          </div>                    

                          <a class="btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>
                          
                      </div>
                    </div>
          </div>
          <?php } ?>
      <?php } ?>

          <?php
              endwhile;
              wp_reset_postdata(); 
            ?>
            </div>
              <a class="featured-crimes__cta" href="<?php echo esc_url( home_url( '/cases' ) ); ?>">See all Wanted &rsaquo;</a>
            </div>
          </div>
          <?php 
            $args = array(
                        'post_type' => 'blog_post',   
                        'posts_per_page' => 1,
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    );
                $community_query = new WP_Query($args); 
                   while ($community_query -> have_posts()) : $community_query -> the_post(); 
                   $bp_img = get_field('blog_img');
            ?>
          <div class="community">
            <div class="wrapper">
              <div class="story">
                <div class="story__image">
                <?php if (!empty($bp_img) ) { ?>
                    <a href="<?php the_field('blog_link'); ?>">
                      <img src="<?php  echo $bp_img['url'];  ?>" alt="Baby Hope"/>
                    </a>  
                <?php } ?>
                </div>
                <div class="story__content">
                  <h2 class="story__section-title">Success Stories</h2>
                  <p class="story__title"><a href="<?php the_field('blog_link'); ?> " target="_blank"><?php the_title(); ?></a></p>
                  <div class="story__blurb">
                  <p><?php the_field('bp_excerpt'); ?></p>
                  </div>
                  <a class="story__link" href="<?php the_field('blog_link'); ?>" target="_blank">Read More &rsaquo;</a>
                </div>
              </div>
              <?php
                endwhile;
                wp_reset_postdata(); 
              ?>
              <div class="community__links"> 
                <?php 
                  $args = array('post_type' => 'community','posts_per_page' => 3, 'orderby' => 'menu_order','order' => 'ASC' );
                      $community_news_query = new WP_Query($args); 
                      while ($community_news_query -> have_posts()) : $community_news_query -> the_post(); 
                ?>
                    <a class="community__link" href="<?php the_field('comm_link'); ?>" target="blank" style="background-image: url(<?php the_field('comm_image'); ?>);">
                      <div class="community__link__container">
                        <p><?php the_title(); ?></p>
                      </div>
                    </a>
                <?php
                  endwhile;
                  wp_reset_postdata(); 
                ?>
              </div>
            </div>
          </div>
        </div>
      </main>
<?php get_footer(); ?>