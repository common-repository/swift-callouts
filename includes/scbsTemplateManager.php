<?php

// scbsTemplateManager.php
// Creates template objects using the data it receives from the
// scbsDBLiaison. Also sends templates and template data to the
// DBLiaison for DB handling.

class scbsTemplateManager {
    
    private $post_data = array();
    
    public function __construct( $post_data, $the_nonce ) {
        if ( !current_user_can( 'manage_options' ) )
            wp_die( __( BAD_NONCE ) );

        $this->post_data = $this->process_post( $post_data );

        if ( !wp_verify_nonce( $this->post_data['_wpnonce'],
                        $the_nonce ) ) {
            wp_die( __( BAD_NONCE ) );
        }
    }

    // Remove special characters from post data
    public function process_post( $post_data ) {

        if ( $post_data[IN_TEXTAREA] !== '' )
            $post_data[IN_TEXTAREA] = htmlspecialchars( stripslashes( $post_data[IN_TEXTAREA] ),
                    ENT_QUOTES );

        return $post_data;
    }
    
    public function get_post_data() {
    	return $this->post_data;
    }

    
    public function update_template() {

        $template_manager = new scbsTemplateManager( $_POST, SCBS_UPDATE_NONCE );
        
        $template_manager->process_template( );

        $template_data = $template_manager->get_post_data();
        $template_id = $template_data[ECBS_TEMPLATE_ID];
        wp_redirect( admin_url( '/plugins.php?page=scbsAdminMenu.php&template='. $template_id ) );
    }

    public function process_template( )
    {
    	$DBLiaison = new scbsDBLiaison();
    	if ($DBLiaison->template_exists_in_options($this->post_data[ECBS_TEMPLATE_ID]))
    	{
	        $template = new scbsTemplate( $this->post_data[ECBS_TEMPLATE_ID] );
	        $this->update_style_elements( $template );
	        $DBLiaison->add_template_to_options( $template );
    	} 
    	else {
    		foreach ( $this->post_data as $style => $value ) {
    			if ( array_key_exists( $style, scbsTemplate::get_style_data() ) )
    				$template_values[$style]= $value;
    		}
    		$this->create_new_template($this->post_data[ECBS_TEMPLATE_ID], $template_values );
    	}   
    }
    
    // This is a static method used to put a template object in the DB without having to
    // instantiate the TemplateManager
    public static function create_new_template($template_id, $values, $overwrite=TRUE) {
    	$new_template = new scbsTemplate($template_id, $values);
    	
    	$DBLiaison = new scbsDBLiaison();
    	$DBLiaison->add_template_to_options( $new_template, $overwrite );
    	
    }
    
    public function update_style_elements( &$template ) {

        foreach ( $this->post_data as $style => $value ) {
            if ( array_key_exists( $style, $template->get_style_data() ) )
                $template->update_style_value( $style, $value );
        }
    } 
    
    public function delete_template( ) {
        $template_manager = new scbsTemplateManager( $_POST['data'], SCBS_DELETE_NONCE );
        
        $template_manager -> do_delete();
    }
    
    public function do_delete( ) {
        
        $template_id = $this->post_data['template'];

        $this->verify_can_delete( $template_id );

        $DBLiaison = new scbsDBLiaison();

        if ( $DBLiaison->delete_template_from_options( $template_id ) )
            wp_die( __( TEMPLATE_DELETED ) );
        else
            wp_die( __( CANNOT_DELETE ) );
    }

    public function verify_can_delete( $template_id ) {
        if ( $template_id === 'default' )
            wp_die( __( CANNOT_DELETE_DEFAULT ) );

        if ( $template_id === 'dummy' )
            wp_die( __( SELECT_TEMPLATE_DELETE ) );
    }
}