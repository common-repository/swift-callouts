<?php

// scbsDBLiaison.php
// This class creates a DBLiaison object that handles all
// communication with the database.

class scbsDBLiaison {

    public $templates = array();

    public function __construct() {
        //if ( !current_user_can( 'manage_options' ) )
          //  wp_die( __( NOT_PERMITTED ) );

        if (get_option( ECBS_TEMPLATES ) )
            $this->templates = get_option( ECBS_TEMPLATES );
    }

    // Returns all of the templates in the database
    public function get_all_templates() {
        
        if ( isset( $this->templates ) )
            return $this->templates;
        else
            return false;
    }

    // Returns the data for a specific template
    public function get_this_template( $template ) {
        $template_id = $this->get_template_id( $template );
        
        if (array_key_exists($template_id, $this->templates))
	        return $this->templates[$template_id];
        else 
        	// If the requested template doesn't exist
        	// give the default template
        	return $this->templates[DEFAULT_TEMPLATE];
    }

    // Determines if the template already exists in the DB.
    // Returns true if it exists and false if it doesn't
    public function template_exists_in_options( $template ) {
        $template_id = $this->get_template_id( $template );
        return array_key_exists( $template_id, $this->templates );
    }

    // Returns the id for a specific template. The id is a 
    // short name that is used for the template="templateID" tag
    // in the shortcode
    public function get_template_id( $template ) {
        if ( is_array( $template ) )
            $template_id = $template[ECBS_TEMPLATE_ID];
        else
            $template_id = $template;

        return $template_id;
    }

    // Public method to add a template to the database. The default value for $overwrite is
    // true. The only time this is falst is when the plug is activated and
    // trying to setup default templates.
    public function add_template_to_options( &$template, $overwrite=TRUE ) {
        
        if ( !is_object( $template ) )
            wp_die( __( NOT_TEMPLATE ) );

        return $this->do_option_add( $template, $overwrite );
    }

    // Public method to delete a template from the database
    public function delete_template_from_options( $template_id ) {
        //$template_id = $this->get_template_id( $template );
        if (!isset($template_id)) wp_die(__( NOT_TEMPLATE ));
        
        return $this->do_option_delete( $template_id );
    }

    // Private method that actually makes the calls to the database
    // via update_option to add the template
    private function do_option_add( &$template, $overwrite=TRUE ) {
        $template_id = $template->get_template_id();      

        if ( $this->template_exists_in_options( $template_id ) && !$overwrite )
        	return;
             
        $this->unset_template( $template_id ); 

        $this->templates[$template_id] = $template->get_all_values();

        ksort( $this->templates );
        
        return update_option( ECBS_TEMPLATES, $this->templates );
    }

    // private that makes the calls to the database, via update_option
    // to delete a template
    private function do_option_delete( $template_id ) {
        
        $this->unset_template( $template_id );

        return update_option( ECBS_TEMPLATES, $this->templates );
    }
    
    // Removes the template from the scbsDBLiaison templates property
    private function unset_template( $template_id ) {
        
        unset( $this->templates[$template_id] );
        
        if ( array_key_exists( $template_id, $this->templates) )
                wp_die(__( UNSET_FAILED )); 
    }

}