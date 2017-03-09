<?php get_header(); ?>

<main class="main" role="main">

  <div class="page-not-found">

    <div class="page-not-found__container">

      <div class="page-not-found__header">
        <h1 class="page-not-found__title">404 Error</h1>
        <h2 class="page-not-found__subtitle">Sorry. This page could not be found.</h2>
      </div>

      <div class="page-not-found__content">

        <p>The page you are looking for appears to have moved, or it has been deleted, or it does not exist.</p>
        <p>Please try using our search bar if you need help finding the page you are looking for.</p>

        <form  role="search" method="get" action="<?php echo home_url( '/' ); ?>">
          <div class="searchbox">
            <input class="field__input searchbox__input" id="search-field" name="s" type="search" placeholder="Search"  type="search" id="s" name="s" >
            <button class="searchbox__button" type="submit" id="searchsubmit" >Search</button>
          </div>
        </form>

      </div>

    </div>
    
  </div>

</main>

<?php get_footer(); ?>
