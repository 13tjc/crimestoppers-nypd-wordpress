<?php
/*
Author: Hook & Loop
URL: http://themble.com/bones/
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );
// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );
  require_once( 'library/tips-post-type.php' );
  require_once( 'library/blog-post-type.php' );
  require_once( 'library/community-post-type.php' );
  require_once( 'library/home-page-numbers.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  add_filter( 'the_generator', 'bones_rss_version' );
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  add_filter( 'gallery_style', 'bones_gallery_style' );

  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );

  bones_theme_support();

  add_action( 'widgets_init', 'bones_register_sidebars' );

  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
  $content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 150, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );



add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('150px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

function wpa_tag_posts_per_page( $query ) {
    if( ! is_admin()
        && $query->is_tag()
        && $query->is_main_query() ) {
            $query->set( 'posts_per_page', 10 );
    }
}
add_action( 'pre_get_posts', 'wpa_tag_posts_per_page' );

function custom_admin_logo() {
    echo '
        <style type="text/css">
            #wpadminbar #wp-admin-bar-wp-logo>.ab-item {
            background: url(/wp-content/themes/crimestopper-bones/img/logo/nypd-shield-2x.png)
                        no-repeat scroll right center;
            background-size: 23px 24px;
            display: inline-block!important;
            margin: 0 auto;
            margin-top: 1px;
            padding-right: 20px;
            }
            #wpadminbar .ab-icon, 
            #wpadminbar .ab-item:before, 
            #wpadminbar>#wp-toolbar>#wp-admin-bar-root-default .ab-icon {
              display: none;
            }
        </style>
    ';
}
add_action('admin_head', 'custom_admin_logo');

/************* THEME CUSTOMIZE *********************/



function bones_theme_customizer($wp_customize) {
  
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Sidebar 1', 'bonestheme' ),
    'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


function bones_fonts() {
  wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

add_action('wp_enqueue_scripts', 'bones_fonts');

function my_acf_load_field($field) {
  global $wpdb;
  $myarray[1] = "'publish'";
  $myarray[2] = "'draft'";
  $myarray[3] = "'future'";
  $myarray[4] = "'trash'";
  $myarray[5] = "'inherit'";
  $myarray[6] = "'private'";
  $myarray[7] = "'pending'";
  $myarray[8] = "'auto-draft'";

  $newarray = implode(", ", $myarray); //makes format 'hi', 'there', 'everybody' 

  $querystr = "SELECT $wpdb->posts.* 
               FROM $wpdb->posts
               WHERE $wpdb->posts.post_status IN ($newarray)            
               AND $wpdb->posts.post_type = 'cases'";

  $pageposts = $wpdb->get_results($querystr, OBJECT);
  $counts = 0;
  if ($pageposts):
    foreach($pageposts as $post):
      $case_number = date("Y");
      add_post_meta($post->ID, 'incr_number', $counts, true);
      update_post_meta($post->ID, 'incr_number', $counts);

      if (($counts <= 99) && ($counts >= 10)) {

          $field['default_value'] = $case_number . "-0" . $counts++;

        }elseif ($counts <= 9) {

          $field['default_value'] = $case_number . "-00" . $counts++;

        }else{

          $field['default_value'] = $case_number . "-" . $counts++;

        }

    endforeach;
  endif;

  return $field;
  }

add_filter('acf/load_field/name=case_number', 'my_acf_load_field');


function be_hide_editor() {
  // Get the Post ID
  if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
  elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
  if( !isset( $post_id ) ) return;
  // Get the Page Template
  $template_file = get_post_meta( $post_id, '_wp_page_template', true );
  // Exclude on these templates
  $exclude_templates = array( 'template-branch.php' );
  
  // Exclude on these IDs
  $exclude_ids = array( get_option( 'page_on_front' ) );
  if( in_array( $template_file, $exclude_templates ) || in_array( $post_id, $exclude_ids ) )
    wp_enqueue_style( 'hide-editor', get_stylesheet_directory_uri() . '/lib/css/hide-editor.css' );
}
add_action( 'admin_enqueue_scripts', 'be_hide_editor' );


add_action('admin_head','remove_all_parents');


function remove_all_parents() {
  global $pagenow;
  if (in_array($pagenow,array('post-new.php','post.php'))) { // Only for the post add & edit pages
    $css=<<<STYLE
<style>
<!--
#newcustom_boro_parent {
  display:none;
}
#newcustom_cat_parent {
  display:none;
}
#newcustom_cri_parent {
  display:none;
}
#newtips_cat_parent {
  display: none;
}
#newtips_desc_parent {
  display: none;
}
#insert-media-button {
  display:none;
}

-->
</style>
STYLE;
    echo $css;
  }
}
add_action('init','remove_boro_parent');
function remove_boro_parent() {
  register_post_type('cases',
    array(
      'label'           => 'Cases',
      'public'          => true,
      'rewrite'         => array('slug' => 'cases'),
      'hierarchical'    => false,
    )
  );
   register_post_type('tips',
    array(
      'label'           => 'tips',
      'public'          => true,
      'rewrite'         => array('slug' => 'tips'),
      'hierarchical'    => false,
    )
  );


    // Hide Parent in Taxonomy's
    // Tips
   register_taxonomy('tips_desc', 'tips', array(
    'hierarchical'    => true,
    'label'           => 'Description of:',
    'rewrite'         => array('slug' => 'custom-slug' ),
    )
  );
   register_taxonomy('tips_cat', 'tips', array(
    'hierarchical'    => true,
    'label'           => 'Type of Crime',
    'rewrite'         => array('slug' => 'custom-slug' ),
    )
  );
    //Cases
  register_taxonomy('custom_boro', 'cases', array(
    'hierarchical'    => true,
    'label'           => 'Borough',
    'rewrite'         => array('slug' => 'custom-slug' ),
    )
  );
  register_taxonomy('custom_cri', 'cases', array(
    'hierarchical'    => true,
    'label'           => 'Criteria',
    'rewrite'         => array('slug' => 'custom-slug' ),
    )
  );
  register_taxonomy('custom_cat', 'cases', array(
    'hierarchical'    => true,
    'label'           => 'Type of Crime',
    'rewrite'         => array('slug' => 'custom-slug' ),
    )
  );
}


add_action('admin_menu','remove_default_post_type');
function remove_default_post_type() {
  remove_menu_page('edit.php');
}

add_action('admin_menu','remove_default_comments');
function remove_default_comments() {
  remove_menu_page('edit-comments.php');
}

add_action( 'admin_head-edit-tags.php', 'remove_parent_category_custom_cri' );
function remove_parent_category_custom_cri(){
    if ( 'custom_cri' != $_GET['taxonomy'] )
        return;
    $parent = 'parent()';
    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php }

add_action( 'admin_head-edit-tags.php', 'remove_parent_category_custom_boro' );
function remove_parent_category_custom_boro(){
    if ( 'custom_boro' != $_GET['taxonomy'] )
        return;
    $parent = 'parent()';
    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php }

add_action( 'admin_head-edit-tags.php', 'remove_parent_category_custom_cat' );
function remove_parent_category_custom_cat(){
    if ( 'custom_cat' != $_GET['taxonomy'] )
        return;
    $parent = 'parent()';
    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php }


function nypd_login_logo() { ?>

    <style type="text/css">
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo/crimestoppers.png);
            padding-bottom: 10px;
            background-size: 250px 54px;
            width: 250px;
        }
        body{
          background: url(/wp-content/themes/crimestopper-bones/img/bg/nyc-cityscape.jpg) no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
        .login form {
            opacity: .9;
           /* border-radius: 10px*/;
            margin-top: -25px!important;
            border-bottom-left-radius:10px;
            border-bottom-right-radius:10px;
        }
        .login .message {
            display: none;
        }
        .login #backtoblog a, .login #nav a, .login h1 a {
            color: #fff;
        }
        .login h1 {
            background-color: #fff;
            opacity: .9;
            padding-top: 35px;  
            border-top-left-radius:10px;
            border-top-right-radius:10px;
        }
        div#login_error {
            display: none!important;
        }

    </style>

<?php }

add_action( 'login_enqueue_scripts', 'nypd_login_logo' );
// custom loop pagination start

function custom_pagination($numpages = '', $pagerange = '', $paged='') {
  if (empty($pagerange)) {
    $pagerange = 2;
  }
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
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
    $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
    if ( $template_name = 'archive_cases.php' )  {

     $prev = $paged - 1;
     $next = $paged + 1;
     if ($next > $numpages) {
      $next = $numpages;
     }
             $val_sea = $_GET;
            
             foreach ($val_sea as $key) { }

      echo "<div class='pagination'>";
      echo "<div class='pagination__item pagination__item--first'><a href='/cases/page/1/?s=" .  $key ."' class='pagination__link'>First</a></div>";
      echo "<div class='pagination__item pagination__item--prev'><a href='/cases/page/". $prev . "/?s=" .  $key ."' class='pagination__link'>Previous</a></div>";
      echo "<div class='pagination__item pagination__item--current'>Page " . $paged . " of " . $numpages . "</div>";
      echo "<div class='pagination__item pagination__item--next'><a href='/cases/page/". $next . "/?s=" .  $key ."' class='pagination__link'>Next</a></div>";
      echo "<div class='pagination__item pagination__item--last'> <a href='/cases/page/". $numpages . "/?s=" .  $key ."' class='pagination__link'>Last</a></div>";
      echo "</div>";
     
    } elseif ($template_name = 'page-about-us.php' ) {

       $prev = $paged - 1;
       $next = $paged + 1;
       if ($next > $numpages) {
        $next = $numpages;
       }

      echo "<div class='pagination'>";
      echo "<div class='pagination__item pagination__item--first'><a href='/about-us/page/1?s' class='pagination__link'>First</a></div>";
      echo "<div class='pagination__item pagination__item--prev'><a href='/about-us/page/". $prev ."/?s' class='pagination__link'>Previous</a></div>";
      echo "<div class='pagination__item pagination__item--current'>Page " . $paged . " of " . $numpages . "</div>";
      echo "<div class='pagination__item pagination__item--next'><a href='/about-us/page/". $next ."/?s' class='pagination__link'>Next</a></div>";
      echo "<div class='pagination__item pagination__item--last'> <a href='/about-us/page/". $numpages ."/?s' class='pagination__link'>Last</a></div>";
      echo "</div>";

    } else {

       $prev = $paged - 1;
       $next = $paged + 1;
       if ($next > $numpages) {
        $next = $numpages;
       }

      echo "<div class='pagination'>";
      echo "<div class='pagination__item pagination__item--first'><a href='/page/1?s' class='pagination__link'>First</a></div>";
      echo "<div class='pagination__item pagination__item--prev'><a href='/page/". $prev ."/?s' class='pagination__link'>Previous</a></div>";
      echo "<div class='pagination__item pagination__item--current'>Page " . $paged . " of " . $numpages . "</div>";
      echo "<div class='pagination__item pagination__item--next'><a href='/page/". $next ."/?s' class='pagination__link'>Next</a></div>";
      echo "<div class='pagination__item pagination__item--last'> <a href='/page/". $numpages ."/?s' class='pagination__link'>Last</a></div>";
      echo "</div>";

    }
  }

}
function custom_pagination2($numpages = '', $pagerange = '', $paged='') {
  if (empty($pagerange)) {
    $pagerange = 2;
  }
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
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
   
     $prev = $paged - 1;
     $next = $paged + 1;
     if ($next > $numpages) {
      $next = $numpages;
     }
            
      echo "<div class='pagination'>";
      echo "<div class='pagination__item pagination__item--first'><a href='/about-us/page/1?s' class='pagination__link'>First</a></div>";
      echo "<div class='pagination__item pagination__item--prev'><a href='/about-us/page/". $prev ."/?s' class='pagination__link'>Previous</a></div>";
      echo "<div class='pagination__item pagination__item--current'>Page " . $paged . " of " . $numpages . "</div>";
      echo "<div class='pagination__item pagination__item--next'><a href='/about-us/page/". $next ."/?s' class='pagination__link'>Next</a></div>";
      echo "<div class='pagination__item pagination__item--last'> <a href='/about-us/page/". $numpages ."/?s' class='pagination__link'>Last</a></div>";
      echo "</div>";

   
  }

}
// custom loop pagination end

 if ( is_singular( 'cases' ) ) {

  function search_custom_boro(&$query){
      if ($query->is_search)
          $query->set('taxonomy', 'custom_boro');
  }
  add_action('parse_query', 'search_custom_boro');

  function search_custom_cri(&$query){
      if ($query->is_search)
          $query->set('taxonomy', 'custom_cri');
  }
  add_action('parse_query', 'search_custom_cri');


  function search_custom_cat(&$query){
      if ($query->is_search)
          $query->set('taxonomy', 'custom_cat');
  }
  add_action('parse_query', 'search_custom_cat');


  function custom_search_where($where){ 
    global $wpdb;
    if (is_search() && get_search_query())
      $where .= "OR ((t.name LIKE '%".get_search_query()."%' OR t.slug LIKE '%".get_search_query()."%') AND {$wpdb->posts}.post_status = 'publish')";
    return $where;
  }

  function custom_search_join($join){
    global $wpdb;
    if (is_search()&& get_search_query())
      $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
    return $join;
  }

  function custom_search_groupby($groupby){
    global $wpdb;

    // we need to group on post ID
    $groupby_id = "{$wpdb->posts}.ID";
    if(!is_search() || strpos($groupby, $groupby_id) !== false || !get_search_query()) return $groupby;

    // groupby was empty, use ours
    if(!strlen(trim($groupby))) return $groupby_id;

    // wasn't empty, append ours
    return $groupby.", ".$groupby_id;
  }

  add_filter('posts_where','custom_search_where');
  add_filter('posts_join', 'custom_search_join');
  add_filter('posts_groupby', 'custom_search_groupby');

}

add_filter("the_excerpt", "break_text");
function break_text($text){
      $length = 200;
    if(strlen($text)<$length+10) return $text;//don't cut if too short
      $break_pos = strpos($text, ' ', $length);//find next space after desired length
      $visible = substr($text, 0, $break_pos);
    return balanceTags($visible) . "";
}
add_theme_support( 'menus' );

function add_menuclass($ulclass) {
   return preg_replace('/<a /', '<a class="footer__nav__item__link"', $ulclass);
}
add_filter('wp_nav_menu','add_menuclass');


add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
add_filter( 'page_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions ){
    if( get_post_type() === 'tips') {
            unset( $actions['view'] );
    }
    return $actions;
}

function remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  ?>
  <style>
  div#postbox-container-2 {display:none;}
  div#postbox-container-3 {display:none;}
  div#postbox-container-4 {display:none;}
  </style>
<?php
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/**
 * CrimeStoppers Custom Dashboard. 
 */
/**
 **************** TIP
**/
add_filter( 'pre_get_shortlink', function( $false, $post_id ) {
    return 'tips' === get_post_type( $post_id ) ? '' : $false;
}, 10, 2 );

add_filter( 'get_sample_permalink_html', 'wpse_125800_sample_permalink' );
  function wpse_125800_sample_permalink( $return ) {
    if( get_post_type() === 'tips') {
      $return = '';
      }
      return $return; 
  }

 $user = wp_get_current_user();
  $allowed_roles = array('occb', 'iab', 'psp');
      if( array_intersect($allowed_roles, $user->roles ) ) { 

        echo "";

        }else{ 

function tip_add_dashboard_widgets() { ?> 
  <style>
    .js .postbox .hndle, .js .widget .widget-top {
    cursor: move;
    font-size: 15px!important;
    font-weight: 900;

    }
    #dashboard-widgets .postbox-container, #wpbody-content #dashboard-widgets.columns-4 .postbox-container {
    width: 100%!important;
    }
  </style>
  <?php
    wp_add_dashboard_widget(
                     'tip_dashboard_widget',         
                     'Quick Links',         
                     'tip_dashboard_widget_function' // Display function.
            );  
    }
    add_action( 'wp_dashboard_setup', 'tip_add_dashboard_widgets' );


function tip_dashboard_widget_function() { ?>
<style>
.quick-out{
  display: table;
  table-layout: fixed;
  width: 100%;
}
.single-link{
  display: table-cell;
  vertical-align: middle;
}
.single-link a > div {
  display: inline-block;
  margin-right: 10px;
  vertical-align: middle;
}
.quick-out .single-link a {
  display: block;
}
.single-link p{
  display: inline-block;
  line-height: inherit;
  margin: 0;
  padding: 0;
  vertical-align: middle;
  font-size: 18px;
  color: #99a1aa;
}
.single-link:hover p{
  color: #0073aa;
}
/*tips*/
.imgBox-tips{ 
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-tips-02.png) no-repeat;
  background-size: 50px 50px;
  display: inline-block;
}
.imgBox-tips:hover{
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-tips-01.png) no-repeat;
  background-size: 50px 50px;
}
/*cases*/
.imgBox-cases{ 
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-cases-02.png) no-repeat;
  background-size: 50px 50px;
  display: inline-block;
}
.imgBox-cases:hover{
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-cases-01.png) no-repeat;
  background-size: 50px 50px;
} 
/*stats*/
.imgBox-stats{ 
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-stats-02.png) no-repeat;
  background-size: 50px 50px;
  display: inline-block;
}
.imgBox-stats:hover{
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-stats-01.png) no-repeat;
  background-size: 50px 50px;
}
/*profile*/
.imgBox-profile{ 
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-profile-02.png) no-repeat;
  background-size: 50px 50px;
  display: inline-block;
}
.imgBox-profile:hover{
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-profile-01.png) no-repeat;
  background-size: 50px 50px;
}
/*media*/
.imgBox-media{ 
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-media-02.png) no-repeat;
  background-size: 50px 50px;
  display: inline-block;
}
.imgBox-media:hover{
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-media-01.png) no-repeat;
  background-size: 50px 50px;
}
/*community*/
.imgBox-community{ 
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-news-02.png) no-repeat;
  background-size: 50px 50px;
  display: inline-block;
}
.imgBox-community:hover{
  width: 50px;
  height: 50px;
  background: url(/wp-content/themes/crimestopper-bones/img/asset/dashicon-news-01.png) no-repeat;
  background-size: 50px 50px;
}
</style>
<?php

  echo "<div class='quick-out'>";
            //Tips
      echo "<div class='single-link'>
              <a href='edit.php?post_type=tips'>
                <div class='imgBox-tips'></div>             
                <p>Tips</p> 
              </a>
            </div>";
            //cases
      echo "<div class='single-link'>
              <a href='edit.php?post_type=cases'>
                <div class='imgBox-cases'></div> 
                <p>Cases</p>
              </a>
            </div>";
            //stats
      echo "<div class='single-link'>
              <a href='admin.php?page=ahc_hits_counter_menu_pro'>
                <div class='imgBox-stats'></div> 
                <p>Stats</p>
              </a>
            </div>";
             //Profile
      echo "<div class='single-link'>
              <a href='profile.php'>
                  <div class='imgBox-profile'></div> 
                  <p>Profile</p> 
              </a>
            </div>";
             //media
      echo "<div class='single-link'>
              <a href='upload.php'>
                <div class='imgBox-media'></div> 
                <p>Media</p>
              </a>
            </div>";
             //Community
      echo "<div class='single-link'>
              <a href='edit.php?post_type=community'>
                <div class='imgBox-community'></div>
                <p>Community News</p>
              </a>
            </div>";
     
  echo "</div>";

 

}


}
function stats_add_dashboard_widgets() {
  wp_add_dashboard_widget(
                 'stats_dashboard_widget',         
                 'Real Time Statistics',         
                 'stats_dashboard_widget_function' 
        );  
}

add_action( 'wp_dashboard_setup', 'stats_add_dashboard_widgets' );

function stats_dashboard_widget_function() { 

$myend_date = ahcpro_last_hit_date(); // ? last_hit_date() : date('Y-m-d', strtotime('-1 hour'));
$mystart_date = date('Y-m-d',strtotime($myend_date.' - '.(AHCPRO_VISITORS_VISITS_LIMIT-1).' days'));
echo ahcpro_include_scripts();
  // echo ahcpro_get_visits_by_date() . "<br>";
  // echo ahcpro_get_visitors_by_date();
?>
<style type="text/css">
.greenBox {
    background: url("")!important;
    background-position: bottom left;
    background-color: #525a66!important;
}
.redBox {
    background: url("")!important;
    background-position: bottom left;
    background-color: #e6a422!important;
}
.blueBox {
    background: url("")!important;
    background-position: bottom left;
    background-color: #2ea8e6!important;
}
.movBox {
    background: url("")!important;
    background-position: bottom left;
    background-color: #2d64b3!important;
}
.box_widget {
    height: 137px;
    font-family: 'Open Sans', sans-serif;
    color: #FFF;
    font-size: 40px;
    padding-right: 10px;
    text-align: left!important;
    padding-top: 55px!important;
    line-height: 34px!important;
    padding-left: 20px!important;
    text-transform: uppercase;

}
.box_widget .txt{
    opacity: 0.5;
    font-size: 18px;

}
</style>
  <style>
    .js .postbox .hndle, .js .widget .widget-top {
    cursor: move;
    font-size: 15px!important;
    font-weight: 900;

    }
    #dashboard-widgets .postbox-container, #wpbody-content #dashboard-widgets.columns-4 .postbox-container {
    width: 100%!important;
    }
  </style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript">
function imgFlagError(image){
    image.onerror = "";
    image.src = "<?php echo plugins_url('/images/flags/noFlag.png', AHCPRO_PLUGIN_MAIN_FILE) ?>";
    return true;
}
</script>

<?php

  $myend_date = ahcpro_last_hit_date(); // ? last_hit_date() : date('Y-m-d', strtotime('-1 hour'));
  $mystart_date = date('Y-m-d',strtotime($myend_date.' - '.(AHCPRO_VISITORS_VISITS_LIMIT-1).' days'));

  $ahc_sum_stat = ahcpro_get_summary_statistics();

?>


<div class="ahc_main_container">
    <div class="row-noshow">
<div class="hitsLogo"></div><h1>&nbsp;&nbsp;<br />&nbsp;Visitors Traffic Real Time Statistics pro <a title="change settings" href="admin.php?page=ahc_hits_counter_settings"><img src="<?php echo plugins_url('/images/settings.jpg', AHCPRO_PLUGIN_MAIN_FILE) ?>" /></a></h1><br /><br /><br />
    </div>
<div class="row">
<div class="col-md-3">
    <div class="box_widget greenBox" >
  <span id="up-down"></span><span id="onlinecounter"><?php echo ahcpro_countOnlineusers();?></span>
  <br /><span class="txt"><img src="<?php echo plugins_url('/images/live.gif', AHCPRO_PLUGIN_MAIN_FILE) ?>">&nbsp; online users</span>
    </div>
</div>

<div class="col-md-3">
    <div class="box_widget redBox">
    <span id="today_visitors_box"><?php echo ahc_pro_NumFormat($ahc_sum_stat['today']['visitors']); ?></span><br /><span class="txt">Today Visitors</span>
    </div>
</div>

<div class="col-md-3">
    <div class="box_widget blueBox">
    <span id="today_visits_box"><?php echo ahc_pro_NumFormat($ahc_sum_stat['today']['visits']); ?></span><br /><span class="txt">Today Visits</span>
    </div>
</div>
<?php
    $totalSER = ahcpro_get_total_visits_by_search_engines();
    $searchEngines = ahcpro_get_all_search_engines();
    $todaysSER = ahcpro_get_hits_search_engines_referers('today');
    $yesterdaysSER = ahcpro_get_hits_search_engines_referers('yesterday');

    $todayTotal = 0;
    $yesterdayTotal = 0;
    if(is_array($searchEngines)){
        foreach($searchEngines as $ser){

            $todayTotal += $todayCount =(isset($todaysSER[$ser['srh_id']]))? $todaysSER[$ser['srh_id']] : 0;
            $yesterdayTotal += $yesterdayCount = (isset($yesterdaysSER[$ser['srh_id']]))? $yesterdaysSER[$ser['srh_id']] : 0;
                if($todayCount == 0 && $yesterdayCount == 0){
                    continue;
                }
              }
            }
?>
<div class="col-md-3">
    <div class="box_widget movBox">
    <span id="today_search_box"><?php echo ahc_pro_NumFormat($todayCount); ?></span><br /><span class="txt">Search Engines</span>
    </div>
</div>
 

</div>


<style>.row-noshow { display: none!important; } </style>

<?php }

function statsgraph_add_dashboard_widgets() {
  wp_add_dashboard_widget(
                 'statsgraph_dashboard_widget',         
                 'Site Visits',         
                 'statsgraph_dashboard_widget_function' 
        );  
}

add_action( 'wp_dashboard_setup', 'statsgraph_add_dashboard_widgets' );

function statsgraph_dashboard_widget_function() { 
$myend_date = ahcpro_last_hit_date(); // ? last_hit_date() : date('Y-m-d', strtotime('-1 hour'));
$mystart_date = date('Y-m-d',strtotime($myend_date.' - '.(AHCPRO_VISITORS_VISITS_LIMIT-1).' days'));
echo ahcpro_include_scripts(); ?>
<style>
.stat-graph {
    height: 35px!important;
    font-size: 13px!important;
    margin-top: 123px!important;
    margin-left: 182px!important;
    position: absolute;
    z-index: 3;
    font-weight: 900!important;
}

</style>
<div class="row">
    <div class="col-md-12">
        <div>
            <h2 class="stat-graph">Displaying Results for Past <?php echo AHCPRO_VISITORS_VISITS_LIMIT?> days</h2>
            <div class="panelcontent" >
          <div id="visitscounthp" style="height:400px;"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

        var visit_chart;
            jQuery(document).ready(function(){
            
        var visit_data_line = <?php echo ahcpro_get_visits_by_date()?>;
        var visitor_data_line = <?php echo ahcpro_get_visitors_by_date()?>;

              visit_chart = jQuery.jqplot('visitscounthp', [visit_data_line, visitor_data_line], {
                title: {
                  text: '',
                  fontSize: '10px',
                  fontFamily: 'Tahoma',
                  textColor: '#000000',
                  },
                axes: {
                  xaxis: {
                      min: '<?php echo $mystart_date?>',
                      max: '<?php echo $myend_date?>',
                      tickInterval: '1 day',
                      renderer:jQuery.jqplot.DateAxisRenderer,
                      tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
                      tickOptions: { 
                        angle: -40,
                        formatString:'%d/%m',
                        showGridline: true, 
                        },
                    },                    
                  yaxis: {
                      min: 0,
                      padMin: 1.0,
                      label: '',
                      labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer,
                      labelOptions: {
                        angle: -100,
                        fontSize: '12px',
                        fontFamily: 'Tahoma',
                        fontWeight: 'bold',
                      },
                    }
                  },
                legend: {
                  show: true,
                  location: 's',
                  placement: 'outsideGrid',
                  labels: ['Visit', 'Visitor'],
                  renderer: jQuery.jqplot.EnhancedLegendRenderer,
                  rendererOptions:
                    {
                      numberColumns: 2, 
                      disableIEFading: false,
                      border: 'none',
                    },
                  },
                highlighter: {
                  show: true,
                  bringSeriesToFront: true,
                  tooltipAxes: 'xy',
                  formatString: '%s:&nbsp;<b>%i</b>&nbsp;',
                  tooltipContentEditor: tooltipContentEditor,
                },
                grid: {
                 drawGridlines: true,
                 borderColor: 'transparent',
                 shadow: false,
                 drawBorder: false,
                 shadowColor: 'transparent'
                },
              } );

              function tooltipContentEditor(str, seriesIndex, pointIndex, plot) {
                // display series_label, x-axis_tick, y-axis value
                return plot.legend.labels[seriesIndex] + ", " + str;;
              }
              
              jQuery(window).resize(function() {
                JQPlotVisitChartLengendClickRedraw()
              });

              function JQPlotVisitChartLengendClickRedraw() {
                visit_chart.replot( {resetAxes: ['yaxis'] } );
                
                jQuery('div[id="visitscounthp"] .jqplot-table-legend').click(function() {
                  JQPlotVisitChartLengendClickRedraw();
                });
              }
              
              jQuery('div[id="visitscounthp"] .jqplot-table-legend').click(function() {
                JQPlotVisitChartLengendClickRedraw()
              });

            });
</script>
<?php }


function add_query_vars_filter( $avars ){
  $avars[] = "borough";
 
  return $avars;
  
}
add_filter( 'query_vars', 'add_query_vars_filter' );
function add_query_vars_filter_b( $bvars ){

  $bvars[] = "crime";
  
  return $bvars;
 
}
add_filter( 'query_vars', 'add_query_vars_filter_b' );

function add_query_vars_filter_c( $cvars ){
 
  $cvars[] = "criteria";
  
  return $cvars;
}
add_filter( 'query_vars', 'add_query_vars_filter_c' );

/*
CUSTOM USER ROLES
*/

add_action( 'admin_init', 'my_role_caps' );

function my_role_caps() {

  $role = get_role( 'editor' );
  $role->add_cap('delete_tips');
  $role->add_cap('delete_private_tips');
  $role->add_cap('delete_published_tips');
  $role->add_cap('delete_others_tips');
  $role->add_cap('read_private_tips');
  $role->add_cap('edit_tips');
  $role->add_cap('edit_private_tips');
  $role->add_cap('edit_published_tips');
  $role->add_cap('edit_others_tips');
}

add_role('occb', 'OCCB', array(
    'read' => true,
    'edit_posts' => true,
    'delete_posts' => false,
));
function add_capability(){
    $role = get_role('occb');
    $role->add_cap('read_private_tips');
    $role->add_cap('edit_tips');
    $role->add_cap('edit_private_tips');
    $role->add_cap('edit_published_tips');
    $role->add_cap('edit_others_tips');
}
add_action('admin_init', 'add_capability');
/**/
/**//**/
add_role('iab', 'IAB', array(
    'read' => true,
    'edit_posts' => true,
    'delete_posts' => false,
));
function add_capability_iab(){
    $role = get_role('iab');
    $role->add_cap('read_private_tips');
    $role->add_cap('edit_tips');
    $role->add_cap('edit_private_tips');
    $role->add_cap('edit_published_tips');
    $role->add_cap('edit_others_tips'); // to be sure
}
add_action('admin_init', 'add_capability_iab');
/**/
add_role('psb', 'PSB', array(
    'read' => true,
    'edit_posts' => true,
    'delete_posts' => false,
));
function add_capability_psb(){
    $role = get_role('psb');
    $role->add_cap('read_private_tips');
    $role->add_cap('edit_tips');
    $role->add_cap('edit_private_tips');
    $role->add_cap('edit_published_tips');
    $role->add_cap('edit_others_tips');
}
add_action('admin_init', 'add_capability_psb');
/**/
/**//**/
  $user = wp_get_current_user();
  $allowed_roles = array('occb', 'iab', 'psb');
      if( array_intersect($allowed_roles, $user->roles ) ) { 

          function remove_menus(){

              remove_menu_page( 'edit.php?post_type=cases');
              remove_menu_page( 'edit.php?post_type=blog_post');
              remove_menu_page( 'edit.php?post_type=community');
              remove_menu_page( 'tools.php');      

             }
          add_action( 'admin_menu', 'remove_menus' );
      } 


function my_page_columns($columns)
{
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title'   => 'Title',
    'department' => 'Department',
    'date'    =>  'Date'
  );
  return $columns;
}

function my_custom_columns($column){
  global $post;
  
   $depart = get_field('department');

   if ($depart != null) {
     echo $depart;
   }
   
}
function my_column_register_sortable( $columns ){

  $columns['department'] = 'department';


  return $columns;
}

add_filter("manage_edit-tips_sortable_columns", "my_column_register_sortable" );

add_action("manage_tips_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-tips_columns", "my_page_columns");

function wpa84258_admin_posts_sort( $query ){
    global $pagenow;
    $user = wp_get_current_user();
    $allowed_roles = array('editor', 'administrator');
     if( !array_intersect($allowed_roles, $user->roles ) ) {  

      if('edit.php' == $pagenow && !isset( $_GET['department'] ) && !isset( $_GET['tips'] ) ){
            $query->set( 'meta_key', 'department' );
            $query->set( 'orderby', 'meta_value' );

              $user = wp_get_current_user();
              $allowed_roles = array('occb');
                if( array_intersect($allowed_roles, $user->roles ) ) {  
                    $query->set( 'meta_value', 'occb' );
                }
                $allowed_psb = array('psb');
                if( array_intersect($allowed_psb, $user->roles ) ) {  
                    $query->set( 'meta_value', 'psb' );
                }
                $allowed_iab = array('iab');
                if( array_intersect($allowed_iab, $user->roles ) ) {  
                    $query->set( 'meta_value', 'iab' );
                }
                  
            
      }
    }
  }

add_action( 'pre_get_posts', 'wpa84258_admin_posts_sort' );
/* DON'T DELETE THIS CLOSING TAG */ ?>