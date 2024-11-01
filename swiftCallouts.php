<?php

/*
  Plugin Name: Swift Callouts (Beta)
  Plugin URI: http://swiftwp.com/swift-callouts-swiftwp-wordpress-callout-plugin/
  Description: Swift Callouts by SwiftWP allows you to add callouts into posts and pages using simple shortcode.
  Author: Rane Wallin @ SwiftWP
  Version: 0.8.5
  Author URI: http://swiftwp.com
  License: GLPv2
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

//namespace SCBS;

include_once 'includes/scbsAdminMenu.php';
include_once 'includes/scbsCallout.php';
include_once 'includes/scbsConstants.php';
include_once 'includes/scbsTemplateManager.php';
include_once 'includes/scbsFormValidator.php';
include_once ECBS_PATHS;


class swiftCallouts {

    function __construct() {
        
        
        // Hook to create default options
        register_activation_hook( __FILE__,
                array( 'swiftHooks', 'on_activation' ) );
        register_uninstall_hook( __FILE__, 
                array( 'swiftHooks', 'on_uninstall' ) );
        
        // Setup Admin menu
        add_action('init', array( 'scbsLoader', 'load_admin' ) );
    }

    

}
$swiftCallouts = new swiftCallouts();

class scbsLoader {

    public function load_admin() {
        add_action( 'admin_menu', array( 'scbsLoader', 'add_plugin_menu' ) );
        add_action( 'admin_enqueue_scripts',
                array( 'scbsAdminMenu', 'get_admin_style' ) );
        add_action( 'admin_post_update_template',
                array( 'scbsTemplateManager', 'update_template' ) );

        // Handle AJAX
        add_action( 'wp_ajax_add_admin_scripts',
                array( 'scbsAdminMenu', 'add_admin_scripts' ) );
        add_action( 'wp_ajax_populate_admin_template',
                array( 'scbsAdminMenu', 'populate_admin_template' ) );
        add_action( 'wp_ajax_validate_data',
                array( 'scbsFormValidator', 'validate_data' ) );
        add_action( 'wp_ajax_delete_template',
                array( 'scbsTemplateManager', 'delete_template' ) );

        add_shortcode( 'callout',
                array( 'scbsCallout', 'insert_callout' ) );
    }

    function add_plugin_menu() {
        $submenu_page=add_submenu_page( 'plugins.php', 'Managing Callouts',
                'Callouts Manager', 'manage_options', 'scbsAdminMenu',
                array( 'scbsAdminMenu', 'build_admin_menu' ) );
        add_action( 'admin_head-'. $submenu_page, array( 'scbsLoader', 'admin_header' ) );
        
        add_action( 'admin_footer-'. $submenu_page, array( 'scbsLoader', 'admin_footer' ) );
    }
    
    function admin_header() {
    	echo //'<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
'<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">';
    
    }
    
    function admin_footer() {
    	echo TOOL_TIP_SCRIPT;
    }

}

class swiftHooks {

    // Sets up pre-installed templates.
    // 
    // The template values are stored in the database using add_option or
    // update_option. The structure is:
    //
    //              'template_id' => array( 'Template Name', array( **options** ) ),
    //
    // There are 17 customizable options. If the callout has a shadow, there are 
    // four additional options for formatting the shadow.
    //
    // All options are stored in a single row on the table to improve speed
    private static $DBLiaison;
    
    function on_activation() {

        //if ( !current_user_can( 'activate_plugins' ) )
          //  wp_die( __('Cannot activate plugin') );

        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';

        check_admin_referer( "activate-plugin_{$plugin}" );

        // Sets up the pre-installed default values
        $default_options = array(
            'default' => array(
                'ecbs-nice-name' => 'Default',
                'float' => 'right',
                'background-color' => '#FFFFFF',
                'border-color' => '#000000',
                'border-style' => 'dashed',
                'border-width' => '2',
            	'border-radius'=>'10px',
                'margin-bottom' => '5',
                'margin-top' => '5',
                'margin-right' => '5',
                'margin-left' => '5',
                'padding-top' => '10',
                'padding-bottom' => '10',
                'padding-right' => '10',
                'padding-left' => '10',
                'width' => '30%',
                'height' => '',
                'color' => '#220011',
                'shadow' => '10px 10px 10px #000',
                IN_TEXTAREA => ''
            ),
            'sunset' => array(
                NICE_NAME => 'Sunset',
                'float' => 'right',
                'background-color' => '#F8D28B',
                'border-color' => '#FC3903',
                'border-style' => 'dashed',
                'border-width' => '3',
                'border-radius'=>'',
                'margin-bottom' => '5',
                'margin-top' => '5',
                'margin-right' => '5',
                'margin-left' => '5',
                'padding-top' => '10',
                'padding-bottom' => '10',
                'padding-right' => '10',
                'padding-left' => '10',
                'width' => '30%',
                'height' => '',
                'color' => '#3D001F',
                'shadow' => '10px 10px 10px #A78D9E',
                IN_TEXTAREA => ''
            ),
            'desert' => array(
                NICE_NAME => 'Painted Desert',
                'float' => 'none',
                'background-color' => '#FFDDAB',
                'border-color' => '#641A00',
                'border-style' => 'solid',
                'border-width' => '5',
                'border-radius'=>'',
                'margin-bottom' => '5',
                'margin-top' => '5',
                'margin-right' => '5',
                'margin-left' => '5',
                'padding-top' => '10',
                'padding-bottom' => '10',
                'padding-right' => '10',
                'padding-left' => '10',
                'width' => '',
                'height' => '',
                'color' => '#0F1F2B',
                'shadow' => '10px 10px 10px #DE410C',
                IN_TEXTAREA => ''
            ),
            'twilight' => array(
                NICE_NAME => 'Twilight Hour',
                'float' => 'left',
                'background-color' => '#8AC1D4',
                'border-color' => '#07072B',
                'border-style' => 'dotted',
                'border-width' => '3',
                'border-radius'=>'',
                'margin-bottom' => '5',
                'margin-top' => '5',
                'margin-right' => '5',
                'margin-left' => '5',
                'padding-top' => '10',
                'padding-bottom' => '10',
                'padding-right' => '10',
                'padding-left' => '10',
                'width' => '50%',
                'height' => '',
                'color' => '#070012',
                'shadow' => '10px 10px 10px #044559',
                IN_TEXTAREA => ''
            ) );



        delete_option( ECBS_TEMPLATES ); // for testing purposes only
        
        foreach( $default_options as $template_id => $values ) {
        	scbsTemplateManager::create_new_template($template_id, $values, NO_OVERWRITE);
        }

    }

    function on_uninstall() {

        if ( !current_user_can( 'activate_plugins' ) )
            return;

        check_admin_referer( 'bulk-plugins' );


        delete_option( ECBS_TEMPLATES );
    }

}