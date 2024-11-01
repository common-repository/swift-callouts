<?php

include_once 'scbsConstants.php';
include_once 'scbsTemplateManager.php';
include_once 'scbsTemplate.php';
//include_once 'scbsFormValidator.php';
include_once 'scbsDBLiaison.php';
include_once ECBS_PATHS;

// This is a static class for creating the admin menu that the user
// uses to create and edit templates
class scbsAdminMenu {

    private static $DBLiaison;
    private static $templates = array();
    private static $template_in_edit;
    private static $template_id;
    private static $active_template;

    // Build the admin page for managing callouts
    public function build_admin_menu() {
        if ( !current_user_can( 'manage_options' ) )
            wp_die( __( NOT_PERMITTED ) );
               
        self::$DBLiaison = new scbsDBLiaison();
               
        self::$templates = self::$DBLiaison->get_all_templates();
        self::$DBLiaison=NULL;
        
        echo ADMIN_HEAD;
        
        // This makes the updated template display after
        // it has been edited
        if ( isset( $_GET['template'] ) )
        	self::$active_template = $_GET['template'];
        
        echo self::get_templates_dropdown();
       
        
        echo EDIT_AREA_DIV;
        
        
        self::add_admin_scripts();
    }


    // Insert template names in admin form
    public function get_templates_dropdown() {

        $the_dropdown =  TEMPLATE_DROP_BEFORE .
                wp_nonce_field( SCBS_DELETE_NONCE, SCBS_DELETE_NONCE ) .
                TEMPLATE_DROP_AFTER;

        return sprintf( $the_dropdown, self::format_dropdowns() );
    }

    // Builds the dropdown options used to select a template for editing or
    // deleting. 
    function format_dropdowns() {
        foreach ( self::$templates as $template => $template_values ) {
            $the_dropdowns .= '<option value="' . $template . '"';  
            
            if ( isset(self::$active_template) && $template === self::$active_template)
              $the_dropdowns .= ' selected'; 
              
              $the_dropdowns .= '>' . $template_values[NICE_NAME] . '</option>';
        }

        return $the_dropdowns;
    }

    // Loads the admin stylesheet
    function get_admin_style() {
        wp_register_style( ECBS_ADMIN_STYLESHEET,
                ECBS_CSS_URL . 'cbs-admin-stylesheet.css' );
        wp_enqueue_style( ECBS_ADMIN_STYLESHEET );
    }

    // Set up jQuery scripts
    function add_admin_scripts() {
        ?>
<script src="<?php echo ECBS_JS_URL . 'cbs-edit-options.js' ?>"></script>
<?php
    }

    // Gets POST data from the cbs-edit-options.js script. Uses that info
    // to format a form containing the customizable template elements. Sends
    // that info back to the .js script where it is processed and sent to
    // the ecbs-edit-area div.
    function populate_admin_template() {

        if ( isset( $_POST['data'] ) && $_POST['data']['template'] != '' ) {

            self::$template_id = $_POST['data']['template'];

            // If the user is creating a new template, get a template
            // object with blank values
            if ( self::$template_id === 'new' ) {
                self::$template_in_edit = new scbsTemplate( );
                self::$template_id = '';

            // If the user selects the "Select Templates" option, it just
            // hides the edit pane
            } else if ( self::$template_id === 'dummy' ) {
                die( NO_DATA );
                
            // If the user selects an existing template to edit pull that template
            // from the DB. Creates a template object from the scbsTemplate class
            } else {
                self::$template_in_edit = new scbsTemplate( self::$template_id, self::$templates[$template_id] );
            }

            die( self::format_template_edit_pane( ) );
        } else {

            die( NO_DATA );
        }
	}

    // Formats the edit pane on the admin menu after the user selects which
    // template to edit
    function format_template_edit_pane( ) {

        $values_form = self::format_edit_head( );

        $template_values = self::$template_in_edit->get_all_values();
        
        // Sends template styles and values to a handler to format
        // then for the edit pane.
        foreach ( $template_values as $style => $value ) {
            if ( $style != IN_TEXTAREA )
                $values_form .= self::handle_style( $style, $value );
        }

		// Combines the style side of the edit pane with the textarea side and decodes
		// the textarea content and puts it into the textarea
        $values_form .= EDIT_TEXTAREA .
                htmlspecialchars_decode( self::$template_in_edit->get_style_value(IN_TEXTAREA) ) .
                EDIT_TEXTAREA_END;

        return $values_form;
    }

    // Formats the beginning of the template edit form in the admin menu
    function format_edit_head( ) {

        return sprintf(EDIT_FORM_HEADER, wp_nonce_field( SCBS_UPDATE_NONCE ),
                self::$template_id,
                self::$template_id,
                (self::$template_id === '' ? '' : 'readonly="readonly"' ) );

    }

    // Determines style type (px, hex, radio or shadow) and sends it to the
    // correct method for formatting, then returns the formatted HTML
    function handle_style( $style, $value ) {
        // Formatting radio options
        if ( $style === 'border-style' || $style === 'float' ) {
            return '<tr>' . 
                            self::format_radio_style( $style,
                            $value );
        }

        // Formatting anything with a textbox
        else {
            return self::format_style( $style, $value );
        }
    }

    // Formats the form inputs for standard style values (i.e. not a radio
    function format_style( $style, $value ) {

        return sprintf( STYLE_INPUTS, self::get_label( $style, $value ),
                            $style, $value, $value );
    }

	// Formats form fields that use radio buttons for the options
    function format_radio_style( $style, $value ) {

        $style_formats = self::$template_in_edit->get_style_data();

        $radio_options = $style_formats[$style][ECBS_RADIO_OPTIONS];

        $radio_output = self::get_label( $style ).'<td>';
        foreach ( $radio_options as $radio_option ) {
            $radio_output .= sprintf( RADIO_FORMAT, $style, $radio_option, 
                    ($radio_option === $value ? 'checked="checked">' : '>'), 
                    $radio_option);
        }

        $radio_output .= '</td></tr>' . "\n";

        return $radio_output;
    }
		
	// Formats the labels used for the template edit form
	function get_label($style) {
		$style_formats = self::$template_in_edit->get_style_data ();
		
		return sprintf ( LABEL_FORMAT, $style_formats [$style] [TOOL_TIP], 
								$style_formats [$style] [TOOL_TIP], 
								$style, 
								$style_formats [$style] [ECBS_NICE_NAME] );
	}
}