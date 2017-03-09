<?php
/*
 * Tips Display Page
*/
?>
<h1><?php the_title(); ?></h1>
<?php if( get_field('tip_notes') ){ ?>
  <p>Notes: <strong><?php the_field('tip_notes'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_date') ){ ?>
  <p>Notes Date: <strong><?php echo date("m/d/Y", strtotime(get_field('tip_date'))); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_time') ){ ?>
  <p>Notes Time: <strong><?php the_field('tip_time'); ?></strong></p>
<?php }; 
  $terms = wp_get_post_terms($post->ID, 'tips_cat');
  if( !empty($terms)){ ?>
  <p>Type of crime: <strong><?php foreach ( $terms as $term ) { echo $term->name;} ?></strong></p>  
 <?php }; 

  $terms_a = wp_get_post_terms($post->ID, 'tips_desc');
  if( !empty($terms_a)){ ?>
  <p>Description of: <strong><?php foreach ( $terms_a as $term_a ) { echo $term_a->name;} ?></strong></p>  
 <?php }; ?> 

<?php if( get_field('tip_crime_knowledge') ){ ?>
  <p>How do you know about the crime? <strong><?php the_field('tip_crime_knowledge'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_url_source') ){ ?>
  <p>URL source: <strong><?php the_field('tip_url_source'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_know_suspect_alias') ){ ?>
  <p>Does suspect have an alias or nickname? <strong><?php the_field('tip_know_suspect_alias'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_alias') ){ ?>
  <p>Suspect alias/nickname: <strong><?php the_field('tip_suspect_alias'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_name') ){ ?>
  <p>Suspect name: <strong><?php the_field('tip_suspect_name'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_has_video_footage') ){ ?>
  <p>Do you have video footage of the crime? <strong><?php the_field('tip_has_video_footage'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_video_footage_url') ){ ?>
  <p>Suspect video footage url: <strong><?php the_field('tip_video_footage_url'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_know_suspect_address') ){ ?>
  <p>Do you know where the suspect lives: <strong><?php the_field('tip_know_suspect_address'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_address') ){ ?>
  <p>Suspect address/location: <strong><?php the_field('tip_suspect_address'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_city') ){ ?>
  <p>Suspect city: <strong><?php the_field('tip_suspect_city'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_state') ){ ?>
  <p>Suspect state: <strong><?php the_field('tip_suspect_state'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_know_how_contact_suspect') ){ ?>
  <p>Do you know how to contact the suspect? <strong><?php the_field('tip_know_how_contact_suspect'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_email') ){ ?>
  <p>Suspect email: <strong><?php the_field('tip_suspect_email'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_phone') ){ ?>
  <p>Suspect phone: <strong><?php the_field('tip_suspect_phone'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_use_social_media') ){ ?>
  <p>Does the suspect use any social media? <strong><?php the_field('tip_suspect_use_social_media'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_social_media_site_1') ){ ?>
  <p>Social media site 1: <strong><?php the_field('tip_social_media_site_1'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_social_media_site_1_link') ){ ?>
  <p>Social media site 1 link: <strong><?php the_field('tip_social_media_site_1_link'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_social_media_site_2') ){ ?>
  <p>Social media site 2: <strong><?php the_field('tip_social_media_site_2'); ?></strong></p>
<?php }; ?>
<?php if( get_field('tip_social_media_site_2_link') ){ ?>
  <p>Social media site 2 link: <strong><?php the_field('tip_social_media_site_2_link'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_employed') ){ ?>
  <p>Is the suspect employed? <strong><?php the_field('tip_suspect_employed'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_employment_location') ){ ?>
  <p>Suspect employment location: <strong><?php the_field('tip_suspect_employment_location'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_describe_suspect') ){ ?>
  <p>Can you describe the suspect? <strong><?php the_field('tip_describe_suspect'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_age') ){ ?>
  <p>Suspect age: <strong><?php the_field('tip_suspect_description_age'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_gender') ){ ?>
  <p>Suspect gender: <strong><?php the_field('tip_suspect_description_gender'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_race') ){ ?>
  <p>Suspect race: <strong><?php the_field('tip_suspect_description_race'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_hair_color') ){ ?>
  <p>Suspect hair color: <strong><?php the_field('tip_suspect_description_hair_color'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_hair_type') ){ ?>
  <p>Suspect hair type: <strong><?php the_field('tip_suspect_description_hair_type'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_eye_color') ){ ?>
  <p>Suspect eye color: <strong><?php the_field('tip_suspect_description_eye_color'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_height') ){ ?>
  <p>Suspect height: <strong><?php the_field('tip_suspect_description_height'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_weight') ){ ?>
  <p>Suspect weight: <strong><?php the_field('tip_suspect_description_weight'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_description_dob') ){ ?>
  <p>Suspect date of birth: <strong><?php the_field('tip_suspect_description_dob'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_hang_out_address') ){ ?>
  <p>Suspect hang out address/location: <strong><?php the_field('tip_suspect_hang_out_address'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_hang_out_city') ){ ?>
  <p>Suspect hang out city: <strong><?php the_field('tip_suspect_hang_out_city'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_hang_out_state') ){ ?>
  <p>Suspect hang out state: <strong><?php the_field('tip_suspect_hang_out_state'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_know_suspect_friends_or_family') ){ ?>
  <p>Do you know any friends (or family) of the suspect? <strong><?php the_field('tip_know_suspect_friends_or_family'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_friend_family_1_name') ){ ?>
  <p>Suspect friend or family 1 name: <strong><?php the_field('tip_suspect_friend_family_1_name'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_friend_family_1_relationship') ){ ?>
  <p>Suspect friend or family 1 relationship: <strong><?php the_field('tip_suspect_friend_family_1_relationship'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_friend_family_2_name') ){ ?>
  <p>Suspect friend or family 2 name: <strong><?php the_field('tip_suspect_friend_family_2_name'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_friend_family_2_relationship') ){ ?>
  <p>Suspect friend or family 2 relationship: <strong><?php the_field('tip_suspect_friend_family_2_relationship'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_carry_weapons') ){ ?>
  <p>Does the suspect carry any weapons? <strong><?php the_field('tip_suspect_carry_weapons'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_type_of_weapon_carried') ){ ?>
  <p>Suspect type of weapon carried: <strong><?php the_field('tip_suspect_type_of_weapon_carried'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_carried_weapon_location') ){ ?>
  <p>Suspect carried weapon location: <strong><?php the_field('tip_suspect_carried_weapon_location'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_gang_affiliated') ){ ?>
  <p>Does the suspect have any gang affiliation? <strong><?php the_field('tip_suspect_gang_affiliated'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_gang_name') ){ ?>
  <p>Suspect gang name: <strong><?php the_field('tip_suspect_gang_name'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_has_tattoos') ){ ?>
  <p>Does the suspect have any tattoos? <strong><?php the_field('tip_suspect_has_tattoos'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_tattoo_1_type') ){ ?>
  <p>Suspect tattoo 1 type: <strong><?php the_field('tip_suspect_tattoo_1_type'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_tattoo_1_location') ){ ?>
  <p>Suspect tattoo 1 location: <strong><?php the_field('tip_suspect_tattoo_1_location'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_tattoo_2_type') ){ ?>
  <p>Suspect tattoo 2 type: <strong><?php the_field('tip_suspect_tattoo_2_type'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_tattoo_2_location') ){ ?>
  <p>Suspect tattoo 2 location: <strong><?php the_field('tip_suspect_tattoo_2_location'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_has_scars') ){ ?>
  <p>Does the suspect have any scars? <strong><?php the_field('tip_suspect_has_scars'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_scar_1_type') ){ ?>
  <p>Suspect scar 1 type: <strong><?php the_field('tip_suspect_scar_1_type'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_scar_1_location') ){ ?>
  <p>Suspect scar 1 location: <strong><?php the_field('tip_suspect_scar_1_location'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_scar_2_type') ){ ?>
  <p>Suspect scar 2 type: <strong><?php the_field('tip_suspect_scar_2_type'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_scar_2_location') ){ ?>
  <p>Suspect scar 2 location: <strong><?php the_field('tip_suspect_scar_2_location'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_drives_vehicle') ){ ?>
  <p>Does the suspect drive a vehicle? <strong><?php the_field('tip_suspect_drives_vehicle'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_make') ){ ?>
  <p>Suspect vehicle make: <strong><?php the_field('tip_suspect_vehicle_make'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_model') ){ ?>
  <p>Suspect vehicle model: <strong><?php the_field('tip_suspect_vehicle_model'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_year') ){ ?>
  <p>Suspect vehicle year: <strong><?php the_field('tip_suspect_vehicle_year'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_color') ){ ?>
  <p>Suspect vehicle color: <strong><?php the_field('tip_suspect_vehicle_color'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_license_plate_num') ){ ?>
  <p>Suspect vehicle license plate #: <strong><?php the_field('tip_suspect_vehicle_license_plate_num'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_license_plate_state') ){ ?>
  <p>Suspect vehicle license plate state: <strong><?php the_field('tip_suspect_vehicle_license_plate_state'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_vehicle_usually_parked') ){ ?>
  <p>Suspect vehicle usually parked: <strong><?php the_field('tip_suspect_vehicle_usually_parked'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_has_distinguishable_features') ){ ?>
  <p>Does the suspect have any other distinguishable features? <strong><?php the_field('tip_suspect_has_distinguishable_features'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_eyeglasses') ){ ?>
  <p>Suspect feature - Eyeglasses: <strong><?php the_field('tip_suspect_feature_eyeglasses'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_mustache') ){ ?>
  <p>Suspect feature - Mustache: <strong><?php the_field('tip_suspect_feature_mustache'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_beard') ){ ?>
  <p>Suspect feature - Beard: <strong><?php the_field('tip_suspect_feature_beard'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_goatee') ){ ?>
  <p>Suspect feature - Goatee: <strong><?php the_field('tip_suspect_feature_goatee'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_missing_teeth') ){ ?>
  <p>Suspect feature - Missing teeth: <strong><?php the_field('tip_suspect_feature_missing_teeth'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_gold_tooth') ){ ?>
  <p>Suspect feature - Gold tooth: <strong><?php the_field('tip_suspect_feature_gold_tooth'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_left_handed') ){ ?>
  <p>Suspect feature - Left-handed: <strong><?php the_field('tip_suspect_feature_left_handed'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_right_handed') ){ ?>
  <p>Suspect feature - Right-handed: <strong><?php the_field('tip_suspect_feature_right_handed'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_missing_limb') ){ ?>
  <p>Suspect feature - Missing limb: <strong><?php the_field('tip_suspect_feature_missing_limb'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_body_piercings') ){ ?>
  <p>Suspect feature - Body piercings: <strong><?php the_field('tip_suspect_feature_body_piercings'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_body_piercings_ear') ){ ?>
  <p>Suspect feature - Body piercings - Ear: <strong><?php the_field('tip_suspect_feature_body_piercings_ear'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_body_piercings_nose') ){ ?>
  <p>Suspect feature - Body piercings - Nose: <strong><?php the_field('tip_suspect_feature_body_piercings_nose'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_body_piercings_brow') ){ ?>
  <p>Suspect feature - Body piercings - Brow: <strong><?php the_field('tip_suspect_feature_body_piercings_brow'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_body_piercings_lip') ){ ?>
  <p>Suspect feature - Body piercings - Lip: <strong><?php the_field('tip_suspect_feature_body_piercings_lip'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_body_piercings_tongue') ){ ?>
  <p>Suspect feature - Body piercings - Tongue: <strong><?php the_field('tip_suspect_feature_body_piercings_tongue'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_distinguishable_walk_limp') ){ ?>
  <p>Suspect feature - Distinguishable walk/limp: <strong><?php the_field('tip_suspect_feature_distinguishable_walk_limp'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_speed_impediment') ){ ?>
  <p>Suspect feature - Speech impediment: <strong><?php the_field('tip_suspect_feature_speed_impediment'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_feature_other') ){ ?>
  <p>Suspect feature - Other: <strong><?php the_field('tip_suspect_feature_other'); ?></strong></p>
<?php }; ?>

<?php if( get_field('tip_suspect_additional_information') ){ ?>
  <p>Can you provide any additional information about the crime committed? <strong><?php the_field('tip_suspect_additional_information'); ?></strong></p>
<?php }; ?>