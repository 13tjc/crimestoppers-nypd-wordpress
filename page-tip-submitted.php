<?php
/*
 Template Name: Tip Submitted
*/
?>
<?php get_header(); ?>
<?php 
$tip_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $tip_link . "<br>";
$tip_number = substr($tip_link, -5);
//echo $tip_number;
$newURL = "/404.php";

?>
<?php if ($tip_number == "tted/"){ ?>
<script>
window.location.replace("/404.php");

</script>

<?php } else { ?>
<main class="main" role="main">

  <div class="hero" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/bg/nyc-hero.jpg);"></div>

  <div class="submit-tip">

    <div class="wrapper">

      <div class="page-title">

        <h1>Tip Submitted</h1>

      </div>

      <div class="submit-tip__confirmation">

        <h2 class="submit-tip__confirmation__title">Thank you. Your tip has been reported.</h2>

        <div class="submit-tip__confirmation__block">

          <p class="submit-tip__confirmation__block__label">Your tip number is:</p>

          <p class="submit-tip__confirmation__block__number"><?php echo $tip_number;?></p>

        </div>

        <p class="submit-tip__confirmation__instructions">Please save your tip number and call our tips hotline in two weeks.If your tip has lead to an arrest and indictment, you will be given a second set of numbers to use for claiming your cash rewards.</p>

      </div>

    </div>

  </div>

</main>

<?php } ?>
<?php get_footer(); ?>