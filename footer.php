 </div>

  </div>
  <footer class="footer" role="contentinfo">
    <div class="footer__primary">
      <div class="wrapper">
        <div class="footer__primary__callout">
          <p>Your City. <span>Your Call.</span></p>
        </div>
        <!-- hcard microformatting -->
        <div class="footer__primary__contact hcard">
          <a class="fn org url sr-only" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span class="organization-name">NYPD Crime Stoppers</span>
          </a>
          <p class="footer__primary__contact__phone tel">
            <span class="value">1-800-577-TIPS</span>
          </p>
          <p class="footer__primary__contact__phone--alt">(1-800-577-8477)</p>
        </div>
      </div>
    </div>
    <div class="footer__secondary">
      <div class="wrapper">
        <div class="footer__secondary__content">
          <a class="footer__nypd-logo" href="/">NYPD</a>
          <nav class="footer__nav">
            <ul class="footer__nav__list footer__nav__list--primary">
              <li class="footer__nav__item">
                <a class="footer__nav__item__link" href="<?php echo esc_url( home_url( '/cases' ) ); ?>">Wanted</a>
              </li>
              <li class="footer__nav__item">
                <a class="footer__nav__item__link" href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">About</a>
              </li>
              <li class="footer__nav__item">
                <a class="footer__nav__item__link" data-modal="tip-modal" href="<?php echo esc_url( home_url( '/submit-tip' ) ); ?>">Submit a Tip</a>
              </li>
            </ul>
            <?php 
                  $defaults = array(
                    'theme_location'  => '',
                    'menu'            => '',
                    'container'       => false,
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'footer__nav__item',
                    'menu_id'         => 'footer__nav__item"',
                    'echo'            => true,
                    'fallback_cb'     => false,
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul class="footer__nav__list footer__nav__list--secondary">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => ''
                  );
                  wp_nav_menu( $defaults );
                  ?>
          </nav>
          <ul class="footer__social share">
            <li class="share__item">
              <a class="share__item__link share__item__link--facebook" href="https://www.facebook.com/NYPD?rf=114659601879209" target="_blank">Facebook</a>
            </li>
            <li class="share__item">
              <a class="share__item__link share__item__link--twitter" href="http://twitter.com/NYPDnews" target="_blank">Twitter</a>
            </li>
            <li class="share__item">
              <a class="share__item__link share__item__link--youtube" href="http://www.youtube.com/user/insideNYPD" target="_blank">YouTube</a>
            </li>
            <li class="share__item">
              <a class="share__item__link share__item__link--instagram" href="http://instagram.com/nypd/" target="_blank">Instagram</a>
            </li>
          </ul>

        </div>

        <div class="footer__secondary__content">

          <a class="footer__nyc-logo" href="/">NYC</a>

          <div class="footer__copyright">

            <p>NYC is a trademark and service mark of the City of New York</p>

            <p>&copy; City of New York. 2015 All Rights Reserved</p>

          </div>
          

        </div>

      </div>

    </div>

  </footer>

  <?php
    // only pushes data through form "post" request
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $typeofcrime      = trim($_POST['type_of_crime']);
      $descof           = trim($_POST['about']);
      $title_tip        = trim($_POST['subject']);
      if ($descof == "Choose") {
          $descof = null;
      }
      if ($typeofcrime == "Choose") {
          $typeofcrime = null;
      }
      $post_information = array(

        'post_title'   => wp_strip_all_tags( $title_tip ), // setting tip number as subject
        'post_name'   => wp_unique_post_slug( sanitize_title( $title_tip ) ),
        'post_type'    => 'tips',
        'post_status'  => 'Private',
        'post_content' =>  $_POST['tipRefID'],
        'tax_input' => array( 'tips_cat'=> $typeofcrime, 'tips_desc'=> $descof) 

      );

    if( ! empty( $title_tip ) ) {
      if( isset($title_tip) ){ 


           $post_if = $wpdb->get_var("SELECT count(post_title)
                                       FROM $wpdb->posts
                                       WHERE post_title like ''
                                       AND $wpdb->posts.post_type = 'tips'");
            if(!isset($post_if)){
               
            } else { 

              //if (!get_page_by_title($title_tip, 'OBJECT', 'tips')){ 
                  $post_id = wp_insert_post( $post_information, true );
             // }

            }
        //wp_update_post( $post_information, true );
        //Tax start
        wp_set_object_terms( $post_id, $typeofcrime, 'tips_cat' );
        wp_set_object_terms( $post_id, $descof, 'tips_desc' );
        // Passed Crime ID ?
        $crime_id = "crime_id";
        $crime_data = $_POST['tipRefID'];   
        update_field( $crime_id, $crime_data, $post_id);

      }
    }

  }
  
  ?>

  <form id="tip-cards-holder" method="post" action="/" class="tip-cards tip-cards--hidden">

    <div class="tip-cards__track">

      <!-- card | Intro -->
      <div class="tip-card tip-card--intro">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <p>If at any point you would like to speak with a detective, please call our tips hotline. We are available 24/7 and calls are always anonymous.</p>
          <div class="tip-card__crime-note">
            <p>If there is a crime currently in progress, please exit this form and dial <span>9-1-1</span> immediately</p>
          </div>
        </div> 
        <div class="tip-card__buttons">
          <button class="btn tip-card__button" type="button" data-card-direction="next">Continue to Form &rsaquo;</button>
        </div>
      </div>

      <!-- card | What type of crime was committed-->
      <div class="tip-card tip-card--required">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">What type of crime was committed?</h3>
          <div class="tip-card__fieldset">
            <div class="field select field--required">
              <label class="select__label" for="input-type-of-crime">Type of Crime</label>
              <select class="select__input" id="input-type-of-crime" name="type_of_crime">
               <option>Choose</option>
                <?php
                    $tax = 'tips_cat';
                    $terms = get_terms( $tax, ['hide_empty' => false]);

                    foreach( $terms as $term ) {
                      echo '<option value="' .  $term->name . '">' . $term->name . '</option>';
                    }
                ?>
              </select>
            </div>
            <div class="field select">
              <h4 class="tip-card__field-title">This is about...</h4>
              <label class="select__label" for="input-this-is-about">This is about...</label>
              <select class="select__input" id="input-this-is-about" name="about">
                <option>Choose</option>
                <?php
                    $tax_desc = 'tips_desc';
                    $terms_desc = get_terms( $tax_desc, ['hide_empty' => false]);

                    foreach( $terms_desc as $term_desc ) { 

                        echo '<option value="' .  $term_desc->name . '">' . $term_desc->name . '</option>';

                } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <p class="tip-card__required">* required field</p>
        </div>
      </div>

       <!-- card | How do you know about the crime -->
       <?php

         $tip_crime_knowledge_field = "tip_crime_knowledge";
         $tip_crime_knowledge = $_POST['tip_crime_knowledge'];
         update_field( $tip_crime_knowledge_field, $tip_crime_knowledge, $post_id );

         $tip_url_source_field = "tip_url_source";
         $tip_url_source = $_POST['tip_url_source'];
         update_field( $tip_url_source_field, $tip_url_source, $post_id );

       ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">How do you know about the crime?</h3>
          <div class="tip-card__fieldset">
            <div class="field select">
              <label class="select__label" for="input-knowledge-of-crime">Knowledge of crime</label>
              <select class="select__input" id="input-knowledge-of-crime" name="tip_crime_knowledge[]">
                <option>Choose</option>
                <option value="I saw it" >I saw it</option>
                <option value="I have information about it" >I have information about it</option>
                <option value="From a News Report" >From a News Report</option>
              </select>
            </div>
            <div class="field">
              <label class="field__label" for="input-url-source">URL source</label>
              <input class="field__input" id="input-url-source" name="tip_url_source" type="text" placeholder="Enter URL if available"/>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does suspect have an alias or nickname -->
      <?php

        $tip_know_suspect_alias_field = "tip_know_suspect_alias";
        $tip_know_suspect_alias = $_POST['tip_know_suspect_alias'];
        update_field( $tip_know_suspect_alias_field, $tip_know_suspect_alias, $post_id );

        $tip_suspect_alias_field = "tip_suspect_alias";
        $tip_suspect_alias = $_POST['tip_suspect_alias'];
        update_field( $tip_suspect_alias_field, $tip_suspect_alias, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person have an alias? Or nickname?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-alias-yes" type="radio" value="yes" name="tip_know_suspect_alias"/>
                <label class="radio__label" for="input-alias-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-alias-no" type="radio" value="no" name="tip_know_suspect_alias"/>
                <label class="radio__label" for="input-alias-no">No</label>
              </div>
            </div>
            <div class="field field--hidden" data-hidden-el="true">
              <label class="field__label" for="input-suspect-alias-nickname">Person's alias or nickname</label>
              <input class="field__input" id="input-suspect-alias-nickname" name="tip_suspect_alias" type="text" placeholder="Enter Alias or Nickname"/>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Do you know the suspect's name-->
      <?php

        $tip_suspect_name_field = "tip_suspect_name";
        $tip_suspect_name = $_POST['tip_suspect_name'];
        update_field( $tip_suspect_name_field, $tip_suspect_name, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Do you know this person's name?</h3>
          <div class="tip-card__fieldset">
            <div class="field">
              <label class="field__label" for="input-suspect-name">Person's name</label>
              <input class="field__input" id="input-suspect-name" name="tip_suspect_name" type="text" placeholder="Enter Name"/>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Do you have video footage of the crime -->
      <?php

        $tip_has_video_footage_field = "tip_has_video_footage";
        $tip_has_video_footage = $_POST['tip_has_video_footage'];
        update_field( $tip_has_video_footage_field, $tip_has_video_footage, $post_id );

        $tip_video_footage_url_field = "tip_video_footage_url";
        $tip_video_footage_url = $_POST['tip_video_footage_url'];
        update_field( $tip_video_footage_url_field, $tip_video_footage_url, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Do you have any video footage of the crime?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-video-footage-yes" type="radio" value="yes" name="tip_has_video_footage"/>
                <label class="radio__label" for="input-video-footage-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-video-footage-no" type="radio" value="no" name="tip_has_video_footage"/>
                <label class="radio__label" for="input-video-footage-no">No</label>
              </div>
            </div>
            <div class="field field--hidden" data-hidden-el="true">
              <label class="field__label" for="input-video-footage-url">URL</label>
              <input class="field__input" id="input-video-footage-url" name="tip_video_footage_url" type="text" placeholder="Enter URL"/>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Do you know where the suspect lives -->
      <?php

        $tip_know_suspect_address_field = "tip_know_suspect_address";
        $tip_know_suspect_address = $_POST['tip_know_suspect_address'];
        update_field( $tip_know_suspect_address_field, $tip_know_suspect_address, $post_id );

        $tip_suspect_address_field = "tip_suspect_address";
        $tip_suspect_address = $_POST['tip_suspect_address'];
        update_field( $tip_suspect_address_field, $tip_suspect_address, $post_id );

        $tip_suspect_city_field = "tip_suspect_city";
        $tip_suspect_city = $_POST['tip_suspect_city'];
        update_field( $tip_suspect_city_field, $tip_suspect_city, $post_id );

        $tip_suspect_state_field = "tip_suspect_state";
        $tip_suspect_state = $_POST['tip_suspect_state'];
        update_field( $tip_suspect_state_field, $tip_suspect_state, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Do you know where this person lives?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-address-yes" type="radio" value="yes" name="tip_know_suspect_address"/>
                <label class="radio__label" for="input-address-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-address-no" type="radio" value="no" name="tip_know_suspect_address"/>
                <label class="radio__label" for="input-address-no">No</label>
              </div>
            </div>
            <div class="fields fields--hidden" data-hidden-el="true">
              <div class="field">
                <label class="field__label" for="input-suspect-address-location">Address/Location</label>
                <input class="field__input" id="input-suspect-address-location" name="tip_suspect_address" type="text" placeholder="Address/Location" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-address-city">City</label>
                <input class="field__input" id="input-suspect-address-city" name="tip_suspect_city" type="text" placeholder="City" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-address-state">State</label>
                <input class="field__input" id="input-suspect-address-state" name="tip_suspect_state" type="text" placeholder="State" />
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>
        </div>
      </div>

       <!-- card | Do you know how to contact the suspect -->
       <?php

         $tip_know_how_contact_suspect_field = "tip_know_how_contact_suspect";
         $tip_know_how_contact_suspect = $_POST['tip_know_how_contact_suspect'];
         update_field( $tip_know_how_contact_suspect_field, $tip_know_how_contact_suspect, $post_id );

         $tip_suspect_email_field = "tip_suspect_email";
         $tip_suspect_email = $_POST['tip_suspect_email'];
         update_field( $tip_suspect_email_field, $tip_suspect_email, $post_id );

         $tip_suspect_phone_field = "tip_suspect_phone";
         $tip_suspect_phone = $_POST['tip_suspect_phone'];
         update_field( $tip_suspect_phone_field, $tip_suspect_phone, $post_id );

       ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Do you know how to contact this person?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-contact-suspect-yes" value="yes" type="radio" name="tip_know_how_contact_suspect"/>
                <label class="radio__label" for="input-contact-suspect-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-contact-suspect-no" value="no" type="radio" name="tip_know_how_contact_suspect"/>
                <label class="radio__label" for="input-contact-suspect-no">No</label>
              </div>
            </div>
            <div class="fields fields--hidden" data-hidden-el="true">
              <div class="field">
                <label class="field__label" for="input-suspect-email-address">Email Address</label>
                <input class="field__input" id="input-suspect-email-address" name="tip_suspect_email" type="text" placeholder="Email Address" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-phone-number">Phone Number</label>
                <input class="field__input" id="input-suspect-phone-number" name="tip_suspect_phone" type="text" placeholder="Phone Number" />
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>
          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect use any social media -->
      <?php

        $tip_suspect_use_social_media_field = "tip_suspect_use_social_media";
        $tip_suspect_use_social_media = $_POST['tip_suspect_use_social_media'];
        update_field( $tip_suspect_use_social_media_field, $tip_suspect_use_social_media, $post_id );

        $tip_social_media_site_1_field = "tip_social_media_site_1";
        $tip_social_media_site_1 = $_POST['tip_social_media_site_1'];
        update_field( $tip_social_media_site_1_field, $tip_social_media_site_1, $post_id );

        $tip_social_media_site_1_link_field = "tip_social_media_site_1_link";
        $tip_social_media_site_1_link = $_POST['tip_social_media_site_1_link'];
        update_field( $tip_social_media_site_1_link_field, $tip_social_media_site_1_link, $post_id );

        $tip_social_media_site_2_field = "tip_social_media_site_2";
        $tip_social_media_site_2 = $_POST['tip_social_media_site_2'];
        update_field( $tip_social_media_site_2_field, $tip_social_media_site_2, $post_id );

        $tip_social_media_site_2_link_field = "tip_social_media_site_2_link";
        $tip_social_media_site_2_link = $_POST['tip_social_media_site_2_link'];
        update_field( $tip_social_media_site_2_link_field, $tip_social_media_site_2_link, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person use any social media?</h3>
          <div class="tip-card__fieldset tip-card__fieldset--wide">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-use-social-media-yes" type="radio" value="yes" name="tip_suspect_use_social_media"/>
                <label class="radio__label" for="input-suspect-use-social-media-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-use-social-media-no" type="radio" value="no" name="tip_suspect_use_social_media"/>
                <label class="radio__label" for="input-suspect-use-social-media-no">No</label>
              </div>
            </div>
            <div class="fields--hidden" data-hidden-el="true">

              <div class="fields fields--replicable">

                <div class="field">

                  <label class="field__label">Social platform</label>

                  <select class="select__input" name="tip_social_media_site_1[]">
                    <option>Choose</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Other">Other</option>
                  </select>

                </div>

                <div class="field">

                  <label class="field__label">Link or Username</label>

                  <input class="field__input" name="tip_social_media_site_1_link" type="text" placeholder="Link or Username" />

                </div>

              </div>

              <div class="fields fields--replicable">

                <div class="field">

                  <label class="field__label">Social platform</label>

                  <select class="select__input" name="tip_social_media_site_2[]">
                    <option>Choose</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Other">Other</option>
                  </select>

                </div>

                <div class="field">

                  <label class="field__label">Link or Username</label>

                  <input class="field__input" name="tip_social_media_site_2_link" type="text" placeholder="Link or Username" />

                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="tip-card__buttons tip-card__buttons--split">

          <button class="btn tip-card__button tip-card__button--prev" type="button" data-card-direction="previous">Back</button>

          <button class="btn tip-card__button tip-card__button--next" type="button" data-card-direction="next">Next</button>

        </div>

        <div class="tip-card__footer">

          <button class="btn tip-card__button tip-card__button--text" type="button" data-card-direction="next">Skip This Question &rsaquo;</button>

        </div>
      </div>

      <!-- card | Is the suspect employed -->
      <?php

        $tip_suspect_employed_field = "tip_suspect_employed";
        $tip_suspect_employed = $_POST['tip_suspect_employed'];
        update_field( $tip_suspect_employed_field, $tip_suspect_employed, $post_id );

        $tip_suspect_employment_location_field = "tip_suspect_employment_location";
        $tip_suspect_employment_location = $_POST['tip_suspect_employment_location'];
        update_field( $tip_suspect_employment_location_field, $tip_suspect_employment_location, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Is this person employed?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-employed-yes" type="radio" name="tip_suspect_employed" value="yes"/>
                <label class="radio__label" for="input-suspect-employed-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide" id="input-suspect-employed-no" type="radio" name="tip_suspect_employed" value="no"/>
                <label class="radio__label" for="input-suspect-employed-no">No</label>
              </div>
            </div>
            <div class="field field--hidden" data-hidden-el="true">
              <label class="field__label" for="input-suspect-employment-location">Location</label>
              <input class="field__input" id="input-suspect-employment-location" name="tip_suspect_employment_location" type="text" placeholder="Enter Location"/>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Can you describe the suspect -->
      <?php

        $tip_describe_suspect_field = "tip_describe_suspect";
        $tip_describe_suspect = $_POST['tip_describe_suspect'];
        update_field( $tip_describe_suspect_field, $tip_describe_suspect, $post_id );

        $tip_suspect_description_age_field = "tip_suspect_description_age";
        $tip_suspect_description_age = $_POST['tip_suspect_description_age'];
        update_field( $tip_suspect_description_age_field, $tip_suspect_description_age, $post_id );

        $tip_suspect_description_gender_field = "tip_suspect_description_gender";
        $tip_suspect_description_gender = $_POST['tip_suspect_description_gender'];
        update_field( $tip_suspect_description_gender_field, $tip_suspect_description_gender, $post_id );

        $tip_suspect_description_race_field = "tip_suspect_description_race";
        $tip_suspect_description_race = $_POST['tip_suspect_description_race'];
        update_field( $tip_suspect_description_race_field, $tip_suspect_description_race, $post_id );

        $tip_suspect_description_hair_color_field = "tip_suspect_description_hair_color";
        $tip_suspect_description_hair_color = $_POST['tip_suspect_description_hair_color'];
        update_field( $tip_suspect_description_hair_color_field, $tip_suspect_description_hair_color, $post_id );

        $tip_suspect_description_hair_type_field = "tip_suspect_description_hair_type";
        $tip_suspect_description_hair_type = $_POST['tip_suspect_description_hair_type'];
        update_field( $tip_suspect_description_hair_type_field, $tip_suspect_description_hair_type, $post_id );

        $tip_suspect_description_eye_color_field = "tip_suspect_description_eye_color";
        $tip_suspect_description_eye_color = $_POST['tip_suspect_description_eye_color'];
        update_field( $tip_suspect_description_eye_color_field, $tip_suspect_description_eye_color, $post_id );

        $tip_suspect_description_height_field = "tip_suspect_description_height";
        $tip_suspect_description_height = $_POST['tip_suspect_description_height'];
        update_field( $tip_suspect_description_height_field, $tip_suspect_description_height, $post_id );

        $tip_suspect_description_weight_field = "tip_suspect_description_weight";
        $tip_suspect_description_weight = $_POST['tip_suspect_description_weight'];
        update_field( $tip_suspect_description_weight_field, $tip_suspect_description_weight, $post_id );

        $tip_suspect_description_dob_field = "tip_suspect_description_dob";
        $tip_suspect_description_dob = $_POST['tip_suspect_description_dob'];
        update_field( $tip_suspect_description_dob_field, $tip_suspect_description_dob, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Can you describe this person?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-description-yes" type="radio" name="tip_describe_suspect" value="yes"/>
                <label class="radio__label" for="input-suspect-description-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-description-no" type="radio" name="tip_describe_suspect" value="no"/>
                <label class="radio__label" for="input-suspect-description-no">No</label>
              </div>
            </div>
            <div class="fields fields--hidden" data-hidden-el="true">
              <div class="field">
                <label class="field__label" for="input-suspect-description-age">Age</label>
                <input class="field__input" id="input-suspect-description-age" name="tip_suspect_description_age" type="text" placeholder="Age" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-gender">Gender</label>
                <select class="select__input" id="input-suspect-description-gender" name="tip_suspect_description_gender[]">
                  <option>Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-race">Race</label>
                <input class="field__input" id="input-suspect-description-race" name="tip_suspect_description_race" type="text" placeholder="Race" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-hair-color">Hair Color</label>
                <input class="field__input" id="input-suspect-description-hair-color" name="tip_suspect_description_hair_color" type="text" placeholder="Hair Color" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-hair-type">Hair Type</label>
                <input class="field__input" id="input-suspect-description-hair-type" name="tip_suspect_description_hair_type" type="text" placeholder="Hair Type" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-eye-color">Eye Color</label>
                <input class="field__input" id="input-suspect-description-eye-color" name="tip_suspect_description_eye_color" type="text" placeholder="Eye Color" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-height">Height</label>
                <input class="field__input" id="input-suspect-description-height" name="tip_suspect_description_height" type="text" placeholder="Height" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-weight">Weight</label>
                <input class="field__input" id="input-suspect-description-weight" name="tip_suspect_description_weight" type="text" placeholder="Weight" />

              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-description-dob">Date of Birth</label>
                <input class="field__input" id="input-suspect-description-dob" name="tip_suspect_description_dob" type="text" placeholder="Date of Birth" />
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Where does the suspect hang out -->
      <?php

        $tip_suspect_hang_out_address_field = "tip_suspect_hang_out_address";
        $tip_suspect_hang_out_address = $_POST['tip_suspect_hang_out_address'];
        update_field( $tip_suspect_hang_out_address_field, $tip_suspect_hang_out_address, $post_id );

        $tip_suspect_hang_out_city_field = "tip_suspect_hang_out_city";
        $tip_suspect_hang_out_city = $_POST['tip_suspect_hang_out_city'];
        update_field( $tip_suspect_hang_out_city_field, $tip_suspect_hang_out_city, $post_id );

        $tip_suspect_hang_out_state_field = "tip_suspect_hang_out_state";
        $tip_suspect_hang_out_state = $_POST['tip_suspect_hang_out_state'];
        update_field( $tip_suspect_hang_out_state_field, $tip_suspect_hang_out_state, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Where does this person hang out?</h3>
          <div class="tip-card__fieldset">
            <div class="field">
              <label class="field__label" for="input-suspect-hangout-address-location">Address/Location</label>
              <input class="field__input" id="input-suspect-hangout-address-location" name="tip_suspect_hang_out_address" type="text" placeholder="Address/Location" />
            </div>
            <div class="field">
              <label class="field__label" for="input-suspect-hangout-city">City</label>
              <input class="field__input" id="input-suspect-hangout-city" name="tip_suspect_hang_out_city" type="text" placeholder="City" />
            </div>
            <div class="field">
              <label class="field__label" for="input-suspect-hangout-state">State</label>
              <input class="field__input" id="input-suspect-hangout-state" name="tip_suspect_hang_out_state" type="text" placeholder="State" />
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect have any gang affiliation -->
      <?php

        $tip_suspect_gang_affiliated_field = "tip_suspect_gang_affiliated";
        $tip_suspect_gang_affiliated = $_POST['tip_suspect_gang_affiliated'];
        update_field( $tip_suspect_gang_affiliated_field, $tip_suspect_gang_affiliated, $post_id );

        $tip_suspect_gang_name_field = "tip_suspect_gang_name";
        $tip_suspect_gang_name = $_POST['tip_suspect_gang_name'];
        update_field( $tip_suspect_gang_name_field, $tip_suspect_gang_name, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person have any gang affiliation?</h3>

          <div class="tip-card__fieldset">

            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-gang-affiliated-yes" type="radio" name="tip_suspect_gang_affiliated" value="yes"/>
                <label class="radio__label" for="input-suspect-gang-affiliated-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide" id="input-suspect-gang-affiliated-no" type="radio" name="tip_suspect_gang_affiliated" value="no"/>
                <label class="radio__label" for="input-suspect-gang-affiliated-no">No</label>
              </div>
            </div>

            <div class="field field--hidden" data-hidden-el="true">
              <label class="field__label" for="input-suspect-gang-name">Gang name</label>
              <input class="field__input" id="input-suspect-gang-name" name="tip_suspect_gang_name" type="text" placeholder="Gang name"/>
            </div>
          </div>

        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect carry weapons -->
      <?php

        $tip_suspect_carry_weapons_field = "tip_suspect_carry_weapons";
        $tip_suspect_carry_weapons = $_POST['tip_suspect_carry_weapons'];
        update_field( $tip_suspect_carry_weapons_field, $tip_suspect_carry_weapons, $post_id );

        $tip_suspect_type_of_weapon_carried_field = "tip_suspect_type_of_weapon_carried";
        $tip_suspect_type_of_weapon_carried = $_POST['tip_suspect_type_of_weapon_carried'];
        update_field( $tip_suspect_type_of_weapon_carried_field, $tip_suspect_type_of_weapon_carried, $post_id );

        $tip_suspect_carried_weapon_location_field = "tip_suspect_carried_weapon_location";
        $tip_suspect_carried_weapon_location = $_POST['tip_suspect_carried_weapon_location'];
        update_field( $tip_suspect_carried_weapon_location_field, $tip_suspect_carried_weapon_location, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person carry any weapons?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-carries-weapons-yes" type="radio" name="tip_suspect_carry_weapons" value="yes"/>
                <label class="radio__label" for="input-suspect-carries-weapons-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-carries-weapons-no" type="radio" name="tip_suspect_carry_weapons" value="no"/>
                <label class="radio__label" for="input-suspect-carries-weapons-no">No</label>
              </div>
            </div>
            <div class="fields fields--hidden" data-hidden-el="true">
              <div class="field">
                <label class="field__label" for="input-suspect-type-of-weapon">Type of Weapon</label>
                <input class="field__input" id="input-suspect-type-of-weapon" name="tip_suspect_type_of_weapon_carried" type="text" placeholder="Type of Weapon" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-weapon-location">Where is it carried?</label>
                <input class="field__input" id="input-suspect-weapon-location" name="tip_suspect_carried_weapon_location" type="text" placeholder="Where is it carried?" />

              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Do you know any friends (or family) of the suspect -->
      <?php

        $tip_know_suspect_friends_or_family_field = "tip_know_suspect_friends_or_family";
        $tip_know_suspect_friends_or_family = $_POST['tip_know_suspect_friends_or_family'];
        update_field( $tip_know_suspect_friends_or_family_field, $tip_know_suspect_friends_or_family, $post_id );

        $tip_suspect_friend_family_1_name_field = "tip_suspect_friend_family_1_name";
        $tip_suspect_friend_family_1_name = $_POST['tip_suspect_friend_family_1_name'];
        update_field( $tip_suspect_friend_family_1_name_field, $tip_suspect_friend_family_1_name, $post_id );

        $tip_suspect_friend_family_1_relationship_field = "tip_suspect_friend_family_1_relationship";
        $tip_suspect_friend_family_1_relationship = $_POST['tip_suspect_friend_family_1_relationship'];
        update_field( $tip_suspect_friend_family_1_relationship_field, $tip_suspect_friend_family_1_relationship, $post_id );

        $tip_suspect_friend_family_2_name_field = "tip_suspect_friend_family_2_name";
        $tip_suspect_friend_family_2_name = $_POST['tip_suspect_friend_family_2_name'];
        update_field( $tip_suspect_friend_family_2_name_field, $tip_suspect_friend_family_2_name, $post_id );

        $tip_suspect_friend_family_2_relationship_field = "tip_suspect_friend_family_2_relationship";
        $tip_suspect_friend_family_2_relationship = $_POST['tip_suspect_friend_family_2_relationship'];
        update_field( $tip_suspect_friend_family_2_relationship_field, $tip_suspect_friend_family_2_relationship, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Do you know any friends (or family) of this person?</h3>
          <div class="tip-card__fieldset tip-card__fieldset--wide">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-knows-suspect-friends-or-family-yes" type="radio" name="tip_know_suspect_friends_or_family" value="yes"/>
                <label class="radio__label" for="input-knows-suspect-friends-or-family-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-knows-suspect-friends-or-family-no" type="radio" name="tip_know_suspect_friends_or_family" value="no"/>
                <label class="radio__label" for="input-knows-suspect-friends-or-family-no">No</label>
              </div>
            </div>
            <div class="fields--hidden" data-hidden-el="true">
              <div class="fields fields--replicable">
                <div class="field">
                  <label class="field__label">Name</label>
                  <input class="field__input" name="tip_suspect_friend_family_1_name" type="text" placeholder="Name" />
                </div>
                <div class="field">
                  <label class="field__label">Relationship</label>
                  <input class="field__input" name="tip_suspect_friend_family_1_relationship" type="text" placeholder="Relationship" />
                </div>
              </div>
              <div class="fields fields--replicable" data-replicate-source>
                <div class="field">
                  <label class="field__label">Name</label>
                  <input class="field__input" name="tip_suspect_friend_family_2_name" type="text" placeholder="Name" />
                </div>
                <div class="field">
                  <label class="field__label">Relationship</label>
                  <input class="field__input" name="tip_suspect_friend_family_2_relationship" type="text" placeholder="Relationship" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect have any tattoos -->
      <?php

        $tip_suspect_has_tattoos_field = "tip_suspect_has_tattoos";
        $tip_suspect_has_tattoos = $_POST['tip_suspect_has_tattoos'];
        update_field( $tip_suspect_has_tattoos_field, $tip_suspect_has_tattoos, $post_id );

        $tip_suspect_tattoo_1_type_field = "tip_suspect_tattoo_1_type";
        $tip_suspect_tattoo_1_type = $_POST['tip_suspect_tattoo_1_type'];
        update_field( $tip_suspect_tattoo_1_type_field, $tip_suspect_tattoo_1_type, $post_id );

        $tip_suspect_tattoo_1_location_field = "tip_suspect_tattoo_1_location";
        $tip_suspect_tattoo_1_location = $_POST['tip_suspect_tattoo_1_location'];
        update_field( $tip_suspect_tattoo_1_location_field, $tip_suspect_tattoo_1_location, $post_id );

        $tip_suspect_tattoo_2_type_field = "tip_suspect_tattoo_2_type";
        $tip_suspect_tattoo_2_type = $_POST['tip_suspect_tattoo_2_type'];
        update_field( $tip_suspect_tattoo_2_type_field, $tip_suspect_tattoo_2_type, $post_id );

        $tip_suspect_tattoo_2_location_field = "tip_suspect_tattoo_2_location";
        $tip_suspect_tattoo_2_location = $_POST['tip_suspect_tattoo_2_location'];
        update_field( $tip_suspect_tattoo_2_location_field, $tip_suspect_tattoo_2_location, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person have any tattoos?</h3>
          <div class="tip-card__fieldset tip-card__fieldset--wide">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-has-tattoos-yes" type="radio" name="tip_suspect_has_tattoos" value="yes"/>
                <label class="radio__label" for="input-suspect-has-tattoos-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-has-tattoos-no" type="radio" name="tip_suspect_has_tattoos" value="no"/>
                <label class="radio__label" for="input-suspect-has-tattoos-no">No</label>
              </div>
            </div>
            <div class="fields--hidden" data-hidden-el="true">
              <div class="fields fields--replicable">
                <div class="field">
                  <label class="field__label">Type of Tattoo</label>
                  <input class="field__input" name="tip_suspect_tattoo_1_type" type="text" placeholder="Type of Tattoo" />
                </div>
                <div class="field">
                  <label class="field__label">Location of Tattoo</label>
                  <input class="field__input" name="tip_suspect_tattoo_1_location" type="text" placeholder="Location of Tattoo" />
                </div>
              </div>
              <div class="fields fields--replicable">
                <div class="field">
                  <label class="field__label">Type of Tattoo</label>
                  <input class="field__input" name="tip_suspect_tattoo_2_type" type="text" placeholder="Type of Tattoo" />
                </div>
                <div class="field">
                  <label class="field__label">Location of Tattoo</label>
                  <input class="field__input" name="tip_suspect_tattoo_2_location" type="text" placeholder="Location of Tattoo" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect have any scars -->
      <?php

        $tip_suspect_has_scars_field = "tip_suspect_has_scars";
        $tip_suspect_has_scars = $_POST['tip_suspect_has_scars'];
        update_field( $tip_suspect_has_scars_field, $tip_suspect_has_scars, $post_id );

        $tip_suspect_scar_1_type_field = "tip_suspect_scar_1_type";
        $tip_suspect_scar_1_type = $_POST['tip_suspect_scar_1_type'];
        update_field( $tip_suspect_scar_1_type_field, $tip_suspect_scar_1_type, $post_id );

        $tip_suspect_scar_1_location_field = "tip_suspect_scar_1_location";
        $tip_suspect_scar_1_location = $_POST['tip_suspect_scar_1_location'];
        update_field( $tip_suspect_scar_1_location_field, $tip_suspect_scar_1_location, $post_id );

        $tip_suspect_scar_2_type_field = "tip_suspect_scar_2_type";
        $tip_suspect_scar_2_type = $_POST['tip_suspect_scar_2_type'];
        update_field( $tip_suspect_scar_2_type_field, $tip_suspect_scar_2_type, $post_id );

        $tip_suspect_scar_2_location_field = "tip_suspect_scar_2_location";
        $tip_suspect_scar_2_location = $_POST['tip_suspect_scar_2_location'];
        update_field( $tip_suspect_scar_2_location_field, $tip_suspect_scar_2_location, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person have any scars?</h3>
          <div class="tip-card__fieldset tip-card__fieldset--wide">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-has-scars-yes" type="radio" name="tip_suspect_has_scars" value="yes"/>
                <label class="radio__label" for="input-suspect-has-scars-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-has-scars-no" type="radio" name="tip_suspect_has_scarss" value="no"/>
                <label class="radio__label" for="input-suspect-has-scars-no">No</label>
              </div>
            </div>
            <div class="fields--hidden" data-hidden-el="true">
              <div class="fields fields--replicable">
                <div class="field">
                  <label class="field__label">Type of Scar</label>
                  <input class="field__input" name="tip_suspect_scar_1_type" type="text" placeholder="Type of Scar" />
                </div>
                <div class="field">
                  <label class="field__label">Location of Scar</label>
                  <input class="field__input" name="tip_suspect_scar_1_location" type="text" placeholder="Location of Scar" />
                </div>
              </div>
              <div class="fields fields--replicable" data-replicate-source>
                <div class="field">
                  <label class="field__label">Type of Scar</label>
                  <input class="field__input" name="tip_suspect_scar_2_type" type="text" placeholder="Type of Scar" />
                </div>
                <div class="field">
                  <label class="field__label">Location of Scar</label>
                  <input class="field__input" name="tip_suspect_scar_2_location" type="text" placeholder="Location of Scar" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect drive a vehicle -->
      <?php

        $tip_suspect_drives_vehicle_field = "tip_suspect_drives_vehicle";
        $tip_suspect_drives_vehicle = $_POST['tip_suspect_drives_vehicle'];
        update_field( $tip_suspect_drives_vehicle_field, $tip_suspect_drives_vehicle, $post_id );

        $tip_suspect_vehicle_make_field = "tip_suspect_vehicle_make";
        $tip_suspect_vehicle_make = $_POST['tip_suspect_vehicle_make'];
        update_field( $tip_suspect_vehicle_make_field, $tip_suspect_vehicle_make, $post_id );

        $tip_suspect_vehicle_model_field = "tip_suspect_vehicle_model";
        $tip_suspect_vehicle_model = $_POST['tip_suspect_vehicle_model'];
        update_field( $tip_suspect_vehicle_model_field, $tip_suspect_vehicle_model, $post_id );

        $tip_suspect_vehicle_year_field = "tip_suspect_vehicle_year";
        $tip_suspect_vehicle_year = $_POST['tip_suspect_vehicle_year'];
        update_field( $tip_suspect_vehicle_year_field, $tip_suspect_vehicle_year, $post_id );

        $tip_suspect_vehicle_color_field = "tip_suspect_vehicle_color";
        $tip_suspect_vehicle_color = $_POST['tip_suspect_vehicle_color'];
        update_field( $tip_suspect_vehicle_color_field, $tip_suspect_vehicle_color, $post_id );

        $tip_suspect_vehicle_license_plate_num_field = "tip_suspect_vehicle_license_plate_num";
        $tip_suspect_vehicle_license_plate_num = $_POST['tip_suspect_vehicle_license_plate_num'];
        update_field( $tip_suspect_vehicle_license_plate_num_field, $tip_suspect_vehicle_license_plate_num, $post_id );

        $tip_suspect_vehicle_license_plate_state_field = "tip_suspect_vehicle_license_plate_state";
        $tip_suspect_vehicle_license_plate_state = $_POST['tip_suspect_vehicle_license_plate_state'];
        update_field( $tip_suspect_vehicle_license_plate_state_field, $tip_suspect_vehicle_license_plate_state, $post_id );

        $tip_suspect_vehicle_usually_parked_field = "tip_suspect_vehicle_usually_parked";
        $tip_suspect_vehicle_usually_parked = $_POST['tip_suspect_vehicle_usually_parked'];
        update_field( $tip_suspect_vehicle_usually_parked_field, $tip_suspect_vehicle_usually_parked, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person drive a vehicle?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-drives-vehicle-yes" type="radio" name="tip_suspect_drives_vehicle" value="yes"/>
                <label class="radio__label" for="input-suspect-drives-vehicle-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-drives-vehicle-no" type="radio" name="tip_suspect_drives_vehicle" value="no"/>
                <label class="radio__label" for="input-suspect-drives-vehicle-no">No</label>
              </div>
            </div>
            <div class="fields fields--hidden" data-hidden-el="true">
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-make">Make</label>
                <input class="field__input" id="input-suspect-vehicle-make" name="tip_suspect_vehicle_make" type="text" placeholder="Make" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-model">Model</label>
                <input class="field__input" id="input-suspect-vehicle-model" name="tip_suspect_vehicle_model" type="text" placeholder="Model" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-year">Year</label>
                <input class="field__input" id="input-suspect-vehicle-year" name="tip_suspect_vehicle_year" type="text" placeholder="Year" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-color">Color</label>
                <input class="field__input" id="input-suspect-vehicle-color" name="tip_suspect_vehicle_color" type="text" placeholder="Color" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-license-plate">License Plate #</label>
                <input class="field__input" id="input-suspect-vehicle-license-plate" name="tip_suspect_vehicle_license_plate_num" type="text" placeholder="License Plate #" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-state">State</label>
                <input class="field__input" id="input-suspect-vehicle-state" name="tip_suspect_vehicle_license_plate_state" type="text" placeholder="State" />
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-vehicle-location">Where is this vehicle usually parked?</label>
                <input class="field__input" id="input-suspect-vehicle-location" name="tip_suspect_vehicle_usually_parked" type="text" placeholder="Where is this vehicle usually parked?" />
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Does the suspect have any other distinguishable features -->
      <?php

        $tip_suspect_has_distinguishable_features_field = "tip_suspect_has_distinguishable_features";
        $tip_suspect_has_distinguishable_features = $_POST['tip_suspect_has_distinguishable_features'];
        update_field( $tip_suspect_has_distinguishable_features_field, $tip_suspect_has_distinguishable_features, $post_id );

        $tip_suspect_feature_eyeglasses_field = "tip_suspect_feature_eyeglasses";
        $tip_suspect_feature_eyeglasses = $_POST['tip_suspect_feature_eyeglasses'];
        update_field( $tip_suspect_feature_eyeglasses_field, $tip_suspect_feature_eyeglasses, $post_id );

        $tip_suspect_feature_mustache_field = "tip_suspect_feature_mustache";
        $tip_suspect_feature_mustache = $_POST['tip_suspect_feature_mustache'];
        update_field( $tip_suspect_feature_mustache_field, $tip_suspect_feature_mustache, $post_id );

        $tip_suspect_feature_beard_field = "tip_suspect_feature_beard";
        $tip_suspect_feature_beard = $_POST['tip_suspect_feature_beard'];
        update_field( $tip_suspect_feature_beard_field, $tip_suspect_feature_beard, $post_id );

        $tip_suspect_feature_goatee_field = "tip_suspect_feature_goatee";
        $tip_suspect_feature_goatee = $_POST['tip_suspect_feature_goatee'];
        update_field( $tip_suspect_feature_goatee_field, $tip_suspect_feature_goatee, $post_id );

        $tip_suspect_feature_missing_teeth_field = "tip_suspect_feature_missing_teeth";
        $tip_suspect_feature_missing_teeth = $_POST['tip_suspect_feature_missing_teeth'];
        update_field( $tip_suspect_feature_missing_teeth_field, $tip_suspect_feature_missing_teeth, $post_id );

        $tip_suspect_feature_gold_tooth_field = "tip_suspect_feature_gold_tooth";
        $tip_suspect_feature_gold_tooth = $_POST['tip_suspect_feature_gold_tooth'];
        update_field( $tip_suspect_feature_gold_tooth_field, $tip_suspect_feature_gold_tooth, $post_id );

        $tip_suspect_feature_left_handed_field = "tip_suspect_feature_left_handed";
        $tip_suspect_feature_left_handed = $_POST['tip_suspect_feature_left_handed'];
        update_field( $tip_suspect_feature_left_handed_field, $tip_suspect_feature_left_handed, $post_id );

        $tip_suspect_feature_right_handed_field = "tip_suspect_feature_right_handed";
        $tip_suspect_feature_right_handed = $_POST['tip_suspect_feature_right_handed'];
        update_field( $tip_suspect_feature_right_handed_field, $tip_suspect_feature_right_handed, $post_id );

        $tip_suspect_feature_missing_limb_field = "tip_suspect_feature_missing_limb";
        $tip_suspect_feature_missing_limb = $_POST['tip_suspect_feature_missing_limb'];
        update_field( $tip_suspect_feature_missing_limb_field, $tip_suspect_feature_missing_limb, $post_id );

        $tip_suspect_feature_body_piercings_field = "tip_suspect_feature_body_piercings";
        $tip_suspect_feature_body_piercings = $_POST['tip_suspect_feature_body_piercings'];
        update_field( $tip_suspect_feature_body_piercings_field, $tip_suspect_feature_body_piercings, $post_id );

        $tip_suspect_feature_body_piercings_ear_field = "tip_suspect_feature_body_piercings_ear";
        $tip_suspect_feature_body_piercings_ear = $_POST['tip_suspect_feature_body_piercings_ear'];
        update_field( $tip_suspect_feature_body_piercings_ear_field, $tip_suspect_feature_body_piercings_ear, $post_id );

        $tip_suspect_feature_body_piercings_nose_field = "tip_suspect_feature_body_piercings_nose";
        $tip_suspect_feature_body_piercings_nose = $_POST['tip_suspect_feature_body_piercings_nose'];
        update_field( $tip_suspect_feature_body_piercings_nose_field, $tip_suspect_feature_body_piercings_nose, $post_id );

        $tip_suspect_feature_body_piercings_brow_field = "tip_suspect_feature_body_piercings_brow";
        $tip_suspect_feature_body_piercings_brow = $_POST['tip_suspect_feature_body_piercings_brow'];
        update_field( $tip_suspect_feature_body_piercings_brow_field, $tip_suspect_feature_body_piercings_brow, $post_id );

        $tip_suspect_feature_body_piercings_lip_field = "tip_suspect_feature_body_piercings_lip";
        $tip_suspect_feature_body_piercings_lip = $_POST['tip_suspect_feature_body_piercings_lip'];
        update_field( $tip_suspect_feature_body_piercings_lip_field, $tip_suspect_feature_body_piercings_lip, $post_id );

        $tip_suspect_feature_body_piercings_tongue_field = "tip_suspect_feature_body_piercings_tongue";
        $tip_suspect_feature_body_piercings_tongue = $_POST['tip_suspect_feature_body_piercings_tongue'];
        update_field( $tip_suspect_feature_body_piercings_tongue_field, $tip_suspect_feature_body_piercings_tongue, $post_id );

        $tip_suspect_feature_distinguishable_walk_limp_field = "tip_suspect_feature_distinguishable_walk_limp";
        $tip_suspect_feature_distinguishable_walk_limp = $_POST['tip_suspect_feature_distinguishable_walk_limp'];
        update_field( $tip_suspect_feature_distinguishable_walk_limp_field, $tip_suspect_feature_distinguishable_walk_limp, $post_id );

        $tip_suspect_feature_speed_impediment_field = "tip_suspect_feature_speed_impediment";
        $tip_suspect_feature_speed_impediment = $_POST['tip_suspect_feature_speed_impediment'];
        update_field( $tip_suspect_feature_speed_impediment_field, $tip_suspect_feature_speed_impediment, $post_id );

        $tip_suspect_feature_other_field = "tip_suspect_feature_other";
        $tip_suspect_feature_other = $_POST['tip_suspect_feature_other'];
        update_field( $tip_suspect_feature_other_field, $tip_suspect_feature_other, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Does this person have any other distinguishable features?</h3>
          <div class="tip-card__fieldset">
            <div class="fields fields--split" data-hidden-control>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="show" id="input-suspect-other-distinguishable-features-yes" type="radio" name="tip_suspect_has_distinguishable_features" value="yes"/>
                <label class="radio__label" for="input-suspect-other-distinguishable-features-yes">Yes</label>
              </div>
              <div class="field radio radio--large">
                <input class="radio__input" data-hidden-control="hide"  id="input-suspect-other-distinguishable-features-no" type="radio" name="tip_suspect_has_distinguishable_features" value="no"/>
                <label class="radio__label" for="input-suspect-other-distinguishable-features-no">No</label>
              </div>
            </div>
            <div class="fields fields--hidden" data-hidden-el="true">
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-eyeglasses" name="tip_suspect_feature_eyeglasses" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-eyeglasses">Eyeglasses</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-mustache" name="tip_suspect_feature_mustache" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-mustache">Mustache</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-beard" name="tip_suspect_feature_beard" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-beard">Beard</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-goatee" name="tip_suspect_feature_goatee" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-goatee">Goatee</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-missing-teeth" name="tip_suspect_feature_missing_teeth" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-missing-teeth">Missing teeth</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-gold-tooth" name="tip_suspect_feature_gold_tooth" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-gold-tooth">Gold tooth</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-left-handed" name="tip_suspect_feature_left_handed" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-left-handed">Left handed</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-right-handed" name="tip_suspect_feature_right_handed" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-right-handed">Right handed</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-missing-finger-limb" name="tip_suspect_feature_missing_limb" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-missing-finger-limb">Missing finger/limb</label>
              </div>
              <div class="field checkbox" data-hidden-control>
                <input type="checkbox" data-hidden-control="show" class="checkbox__input" id="input-suspect-features-body-piercings" name="tip_suspect_feature_body_piercings" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-body-piercings">Body piercings</label>
              </div>
              <div class="fields fields--hidden fields--checkboxes" data-hidden-el="true">
                <div class="field checkbox">
                  <input type="checkbox" class="checkbox__input" id="input-suspect-features-body-piercing-ear" name="tip_suspect_feature_body_piercings_ear" value="yes"/>
                  <label class="checkbox__label" for="input-suspect-features-body-piercing-ear">Ear</label>
                </div>
                <div class="field checkbox">
                  <input type="checkbox" class="checkbox__input" id="input-suspect-features-body-piercing-nose" name="tip_suspect_feature_body_piercings_nose" value="yes"/>
                  <label class="checkbox__label" for="input-suspect-features-body-piercing-nose">Nose</label>
                </div>
                <div class="field checkbox">
                  <input type="checkbox" class="checkbox__input" id="input-suspect-features-body-piercing-brow" name="tip_suspect_feature_body_piercings_brow" value="yes"/>
                  <label class="checkbox__label" for="input-suspect-features-body-piercing-brow">Brow</label>
                </div>
                <div class="field checkbox">
                  <input type="checkbox" class="checkbox__input" id="input-suspect-features-body-piercing-lip" name="tip_suspect_feature_body_piercings_lip" value="yes"/>
                  <label class="checkbox__label" for="input-suspect-features-body-piercing-lip">Lip</label>
                </div>
                <div class="field checkbox">
                  <input type="checkbox" class="checkbox__input" id="input-suspect-features-body-piercing-tongue" name="tip_suspect_feature_body_piercings_tongue" value="yes"/>
                  <label class="checkbox__label" for="input-suspect-features-body-piercing-tongue">Tongue</label>
                </div>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-distinguishable-walk-limp" name="tip_suspect_feature_distinguishable_walk_limp" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-distinguishable-walk-limp">Distinguishable walk/limp</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="input-suspect-features-speech-impediment" name="tip_suspect_feature_speed_impediment" value="yes"/>
                <label class="checkbox__label" for="input-suspect-features-speech-impediment">Speech impediment</label>
              </div>
              <div class="field">
                <label class="field__label" for="input-suspect-features-other">Other</label>
                <input class="field__input" id="input-suspect-features-other" name="tip_suspect_feature_other" type="text" placeholder="Other"/>
              </div>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons tip-card__buttons--split">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Can you provide any additional information about the crime committed -->
      <?php

        $tip_suspect_additional_information_field = "tip_suspect_additional_information";
        $tip_suspect_additional_information = $_POST['tip_suspect_additional_information'];
        update_field( $tip_suspect_additional_information_field, $tip_suspect_additional_information, $post_id );

      ?>
      <div class="tip-card">
        <div class="tip-card__contact">
          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>
          <span>(1-800-577-8477)</span>
        </div>
        <div class="tip-card__content">
          <h3 class="tip-card__title">Can you provide any additional information about the crime committed?</h3>
          <div class="tip-card__fieldset tip-card__fieldset--wide">
            <div class="field">
              <label class="field__label" for="input-suspect-additional-information">Additional Information</label>
              <textarea class="field__input" id="input-suspect-additional-information" name="tip_suspect_additional_information"></textarea>
            </div>
          </div>
        </div>
        <div class="tip-card__buttons">
          <button class="btn tip-card__button tip-card__button--prev" data-card-direction="previous" type="button">Back</button>
          <button class="btn tip-card__button tip-card__button--next" data-card-direction="next" type="button">Next</button>
        </div>
        <div class="tip-card__footer">
          <button class="btn tip-card__button tip-card__button--text" data-card-direction="next" type="button">Skip This Question &rsaquo;</button>
        </div>
      </div>

      <!-- card | Verify (Captcha) -->
      <div class="tip-card tip-card--verify">

        <div class="tip-card__contact">

          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>

          <span>(1-800-577-8477)</span>

        </div>

        <div class="tip-card__content">

          <h3 class="tip-card__title">Verify and submit this tip</h3>

          <div class="tip-card__recaptcha">

            <input id="tip-number-input" type="hidden" name="subject"/>

            <div class="tip-card__button-container">
              <button class="btn tip-card__button" type="submit">Submit Tip</button>
            </div>

          </div>

          <p class="tip-card__note">For security purposes we recommend that you DO NOT print this tip submission form or save it to your computer. Please be sure that you did not give any of your personal information in this tip.</p>

        </div>

        <div class="tip-card__footer">

          <button class="btn tip-card__button tip-card__button--text" data-card-direction="previous" type="button">&lsaquo; Previous Question</button>

        </div>

      </div>

      <!-- card | Tip number confirmation -->
      <div class="tip-card tip-card--success">

        <div class="tip-card__contact">

          <p>
            <a href="tel:1-800-577-8477">1-800-577-TIPS</a>
          </p>

          <span>(1-800-577-8477)</span>

        </div>

        <div class="tip-card__content">

          <h3 class="tip-card__title">Thank you. Your tip has been reported.</h3>

          <div class="tip-card__confirmation">

            <p class="tip-card__confirmation__label">Your tip number is:</p>

            <p class="tip-card__confirmation__number" id="tip-number"></p>

          </div>

          <p class="tip-card__number-instructions">Please save your tip number and call our tips hotline in two weeks.If your tip has lead to an arrest and indictment, you will be given a second set of numbers to use for claiming your cash rewards.</p>

        </div>

        <div class="tip-card__footer">

          <button class="btn tip-card__button tip-card__button--text tip-modal__close" type="button">Close This Form</button>

        </div>

      </div>

    </div>
  </form>


  <!-- Tip submission bar (mobile) -->
  <div class="tip-submission-bar">

    <p class="tip-submission-bar__title">Submit a tip</p>

    <ul class="tip-submission-bar__list">

      <li class="tip-submission-bar__list__item">
        <a class="tip-submission-bar__list__item__btn tip-submission-bar__list__item__btn--phone" href="tel:18005779477">Phone</a>
      </li>

      <li class="tip-submission-bar__list__item">
        <button class="tip-submission-bar__list__item__btn tip-submission-bar__list__item__btn--form" data-modal="tip-modal">Online form</button>
      </li>

      <li class="tip-submission-bar__list__item">
        <a class="tip-submission-bar__list__item__btn tip-submission-bar__list__item__btn--text" href="sms:274637">Text message</a>
      </li>

      <li class="tip-submission-bar__list__item">
        <a class="tip-submission-bar__list__item__btn tip-submission-bar__list__item__btn--app" href="https://itunes.apple.com/us/app/nypd/id587943117?mt=8" target="_blank">Submit through app</a>
      </li>

    </ul>

  </div>

  <!-- Tip submission overlay (mobile) -->
  <div id="tip-submission-overlay" class="tip-submission-overlay overlay">

    <button class="overlay__close tip-submission-overlay__close-btn" type="button">Close</button>

    <div class="tip-submission-overlay__container">

      <div class="tip-submission-overlay__container__wrapper">

        <div class="tip-submission-overlay__header">

          <p class="tip-submission-overlay__title">Submit a tip</p>

          <p class="tip-submission-overlay__number">
            <a href="tel:18005778477">
              1-800-577-TIPS
              <span>(1-800-577-8477)</span>
            </a>
          </p>

        </div>

        <div class="tip-submission-overlay__content">

          <a class="tip-submission-overlay__phone" href="tel:18005779477">Call 1-800-577-8477</a>

          <ul class="tip-submission-overlay__list">

            <li class="tip-submission-overlay__list__item">
              <button class="tip-submission-overlay__list__item__btn tip-submission-overlay__list__item__btn--form" data-modal="tip-modal" type="button">
                <span></span>
                Online
              </button>
            </li>

            <li class="tip-submission-overlay__list__item">
              <a class="tip-submission-overlay__list__item__btn tip-submission-overlay__list__item__btn--text" href="sms:274637">
                <span></span>
                SMS Text
              </a>
            </li>

            <li class="tip-submission-overlay__list__item">
              <a class="tip-submission-overlay__list__item__btn tip-submission-overlay__list__item__btn--app" href="https://itunes.apple.com/us/app/nypd/id587943117?mt=8" target="_blank">
                <span></span>
                App
              </a>
            </li>

          </ul>

          <button class="overlay__close tip-submission-overlay__continue-btn" type="button">Continue to Website &rsaquo;</button>

        </div>

      </div>

    </div>

  </div>

  <?php wp_footer(); ?>

  <script src="https://www.google.com/recaptcha/api.js?onload=renderReCaptcha"></script>

  <script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/crimestoppers.js"></script>

</body>
</html>