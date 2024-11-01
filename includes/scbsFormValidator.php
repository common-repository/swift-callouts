<?php

/* scbsForValidator.php
 * 
 * Validates data when user submits form to update templates
 * 
 * PHP version 5
 * 
 * @author      Rane Wallin
 * @copyright   SwiftWP
 * @license     GPLv2
 * @version     0.8.5
 * @link        http://swiftwp.com/swift-callouts-swiftwp-wordpress-callout-plugin/
 * 
 */

include_once 'scbsTemplateManager.php';

class scbsFormValidator {

    function validate_data() {

        $params = $_POST['data'];
        
        $params = $params['form_inputs'];
        
        parse_str( $params,
                $values );

        // Verify the request is coming from the right place
        if ( !wp_verify_nonce( $values['_wpnonce'],
                        SCBS_UPDATE_NONCE ) ) {
            die( BAD_NONCE );
        }

        // Get the style data from cbs-style-class.php
        $style_data = scbsTemplate::get_style_data();

        die( self::find_validation_problems( $values,
                        $style_data ) );
    }

    function find_validation_problems( $values, $style_data ) {

        // Verify template id has no spaces, underscores or dashes
        if ( !self::verify_id( $values[ECBS_TEMPLATE_ID] ) ) {
            $what_is_wrong .= ECBS_ID_FAIL ;
        }

        // Verify the template name contains no underscores or dashes
        if ( !self::verify_name( $values[NICE_NAME] ) ) {
            $what_is_wrong .= ECBS_NAME_FAIL;
        }

        // Loop through the form_inputs and validate the input
        foreach ( $values as $style => $value ) {
            if ( array_key_exists( $style,
                            $style_data ) && $style_data[$style][ECBS_VALUE_TYPE] !==
                    'radio' && !self::validate_style_data( $value,
                            $style_data[$style][ECBS_VALUE_TYPE] ) ) {

                $what_is_wrong .=
                        self::get_what_is_wrong( $style_data[$style][ECBS_NICE_NAME],
                        $style_data[$style][ECBS_VALUE_TYPE] );
            }
        }

        if ( !isset( $what_is_wrong ) )
            return ( SUCCESS );
        else
            return ( $what_is_wrong );
    }

    function validate_style_data( $value, $type ) {
        $is_valid = TRUE;

        switch ( $type ) {
            case 'px': $is_valid = self::verify_px( $value );
                break;
            case 'hex': $is_valid = self::verify_hex( $value );
                break;
            case 'shadow': $is_valid = self::verify_shadow( $value );
                break;
            // Type is radio, which doesn't require validation
            default: $is_valid = TRUE;
        }

        return $is_valid;
    }

    

    function get_what_is_wrong( $style, $type ) {
        switch ( $type ) {
    	case 'px': $error_string = ECBS_PX_FAIL;
        	break;
    	case 'hex': $error_string = ECBS_HEX_FAIL;
    		break;
    	case 'shadow': $error_string = ECBS_SHADOW_FAIL;
    		break;
    	default: $error_string = ECBS_DEFAULT_FAIL;
        }

        return sprintf( $error_string,
                $style );
    }
    
    function verify_px( $value ) {
        return preg_match( '/^-?[0-9]*$/', $value ) || 
        		preg_match( '/^-?[0-9]*\s*px$/i', $value ) ||
        		preg_match( '/^-?[0-9]*%\s*$/i', $value );
    }

    function verify_hex( $value ) {
        return self::valid_hex( $value ) || self::valid_hex( '#' . $value ) ||
                $value === '';
    }

    function valid_hex( $value ) {
        return preg_match( '/^#[a-f0-9]{6}$/i',
                        $value ) || preg_match( '/^#[a-f0-9]{3}$/i',
                        $value );
    }

    function verify_id( $value ) {
        return preg_match( '/^[a-zA-Z0-9]+$/',
                $value );
    }

    function verify_name( $value ) {
        return preg_match( '/^[a-z0-9 ]*$/i',
                        $value ) && ($value !== '');
    }

    function verify_shadow( $value ) {
        return ($value === '') ||
               preg_match( '/^-?[0-9]*\s*px -?[0-9]*\s*px\s*( [0-9]*\s*px)?\s*( #[a-f0-9]{6})?\s*$/i', $value ) ||
               preg_match( '/^-?[0-9]*\s*px -?[0-9]*\s*px\s*( [0-9]*\s*px)?\s*( #[a-f0-9]{3})?\s*$/i', $value );
    }

}