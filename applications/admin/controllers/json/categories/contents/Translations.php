<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translations extends JSON_Controller 
{
    /**
     * __construct: Class contruct.
     *              Load Language File.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Load Language File.
        $this->lang->load('categories/contents/translations');
    }

    /**
     * save: Validate and Save an Category Translation.
     *
     * @access public
     * @param  int $id, Category Id
     * @return json
    **/
    public function save( $id ) 
    {
        $errors   = $data = array();
        $content  = new Content();
        $language = new I18n_Language();

        // Gets Content Object for Translate
        $content->get_by_id( $id );
        $language->get_by_id( $this->uri->segment(6) );

        if ( !$content->exists() || !$language->exists() )
            show_404();

        // Get Translatable fields to be validate.
        $fields = array( 'name' => $content->validation['name'], 'keywords' => $content->validation['keywords'] );

        // Get Translatable fields to be validate.
        $fields = $fields + $content->content_type->get()->translatable_fields();

        $values = array();
        $rules  = 0;
        foreach ( $fields as $field ) 
        {
            $values[ $field['field'] ] = $this->input->post( $field['field'] );

            foreach ( $field['rules'] as $rule ) 
            {
                $rules++;

                // Add validation rule for field.
                $this->form_validation->set_rules(
                    $field['field'],
                    $field['label'],
                    $rule
                );
            }
        }

        // Validate the Content Fields.
        $valid = ( $rules > 0 ) ? $this->form_validation->run() : TRUE;

        // If the Content is valid insert the data.
        if ( $valid ) 
        {
            foreach ( $fields as $field ) 
            {
                $translation = new Translation();
                $count = $translation->where(array(
                        'content_id'  => $content->id,
                        'language_id' => $language->id,
                        'name'        => $field['field']
                    )
                )->count();

                if ( $count == 0 ) 
                {
                    $translation = new Translation();
                    $translation->content_id  = $content->id;
                    $translation->language_id = $language->id;
                    $translation->name        = $field['field'];
                    $translation->value       = $this->input->post( $field['field'] );
                }
                else 
                {
                    $translation = new Translation();
                    $translation->where(array(
                            'content_id'  => $content->id,
                            'language_id' => $language->id,
                            'name'        => $field['field']
                        )
                    )->get();

                    $translation->value = $this->input->post( $field['field'] );
                }

                $translation->save();
            }

            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', $this->lang->line('save_success_message') )
            );
        }
        else 
        {
            //Get Fields Error Messages.
            foreach ( $fields as $field ) 
            {
                if ( $error = $this->form_validation->error( $field['field'] ) )
                    $errors[ $field['field'] ] = strip_tags( $error );
            }

            $data = array(
                'show_errors'  => $errors,
                'notification' => array('error', $this->lang->line('save_error_message') ),
            );
        }

        parent::index( $data );
    }

}