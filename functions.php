<?php

	require_once locate_template('includes/categoria-custom-fields.php');
	
	 // CONTENT WIDTH & feedlinks 

	if ( ! isset( $content_width ) ) $content_width = 900;
	add_theme_support( 'automatic-feed-links' );

?>
<?php // REPLY comment script 

	function fullby_enqueue_comments_reply() {
		if( get_option( 'thread_comments' ) )  {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'comment_form_before', 'fullby_enqueue_comments_reply' );
	
?>
<?php // MENU 

	add_action( 'after_setup_theme', 'wpt_setup' );
    if ( ! function_exists( 'wpt_setup' ) ):
        function wpt_setup() { 
            register_nav_menu( 'primary', __( 'Primary navigation', 'wptuts' ) );
            register_nav_menu( 'secondary', __( 'Secondary navigation', 'wptuts' ) );
    } endif;
?>
<?php // BOOTSTRAP MENU - Custom navigation walker (Required)
    require_once('wp_bootstrap_navwalker.php');
?>
<?php // CUSTOM THUMBNAIL 

	add_theme_support('post-thumbnails');
	
	if ( function_exists('add_theme_support') ) {
		add_theme_support('post-thumbnails');
	}
	
	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'quad', 400, 400, true ); //(cropped)
		add_image_size( 'single', 800, 494, true ); //(cropped)
	}

?>
<?php // WIDGET SIDEBAR 

	if ( function_exists('register_sidebar') )
		register_sidebar(array('name'=>'Primary Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',	
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'Secondary Sidebar',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',	
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

?>
<?php // METABOX POST (Video,[...])

add_action( 'add_meta_boxes', 'meta_box_post' );

	function meta_box_post( $post ) {
	
	    add_meta_box(
	            'meta-box-post', // ID, should be a string
	            'YouTube Video', // Meta Box Title
	            'meta_box_post_content', // Your call back function, this is where your form field will go
	            'post', // The post type you want this to show up on, can be post, page, or custom post type
	            'normal', // The placement of your meta box, can be normal or side
	            'high' // The priority in which this will be displayed
	        );
	        
	}
	
	// Content for the custom meta box
	function meta_box_post_content() {
	
		// info current post
	    global $post;
	    
	    //metabox value if is saved
	    $fullby_video = get_post_meta($post->ID, 'fullby_video', true);
	    // ADD here more custom field 	    
	    
	    // security check
	    wp_nonce_field(__FILE__, 'fullby_nonce');
	    ?>
	    <p>To show a video in the article paste the id of a YouTube video in the box below. <br/><input name="fullby_video" id="fullby_video" value="<?php echo $fullby_video; ?>" style="border: 1px solid #ccc; margin: 10px 10px 0 0"/> <small>If the url is http://www.youtube.com/watch?v=<strong>UWHeEI7aOvc</strong>, the ID is <strong>UWHeEI7aOvc</strong>.</small></p>
	    <!-- *** ADD here more custom field  *** -->	    
	    
	    <?php
		
	}

// save function only when save
add_action('save_post', 'save_resource_meta');

	function save_resource_meta(){
    // post info
	    global $post;
	    // don't autosave metabox
	    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	        return;
	    }
	    
	    // security check:
	    // chek if hidden field wp_nonce_field()
	    // is correct, if isn't don't save the field
	    if ($_POST && wp_verify_nonce($_POST['fullby_nonce'], __FILE__) ) {
	        // check if the value is in the form
	        if ( isset($_POST['fullby_video']) ) {
	            // save info metabox
	            update_post_meta($post->ID, 'fullby_video', $_POST['fullby_video']);
	            //ADD here more custom field 
	        }
	    }  
	}
?>
<?php // POPULAR POST 

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/* add post views to single page */
function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

?>
<?php // THEME OPTIONS

add_action('admin_menu', 'fullby_theme_page');
function fullby_theme_page ()
{
	if ( count($_POST) > 0 && isset($_POST['fullby_settings']) )
	{
		$options = array ('description','analytics','url','mensaje','imagen-header','footer-desc','derechos','footer-logo','hashtag');
		
		foreach ( $options as $opt )
		{
			delete_option ( 'fullby_'.$opt, $_POST[$opt] );
			add_option ( 'fullby_'.$opt, $_POST[$opt] );	
		}			
		 
	}
	add_theme_page('Theme Options', 'Theme Options', 'edit_themes', basename(__FILE__), 'fullby_settings');
	
}
function fullby_settings()
{
	require_once locate_template('vendor/themeoptions.php');
}
?>
<?php
/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 *
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true, the sidebar will NOT be displayed.
 *
 * @link http://roots.io/the-roots-sidebar/
 *
 * @param array list of conditional tags (http://codex.wordpress.org/Conditional_Tags)
 * @param array list of page templates. These will be checked via is_page_template()
 *
 * @return boolean True will display the sidebar, False will not
 */
class agrega_sidebar {
  private $conditionals;
  private $templates;

  public $display = true;

  function __construct($conditionals = array(), $templates = array()) {
    $this->conditionals = $conditionals;
    $this->templates    = $templates;

    $conditionals = array_map(array($this, 'check_conditional_tag'), $this->conditionals);
    $templates    = array_map(array($this, 'check_page_template'), $this->templates);

    if (in_array(true, $conditionals) || in_array(true, $templates)) {
      $this->display = false;
    }
  }

  private function check_conditional_tag($conditional_tag) {
    if (is_array($conditional_tag)) {
      return $conditional_tag[0]($conditional_tag[1]);
    } else {
      return $conditional_tag();
    }
  }

  private function check_page_template($page_template) {
    return is_page_template($page_template);
  }
}


	/**
	 * Define which pages shouldn't have the sidebar
	 *
	 * See lib/sidebar.php for more details
	 */
	function agrega_display_sidebar() {
	  $sidebar_config = new agrega_sidebar(
	    /**
	     * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
	     * Any of these conditional tags that return true won't show the sidebar
	     *
	     * To use a function that accepts arguments, use the following format:
	     *
	     * array('function_name', array('arg1', 'arg2'))
	     *
	     * The second element must be an array even if there's only 1 argument.
	     */
	    array(
	      'is_404',
	      'is_front_page',
	      // 'is_category'
	      'is_home'
	    ),
	    /**
	     * Page template checks (via is_page_template())
	     * Any of these page templates that return true won't show the sidebar
	     */
	    array(
	      'page-full.php',
	      'page-roteiros.php'
	    )
	  );

	  return apply_filters('agrega_display_sidebar', $sidebar_config->display);
	}

/**
 * .main classes
 */
function agrega_main_class() {
  if (agrega_display_sidebar()) {
    // Classes on pages with the sidebar
    $class = 'col-md-9';
  } else {
    // Classes on full width pages
    $class = 'col-md-12';
  }

  return $class;
}
/**
 * .sidebar classes
 */
function roots_sidebar_class() {
  return 'col-sm-5';
}

function is_desc_cat($cats, $_post = null) {
  foreach ((array)$cats as $cat) {
    if (in_category($cat, $_post)) {
      return true;
    } else {
      if (!is_int($cat)) $cat = get_cat_ID($cat);
      $descendants = get_term_children($cat, 'category');
      if ($descendants && in_category($descendants, $_post)) return true;
    }
  }

return false;
}

function keep_my_links($text) {
  global $post;
if ( '' == $text ) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    $text = strip_tags($text, '<a>');
  }
  return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'keep_my_links');


?>