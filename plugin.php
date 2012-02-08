<?php
/*
Plugin Name: Path
Plugin URI: path
Description: Display your Path activity
Version: 1.0
Author: Mathieu BUONOMO
Author URI: www.mathieubuonomo.com
Author Email: mbuonomo@gmail.com
License:

  Copyright 2011 TODO (email@domain.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include('class.path.php');
/*
$api = new path_wrapper();

$user = $api->login('mbuonomo@gmail.com', 'bdsbqzyz');

echo $api->user->id;

$data = $api->getHome();

echo '<pre>';
print_r($data);
*/
class PathActivity extends WP_Widget {

	private $_pathusername = '';
	private $_pathpassword = '';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * The widget constructor. Specifies the classname and description, instantiates
	 * the widget, loads localization files, and includes necessary scripts and
	 * styles.
	 */
  // TODO: This should match the title given in the class definition above.
	function PathActivity() {
    // Define constnats used throughout the plugin
    $this->init_plugin_constants();
  
    // TODO: update classname and description
		$widget_opts = array (
			'classname' => PLUGIN_NAME, 
			'description' => __('Short description of the plugin goes here.', PLUGIN_LOCALE)
		);	
		
		$this->WP_Widget(PLUGIN_SLUG, __(PLUGIN_NAME, PLUGIN_LOCALE), $widget_opts);
		load_plugin_textdomain(PLUGIN_LOCALE, false, dirname(plugin_basename( __FILE__ ) ) . '/lang/' );
		
    // Load JavaScript and stylesheets
    $this->register_scripts_and_styles();
	$this->register_hooks();
	} // end constructor

	public function register_hooks(){
	
		add_action('wp_ajax_nopriv_getpathactivity', array( &$this, 'get_path_activity' ));
		add_action('wp_ajax_get_path_activity', array( &$this, 'get_path_activity' ));
	}

	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance
	 */
	function widget($args, $instance) {
	
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$this->_pathusername 	= empty($instance['pathusername']) ? '' : apply_filters('pathusername', $instance['pathusername']);  
		$this->_pathpassword 	= empty($instance['pathpassword']) ? '' : apply_filters('pathpassword', $instance['pathpassword']);
		$this->_pathnbdisplay 	= empty($instance['pathnbdisplay']) ? '' : apply_filters('pathnbdisplay', $instance['pathnbdisplay']);
		try {
//    		$user = $oPathApi->login($pathusername, $pathpassword);
//			$aPathActivity = $oPathApi->getHome();
		} catch (Exception $e) {
			var_dump($e->getMessage());
		}
		
		// Display the widget
		include(WP_PLUGIN_DIR . '/' . PLUGIN_SLUG . '/views/widget.php');
		echo $after_widget;
		
	} // end widget
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['pathusername'] = strip_tags(stripslashes($new_instance['pathusername'])); 
		$instance['pathpassword'] = strip_tags(stripslashes($new_instance['pathpassword'])); 
		$instance['pathnbdisplay'] = strip_tags(stripslashes($new_instance['pathnbdisplay'])); 
		
		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	function form($instance) {
	
    // TODO define default values for your variables
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'pathusername' => '',
				'pathpassword' => '',
			)
		);
	
		$pathusername = strip_tags(stripslashes($new_instance['pathusername'])); 
	    $pathpassword = strip_tags(stripslashes($new_instance['pathpassword']));
	    $pathnbdisplay = strip_tags(stripslashes($new_instance['pathnbdisplay']));

		// Display the admin form
    include(WP_PLUGIN_DIR . '/' . PLUGIN_SLUG . '/views/admin.php');
		
	} // end form
	
	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/
	
  /**
   * Initializes constants used for convenience throughout 
   * the plugin.
   */
  private function init_plugin_constants() {
    
    /* TODO
     * 
     * This provides the unique identifier for your plugin used in
     * localizing the strings used throughout.
     * 
     * For example: wordpress-widget-boilerplate-locale.
     */
    if(!defined('PLUGIN_LOCALE')) {
      define('PLUGIN_LOCALE', 'path-activity-locale');
    } // end if
    
    /* TODO
     * 
     * Define this as the name of your plugin. This is what shows
     * in the Widgets area of WordPress.
     * 
     * For example: WordPress Widget Boilerplate.
     */
    if(!defined('PLUGIN_NAME')) {
      define('PLUGIN_NAME', 'Path Activity');
    } // end if
    
    /* TODO
     * 
     * this is the slug of your plugin used in initializing it with
     * the WordPress API.
     
     * This should also be the
     * directory in which your plugin resides. Use hyphens.
     * 
     * For example: wordpress-widget-boilerplate
     */
    if(!defined('PLUGIN_SLUG')) {
      define('PLUGIN_SLUG', 'path-activity');
    } // end if
  
  } // end init_plugin_constants
  
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if(is_admin()) {
      		$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/js/admin.js', true);
			$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/css/admin.css');
		} else {
      		$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/js/admin.css', true);
			$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/css/widget.css');
		} // end if/else
		$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/js/widget.js', true);
  		
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file($name, $file_path, $is_script = false) {
		
    	$url = WP_PLUGIN_URL . $file_path;
		$file = WP_PLUGIN_DIR . $file_path;
    
		if(file_exists($file)) {
			if($is_script) {
				wp_register_script($name, $url,array('jquery'), false,true);
				wp_enqueue_script($name);
			} else {
				wp_register_style($name, $url);
				wp_enqueue_style($name);
			} // end if
		} // end if
    
	} // end load_file
	
	public function get_path_activity($instance){
		try {
			$oPathApi		= new path_wrapper();
			$test			= get_option('widget_path-activity');
			$options		= $test[3];
			
			$pathusername = strip_tags(stripslashes($options['pathusername'])); 
		    $pathpassword = strip_tags(stripslashes($options['pathpassword']));
			
    		$user 			= $oPathApi->login($pathusername, $pathpassword);
			$aPathActivity 	= $oPathApi->getHome();
			$activity		= array();
			$sort			= array();
			foreach($aPathActivity->moments as $moment){
				if(!in_array($moment->type, array("ambient"))) {
					$activity[''.$moment->visible_ts.''] = $moment;
					$sort[] = $moment->visible_ts;
				}
			}
			arsort($sort);
			$nbdisplay	= (empty($options['pathnbdisplay']))?'5':strip_tags(stripslashes($options['pathnbdisplay']));
			echo json_encode(array("sort"=>$sort, "data"=>$activity, "nbdisplay"=>$nbdisplay));
			exit;
		} catch (Exception $e) {
			var_dump($e->getMessage());
		}
		die();
	}
	
} // end class

	add_action('widgets_init', create_function('', 'register_widget("PathActivity");'));


?>