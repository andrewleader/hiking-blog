<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/admin
 * @author     novo-media <contact@novo-media.ch>
 */
class Novo_Map_Admin {

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
     * The url of the plugin dir
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_dir_url    The current url of the plugin dir.
     */
	private $plugin_dir_url;

    /**
     * The url of the plugin path
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_dir_path    The current path of the plugin dir.
     */
    private $plugin_dir_path;


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
		$this->plugin_dir_url = plugin_dir_url(dirname( __FILE__ ));
		$this->plugin_dir_path = plugin_dir_path( dirname( __FILE__ ) );
        require_once $this->plugin_dir_path . 'admin/helpers/admin-helpers.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/novo-map-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
        wp_enqueue_media();
	    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/novo-map-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'objectL10n', array(
            'confirm_text' => __( 'Are you sure ?', $this->plugin_name ),
            'delete_marker_button' => __('Delete marker', $this->plugin_name),
            'add_marker_button' => __('Add marker', $this->plugin_name),
        ) );
        wp_localize_script( $this->plugin_name, 'postAjaxMarker', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'animeurl' => plugin_dir_url( __FILE__ ) . 'assets/js/novo-map-admin.js'
        ));
	}

    /**
     * register post admin menu specific js
     */
	public function enqueue_post_admin_script() {
        wp_enqueue_script( $this->plugin_name.'-gmap-api', 'https://maps.googleapis.com/maps/api/js?v=3.37&key=' . esc_attr(get_option($this->plugin_name.'_gmap_api_key')) . '', array(), null, false );
	}

    /**
     * register post admin menu specific js
     */
    public function enqueue_main_admin_script() {
        wp_enqueue_script( $this->plugin_name.'-gmap-api', 'https://maps.googleapis.com/maps/api/js?v=3.37&key=' . esc_attr(get_option($this->plugin_name.'_gmap_api_key')) . '', array(), null, false );
        wp_enqueue_script( $this->plugin_name.'-infobox', plugins_url( $this->plugin_name) .'/public/assets/js/infobox.js', array( $this->plugin_name.'-gmap-api' ) );
        wp_enqueue_script( $this->plugin_name.'-markerclusterer', plugins_url( $this->plugin_name) .'/public/assets/js/markerclusterer.js', array( $this->plugin_name.'-gmap-api' ) );
    }

    public function register_widgets() {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-widget.php';
        register_widget( 'Novo_Map_Widget' );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Add the main admin menu
     *
     * @since  1.0.0
     */
    public function main_admin_menu() {
        add_menu_page( 'Novo-Map Admin Menu',
            'Novo-Map',
            'manage_options',
            $this->plugin_name,
            array($this, 'main_admin_menu_callback'),
            plugin_dir_url( __FILE__ ) .'assets/images/novo-map-admin-icon.svg'
        );
    }

    /**
     * Render the main admin menu and save data to the db
     *
     * @since  1.0.0
     */
    public function main_admin_menu_callback() {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap-manager.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo-manager.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-infobox-style.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-infobox-style-manager.php';
        global $wpdb;
        $gmap_manager = new Gmap_Manager($wpdb);
        $marker_manager = new Marker_Manager($wpdb);
        $marker_logo_manager = new Marker_logo_manager($wpdb);
        $infobox_style_manager = new Infobox_Style_Manager($wpdb);
        $gmap_list = $gmap_manager->get_list();
        $default_marker_logos = $marker_logo_manager->get_list_status('default');
        $user_marker_logos = $marker_logo_manager->get_list_status('user');
        $categories = get_categories();
        $tags = get_tags();
        $infobox_style_list = $infobox_style_manager->get_all_infobox_styles();

        //due to very strange behaviour of WP slashing POST data
        // --> https://stackoverflow.com/questions/8949768/with-magic-quotes-disabled-why-does-php-wordpress-continue-to-auto-escape-my
        $post = array_map('stripslashes_deep', $_POST);
        //filter subset of the post array to avoid conflict
        $novo_post = array_intersect_key($post, array_flip(preg_grep('/^'.$this->plugin_name.'/', array_keys($post))));

        if (isset($post[$this->plugin_name.'-gmap-create'])) {
            if(security_check($post, $this->plugin_name.'-main_admin_menu')) {
                $gmap = new Gmap($novo_post);
                $id = $gmap_manager->add($gmap);
                echo '<script>window.location.replace("'.add_query_arg( 'id', $id ).'")</script>';
            }
        }
        elseif (isset($post[$this->plugin_name.'-gmap-update'])) {
            if(security_check($post, $this->plugin_name.'-main_admin_menu')){
                $gmap = new Gmap($novo_post);
                $gmap_manager->update($gmap);
                echo '<script>window.location.replace("'.add_query_arg( 'id', intval($_GET['id']) ).'")</script>';
            }
        }
        elseif (isset($post[$this->plugin_name.'-gmap-delete'])) {
            if(security_check($post, $this->plugin_name.'-main_admin_menu')) {
                $gmap = new Gmap($novo_post);
                $gmap_manager->delete($gmap);
                echo '<script>window.location.replace("admin.php?page=novo-map")</script>';
            }
        }
        elseif (isset($post[$this->plugin_name.'-gmap-save-api-key'])) {
            if(security_check($post, $this->plugin_name.'-main_admin_menu')) {
                update_option($this->plugin_name.'_gmap_api_key', sanitize_text_field($post[$this->plugin_name.'-gmap-api_key']));
                echo '<script>window.location.replace("admin.php?page=novo-map")</script>';
            }
        }
        elseif (isset($post[$this->plugin_name.'-gmap-delete-duplicate-markers'])) {
            if(security_check($post, $this->plugin_name.'-main_admin_menu')) {
                $marker_list = $marker_manager->get_list();
                foreach ($marker_list as $marker) {
                    if (wp_is_post_revision($marker->post_id())) {
                        $marker_manager->delete($marker);
                    }
                }
                echo '<script>window.location.replace("admin.php?page=novo-map")</script>';
            }
        }
        if (isset($_GET['id'])) {
            $get_id = intval($_GET['id']);
            $gmap = $gmap_manager->get($get_id);
        }
        else {
            //get default properties of the class
            $reflectionClass = new ReflectionClass('Gmap');
            $gmap_data = $reflectionClass->getDefaultProperties();
            $gmap = new Gmap($gmap_data);
        }

        //get the map to render in main menu
        add_action( 'admin_footer', array($gmap, 'generate_script_admin'), 15 );

        //get a default map to render a small map in the additional marker section
        $reflectionClass = new ReflectionClass('Gmap');
        $gmap_data_small_map = $reflectionClass->getDefaultProperties();
        $gmap_small_map = new Gmap($gmap_data_small_map);
        $gmap_small_map->set_name('gmapmainmenusmall');

        add_action( 'admin_footer', array($gmap_small_map, 'generate_script_admin'), 16 );

        //get clustered marker to generate image in the form and additional marker
        $cluster_marker_small = $marker_logo_manager->get($gmap->clustering_marker_logo_id_small());
        $cluster_marker_medium = $marker_logo_manager->get($gmap->clustering_marker_logo_id_medium());
        $cluster_marker_big = $marker_logo_manager->get($gmap->clustering_marker_logo_id_big());
        $additional_marker = $marker_logo_manager->get($gmap->additional_marker_logo_id());

        //generate the form
        ob_start();
        include( 'partials/main-admin-menu.php' );
        $admin_menu_html = ob_get_contents();
        ob_end_clean();
        echo $admin_menu_html;
    }


    /**
     * Add the Marker Logo submenu
     *
     * @since  1.0.0
     */
    public function marker_logo_admin_menu() {
        add_submenu_page(
            $this->plugin_name,
            __( 'Markers menu', $this->plugin_name  ),
            __( 'Markers', $this->plugin_name  ),
            'manage_options',
            $this->plugin_name.'-marker-logo',
            array($this, 'marker_logo_admin_menu_callback')
        );

        //add main admin menu specific scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_main_admin_script'), 15 );
    }

    /**
     * Render the Marker Logo submenu
     *
     * @since  1.0.0
     */
    public function marker_logo_admin_menu_callback() {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo-manager.php';
        global $wpdb;
        $marker_logo_manager = new Marker_Logo_Manager($wpdb);
        $post = array_map('stripslashes_deep', $_POST);

        //get default and user defined marker logos
        $default_marker_logos = $marker_logo_manager->get_list_status('default');
        $user_marker_logos = $marker_logo_manager->get_list_status('user');

        $markers_dir_path = $this->plugin_dir_path . 'public/assets/images/markers/';
        $markers_dir_url = $this->plugin_dir_url. 'public/assets/images/markers/';
        $markers_paths = array_diff(scandir($markers_dir_path), array('.', '..'));

        //get default values of the marker logo
        $reflectionClass = new ReflectionClass('Marker_Logo');
        $marker_logo_data = $reflectionClass->getDefaultProperties();
        $marker_logo = new Marker_Logo($marker_logo_data);

        if (isset($post[$this->plugin_name.'-marker-logo-add'])) {
            if(security_check($post, $this->plugin_name.'-marker-logo_admin_menu')) {
                $marker_logo = new Marker_logo($post);
                $id = $marker_logo_manager->add($marker_logo);
                echo '<script>window.location.replace("'.add_query_arg( NULL, NULL ).'")</script>';
            }
        }
        if (isset($post[$this->plugin_name.'-marker-logo-update'])) {
            if(security_check($post, $this->plugin_name.'-marker-logo_admin_menu')) {
                $marker_logo = new Marker_logo($post);
                $marker_logo_manager->update($marker_logo);
                echo '<script>window.location.replace("'.add_query_arg( NULL, NULL ).'")</script>';
            }
        }
        if (isset($_GET['id']) and isset($_GET['edit'])) {
            $get_id = intval($_GET['id']);
            $marker_logo = $marker_logo_manager->get($get_id);
            $user_marker_logos = remove_id_from_list($user_marker_logos, $get_id);
        }
        // delete the pin and update the markers that were using this pin with default value
        // it should also update all map objects that were using this pin for clustering
        if (isset($_GET['id']) and isset($_GET['delete'])) {
            $get_id = intval($_GET['id']);
            // update gmap objects
            require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap.php';
            require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap-manager.php';
            $gmap_manager = New Gmap_Manager($wpdb);
            $gmap_list = $gmap_manager->get_list_with_marker($get_id);
            $gmap_reflectionClass = new ReflectionClass('Gmap');
            $default_gmap = $gmap_reflectionClass->getDefaultProperties();
            if(! empty($gmap_list)) {
                foreach ($gmap_list as $gmap) {
                    if($gmap->clustering_marker_logo_id_small()==$get_id) {
                        $gmap->set_clustering_marker_logo_id_small($default_gmap['clustering_marker_logo_id_small']);
                    }
                    if($gmap->clustering_marker_logo_id_medium()==$get_id) {
                        $gmap->set_clustering_marker_logo_id_medium($default_gmap['clustering_marker_logo_id_medium']);
                    }
                    if($gmap->clustering_marker_logo_id_big()==$get_id) {
                        $gmap->set_clustering_marker_logo_id_big($default_gmap['clustering_marker_logo_id_big']);
                    }
                }
                $gmap_manager->update($gmap);
            }

            // update markers objects
            require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
            require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
            $marker_manager = New Marker_Manager($wpdb);
            $marker_list = $marker_manager->get_list_row_value('marker_logo_id', $get_id);
            $marker_reflectionClass = new ReflectionClass('Marker');
            $default_marker = $marker_reflectionClass->getDefaultProperties();
            foreach ($marker_list as $marker) {
                $marker->set_marker_logo_id($default_marker['marker_logo_id']);
                $marker_manager->update($marker);
            }

            $marker_logo_manager->delete($get_id);
            echo '<script>window.location.replace("admin.php?page='.$this->plugin_name.'-marker-logo")</script>';
        }

        //get default image for marker logo
        $default_marker_logo_url = plugin_dir_url( dirname(__FILE__) ) .'public/assets/images/markers/icn-map-green.svg';
        $marker_logo_url = $marker_logo->url();
        if(empty($marker_logo_url)) {
            $marker_logo_url = $default_marker_logo_url;
        }
        else {
            $marker_logo_url = $marker_logo->url();
        }

        //generate the form
        ob_start();
        include( 'partials/marker-logo-admin-menu.php' );
        $marker_logo_admin_menu_html = ob_get_contents();
        ob_end_clean();
        echo $marker_logo_admin_menu_html;
    }


    /**
     * add the post admin menu
     *
     * @since  1.0.0
     */
    public function post_admin_menu() {
        // display the menu on post and page
        $screens = apply_filters('novo_map_allowed_post_type', array( 'post', 'page' ));

        foreach ( $screens as $screen ) {
            add_meta_box(
                $this->plugin_name.'-post-admin-menu',
                __( 'Novo Map', $this->plugin_name ),
                array($this, 'post_admin_menu_callback'),
                $screen
            );
        }

        //add post admin menu specific scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_post_admin_script'), 15 );
    }

    /**
     * Render the post admin menu
     *
     * @since  1.0.0
     */
    public function post_admin_menu_callback() {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo-manager.php';
        global $wpdb;
        $marker_logo_manager = new Marker_Logo_Manager($wpdb);
        $marker_manager = new Marker_Manager($wpdb);
        $post_id = get_the_ID();
        $post_status = get_post_status($post_id);
        if ($post_status == 'draft' || $post_status == 'auto-draft') {
            $show_post_admin_menu = false;
        }
        else {
            $show_post_admin_menu = true;
        }
        $marker_list = $marker_manager->get_list_row_value('post_id', $post_id);
        $default_marker_logos = $marker_logo_manager->get_list_status('default');
        $user_marker_logos = $marker_logo_manager->get_list_status('user');
        $texteditor_settings = array(
            'tinymce' => array(
                'toolbar1' => 'bold, italic, bullist, link',
                'toolbar2' => '',
            ),
            'wpautop' => false,
            'media_buttons' => false,
            'quicktags' => false,
            'textarea_name' => $this->plugin_name.'-marker-infobox_description',
            'editor_height' => 140
        );

        //get default map to render in post menu
        $gmap_reflectionClass = new ReflectionClass('Gmap');
        $default_gmap = $gmap_reflectionClass->getDefaultProperties();
        $gmap = new Gmap($default_gmap);
        $gmap->set_name('postmenumap');
        add_action( 'admin_footer', array($gmap, 'generate_script_admin'), 15 );

        //if there is no marker, get the default class value
        if(empty($marker_list)) {
            $reflectionClass = new ReflectionClass('Marker');
            $marker_data = $reflectionClass->getDefaultProperties();
            $marker = new Marker($marker_data);
        }
        //get the first marker
        else {
           $marker = reset($marker_list);
        }

        //get the marker_logo
        $marker_logo = $marker_logo_manager->get($marker->marker_logo_id());

        //define default value for the title
        $marker_title = $marker->title();
        if(empty($marker_title)) {
            $marker_title = get_the_title($post_id);
        }
        else {
            $marker_title = $marker->title();
        }

        //define default value for the infobox description
        if(is_null($marker->infobox_description())) {
            $infobox_description = get_the_excerpt_or_trim($post_id, 70);
        }
        else {
            $infobox_description  = $marker->infobox_description();
        }

        //get default image for the image uploader (on 1st load, get post thumbnail if defined)
        $default_upload_image_src = plugin_dir_url( __FILE__ ) .'assets/images/upload-default-image.jpg';
        $marker_infobox_image = $marker->infobox_image();
        if($marker_infobox_image == -1) {
            if(has_post_thumbnail($post_id)) {
                $upload_image_src = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
                $marker->set_infobox_image(get_post_thumbnail_id($post_id));
            }
            else {
                $upload_image_src = $default_upload_image_src;
            }
        }
        elseif(empty($marker_infobox_image)) {
            $upload_image_src = $default_upload_image_src;
        }
        else {
            $attachment_image_src = wp_get_attachment_image_src($marker_infobox_image);
            $upload_image_src = $attachment_image_src[0];
        }

        // render menu
        ob_start();
        include( 'partials/post-admin-menu.php' );
        $post_menu_html = ob_get_contents();
        ob_end_clean();
        echo $post_menu_html;
    }

    /**
     * save post admin data to the marker db
     *
     * @param $post_id
     * @since  1.0.0
     */
    public function save_post_admin_data($post_id) {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        global $wpdb;
        $manager = new Marker_Manager($wpdb);
        $post = array_map('stripslashes_deep', $_POST);

        //filter subset of the post array to avoid conflict
        $novo_post = array_intersect_key($post, array_flip(preg_grep('/^'.$this->plugin_name.'/', array_keys($post))));

        // if there are data to save for novo-map (post page)
        if(! empty($novo_post) and $post['post_type'] != 'revision') {
            // security checks and user permission
            if(! security_check($post, $this->plugin_name.'-post_admin_menu')){
                exit;
            }

            //add categories, tags and post id in the novo-post array
            $novo_post[$this->plugin_name.'-marker-categories'] = get_post_categories_name_list($post_id);
            $novo_post[$this->plugin_name.'-marker-tags'] = get_post_tags_name_list($post_id);
            $novo_post[$this->plugin_name.'-marker-post_id'] = $post_id;

            //add another check to be sure this is not a post revision
            if(wp_is_post_revision($novo_post['novo-map-marker-post_id']) == false) {

                //update marker
                if(isset($post[$this->plugin_name.'-marker-update'])) {
                    $marker = new Marker($novo_post);
                    $manager->update($marker);
                }

                //update marker ( mainly for categories and tags) on post update if it exists
                else {
                    //check if there is an existing marker
                    $marker_list = $manager->get_list_row_value('post_id', $post_id);
                    if (! empty($marker_list)) {
                        $marker = new Marker($novo_post);
                        $manager->update($marker);
                    }
                }
            }
        }
        // if the $novo_post is empty, we save from the quick edit
        elseif(empty($novo_post)) {
            $marker_list = $manager->get_list_row_value('post_id', $post_id);
            // if there are markers attached to the article
            if (! empty($marker_list)) {
                //add categories, tags and post id in the novo-post array
                $novo_quick_edit_categories = get_post_categories_name_list($post_id);
                $novo_quick_edit_tags = get_post_tags_name_list($post_id);
                foreach ($marker_list as $marker) {
                    $marker->set_categories($novo_quick_edit_categories);
                    $marker->set_tags($novo_quick_edit_tags);
                    $manager->update($marker);
                }
            }
        }
    }

    /**
     * Ajax add marker function for post admin menu (after WP 5.0)
     *
     * @since 1.0.7
     */
    public function post_ajax_marker_add() {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        global $wpdb;
        $manager = new Marker_Manager($wpdb);
        $post = array_map('stripslashes_deep', $_POST);
        $novo_post = $post['novo_post'];
        $novo_post[$this->plugin_name.'-marker-categories'] = get_post_categories_name_list($novo_post['novo-map-marker-post_id']);
        $novo_post[$this->plugin_name.'-marker-tags'] = get_post_tags_name_list($novo_post['novo-map-marker-post_id']);
        if(! security_check($novo_post, $this->plugin_name.'-post_admin_menu')){
            exit;
        }
        $marker = new Marker($novo_post);
        $marker_id = $manager->add($marker);
        wp_die($marker_id);
    }

    /**
     * Ajax remove marker function for the post admin menu (after WP 5.0)
     *
     * @since 1.0.7
     */
    public function post_ajax_marker_delete() {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        global $wpdb;
        $manager = new Marker_Manager($wpdb);
        $post = array_map('stripslashes_deep', $_POST);
        $novo_post = $post['novo_post'];
        $novo_post[$this->plugin_name.'-marker-categories'] = get_post_categories_name_list($novo_post['novo-map-marker-post_id']);
        $novo_post[$this->plugin_name.'-marker-tags'] = get_post_tags_name_list($novo_post['novo-map-marker-post_id']);
        if(! security_check($novo_post, $this->plugin_name.'-post_admin_menu')){
            exit;
        }
        $marker = new Marker($novo_post);
        $manager->delete($marker);
        wp_die();
    }

    /**
     * Remove markers on post trash to avoid orphan data
     *
     * @param $post_id
     * @since 1.0.0
     */
    public function post_trash_delete_marker($post_id) {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        global $wpdb;
        $manager = new Marker_Manager($wpdb);
        $marker_list = $manager->get_list_row_value('post_id', $post_id);
        foreach ($marker_list as $marker) {
            $manager->delete($marker);
        }
    }

    /**
     * set default marker logo url to marker logos on attachment delete (if the image was used)
     *
     * @param $image_id
     * @since 1.0.0
     */
    public function media_delete_update_marker_logo($image_id) {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-logo-manager.php';
        global $wpdb;
        $marker_logo_manager = new Marker_Logo_Manager($wpdb);

        $marker_reflectionClass = new ReflectionClass('Marker');
        $default_marker_data = $marker_reflectionClass->getDefaultProperties();
        $default_marker = new Marker($default_marker_data);
        $default_marker_logo = $marker_logo_manager->get($default_marker->marker_logo_id());

        $image_url = wp_get_attachment_url($image_id);
        //remove extension of image path
        $image_url_no_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_url);
        $user_marker_logo_list = $marker_logo_manager->get_list_status('user');

        foreach ($user_marker_logo_list as $marker_logo) {
            //if marker logo url contain the path of the deleted media, update the marker logo
            if(strpos($marker_logo->url(), $image_url_no_ext) !== false) {
                $marker_logo->set_url($default_marker_logo->url());
                $marker_logo_manager->update($marker_logo);
            }
        }
    }

    /**
     * update infobox image value on attachment delete if it used the deleted attachment
     *
     * @param $image_id
     * @since 1.0.0
     */
    public function media_delete_update_infobox_image($image_id) {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        global $wpdb;
        $marker_manager = new Marker_Manager($wpdb);
        $marker_list = $marker_manager->get_list_row_value('infobox_image', $image_id);
        foreach($marker_list as $marker) {
            if($marker->infobox_image() == $image_id) {
                $marker->set_infobox_image(-1);
                $marker_manager->update($marker);
            }
        }
    }


    /**
     * update marker / gmap categories and tags on term delete
     *
     * @param $term_id
     * @since 1.0.0
     */
    public function term_delete_update_marker_gmap($term_id) {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-marker-manager.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap-manager.php';
        global $wpdb;
        $marker_manager = new Marker_Manager($wpdb);
        $gmap_manager = new Gmap_Manager($wpdb);
        $term = get_term($term_id);
        if ($term->taxonomy == 'category') {
            $marker_list = $marker_manager->get_list_category($term->term_id);
            foreach ($marker_list as $marker) {
                $marker_categories = unserialize($marker->categories());
                unset($marker_categories[$term->term_id]);
                $marker->set_categories(serialize($marker_categories));
                $marker_manager->update($marker);
            }
            $gmap_list = $gmap_manager->get_list_category($term->term_id);
            foreach ($gmap_list as $gmap) {
                $gmap->set_category(NULL);
                $gmap_manager->update($gmap);
            }
        }
        elseif ($term->taxonomy == 'post_tag') {
            $marker_list = $marker_manager->get_list_tag($term->term_id);
            foreach ($marker_list as $marker) {
                $marker_tags = unserialize($marker->tags());
                unset($marker_tags[$term->term_id]);
                $marker->set_tags(serialize($marker_tags));
                $marker_manager->update($marker);
            }
            $gmap_list = $gmap_manager->get_list_tag($term->term_id);
            foreach ($gmap_list as $gmap) {
                $gmap->set_tag(NULL);
                $gmap_manager->update($gmap);
            }
        }
    }
}
