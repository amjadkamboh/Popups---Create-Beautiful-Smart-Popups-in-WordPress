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

function inf_custome_box() {
    add_meta_box( 'inf_meta', __( 'Meta Box Title', 'test' ), 'custome_box_callback', 'admin_page_wp_popups' );
}
add_action( 'add_meta_boxes', 'inf_custome_box' );

function custome_box_callback() {
    echo 'This is a meta box';  
}

add_action('admin_init', 'gpm_add_meta_boxes', 2);

function gpm_add_meta_boxes() {
    add_meta_box( 'gpminvoice-group', 'Custom Repeatable', 'Repeatable_meta_box_display', 'page', 'normal', 'default');
}

function Repeatable_meta_box_display() {
    global $post;
    $gpminvoice_group = get_post_meta($post->ID, 'customdata_group', true);
     wp_nonce_field( 'gpm_repeatable_meta_box_nonce', 'gpm_repeatable_meta_box_nonce' );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function( $ ){
        $( '#add-row' ).on('click', function() {
            var row = $( '.empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
            return false;
        });

        $( '.remove-row' ).on('click', function() {
            $(this).parents('tr').remove();
            return false;
        });
    });
  </script>
  <table id="repeatable-fieldset-one" width="100%">
  <tbody>
    <?php
     if ( $gpminvoice_group ) :
      foreach ( $gpminvoice_group as $field ) {
    ?>
    <tr>
      <td width="15%">
        <input type="text"  placeholder="Title" name="TitleItem[]" value="<?php if($field['TitleItem'] != '') echo esc_attr( $field['TitleItem'] ); ?>" /></td> 
      <td width="70%">
      <textarea placeholder="Description" cols="55" rows="5" name="TitleDescription[]"> <?php if ($field['TitleDescription'] != '') echo esc_attr( $field['TitleDescription'] ); ?> </textarea></td>
      <td width="15%"><a class="button remove-row" href="#1">Remove</a></td>
    </tr>
    <?php
    }
    else :
    // show a blank one
    ?>
    <tr>
      <td> 
        <input type="text" placeholder="Title" title="Title" name="TitleItem[]" /></td>
      <td> 
          <textarea  placeholder="Description" name="TitleDescription[]" cols="55" rows="5">  </textarea>
          </td>
      <td><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
    </tr>
    <?php endif; ?>

    <!-- empty hidden one for jQuery -->
    <tr class="empty-row screen-reader-text">
      <td>
        <input type="text" placeholder="Title" name="TitleItem[]"/></td>
      <td>
          <textarea placeholder="Description" cols="55" rows="5" name="TitleDescription[]"></textarea>
          </td>
      <td><a class="button remove-row" href="#">Remove</a></td>
    </tr>
  </tbody>
</table>
<p><a id="add-row" class="button" href="#">Add another</a></p>
 <?php
}
add_action('save_post', 'custom_repeatable_meta_box_save');
function custom_repeatable_meta_box_save($post_id) {
    if ( ! isset( $_POST['gpm_repeatable_meta_box_nonce'] ) ||
    ! wp_verify_nonce( $_POST['gpm_repeatable_meta_box_nonce'], 'gpm_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'customdata_group', true);
    $new = array();
    $invoiceItems = $_POST['TitleItem'];
    $prices = $_POST['TitleDescription'];
     $count = count( $invoiceItems );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $invoiceItems[$i] != '' ) :
            $new[$i]['TitleItem'] = stripslashes( strip_tags( $invoiceItems[$i] ) );
             $new[$i]['TitleDescription'] = stripslashes( $prices[$i] ); // and however you want to sanitize
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'customdata_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'customdata_group', $old );


}