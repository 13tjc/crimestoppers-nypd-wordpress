<?php
/*
 Template Name: Submit Tip
*/
?>
<?php 
get_header(); 
$five_random_number = mt_rand(10000, 99999);
?>

<main class="main" role="main">

  <div class="hero" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/bg/nyc-hero.jpg);"></div>

  <div class="submit-tip">

    <div class="wrapper">

      <div class="page-title">

        <h1>Submit a Tip</h1>

      </div>

      <div class="submit-tip__intro">

        <p>If at any point you would like to speak with a detective, please call our tips hotline. We are available 24/7 and calls are always anonymous.</p>

        <p><strong>If there is a crime currently in progress, close this form and dial  <span>9-1-1</span> immediately.</strong></p>

      </div>

      <form class="tip-form" id="tip-form" method="post" action="/tip-submitted?<?php echo "$five_random_number";?>">

        <!-- Intro -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">What type of crime was committed?</h2>

          <div class="tip-form__block__content">

            <div class="field select field--required">
              <label class="select__label" for="type-of-crime">Type of Crime</label>
              <select class="select__input" id="type-of-crime" name="type_of_crime">
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
              <h4 class="tip-form__field-title">This is about...</h4>
              <label class="select__label" for="this-is-about">This is about...</label>
              <select class="select__input" id="this-is-about" name="about">
                <option>Choose</option>
                <?php
                  $tax_desc = 'tips_desc';
                  $terms_desc = get_terms( $tax_desc, ['hide_empty' => false]);
                  foreach( $terms_desc as $term_desc ) { 
                    echo '<option value="' .  $term_desc->name . '">' . $term_desc->name . '</option>';
                  }
                ?>
              </select>
            </div>

            <p class="tip-form__required">* required field</p>

          </div>

        </div>

        <!-- How do you know about the crime -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">How do you know about the crime?</h2>

          <div class="tip-form__block__content">

            <div class="field select">
              <label class="select__label" for="knowledge-of-crime">Knowledge of crime</label>
              <select class="select__input" id="knowledge-of-crime" name="tip_crime_knowledge[]">
                <option>Choose</option>
                <option value="I saw it" >I saw it</option>
                <option value="I have information about it" >I have information about it</option>
                <option value="From a News Report" >From a News Report</option>
              </select>
            </div>
            <div class="field">
              <label class="field__label" for="url-source">URL source</label>
              <input class="field__input" id="url-source" name="tip_url_source" type="text" placeholder="Enter URL if available"/>
            </div>

          </div>

        </div>

        <!-- Does suspect have an alias or nickname -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person have an alias? Or nickname?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="suspect-alias-nickname">Person's alias or nickname</label>
              <input class="field__input" id="suspect-alias-nickname" name="tip_suspect_alias" type="text" placeholder="Enter Alias or Nickname"/>
            </div>

          </div>

        </div>

        <!-- Do you know the suspect's name-->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Do you know this person's name?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="suspect-name">Person's name</label>
              <input class="field__input" id="suspect-name" name="tip_suspect_name" type="text" placeholder="Enter Name"/>
            </div>

          </div>

        </div>

        <!-- Do you have any video footage of the crime-->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Do you have any video footage of the crime?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="video-footage-url">URL</label>
              <input class="field__input" id="video-footage-url" name="tip_video_footage_url" type="text" placeholder="Enter URL"/>
            </div>

          </div>

        </div>

        <!-- Do you know where the suspect lives -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Do you know where this person lives?</h2>

          <div class="tip-form__block__content">

            <div class="fields">
              <div class="field">
                <label class="field__label" for="suspect-address-location">Address/Location</label>
                <input class="field__input" id="suspect-address-location" name="tip_suspect_address" type="text" placeholder="Address/Location" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-address-city">City</label>
                <input class="field__input" id="suspect-address-city" name="tip_suspect_city" type="text" placeholder="City" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-address-state">State</label>
                <input class="field__input" id="suspect-address-state" name="tip_suspect_state" type="text" placeholder="State" />
              </div>
            </div>

          </div>

        </div>

        <!-- Do you know how to contact the suspect -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Do you know how to contact this person?</h2>

          <div class="tip-form__block__content">

            <div class="fields">
              <div class="field">
                <label class="field__label" for="suspect-email-address">Email Address</label>
                <input class="field__input" id="suspect-email-address" name="tip_suspect_email" type="text" placeholder="Email Address" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-phone-number">Phone Number</label>
                <input class="field__input" id="suspect-phone-number" name="tip_suspect_phone" type="text" placeholder="Phone Number" />
              </div>
            </div>

          </div>

        </div>

        <!-- Does the suspect use any social media -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person use any social media?</h2>

          <div class="tip-form__block__content">

              <div class="fields fields--replicable">

                <div class="field">

                  <label class="field__label" for="tip_social_media_site_1">Social platform</label>

                  <select class="select__input" id="tip_social_media_site_1" name="tip_social_media_site_1[]">
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

                  <label class="field__label" for="tip_social_media_site_2">Social platform</label>

                  <select class="select__input" id="tip_social_media_site_2" name="tip_social_media_site_2[]">
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

        <!-- Is the suspect employed -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Is this person employed?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="suspect-employment-location">Location</label>
              <input class="field__input" id="suspect-employment-location" name="tip_suspect_employment_location" type="text" placeholder="Enter Location"/>
            </div>

          </div>

        </div>

        <!-- Can you describe the suspect -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Can you describe this person?</h2>

          <div class="tip-form__block__content">

            <div class="fields">
              <div class="field">
                <label class="field__label" for="suspect-description-age">Age</label>
                <input class="field__input" id="suspect-description-age" name="tip_suspect_description_age" type="text" placeholder="Age" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-gender">Gender</label>
                <select class="select__input" id="suspect-description-gender" name="tip_suspect_description_gender[]">
                  <option>Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-race">Race</label>
                <input class="field__input" id="suspect-description-race" name="tip_suspect_description_race" type="text" placeholder="Race" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-hair-color">Hair Color</label>
                <input class="field__input" id="suspect-description-hair-color" name="tip_suspect_description_hair_color" type="text" placeholder="Hair Color" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-hair-type">Hair Type</label>
                <input class="field__input" id="suspect-description-hair-type" name="tip_suspect_description_hair_type" type="text" placeholder="Hair Type" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-eye-color">Eye Color</label>
                <input class="field__input" id="suspect-description-eye-color" name="tip_suspect_description_eye_color" type="text" placeholder="Eye Color" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-height">Height</label>
                <input class="field__input" id="suspect-description-height" name="tip_suspect_description_height" type="text" placeholder="Height" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-weight">Weight</label>
                <input class="field__input" id="suspect-description-weight" name="tip_suspect_description_weight" type="text" placeholder="Weight" />

              </div>
              <div class="field">
                <label class="field__label" for="suspect-description-dob">Date of Birth</label>
                <input class="field__input" id="suspect-description-dob" name="tip_suspect_description_dob" type="text" placeholder="Date of Birth" />
              </div>
            </div>

          </div>

        </div>

        <!-- Where does the suspect hang out? -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Where does this person hang out?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="suspect-hangout-address-location">Address/Location</label>
              <input class="field__input" id="suspect-hangout-address-location" name="tip_suspect_hang_out_address" type="text" placeholder="Address/Location" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-hangout-city">City</label>
              <input class="field__input" id="suspect-hangout-city" name="tip_suspect_hang_out_city" type="text" placeholder="City" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-hangout-state">State</label>
              <input class="field__input" id="suspect-hangout-state" name="tip_suspect_hang_out_state" type="text" placeholder="State" />
            </div>

          </div>

        </div>

        <!-- Does the suspect have any gang affiliation -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person have any gang affiliation?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="input-suspect-gang-name">Gang name</label>
              <input class="field__input" id="input-suspect-gang-name" name="tip_suspect_gang_name" type="text" placeholder="Gang name"/>
            </div>

          </div>

        </div>

        <!-- Does the suspect carry weapons -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person carry any weapons?</h2>

          <div class="tip-form__block__content">

            <div class="fields">
              <div class="field">
                <label class="field__label" for="suspect-type-of-weapon">Type of Weapon</label>
                <input class="field__input" id="suspect-type-of-weapon" name="tip_suspect_type_of_weapon_carried" type="text" placeholder="Type of Weapon" />
              </div>
              <div class="field">
                <label class="field__label" for="suspect-weapon-location">Where is it carried?</label>
                <input class="field__input" id="suspect-weapon-location" name="tip_suspect_carried_weapon_location" type="text" placeholder="Where is it carried?" />

              </div>
            </div>

          </div>

        </div>

        <!-- Do you know any friends (or family) of the suspect -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Do you know any friends (or family) of this person?</h2>

          <div class="tip-form__block__content">

            <div class="fields fields--replicable">
              <div class="field">
                <label class="field__label" for="tip_suspect_friend_family_1_name">Name</label>
                <input class="field__input" id="tip_suspect_friend_family_1_name" name="tip_suspect_friend_family_1_name" type="text" placeholder="Name" />
              </div>
              <div class="field">
                <label class="field__label" for="tip_suspect_friend_family_1_relationship">Relationship</label>
                <input class="field__input" id="tip_suspect_friend_family_1_relationship" name="tip_suspect_friend_family_1_relationship" type="text" placeholder="Relationship" />
              </div>
            </div>
            <div class="fields fields--replicable">
              <div class="field">
                <label class="field__label" for="tip_suspect_friend_family_2_name">Name</label>
                <input class="field__input" id="tip_suspect_friend_family_2_name" name="tip_suspect_friend_family_2_name" type="text" placeholder="Name" />
              </div>
              <div class="field">
                <label class="field__label" for="tip_suspect_friend_family_2_relationship">Relationship</label>
                <input class="field__input" id="tip_suspect_friend_family_2_relationship" name="tip_suspect_friend_family_2_relationship" type="text" placeholder="Relationship" />
              </div>
            </div>

          </div>

        </div>

        <!-- Does the suspect have any tattoos -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person have any tattoos?</h2>

          <div class="tip-form__block__content">

            <div class="fields fields--replicable">
              <div class="field">
                <label class="field__label" for="tip_suspect_tattoo_1_type">Type of Tattoo</label>
                <input class="field__input" id="tip_suspect_tattoo_1_type" name="tip_suspect_tattoo_1_type" type="text" placeholder="Type of Tattoo" />
              </div>
              <div class="field">
                <label class="field__label" for="tip_suspect_tattoo_1_location">Location of Tattoo</label>
                <input class="field__input" id="tip_suspect_tattoo_1_location" name="tip_suspect_tattoo_1_location" type="text" placeholder="Location of Tattoo" />
              </div>
            </div>
            <div class="fields fields--replicable">
              <div class="field">
                <label class="field__label" for="tip_suspect_tattoo_2_type">Type of Tattoo</label>
                <input class="field__input" id="tip_suspect_tattoo_2_type" name="tip_suspect_tattoo_2_type" type="text" placeholder="Type of Tattoo" />
              </div>
              <div class="field">
                <label class="field__label" for="tip_suspect_tattoo_2_location">Location of Tattoo</label>
                <input class="field__input" id="tip_suspect_tattoo_2_location" name="tip_suspect_tattoo_2_location" type="text" placeholder="Location of Tattoo" />
              </div>
            </div>

          </div>

        </div>

        <!-- Does the suspect have any scars -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person have any scars?</h2>

          <div class="tip-form__block__content">

            <div class="fields fields--replicable">
              <div class="field">
                <label class="field__label" for="tip_suspect_scar_1_type">Type of Scar</label>
                <input class="field__input" id="tip_suspect_scar_1_type" name="tip_suspect_scar_1_type" type="text" placeholder="Type of Scar" />
              </div>
              <div class="field">
                <label class="field__label" for="tip_suspect_scar_1_location">Location of Scar</label>
                <input class="field__input" id="tip_suspect_scar_1_location" name="tip_suspect_scar_1_location" type="text" placeholder="Location of Scar" />
              </div>
            </div>
            <div class="fields fields--replicable" data-replicate-source>
              <div class="field">
                <label class="field__label" for="tip_suspect_scar_2_type">Type of Scar</label>
                <input class="field__input" id="tip_suspect_scar_2_type" name="tip_suspect_scar_2_type" type="text" placeholder="Type of Scar" />
              </div>
              <div class="field">
                <label class="field__label" for="tip_suspect_scar_2_location">Location of Scar</label>
                <input class="field__input" id="tip_suspect_scar_2_location" name="tip_suspect_scar_2_location" type="text" placeholder="Location of Scar" />
              </div>
            </div>

          </div>

        </div>

        <!-- Does the suspect drive a vehicle -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person drive a vehicle?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="suspect-vehicle-make">Make</label>
              <input class="field__input" id="suspect-vehicle-make" name="tip_suspect_vehicle_make" type="text" placeholder="Make" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-vehicle-model">Model</label>
              <input class="field__input" id="suspect-vehicle-model" name="tip_suspect_vehicle_model" type="text" placeholder="Model" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-vehicle-year">Year</label>
              <input class="field__input" id="suspect-vehicle-year" name="tip_suspect_vehicle_year" type="text" placeholder="Year" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-vehicle-color">Color</label>
              <input class="field__input" id="suspect-vehicle-color" name="tip_suspect_vehicle_color" type="text" placeholder="Color" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-vehicle-license-plate">License Plate #</label>
              <input class="field__input" id="suspect-vehicle-license-plate" name="tip_suspect_vehicle_license_plate_num" type="text" placeholder="License Plate #" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-vehicle-state">State</label>
              <input class="field__input" id="suspect-vehicle-state" name="tip_suspect_vehicle_license_plate_state" type="text" placeholder="State" />
            </div>
            <div class="field">
              <label class="field__label" for="suspect-vehicle-location">Where is this vehicle usually parked?</label>
              <input class="field__input" id="suspect-vehicle-location" name="tip_suspect_vehicle_usually_parked" type="text" placeholder="Where is this vehicle usually parked?" />
            </div>

          </div>

        </div>

        <!-- Does the suspect have any other distinguishable features -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Does this person have any other distinguishable features?</h2>

          <div class="tip-form__block__content">

            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-eyeglasses" name="tip_suspect_feature_eyeglasses" value="yes"/>
              <label class="checkbox__label" for="suspect-features-eyeglasses">Eyeglasses</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-mustache" name="tip_suspect_feature_mustache" value="yes"/>
              <label class="checkbox__label" for="suspect-features-mustache">Mustache</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-beard" name="tip_suspect_feature_beard" value="yes"/>
              <label class="checkbox__label" for="suspect-features-beard">Beard</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-goatee" name="tip_suspect_feature_goatee" value="yes"/>
              <label class="checkbox__label" for="suspect-features-goatee">Goatee</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-missing-teeth" name="tip_suspect_feature_missing_teeth" value="yes"/>
              <label class="checkbox__label" for="suspect-features-missing-teeth">Missing teeth</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-gold-tooth" name="tip_suspect_feature_gold_tooth" value="yes"/>
              <label class="checkbox__label" for="suspect-features-gold-tooth">Gold tooth</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-left-handed" name="tip_suspect_feature_left_handed" value="yes"/>
              <label class="checkbox__label" for="suspect-features-left-handed">Left handed</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-right-handed" name="tip_suspect_feature_right_handed" value="yes"/>
              <label class="checkbox__label" for="suspect-features-right-handed">Right handed</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-missing-finger-limb" name="tip_suspect_feature_missing_limb" value="yes"/>
              <label class="checkbox__label" for="suspect-features-missing-finger-limb">Missing finger/limb</label>
            </div>
            <div class="field checkbox" data-hidden-control>
              <input type="checkbox" data-hidden-control="show" class="checkbox__input" id="suspect-features-body-piercings" name="tip_suspect_feature_body_piercings" value="yes"/>
              <label class="checkbox__label" for="suspect-features-body-piercings">Body piercings</label>
            </div>
            <div class="fields fields--hidden fields--checkboxes" data-hidden-el="true">
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="suspect-features-body-piercing-ear" name="tip_suspect_feature_body_piercings_ear" value="yes"/>
                <label class="checkbox__label" for="suspect-features-body-piercing-ear">Ear</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="suspect-features-body-piercing-nose" name="tip_suspect_feature_body_piercings_nose" value="yes"/>
                <label class="checkbox__label" for="suspect-features-body-piercing-nose">Nose</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="suspect-features-body-piercing-brow" name="tip_suspect_feature_body_piercings_brow" value="yes"/>
                <label class="checkbox__label" for="suspect-features-body-piercing-brow">Brow</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="suspect-features-body-piercing-lip" name="tip_suspect_feature_body_piercings_lip" value="yes"/>
                <label class="checkbox__label" for="suspect-features-body-piercing-lip">Lip</label>
              </div>
              <div class="field checkbox">
                <input type="checkbox" class="checkbox__input" id="suspect-features-body-piercing-tongue" name="tip_suspect_feature_body_piercings_tongue" value="yes"/>
                <label class="checkbox__label" for="suspect-features-body-piercing-tongue">Tongue</label>
              </div>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-distinguishable-walk-limp" name="tip_suspect_feature_distinguishable_walk_limp" value="yes"/>
              <label class="checkbox__label" for="suspect-features-distinguishable-walk-limp">Distinguishable walk/limp</label>
            </div>
            <div class="field checkbox">
              <input type="checkbox" class="checkbox__input" id="suspect-features-speech-impediment" name="tip_suspect_feature_speed_impediment" value="yes"/>
              <label class="checkbox__label" for="suspect-features-speech-impediment">Speech impediment</label>
            </div>
            <div class="field">
              <label class="field__label" for="suspect-features-other">Other</label>
              <input class="field__input" id="suspect-features-other" name="tip_suspect_feature_other" type="text" placeholder="Other"/>
            </div>

          </div>

        </div>

         <!-- Can you provide any additional information about the crime committed -->
        <div class="tip-form__block">

          <h2 class="tip-form__block__title">Can you provide any additional information about the crime committed?</h2>

          <div class="tip-form__block__content">

            <div class="field">
              <label class="field__label" for="suspect-additional-information">Additional Information</label>
              <textarea class="field__input" id="suspect-additional-information" name="tip_suspect_additional_information"></textarea>
            </div>

          </div>

        </div>

        <!-- Verify (Captcha) -->
        <div class="tip-form__block tip-form__block--verify">

          <h2 class="tip-form__block__title">Verify and submit this tip</h2>

          <div class="tip-form__block__content">

            <div class="tip-form__recaptcha">

              <div class="g-recaptcha" data-sitekey="6Lf6OhATAAAAAIydEdqSAkByiIV6KGTeGxnFoYRL"></div>

              <input  type="hidden" name="subject" value="Tip #<?php echo $five_random_number; ?> (-unauthorized-)"/>

            </div>

            <div class="tip-form__block__button-container">
              <button class="btn tip-form__button" type="submit">Submit Tip</button>
            </div>

            <p class="tip-form__block__content__note">For security purposes we recommend that you DO NOT print this tip submission form or save it to your computer. Please be sure that you did not give any of your personal information in this tip.</p>

          </div>

        </div>

      </form>

    </div>

  </div>

</main>
<?php get_footer(); ?>