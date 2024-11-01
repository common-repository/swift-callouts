<?php

// SwiftCallouts by SwiftWP
// scbsCallout.php
// This static class creates the callout on the page

class scbsCallout {
	
	private static $current_template;
    
	// Creates the callout
    function insert_callout( $atts, $content ) {

        // If the user hasn't specified a specific callout template set the
        // template to default
        if ( !is_array( $atts ) || !isset($atts['template']) ) {
            $style_template = DEFAULT_TEMPLATE;
        } else {
            $style_template = $atts['template'];
        }

        // Get a template object used for formatting the callout
        self::$current_template = new scbsTemplate($style_template);

        return self::build_callout_div($content, $atts );
    }

	// Uses the template to build a div for the callout that contains the user's
	// desired style elements.
    function build_callout_div( $content, $style_overrides ) {

        // WordPress shortcode doesn't work with hyphens, so the overrides
        // use underscores that have to be turned back into hyphens 
        if ( is_array( $style_overrides ) ) {
            $style_overrides = self::hyphenate_this( $style_overrides );
            self::do_overrides( $style_overrides );
        }

        $style_keys = self::$current_template->get_style_data();

        // Create each style element in the form 'key: value; 
        foreach ( self::$current_template->get_all_values() as $style => $value ) {

            // Special Handling for box shadows
            if ( $style === 'shadow' && $value != '' ) {
                $style_tag .= self::format_shadow( $value,
                                $style_overrides );
            } else if ( $value !== '' && $style !== IN_TEXTAREA ) {
                $style_tag .= $style .
                        ': ' . self::format_value( $value,
                                $style_keys[$style][ECBS_VALUE_TYPE] ) . '; ';
            }
        }

        // Return the formatted callout div after decoding the default value. 
        // This is the actual callout that appears on the page
        return '<div style="' . $style_tag . '" >' .
                do_shortcode( htmlspecialchars_decode( self::$current_template->get_style_value(IN_TEXTAREA) ) . $content ) .
                '</div>';
    }
    
    // overrides get set in the template object, which does not impact the database, only the specific instance of
    // the template
    function do_overrides( $style_overrides ) {
    	
    	foreach( $style_overrides as $style => $value )
    		self::$current_template->update_style_value( $style, $value );
    	
    }

    function format_value( $value, $value_type ) {
        if ( $value_type === 'px' ) {
        	// If the user hasn't specified px or %, then default to px
            if ( ( preg_match( '/^-?[0-9]*\s*px$/i', $value ) ||
        		preg_match( '/^-?[0-9]*%\s*$/i', $value ) ) === FALSE ) {
                //echo '<pre>test</pre>';
                $value .= 'px';
            }
        }

        if ( $value_type === 'hex' ) {
            if ( strpos( $value,
                            '#' ) === FALSE ) {
                $value = '#' . $value;
            }
        }

        return $value;
    }

	// shortcode doesn't handle dashes well, so the user needs to use
	// underscores in the style name in place of dahses. This replaces the
	// underscores with dashes.
    function hyphenate_this( $overrides ) {

        foreach ( $overrides as $key => $value ) {
            $new_key = str_replace( '_',
                    '-',
                    $key );
            $new_overrides[$new_key] = $value;
        }

        return $new_overrides;
    }

    // This is special handling for creating the box shadow. It
    // is required, because different browsers handle shadows
    // in different ways.
    function format_shadow( $value, $overrides ) {
        if ( is_array( $overrides ) && array_key_exists( 'shadow',
                        $overrides ) ) {
            $box_shadow_style = $overrides['shadow'];
        } else {
            $box_shadow_style = $value;
        }

        $value = 'box-shadow: ' . $box_shadow_style . '; ' .
                '-webkit-box-shadow: ' . $box_shadow_style . '; ' .
                '-moz-box-shadow: ' . $box_shadow_style . '; ';

        return $value;
    }
}