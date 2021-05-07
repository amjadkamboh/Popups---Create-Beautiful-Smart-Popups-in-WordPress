<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Wp_Popup_Roon
 * @subpackage Wp_Popup_Roon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Popup_Roon
 * @subpackage Wp_Popup_Roon/admin
 * @author     Amjad Kamboh <amjadbashir.ui7@gmail.com>
 */
class Wp_Popup_Roon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Popup_Roon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Popup_Roon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-popup-roon-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Popup_Roon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Popup_Roon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-popup-roon-admin.js', array( 'jquery' ), $this->version, false );

	}
}
//add menu page
add_action('admin_menu', 'wp_popups_admin_menu');
function wp_popups_admin_menu(){       
    add_menu_page( 'WP Popups', 'WP Popups', 'manage_options', 'wp-popups', 'wp_popups_plugin_admin_options','dashicons-schedule',); 
}

//register settings
add_action( 'admin_init', 'register_wp_popups_plugin_settings' );
function register_wp_popups_plugin_settings() {
    //register our settings
    register_setting( 'test-plugin-settings-group', 'theme_option_wppo_title' );
    register_setting( 'test-plugin-settings-group', 'theme_option_wppo_content' );
}

//create page content and options
function wp_popups_plugin_admin_options(){
?>
    <h1>WP Popups Plugin</h1>
    <form method="post" action="options.php">
        <?php settings_fields( 'test-plugin-settings-group' ); ?>
        <?php do_settings_sections( 'test-plugin-settings-group' ); ?>
		<div class="popupidholder">
          <h2>Popup Title </h2>
          <input type="text" name="theme_option_wppo_title" value="<?php echo get_option( 'theme_option_wppo_title' ); ?>"/>
		  <br><Small>Shown as headline inside the popup. Can be left blank.</small><br>
		  <textarea placeholder="Popup Content" cols="55" rows="5" name="theme_option_wppo_content">
		 	 <?php echo get_option( 'theme_option_wppo_content' ); ?>
		  </textarea>
		  <br><Small>Shown as Content inside the popup. You can add Form the Shortcode.</small><br>
        </div>
    <?php submit_button(); ?>
    </form>

<?php }

