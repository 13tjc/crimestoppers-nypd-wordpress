<?php
/*
 * CASES POST TYPE TEMPLATE
*/
?>
<?php get_header(); ?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<main class="main" role="main">

  <?php if (have_posts()) : while (have_posts()) : the_post(); 

// run after ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'my_acf_save_post', 20);


    $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
     if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ 
                    $my_post = array(
                        'ID'           => $post->ID,
                        'menu_order'   => '100000',
                    );
                    wp_update_post( $my_post );
                 }
  ?>

  <div class="crime-detail">

    <div class="crime-detail__container">

      <?php if( get_field('sec_image') ): ?>
        <div class="crime-detail__featured-photo">
          <img src="<?php  the_field('sec_image');  ?>" alt="Crime"/>
        </div>
      <?php endif; ?>

      <div class="crime-detail__specs">

        <?php if( has_term( 'Wanted', 'custom_cri' ) ) { 

           if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ 
                      $card_dis = "card--closed";
                  } else { $card_dis = ""; } ?>

          <div class="crime-detail__specs__card card card--wanted <?php echo $card_dis; ?>">

            <div class="card__profile "> 
              <?php if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ ?><div class="card__status">Case Closed</div><?php } ?>
              <div class="card__type">Wanted</div>

              <div class="card__photo">
                <img class="card__photo__img" src="<?php echo $url; ?>" alt="<?php the_field('feat_text') ?>" />
              </div>

              <div class="card__label"><?php the_field('feat_text') ?></div>

            </div>

            <div class="card__details">

              <div class="card__crime"> 
                <?php
                  $terms = wp_get_post_terms($post->ID, 'custom_cat');
                  $count = count($terms);
                  if ( $count > 0 ) {
                    foreach ( $terms as $term ) {
                      echo $term->name . " ";
                    }
                  }
                ?>
              </div> 

              <div class="card__reward">Reward up to 
                <span class="card__reward__value">
                  <?php $reward = get_field('reward'); $stock_reward = "$" . get_option('global_reward'); 
                    if ($reward == null) { echo $stock_reward; } else { echo "$" . $reward; }
                  ?>
	              </span>
              </div>          

              <a class="btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

            </div>

          </div>

        <?php } elseif ( has_term( 'Victim', 'custom_cri' ) )  { 
          if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ 
                      $card_dis = "card--closed";
                  } else { $card_dis = ""; } ?>

          <div class="crime-detail__specs__card card card--victim <?php echo $card_dis; ?>">

            <div class="card__profile">
              <?php if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ ?><div class="card__status">Case Closed</div><?php } ?>
              <div class="card__type">Victim</div>

              <div class="card__photo">
                <img class="card__photo__img" src="<?php echo $url; ?>" alt="<?php the_field('feat_text') ?>" />
              </div>

              <div class="card__label"><?php the_field('feat_text') ?></div>

            </div>

            <div class="card__details">

              <div class="card__crime">
                <?php
                  $terms = wp_get_post_terms($post->ID, 'custom_cat');
                  $count = count($terms);
                  if ( $count > 0 ) {
                    foreach ( $terms as $term ) {
                      echo $term->name . " ";
                    }
                  }
                ?>
              </div>

              <div class="card__reward">Reward up to 
                <span class="card__reward__value">
                  <?php $reward = get_field('reward'); $stock_reward = "$" . get_option('global_reward'); 
                    if ($reward == null) { echo $stock_reward; } else { echo "$" . $reward; }
                  ?>
                </span>
              </div>

              <a class="btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

            </div>

          </div>

        <?php } else { 
          if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ 
                      $card_dis = "card--closed";
                  } else { $card_dis = ""; } ?>

          <div class="crime-detail__specs__card card card--wanted <?php echo $card_dis; ?>">

            <div class="card__profile">
              <?php if(get_field('condition') === 'Solved' || get_field('condition') === 'Captured'){ ?><div class="card__status">Case Closed</div><?php } ?>
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

              <div class="card__photo">
                <img class="card__photo__img" src="<?php echo $url; ?>" alt="Name of person" />

              </div>

              <div class="card__label"><?php the_field('feat_text') ?></div>

            </div>

            <div class="card__details">

              <div class="card__crime"> 
                <?php
                  $terms = wp_get_post_terms($post->ID, 'custom_cat');
                  $count = count($terms);
                  if ( $count > 0 ) {
                    foreach ( $terms as $term ) {
                      echo $term->name . " ";
                    }
                  }
                ?>
              </div>

              <div class="card__reward">Reward up to 
                <span class="card__reward__value">
                  <?php $reward = get_field('reward'); $stock_reward = "$" . get_option('global_reward'); 
                    if ($reward == null) { echo $stock_reward; } else { echo "$" . $reward; }
                  ?>
                </span>
              </div>

             <a class="btn" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>" data-modal="tip-modal" data-tip-id="<?php the_field('case_number'); ?>">Submit a Tip</a>

            </div>

          </div>

        <?php } ?> 

        <div class="crime-detail__specs__block">
          <h2 class="crime-detail__heading">Crime Details</h2>
          <ul class="crime-detail__specs__block__list">
            <li>
              <span>Reference ID:</span>
              <?php if( get_field('reference_id') ): ?>
                <?php the_field('reference_id'); ?>
              <?php else: ?>
                N/A
              <?php endif; ?>
            </li>
            <li>
              <span>Date:</span>
              <?php if( get_field('date_time') ): ?>
                <?php
                  $date = get_field('date_time');
                  $y = substr($date, 0, 4);
                  $m = substr($date, 4, 2);
                  $d = substr($date, 6, 2);
                  $time = strtotime("{$d}-{$m}-{$y}");
                  echo date('F d, Y', $time);              
                ?>
              <?php else: ?>
                N/A
              <?php endif; ?>
            </li>
            <li>
              <span>Time:</span>  
              <?php the_field("time"); ?>
            </li>
            <li>
              <span>Location:</span>
              <?php if( get_field('crime_location') ): ?>
                <?php the_field('crime_location'); ?>
              <?php else: ?>
                N/A
              <?php endif; ?>
            </li>
          </ul>
        </div>

        <?php
          if(get_field('suspect_or_victim') == ""){
              echo '';
          } else {  ?>
            <div class="crime-detail__specs__block">
              <h2 class="crime-detail__heading">
                <?php
                  if(get_field('suspect_or_victim') == "Suspect"){
                     echo 'suspect';
                  }
                  if(get_field('suspect_or_victim') == "Victim"){
                     echo 'victim';
                  }
                ?>
                Details</h2>
              <table class="data-table">
                <?php if(get_field('gender')){ ?>
                <tr>
                  <th>Gender:</th>
                  <td><?php the_field('gender'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('sv_title')){ ?>
                <tr>
                  <th>Race:</th>
                  <td><?php the_field('sv_title'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('weight_lbs')){ ?>
                <tr>
                  <th>Weight:</th>
                  <td><?php the_field('weight_lbs'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('height_feet') ){ ?>
                <tr>
                  <th>Height:</th>
                  <td><?php the_field('height_feet'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_color') ){ ?>
                <tr>
                  <th>Hair Color:</th>
                  <td><?php the_field('hair_color'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_type') ){ ?>
                <tr>
                  <th>Hair Type:</th>
                  <td><?php the_field('hair_type'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_length') ){ ?>
                <tr>
                  <th>Hair Length:</th>
                  <td><?php the_field('hair_length'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('sv_date_of_birth') ){ ?>
                <tr>
                  <th>Date of Birth:</th>
                  <td>
                      <?php
                        $datesv = get_field('sv_date_of_birth');
                        $ysv = substr($datesv, 0, 4);
                        $msv = substr($datesv, 4, 2);
                        $dsv = substr($datesv, 6, 2);
                        $timesv = strtotime("{$dsv}-{$msv}-{$ysv}");
                        echo date('m/d/Y', $timesv);
                      ?>
                  </td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_color') ){ ?>
                <tr>
                  <th>Eye Color:</th>
                  <td><?php the_field('eye_color'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_description') ){ ?>
                <tr>
                  <th>Eye Description:</th>
                  <td><?php the_field('eye_description'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('precinct_crime') ){ ?>
                <tr>
                  <th>Precinct:</th>
                  <td><?php the_field('precinct_crime'); ?></td>
                </tr>
                <?php } ?>

              </table>
            </div>
        <?php } ?>

        <?php
          if(get_field('suspect_or_victim_vic') == ""){
              echo '';
          } else {  ?>
            <div class="crime-detail__specs__block">
               <?php 
                $image_vic = get_field('suspect_victim_image_vic');
                if( !empty($image_vic) ){  ?>
                  <img class="card__photo__img" src="<?php echo $image_vic['url']; ?>" alt="<?php echo $image_vic['alt']; ?>" />
                <?php } ?>
                <br>
              <h2 class="crime-detail__heading">
                <?php
                  if(get_field('suspect_or_victim_vic') == "Suspect"){
                     echo 'suspect';
                  }
                  if(get_field('suspect_or_victim_vic') == "Victim"){
                     echo 'victim';
                  }
                ?>
                Details</h2>
              <table class="data-table">
                <?php if(get_field('gender_vic')){ ?>
                <tr>
                  <th>Gender:</th>
                  <td><?php the_field('gender_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('sv_title_vic')){ ?>
                <tr>
                  <th>Race:</th>
                  <td><?php the_field('sv_title_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('weight_lbs_vic')){ ?>
                <tr>
                  <th>Weight:</th>
                  <td><?php the_field('weight_lbs_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('height_feet_vic') ){ ?>
                <tr>
                  <th>Height:</th>
                  <td><?php the_field('height_feet_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_color_vic') ){ ?>
                <tr>
                  <th>Hair Color:</th>
                  <td><?php the_field('hair_color_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_type_vic') ){ ?>
                <tr>
                  <th>Hair Type:</th>
                  <td><?php the_field('hair_type_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_length_vic') ){ ?>
                <tr>
                  <th>Hair Length:</th>
                  <td><?php the_field('hair_length_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('sv_date_of_birth_vic') ){ ?>
                <tr>
                  <th>Date of Birth:</th>
                  <td>
                      <?php
                        $datesv = get_field('sv_date_of_birth_vic');
                        $ysv = substr($datesv, 0, 4);
                        $msv = substr($datesv, 4, 2);
                        $dsv = substr($datesv, 6, 2);
                        $timesv = strtotime("{$dsv}-{$msv}-{$ysv}");
                        echo date('m/d/Y', $timesv);
                      ?>
                  </td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_color_vic') ){ ?>
                <tr>
                  <th>Eye Color:</th>
                  <td><?php the_field('eye_color_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_description_vic') ){ ?>
                <tr>
                  <th>Eye Description:</th>
                  <td><?php the_field('eye_description_vic'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('precinct_crime_vic') ){ ?>
                <tr>
                  <th>Precinct:</th>
                  <td><?php the_field('precinct_crime_vic'); ?></td>
                </tr>
                <?php } ?>

              </table>
            </div>
        <?php } ?>

        <?php
          if(get_field('suspect_or_victim_three') == ""){
              echo '';
          } else {  ?>
            <div class="crime-detail__specs__block">
              <?php 
                $image = get_field('suspect_victim_image_three');
                if( !empty($image) ){  ?>
                  <img class="card__photo__img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
              <?php } ?>
                <br>
              <h2 class="crime-detail__heading">
                <?php
                  if(get_field('suspect_or_victim_three') == "Suspect"){
                     echo 'suspect';
                  }
                  if(get_field('suspect_or_victim_three') == "Victim"){
                     echo 'victim';
                  }
                ?>
                Details</h2>
              <table class="data-table">
                <?php if(get_field('gender_three')){ ?>
                <tr>
                  <th>Gender:</th>
                  <td><?php the_field('gender_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('sv_title_three')){ ?>
                <tr>
                  <th>Race:</th>
                  <td><?php the_field('sv_title_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('weight_lbs_three')){ ?>
                <tr>
                  <th>Weight:</th>
                  <td><?php the_field('weight_lbs_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('height_feet_three') ){ ?>
                <tr>
                  <th>Height:</th>
                  <td><?php the_field('height_feet_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_color_three') ){ ?>
                <tr>
                  <th>Hair Color:</th>
                  <td><?php the_field('hair_color_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_type_three') ){ ?>
                <tr>
                  <th>Hair Type:</th>
                  <td><?php the_field('hair_type_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_length_three') ){ ?>
                <tr>
                  <th>Hair Length:</th>
                  <td><?php the_field('hair_length_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('sv_date_of_birth_three') ){ ?>
                <tr>
                  <th>Date of Birth:</th>
                  <td>
                      <?php
                        $datesv = get_field('sv_date_of_birth_three');
                        $ysv = substr($datesv, 0, 4);
                        $msv = substr($datesv, 4, 2);
                        $dsv = substr($datesv, 6, 2);
                        $timesv = strtotime("{$dsv}-{$msv}-{$ysv}");
                        echo date('m/d/Y', $timesv);
                      ?>
                  </td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_color_three') ){ ?>
                <tr>
                  <th>Eye Color:</th>
                  <td><?php the_field('eye_color_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_description_three') ){ ?>
                <tr>
                  <th>Eye Description:</th>
                  <td><?php the_field('eye_description_three'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('precinct_crime_three') ){ ?>
                <tr>
                  <th>Precinct:</th>
                  <td><?php the_field('precinct_crime_three'); ?></td>
                </tr>
                <?php } ?>

              </table>
            </div>
        <?php } ?>

        <?php
          if(get_field('suspect_or_victim_four') == ""){
              echo '';
          } else {  ?>
            <div class="crime-detail__specs__block">
              <?php 
                $image_four = get_field('suspect_victim_image_four');
                if( !empty($image_four) ){  ?>
                  <img class="card__photo__img" src="<?php echo $image_four['url']; ?>" alt="<?php echo $image_four['alt']; ?>" />
              <?php } ?>
              <br>
              <h2 class="crime-detail__heading">
                <?php
                  if(get_field('suspect_or_victim_four') == "Suspect"){
                     echo 'suspect';
                  }
                  if(get_field('suspect_or_victim_four') == "Victim"){
                     echo 'victim';
                  }
                ?>
                Details</h2>
              <table class="data-table">
                <?php if(get_field('gender_four')){ ?>
                <tr>
                  <th>Gender:</th>
                  <td><?php the_field('gender_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('sv_title_four')){ ?>
                <tr>
                  <th>Race:</th>
                  <td><?php the_field('sv_title_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('weight_lbs_four')){ ?>
                <tr>
                  <th>Weight:</th>
                  <td><?php the_field('weight_lbs_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('height_feet_four') ){ ?>
                <tr>
                  <th>Height:</th>
                  <td><?php the_field('height_feet_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_color_four') ){ ?>
                <tr>
                  <th>Hair Color:</th>
                  <td><?php the_field('hair_color_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_type_four') ){ ?>
                <tr>
                  <th>Hair Type:</th>
                  <td><?php the_field('hair_type_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_length_four') ){ ?>
                <tr>
                  <th>Hair Length:</th>
                  <td><?php the_field('hair_length_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('sv_date_of_birth_four') ){ ?>
                <tr>
                  <th>Date of Birth:</th>
                  <td>
                      <?php
                        $datesv = get_field('sv_date_of_birth_four');
                        $ysv = substr($datesv, 0, 4);
                        $msv = substr($datesv, 4, 2);
                        $dsv = substr($datesv, 6, 2);
                        $timesv = strtotime("{$dsv}-{$msv}-{$ysv}");
                        echo date('m/d/Y', $timesv);
                      ?>
                  </td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_color_four') ){ ?>
                <tr>
                  <th>Eye Color:</th>
                  <td><?php the_field('eye_color_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_description_four') ){ ?>
                <tr>
                  <th>Eye Description:</th>
                  <td><?php the_field('eye_description_four'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('precinct_crime_four') ){ ?>
                <tr>
                  <th>Precinct:</th>
                  <td><?php the_field('precinct_crime_four'); ?></td>
                </tr>
                <?php } ?>

              </table>
            </div>
        <?php } ?>


        <?php
          if(get_field('suspect_or_victim_five') == ""){
              echo '';
          } else {  ?>
            <div class="crime-detail__specs__block">
              <?php 
                $image_five = get_field('suspect_victim_image_five');
                if( !empty($image_five) ){  ?>
                  <img class="card__photo__img" src="<?php echo $image_five['url']; ?>" alt="<?php echo $image_five['alt']; ?>" />
              <?php } ?>
              <br>
              <h2 class="crime-detail__heading">
                <?php
                  if(get_field('suspect_or_victim_five') == "Suspect"){
                     echo 'suspect';
                  }
                  if(get_field('suspect_or_victim_five') == "Victim"){
                     echo 'victim';
                  }
                ?>
                Details</h2>
              <table class="data-table">
                <?php if(get_field('gender_five')){ ?>
                <tr>
                  <th>Gender:</th>
                  <td><?php the_field('gender_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('sv_title_five')){ ?>
                <tr>
                  <th>Race:</th>
                  <td><?php the_field('sv_title_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if(get_field('weight_lbs_five')){ ?>
                <tr>
                  <th>Weight:</th>
                  <td><?php the_field('weight_lbs_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('height_feet_five') ){ ?>
                <tr>
                  <th>Height:</th>
                  <td><?php the_field('height_feet_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_color_five') ){ ?>
                <tr>
                  <th>Hair Color:</th>
                  <td><?php the_field('hair_color_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_type_five') ){ ?>
                <tr>
                  <th>Hair Type:</th>
                  <td><?php the_field('hair_type_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('hair_length_five') ){ ?>
                <tr>
                  <th>Hair Length:</th>
                  <td><?php the_field('hair_length_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('sv_date_of_birth_five') ){ ?>
                <tr>
                  <th>Date of Birth:</th>
                  <td>
                      <?php
                        $datesv = get_field('sv_date_of_birth_five');
                        $ysv = substr($datesv, 0, 4);
                        $msv = substr($datesv, 4, 2);
                        $dsv = substr($datesv, 6, 2);
                        $timesv = strtotime("{$dsv}-{$msv}-{$ysv}");
                        echo date('m/d/Y', $timesv);
                      ?>
                  </td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_color_five') ){ ?>
                <tr>
                  <th>Eye Color:</th>
                  <td><?php the_field('eye_color_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('eye_description_five') ){ ?>
                <tr>
                  <th>Eye Description:</th>
                  <td><?php the_field('eye_description_five'); ?></td>
                </tr>
                <?php } ?>

                <?php if( get_field('precinct_crime_five') ){ ?>
                <tr>
                  <th>Precinct:</th>
                  <td><?php the_field('precinct_crime_five'); ?></td>
                </tr>
                <?php } ?>

              </table>
            </div>
        <?php } ?>




      </div>

      <div class="crime-detail__content">

        <div class="crime-detail__content__block crime-detail__content__block--description">

          <h2 class="crime-detail__heading">Description</h2>

          <?php the_content(); ?>

        </div>

        <?php if( get_field('crime_location') ): ?>
          <div class="crime-detail__content__block crime-detail__content__block--location">

            <h2 class="crime-detail__heading">Location</h2>

            <?php
              $add = get_field('crime_location'); 
            ?>

            <script type="text/javascript">

              var geocoder;
              var map;
              var address = <?php echo json_encode($add) ?>;

              function initialize() {

                geocoder = new google.maps.Geocoder();
                var latlng = new google.maps.LatLng(-34.397, 150.644);
                var myOptions = {
                  zoom: 12,
                  center: latlng,
                  scrollwheel: false,
                  mapTypeControl: true,
                  mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                  },
                  navigationControl: true,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

                if (geocoder) {
                  geocoder.geocode({
                    'address': address
                  }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                        map.setCenter(results[0].geometry.location);

                        var infowindow = new google.maps.InfoWindow({
                          content: '<strong>' + address + '</strong>',
                          size: new google.maps.Size(150, 50)
                        });

                        var marker = new google.maps.Marker({
                          position: results[0].geometry.location,
                          map: map,
                          title: address
                        });
                        google.maps.event.addListener(marker, 'click', function() {
                          infowindow.open(map, marker);
                        });

                      } else {
                        //alert("No results found");
                      }
                    } else {
                      //alert("Geocode was not successful for the following reason: " + status);
                    }
                  });
                }
              }
              google.maps.event.addDomListener(window, 'load', initialize);

            </script>

            <div class="crime-detail__map" id="map_canvas"></div>

          </div>
        <?php endif; ?>

        <?php if( get_field('video_url') ): ?>
          <div class="crime-detail__content__block crime-detail__content__block--videos">

            <h2 class="crime-detail__heading">Videos</h2>

            <div class="crime-detail__content__block__video">
               <?php
                $iframe = get_field('video_url', false, false);
                preg_match('/src="(.+?)"/', $iframe, $matches);
                $src = $matches[1];              
       
                    if (get_field('video_format') == 'Youtube'){

                        echo wp_oembed_get( get_field( 'video_url' ) ); 

                      }elseif(get_field('video_format') == 'Other'){ ?>

                       <iframe src="<?php echo $src; ?>" ></iframe> 
               
                     <?php }else{

                        $thevid = get_field('video_url');
                        echo $thevid;
                      }
                  ?>
            </div>

          </div>
        <?php endif; 

          $attachments = get_attached_media( 'image', $post->ID );

          if ($attachments != null ) {
         
        ?>

        <div class="crime-detail__content__block crime-detail__content__block--photos">

          <h2 class="crime-detail__heading">Photos</h2>

          <ul class="crime-detail__photos">

            <?php
          
              foreach($attachments as $attachment) {
                $img_full = wp_get_attachment_url($attachment->ID);
                $img = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
                //Now you can output any HTML you want to make it work
                if($img !== false) {
              ?>
              <li class="crime-detail__photos__item">
                <div class="crime-detail__photos__item__container">
                  <a href="<?php echo $img_full; ?>" rel="crime-photos" title="<?php echo $attachment->post_title; ?>">
                    <img src="<?php echo $img[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
                  </a>
                </div>
              </li>
            <?php }} ?>

          </ul>

        </div>
        <?php } ?>

      </div>

      <div class="crime-detail__share">

        <h2 class="crime-detail__heading">Share this page</h2>

        <ul class="share">
          <li class="share__item">
            <a class="share__item__link share__item__link--twitter" href="http://twitter.com/share? target='_blank' ">Share on Twitter</a>
          </li>
          <li class="share__item">
            <a class="share__item__link share__item__link--facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?> target='_blank' ">Share on Facebook</a>
          </li>
          <li class="share__item">
            <a class="share__item__link share__item__link--gplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>">Share on Google+</a>
          </li>
          <li class="share__item">
            <a class="share__item__link share__item__link--email" href="mailto:?body=<?php the_permalink(); ?>">Email</a>
          </li>
          <li class="share__item">
            <a class="share__item__link share__item__link--print" href="javascript:window.print()">Print</a>
          </li>
        </ul>

      </div>

    </div>

  </div>

  <?php endwhile; ?>
  <?php else : ?>
  <?php endif; ?>

</main>	
<?php get_footer(); ?>