<?php
/* Our custom functions.php file for putting is hooks and other goodness
 * Customize to your liking
 */

// Custom default header image.
define('HEADER_IMAGE', get_bloginfo('stylesheet_directory') . '/images/banner.jpg'); // 

// Removed existing twentyten headers
function yourchildtheme_remove_twenty_ten_headers(){ //source: http://aaron.jorb.in/blog/2010/07/remove-all-default-header-images-in-a-twenty-ten-child-theme/
    unregister_default_headers( array(
        'berries',
        'cherryblossom',
        'concave',
        'fern',
        'forestfloor',
        'inkwell',
        'path',
        'sunset')
    );
}
add_action( 'after_setup_theme', 'yourchildtheme_remove_twenty_ten_headers', 11 );

// Add new headers if needed
function banner_setup() {
    $theme_dir =   get_bloginfo('stylesheet_directory');
    register_default_headers( array (
        'road' => array (
            'url' => "$theme_dir/images/banner.jpg",
            'thumbnail_url' => "$theme_dir/images/banner-thumbnail.jpg",
            'description' => __( 'Banner', 'banner' )
        )
    ));
}
add_action( 'after_setup_theme', 'banner_setup' );

// Add favicon to head
function favicon_link() {
    echo '<link rel="shortcut icon" href="' . get_bloginfo('stylesheet_directory') . '/images/favicon.png">' . "\n";
}
add_action('wp_head', 'favicon_link');

// Hide update notice
function hide_update_notice() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_notices', 'hide_update_notice', 1 );

// Post thumbnails 
/* function post_thumbnail_setup() {
    set_post_thumbnail_size( 940, 198, true );
    add_image_size( 'single-post-thumbnail', 250, 250 );
}
add_action( 'init', 'post_thumbnail_setup' ); */

// Prevent duplicate comment pages
function canonical_for_comments() {
    global $cpage, $post;
    if ( $cpage > 1 ) :
        echo "\n";
        echo "<link rel='canonical' href='";
        echo get_permalink( $post->ID );
        echo "' />\n";
     endif;
}
add_action( 'wp_head', 'canonical_for_comments' );

// Enqueue scripts
function my_load_scripts() {
    if (!is_admin()) {
        // remove jquery and load it instead from google's cdn
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js');
        wp_enqueue_script( 'jquery' );
        // register your script location, dependencies and version
        wp_register_script('custom_script',
            get_bloginfo('template_directory') . '/js/site.js',
            array('jquery'),
            '1.0' );
        // enqueue the script
        wp_enqueue_script('custom_script');
    }
}    
add_action('init', 'my_load_scripts');
