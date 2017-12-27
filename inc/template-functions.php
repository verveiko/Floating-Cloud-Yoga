<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package FloatingCloudYoga
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function floatingcloudyoga_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'floatingcloudyoga_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function floatingcloudyoga_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'floatingcloudyoga_pingback_header' );



/**
* Content Embed Max Size
*/
function floatingcloudyoga_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'floatingcloudyoga_content_width', 640 );
}
add_action( 'after_setup_theme', 'floatingcloudyoga_content_width', 0 );



//REMOVES PHP ERROR NOTICE FOR OB FLUSH
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

// Custom Excerpt
function custom_wp_trim_excerpt($text) {
  $raw_excerpt = $text;
  if ( '' == $text ) {
    $text = get_the_content(''); // Original Content
    $text = strip_shortcodes($text); // Minus Shortcodes
    $text = apply_filters('the_content', $text); // Filters
    $text = str_replace(']]>', ']]&gt;', $text); // Replace
    
    $excerpt_length = apply_filters('excerpt_length', 55); // Length
    $excerpt_more = apply_filters('excerpt_more', ' ' . '<a class="readmore" href="'. get_permalink() .'">Read more...</a>');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
    
    // Use First Video as Excerpt
    $postcustom = get_post_custom_keys();
    if ($postcustom){
      $i = 1;
      foreach ($postcustom as $key){
        if (strpos($key,'oembed')){
          foreach (get_post_custom_values($key) as $video){
            if ($i == 1){
              $text = $video.$text;
            }
          $i++;
          }
        }  
      }
    }
  }
  return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');
