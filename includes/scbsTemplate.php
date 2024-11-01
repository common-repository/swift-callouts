<?php

class scbsTemplate {

    public $template = array();
    //public $template_styles = array();
    public $template_id;

    public function __construct( $template_id = NULL, $values = NULL ) {

        $this->template_id = $template_id;
        
        // Creating a new template that doesn't exist in DB
        if ( isset( $template_id ) && isset( $values ) ) {
            $this->template = $values;
            
        // Building a template off of values in DB
        } else if ( isset( $template_id ) ) {
            $this->template_id = $template_id;

            $DBLiaison = new scbsDBLiaison();
            $this->template = $DBLiaison->get_this_template( $template_id );
            
        // Creating a blank template
        } else {
            $this->template = $this->get_dummy_values();
        }

        //$this->template_styles =  $this->template ;
    }

    public function get_template_id() {
        return $this->template_id;
    }

    public function get_template() {
        return $this->template;
    }

    public function get_style_value( $style ) {
        return $this->template[$style];
    }
    
    public function get_all_values() {
        return $this->template;
    }
    
    // changes the style => value pair in the template
    // object. Does not interact with the database.
    // Will only change the database if the template is
    // sent to the DBLiaison through the TemplateManager
    public function update_style_value( $style, $value ) {
        $this->template[$style] = $value;
    }

    // Static data that gives information about style types. Primarily
    // used in formatting the admin edit pane in the scbsAdminMenu class
    public static function get_style_data() {
        return array(
            NICE_NAME => array( 'text', 'Template Name',  NICE_NAME_TIP ),
            'float' => array( 'radio', 'Float', FLOAT_TIP, array( 'right', 'left', 'none' ) ),
            'background-color' => array( 'hex', 'Background Color', BG_COLOR_TIP ),
            'border-color' => array( 'hex', 'Border Color', BRDR_COLOR_TIP ),
            'border-style' => array( 'radio', 'Border Style', BRDR_STYLE_TIP,
                array( 'dashed', 'dotted', 'solid', 'double',
                    'inset', 'outset', 'groove', 'ridge', 'none' ) ),
            'border-width' => array( 'px', 'Border Width', BRDR_WDTH_TIP ),
        	'border-radius' => array( 'px', 'Border Radius', BRDR_RAD_TIP),
            'margin-bottom' => array( 'px', 'Bottom Margin', MARGIN_TIP ),
            'margin-top' => array( 'px', 'Top Margin', MARGIN_TIP ),
            'margin-right' => array( 'px', 'Right Margin', MARGIN_TIP ),
            'margin-left' => array( 'px', 'Left Margin', MARGIN_TIP ),
            'padding-top' => array( 'px', 'Top Padding', PADDING_TIP ),
            'padding-bottom' => array( 'px', 'Bottom Padding', PADDING_TIP ),
            'padding-right' => array( 'px', 'Right Padding', PADDING_TIP ),
            'padding-left' => array( 'px', 'Left Padding', PADDING_TIP ),
            'width' => array( 'px', 'Width', WDTH_TIP ),
            'height' => array( 'px', 'Height', HEIGHT_TIP ),
            'color' => array( 'hex', 'Text Color', TXT_COLOR_TIP ),
            'shadow' => array( 'shadow', 'Shadow', SHADOW_TIP ),
            IN_TEXTAREA => array( 'textarea', 'Default Content' ) );
    }

    // Creates a formatted array with blank values used to setup a new
    // template
    public static function get_dummy_values() {
        return //array( '' => 
                array(
                NICE_NAME => '',
                'float' => 'none',
                'background-color' => '',
                'border-color' => '',
                'border-style' => 'none',
                'border-width' => '',
                'border-radius'=>'',
                'margin-bottom' => '',
                'margin-top' => '',
                'margin-right' => '',
                'margin-left' => '',
                'padding-top' => '',
                'padding-bottom' => '',
                'padding-right' => '',
                'padding-left' => '',
                'width' => '',
                'height' => '',
                'color' => '',
                'shadow' => '',
                IN_TEXTAREA => '' ); 
    }

}
