<?php
/*
Plugin Name: Feed modify on your choice
Plugin URI: http://wordpress.org/extend/plugins/feed-modify-on-your-choice/
Description: This plugin modifies RSS feeds and ATOM feeds on your choice.
Author: Kishor
Version: 1.0
Author URI: http://kishorkumarmahato.com.np/
Text Domain: feed-modify-on-your-choice
Domain Path: /languages/

License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html
*/
class feed_modify_on_your_choice {
	private $feed_type = '';

	public function __construct() {
		$this->feed_type = (
			isset($_GET['type'])
			? esc_html($_GET['type'])
			: 'feed'
			);

		remove_filter('do_feed_rdf', 'do_feed_rdf', 10);
		remove_filter('do_feed_rss', 'do_feed_rss', 10);
		remove_filter('do_feed_rss2', 'do_feed_rss2', 10);
		remove_filter('do_feed_atom', 'do_feed_atom', 10);
 		
		add_action('do_feed_rdf', array(&$this, 'custom_feed_rdf'), 10, 1);
		add_action('do_feed_rss', array(&$this, 'custom_feed_rss'), 10, 1);
		add_action('do_feed_rss2', array(&$this, 'custom_feed_rss2'), 10, 1);
		add_action('do_feed_atom', array(&$this, 'custom_feed_atom'), 10, 1);
	}

	private function get_template_file($template_file) {

		// if (function_exists('get_stylesheet_directory') && file_exists( get_stylesheet_directory() . $template_file)) {
		// 	$template_file = get_stylesheet_directory() . $template_file;
		// } elseif (function_exists('get_template_directory') && file_exists( get_template_directory() . $template_file)) {
		// 	$template_file = get_template_directory() . $template_file;
		// } elseif (file_exists(trailingslashit(dirname(__FILE__)) . $template_file)) {
		// 	$template_file = trailingslashit(dirname(__FILE__)) . $template_file;
		// } elseif (file_exists(ABSPATH . WPINC . $template_file)) {
		// 	$template_file = ABSPATH . WPINC . $template_file;
		// } else {
		// 	$template_file = ABSPATH . WPINC . str_replace($this->feed_type, 'feed', $template_file);
		// }
		
			 $dir = plugin_dir_path( __FILE__ );
			 $dir .='feedfile';
			 
			 if (file_exists( $dir. $template_file)) {
			 	$template_file = $dir.$template_file;
			 	// return $template_file;
			 }
			 else{
			 		$template_file = ABSPATH . WPINC . str_replace($this->feed_type, 'feed', $template_file);
			 		// return $template_file;
				 }
			 // print $template_file;
			 
			return $template_file;
		
	}

	public function custom_feed_rdf() {
		$template_file = "/{$this->feed_type}-rdf.php";
		load_template( $this->get_template_file($template_file) );
	}
 
	public function custom_feed_rss() {
		$template_file = "/{$this->feed_type}-rss.php";
		load_template( $this->get_template_file($template_file) );
	}
 
	public function custom_feed_rss2( $for_comments ) {
		$template_file = "/{$this->feed_type}-rss2" . ( $for_comments ? '-comments' : '' ) . '.php';
		load_template( $this->get_template_file($template_file) );
	}
 
	public function custom_feed_atom( $for_comments ) {
		$template_file = "/{$this->feed_type}-atom" . ( $for_comments ? '-comments' : '' ) . '.php';
		load_template( $this->get_template_file($template_file) );
	}
}
new feed_modify_on_your_choice();