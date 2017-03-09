<?php
/*
 * About us page
*/
?>
<?php get_header(); ?>
<main class="main" role="main">

  <div class="about">

    <div class="about__hero">

      <div class="wrapper">

        <div class="about__hero__image">
          <img class="bp-image" src="<?php echo get_template_directory_uri(); ?>/img/asset/img-placeholder.gif" data-img-sm="<?php echo get_template_directory_uri(); ?>/img/asset/crime-stoppers-site-on-devices-sm.png" data-img-lg="<?php echo get_template_directory_uri(); ?>/img/asset/crime-stoppers-site-on-devices-lg.png" alt="Crime Stoppers"/>
        </div>

      </div>

    </div>

    <div class="tip-submission">

      <div class="wrapper">

        <h2 class="tip-submission__title">4 ways to submit your tip</h2>

        <ul class="tip-submission__blocks">

          <li class="tip-submission__block tip-submission__block--alpha tip-submission__block--call">
            <h3 class="tip-submission__block__title">Call Us</h3>
            <ol class="numbered-list">
              <li>Call <strong>1-800-577-TIPS</strong> (1-800-577-8477)</li>
              <li> After providing tip information, the receiving Detective will give you a tip number.</li>
              <li>
                <p>After one week, tipsters can use their tip number to follow up on their supplied information by calling the tips hotline: 1-800-577-TIPS (1-800-577-8477).</p>
                <p>The tipster's cell phone number will not be displayed or traced.</p>
              </li>
            </ol>
          </li>

          <li class="tip-submission__block tip-submission__block--alpha tip-submission__block--online">
            <h3 class="tip-submission__block__title">Submit Online</h3>
            <ol class="numbered-list">
              <li>Visit <strong>NYPDCrimeStoppers.com</strong></li>
              <li>Submit a tip using the online tip form.</li>
              <li>After filling out the form, you will automatically receive a computer-generated tip number.</li>
              <li>After one week, tipsters can use their tip number to follow up on their supplied information by calling the tips hotline: <strong>1-800-577-TIPS</strong> (1-800-577-8477).</li>
            </ol>
          </li>

          <li class="tip-submission__block tip-submission__block--beta tip-submission__block--text">
            <h3 class="tip-submission__block__title">Text Us</h3>
            <ol class="numbered-list">
              <li>
                <p>Send a text to <strong>CRIMES (274637)</strong></p>
                <p>The tipster's cell phone number will not be displayed or traced. The tipster can stop communication at any time by texting "<strong>STOP</strong>".</p>
              </li>
              <li>The next step is to type <strong>Tips577</strong> and then the tip information. Tipster will then begin a text conversation with a CrimeStoppers investigator.</li>
              <li>At the end of the conversation, tipsters will be given a tip number.</li>
                <p>After one week, tipsters can use their tip number to follow up on their supplied information by calling the tips hotline: <strong>1-800-577-TIPS</strong> (1-800-577-8477).</p>
                <p><strong>NOTE:</strong> For safety reasons, we encourage tipsters to delete all text communications.</p>
              </li>
            </ol>
          </li>
          <li class="tip-submission__block tip-submission__block--beta tip-submission__block--app">
            <h3 class="tip-submission__block__title">Get the App</h3>
            <ol class="numbered-list">
              <li>Download our app for iOS or Android.</li>
              <li>Submit a tip using the in app tip submission form.</li>
              <li>After filling out the form, you will automatically receive a computer-generated tip number.</li>
              <li>After one week, tipsters can use their tip number to follow up on their supplied information by calling the tips hotline: <strong>1-800-577-TIPS</strong> (1-800-577-8477).</li>
            </ol>
            <div class="tip-submission__block__app-download">
              <a class="tip-submission__block__app-download__link" href="https://itunes.apple.com/gb/app/nypd/id587943117?mt=8">
                <img src="<?php echo get_template_directory_uri(); ?>/img/icon/app-store-download.png" alt="Download on the App Store"/>
              </a>
              <a class="tip-submission__block__app-download__link" href="https://play.google.com/store/apps/details?id=com.nypd.phonegap2">
                <img src="<?php echo get_template_directory_uri(); ?>/img/icon/google-play-download.png" alt="Get it on Google play"/>
              </a>
            </div>
          </li>

        </ul>

      </div>
    </div>

    <div class="tip-number">

      <div class="wrapper">

        <h2 class="tip-number__title">Once a tip has been submitted tipsters will be given a tip number</h2>

        <div class="tip-number__image">
          <img class="bp-image" src="<?php echo get_template_directory_uri(); ?>/img/asset/img-placeholder.gif" data-img-sm="<?php echo get_template_directory_uri(); ?>/img/asset/tip-number-sm.png" data-img-lg="<?php echo get_template_directory_uri(); ?>/img/asset/tip-number-lg.png" alt="tip number"/>
        </div>

        <div class="tip-number__content">
          <p>Tipsters can use their tip number to call in and check results of their tip. If a tip has led to an arrest and indictment, the tipster will be given a second number to claim their reward.</p>
        </div>

      </div>

    </div>

    <div class="success-stories">

      <div class="wrapper">

        <h2 class="success-stories__title">Success Stories</h2>

        <?php 
          $args = array(
            'post_type' => 'blog_post',
            'posts_per_page' => 4,
            'paged' => $paged, 
          );
          $ss_query = new WP_Query($args); 
          while ($ss_query -> have_posts()) : $ss_query -> the_post(); 
          $bp_img = get_field('blog_img');
        ?>
         
          <div class="story">

            <div class="story__image">
              <?php if (!empty($bp_img) ) { ?>
                <img src="<?php  echo $bp_img['url'];  ?>" alt="Baby Hope"/>
              <?php } ?>
            </div>

            <div class="story__content">
              <p class="story__title"><a href="<?php the_field('blog_link'); ?>" target="_blank"><?php the_title(); ?></a></p>
              <p class="story__subtext"><span>Solved:</span>
                <?php 
                  $date = get_field('date_solved');
                  $y = substr($date, 0, 4);
                  $m = substr($date, 4, 2);
                  $d = substr($date, 6, 2);
                  $time = strtotime("{$d}-{$m}-{$y}");
                  echo date('F Y', $time);
                ?>
              </p>
              <div class="story__blurb">
                <p><?php the_field('bp_excerpt'); ?> ... </p>
              </div>
              <a class="story__link" href="<?php the_field('blog_link'); ?>" target="_blank">Read more &rsaquo;</a>
            </div>

          </div>
         
 
        <?php
          endwhile;
          wp_reset_postdata(); 
        ?>
         <?php
                 if (function_exists(custom_pagination2)) {
                   custom_pagination2($ss_query->max_num_pages,"",$paged);
                 }
               ?>

      </div>

    </div>

  </div>

</main>
<?php get_footer(); ?>