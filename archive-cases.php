<?php
/*
 * ARCHIVE CASES
*/
?>
<?php   
        get_header(); 
        if (isset($_POST['crime'])) { $terms_crime = $_POST['crime']; }
        if (isset($_POST['criteria'])) { $terms_criteria = $_POST['criteria']; }
        if (isset($_POST['borough'])) { $terms_borough = $_POST['borough']; }
        if (isset($_POST['from_input'])) { $from =  $_POST['from_input']; }
        if (isset($_POST['to_input'])) { $to = $_POST['to_input']; }
        $val = $_GET;
        foreach( $val as $key_p => $value_pass_p ){
             if ($key_p == 'borough') { $terms_borough = $value_pass_p; }
             if ($key_p == 'criteria') { $terms_criteria = $value_pass_p; }
             if ($key_p == 'crime') { $terms_crime = $value_pass_p; }
             if ($key_p == 'from') { $from = $value_pass_p; }
             if ($key_p == 'to') { $to = $value_pass_p; }
        }
?>
<main class="main" role="main">
  <form class="crime-filters" method="post">
    <div class="crime-filters__container">
      <!-- Borough filters -->
      <div class="filters filters--first">
        <div class="filters__header">
          <div class="filters__title">Borough</div> 
        </div>
        <div class="filters__content">
          <ul class="filters__list">
            <?php
              $tax_boro = 'custom_boro';
              $terms_boro = get_terms( $tax_boro, ['hide_empty' => false]);
              foreach( $terms_boro as $term_boro ) {
            ?>
              <li class="filters__list__item checkbox">
                <input type="checkbox" class="checkbox__input" store="checkbox-<?php echo $term_boro->name; ?>" id="filter-borough-<?php echo $term_boro->name; ?>" name="borough[]" value="<?php echo $term_boro->name; ?>" <?php if (isset($terms_borough)) { if (in_array($term_boro->name, $terms_borough)){ echo 'checked'; }} ?> />
                <label class="checkbox__label" for="filter-borough-<?php echo $term_boro->name; ?>"><?php echo $term_boro->name; ?></label>
              </li>  

            <?php } ?>  
          </ul>
        </div>
      </div>  
      <!-- Criteria filters -->
      <div class="filters">

        <div class="filters__header">
          <div class="filters__title">Criteria</div>
        </div>

        <div class="filters__content">

          <ul class="filters__list">
            <?php
              $tax_cri = 'custom_cri';
              $terms_cri = get_terms( $tax_cri, ['hide_empty' => false]);
              foreach( $terms_cri as $term_cri ) {  
            ?>

              <li class="filters__list__item checkbox">
                <input type="checkbox" class="checkbox__input" id="filter-criteria-<?php echo $term_cri->name; ?>" name="criteria[]" value="<?php echo $term_cri->name; ?>"<?php if (isset($terms_criteria)) {if (in_array($term_cri->name, $terms_criteria)) { echo 'checked'; }} ?>/>
                <label class="checkbox__label" for="filter-criteria-<?php echo $term_cri->name; ?>"><?php echo $term_cri->name; ?></label>
              </li>

            <?php } ?>

          </ul>

        </div>

      </div>

      <!-- Crime filters -->
      <div class="filters filters--wide">

        <div class="filters__header">
          <div class="filters__title">Type of crime</div>
        </div>

        <div class="filters__content">

          <ul class="filters__list">
            <?php
              $tax_cat = 'custom_cat';
              $terms_cat = get_terms( $tax_cat, ['hide_empty' => false]);
              foreach( $terms_cat as $term_cat ) {
            ?> 
   
              <li class="filters__list__item checkbox">
                <input type="checkbox" class="checkbox__input" id="filter-crime-<?php echo $term_cat->name; ?>" name="crime[]" value="<?php echo $term_cat->name; ?>" <?php if (isset($terms_crime)) { if (in_array($term_cat->name, $terms_crime)) { echo 'checked'; }} ?>/>
                <label class="checkbox__label" for="filter-crime-<?php echo $term_cat->name; ?>"><?php echo $term_cat->name; ?></label>
              </li>
                  
            <?php } ?>

          </ul>
  
        </div>

      </div>

      <!-- Date filters -->
      <div class="filters filters--last">

        <div class="filters__header">
          <div class="filters__title">Date</div>
        </div>

        <div class="filters__content">

          <div class="filters__date-range">

            <div class="filters__date-range__field filters__date-range__field--from">
              <label class="sr-only" for="filter-date-range-from">Date From</label>
              <input class="field__input field__input--date-picker" type="date" name="Date From" id="filter-date-range-from" value="<?php if(!empty($from)){ echo date("m/d/Y", strtotime($from)); } ?>"/>
              <input type="hidden" id="from" name="from_input" value="<?php //echo $to; ?>">  
            </div> 

            <p class="filters__date-range__label">to</p>

            <div class="filters__date-range__field filters__date-range__field--to picker-align-right">
              <label class="sr-only" for="filter-date-range-to">Date To</label>
              <input class="field__input field__input--date-picker" type="date" name="Date To" id="filter-date-range-to" value="<?php if(!empty($to)){ echo date("m/d/Y", strtotime($to)); } ?>"/><br>
              <input type="hidden" id="to" name="to_input" value="<?php //echo $from; ?>">
            </div> 

          </div>

        </div>

      </div>

      <div class="filters__btn-container">
        <button type="submit" class="btn filters__filter-btn">Filter</button>
        <button type="reset" onclick="window.location.href='/cases'" class="btn filters__filter-btn filters__filter-btn--reset" id="reset-filters">Reset</button>
      </div>

    </div>

  </form>
  
   <div class="crime-listing">

     <div class="wrapper">

    <?php

       $bor_url  = http_build_query(array('borough' => $terms_borough));       
       $tr_url   = http_build_query(array('crime' => $terms_crime));     
       $cr_url   = http_build_query(array('criteria' => $terms_criteria));
       $to_url   = http_build_query(array('to' => $to));
       $from_url = http_build_query(array('from' => $from));

         $tax_query = array('relation' => 'AND');
         if (isset($terms_crime)){ 
           $tax_query[] =  array(
             'taxonomy' => 'custom_cat',
             'field' => 'slug',
             'terms' => $terms_crime,
           );
         }
         if (isset($terms_criteria)){
           $tax_query[] =  array(
             'taxonomy' => 'custom_cri',
             'field' => 'slug',
             'terms' => $terms_criteria,
           );
         }
         if (isset($terms_borough)){
           $tax_query[] =  array(
             'taxonomy' => 'custom_boro',
             'field' => 'slug',
             'terms' => $terms_borough,
           );
         } 
           
         if ( !empty($from) && !empty($to) ) {
           $meta_query = array(
             array(
               'key' => 'date_time',
               'value' => array($from, $to),
               'compare' => 'BETWEEN',
               'type' => 'DATE',
             )
           ); 
         } else {
           $meta_query = "";
         }

        foreach( $val as $key => $value_pass ){  
            if ($key == 'borough') {
              $tax_query[] =  array(
                    'taxonomy' => 'custom_boro',
                     'field' => 'slug',
                     'terms' => $value_pass,
              );
             }
            if ($key == 'crime') {
              $tax_query[] =  array(
                 'taxonomy' => 'custom_cat',
                 'field' => 'slug',
                 'terms' => $value_pass,
              );
             }
            if ($key == 'criteria') {
              $tax_query[] =  array(
                 'taxonomy' => 'custom_cri',
                 'field' => 'slug',
                 'terms' => $value_pass,
              );             
             }        
        }  
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
           'post_type' => 'cases',   
           'posts_per_page' => 16,
           'paged' => $paged, 
           'orderby' => 'menu_order',
           'order' => 'ASC',
           'tax_query' => $tax_query,
           'meta_key' => 'date_time',
           'meta_query' => $meta_query,
         );
    
          $the_query = new WP_Query($args);
          if ($the_query->have_posts()):
    ?>
          <div class="crime-listing__header">
            <div class="crime-legend">
              <ul class="crime-legend__list">
                <li class="crime-legend__item crime-legend__item--suspect">Suspect Pictured</li>
                <li class="crime-legend__item crime-legend__item--victim">Vicitim Pictured</li>
              </ul>
            </div>
          <?php
            //global $wp_query;
            $numpages = $the_query->max_num_pages;
            if(!$numpages) {
                $numpages = 1;
            }
          
          $pagination_args = array(
            'base'            => get_pagenum_link(1) . '%_%',
            'format'          => '/page/%#%',
            'total'           => $numpages,
            'current'         => $paged,
            'show_all'        => False,
            'end_size'        => 1,
            'mid_size'        => $pagerange,
            'prev_next'       => True,
            'prev_text'       => __('&laquo;'),
            'next_text'       => __('&raquo;'),
            'type'            => 'plain',
            'add_args'        => false,
            'add_fragment'    => ''
          );
          $paginate_links = paginate_links($pagination_args);
          if ($paginate_links) {
            $template_name = get_post_meta( $the_query->post->ID, '_wp_page_template', true );
            
             $prev = $paged - 1;
             $next = $paged + 1;
             if ($next > $numpages) {
              $next = $numpages;
             }
              echo "<div class='pagination'>";
              echo "<div class='pagination__item pagination__item--first'><a href='/cases/page/1' class='pagination__link'>First</a></div>";
              echo "<div class='pagination__item pagination__item--prev'><a href='/cases/page/". $prev . "/?" . $bor_url . "&" . $tr_url . "&" . $cr_url . "&" . $to_url . "&" . $from_url . "' class='pagination__link'>Previous</a></div>";
              echo "<div class='pagination__item pagination__item--current'>Page " . $paged . " of " . $numpages . "</div>";
              echo "<div class='pagination__item pagination__item--next'><a href='/cases/page/" . $next . "/?" . $bor_url . "&" . $tr_url . "&" . $cr_url . "&" . $to_url . "&" . $from_url . "' class='pagination__link'>Next</a></div>";
              echo "<div class='pagination__item pagination__item--last'> <a href='/cases/page/" . $numpages . "/?" . $bor_url . "&" . $tr_url . "&" . $cr_url . "&" . $to_url . "&" . $from_url . "' class='pagination__link'>Last</a></div>";
              echo "</div>";
          }          
          ?>
          </div>
          <ul class="crime-grid">
            <?php
              while ($the_query -> have_posts()) : $the_query -> the_post(); 
                $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                $reward = get_field('reward');
                $stock_reward = "$" . get_option('global_reward'); 
                 if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ 
                    $my_post = array(
                        'ID'           => $post->ID,
                        'menu_order'   => '100000',
                    );
                    wp_update_post( $my_post );
                 }
             ?>

             <?php if( has_term( 'Wanted', 'custom_cri' ) ) { 
               if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ 
                      $card_dis = "card--closed";
                  } else { $card_dis = ""; } ?>
              
                <li class="crime-grid__item">

                  <div class="card card--wanted <?php echo $card_dis; ?>">

                    <div class="card__profile">
                      <?php if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ ?><div class="card__status">Case Closed</div><?php } ?>
                      <div class="card__type">Wanted</div>
                      <a href=" <?php the_permalink(); ?> ">
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

                      <div class="card__reward">Reward up to 
                        <span class="card__reward__value">
                          <?php  if ($reward == null) { echo $stock_reward; } else { echo "$".$reward; } ?>
                        </span>
                      </div>

                      <a class="btn card__btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

                    </div>

                  </div>

                </li>

             <?php } elseif ( has_term( 'Victim', 'custom_cri' ) )  { 
                  if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ 
                      $card_dis = "card--closed";
                  } else { $card_dis = ""; }?>
                <li class="crime-grid__item">
                  <div class="card card--victim <?php echo $card_dis; ?>">
                    <div class="card__profile">
                      <?php if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ ?><div class="card__status">Case Closed</div><?php } ?>
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

                      <div class="card__reward">Reward up to
                        <span class="card__reward__value">
                          <?php  if ($reward == null) { echo $stock_reward; } else { echo "$".$reward; } ?>
                        </span>
                      </div>

                      <a class="btn card__btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

                    </div>

                  </div>

                </li>

             <?php } else { 
                 if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ 
                      $card_dis = "card--closed";
                  } else { $card_dis = ""; } ?>
                <li class="crime-grid__item">

                  <div class="card card--wanted <?php echo $card_dis; ?>">

                    <div class="card__profile">
                       <?php if(get_field('condition') == 'Solved' || get_field('condition') == 'Captured'){ ?><div class="card__status">Case Closed</div><?php } ?>
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

                      <a href=" <?php the_permalink(); ?> ">
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

                      <div class="card__reward">Reward up to
                        <span class="card__reward__value">
                          <?php  if ($reward == null) { echo $stock_reward; } else { echo "$".$reward; } ?>
                        </span>
                      </div>

                      <a class="btn card__btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

                    </div>

                  </div>

                </li>

             <?php } ?>

             <?php
               endwhile;
               wp_reset_postdata(); 
             ?>

          </ul>

        <?php else : ?>

          <div class="crime-list__no-results">

            <h2>No cases found</h2>

            <p>Please refine your filtering criteria.</p>

          </div>

        <?php endif; ?>

     </div>

  </div>

</main>

<?php get_footer(); ?>