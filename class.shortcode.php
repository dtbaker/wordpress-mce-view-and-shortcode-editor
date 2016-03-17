<?php

/**
 * Class dtbaker_Shortcode_Banner
 * handles the creation of [boutique_banner] shortcode
 * adds a button in MCE editor allowing easy creation of shortcode
 * creates a wordpress view representing this shortcode in the editor
 * edit/delete button on wp view as well makes for easy shortcode managements.
 *
 * separate css is in style.content.css - this is loaded in frontend and also backend with add_editor_style
 *
 * Author: dtbaker@gmail.com
 * Copyright 2014
 */

class dtbaker_Shortcode_Banner {
    private static $instance = null;
    public static function get_instance() {
        if ( ! self::$instance )
            self::$instance = new self;
        return self::$instance;
    }

	public function init(){
		// comment this 'add_action' out to disable shortcode backend mce view feature
		add_action( 'admin_init', array( $this, 'init_plugin' ), 20 );
        add_shortcode( 'boutique_banner', array( $this, 'dtbaker_shortcode_banner' ) );
	}
	
	public function init_plugin() {
		//
		// This plugin is a back-end admin ehancement for posts and pages
		//
    	if ( current_user_can('edit_posts') || current_user_can('edit_pages') ) {
			add_action( 'print_media_templates', array( $this, 'print_media_templates' ) );
			add_action( 'admin_head', array( $this, 'admin_head' ) );
			add_action( 'wp_ajax_dtbaker_mce_banner_button', array( $this, 'wp_ajax_dtbaker_mce_banner_button' ) );
			add_filter("mce_external_plugins", array($this, 'mce_plugin'));
			add_filter("mce_buttons", array($this, 'mce_button'));
		}
    }
    
	// front end shortcode displaying:
	public function dtbaker_shortcode_banner($atts=array(), $innercontent='', $code='') {
	    $sc_atts = shortcode_atts(
    		array(
        		'id' => false,
        		'title' => 'Special:',
        		'link' => '',
        		'linkhref' => '',
    		),
    		$atts
	    );
	    $sc_atts['banner_id'] = strtolower(preg_replace('#\W+#','', $sc_atts['title'])); // lets put everything in the view-data object
	    $sc_atts = json_decode( json_encode( $sc_atts ) ); // slightly evil way of making $sc_atts an object

		// Use Output Buffering feature to have PHP use it's own enging for templating
	    ob_start();
	    include __DIR__.'/views/dtbaker_shortcode_banner_view.php';
	    return ob_get_clean();
	}

	public function wp_ajax_dtbaker_mce_banner_button(){
		header("Content-type: text/javascript");
		include_once __DIR__.'/js/mce-button-boutique-banner-inline.js';
		die();
	}
	public function mce_plugin($plugin_array){
		$plugin_array['dtbaker_mce_banner'] = admin_url('admin-ajax.php?action=dtbaker_mce_banner_button');
		return $plugin_array;
	}
	public function mce_button($buttons){
        array_push($buttons, 'dtbaker_mce_banner_button');
		return $buttons;
	}
    /**
     * Outputs the view inside the wordpress editor.
     */
    public function print_media_templates() {
        if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
            return;
        include_once __DIR__.'/templates/tmpl-editor-boutique-banner.html';
    }
        if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
            return;
    public function admin_head() {

		wp_enqueue_script( 'boutique-banner-editor-view', plugins_url( 'js/boutique-banner-editor-view.js', __FILE__ ), array( 'wp-util', 'jquery' ), false, true );
    }
}

dtbaker_Shortcode_Banner::get_instance()->init();


