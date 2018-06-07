<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_Types extends HTML_Controller 
{
    /**
     * __construct: Content Types Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Add Breadcrumb for Content Types.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('content_type_breadcrumb'),
                'href' => 'administration/content_types',
            )
        );
    }

    /**
     * index: Add Content Types data and render Content Types page.
     *
     * @access public
     * @return void
    **/
    public function index( $template = 'index' ) 
    {
        $data = (object) array(
            'source' => 'administration/content_types.json',
            'header' => array(
                $this->lang->line('content_type_name'),
                $this->lang->line('content_type_uriname'),
                $this->lang->line('content_type_creation_date'),
                $this->lang->line('content_type_status'),
            ),
        );

        $this->add_data( array(
                'title' => $this->lang->line('content_type_title'),
                'table'   => $data,
                'actions' => array(
                    $this->lang->line('add') => 'administration/content_types/add',
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Content Type Form.
     *
     * @access public
     * @return void
    **/
    public function add() 
    {
        // Add Breadcumb to Add Content Type.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('content_type_breadcrumb_add'),
                'href' => uri_string(),
            )
        );

        // Inicialize Content Type Object and Form Object.
        $content_type_form = new Form();
        $content_type      = new Content_Type();

        // Build Content Type Form.
        $content_type_form
            ->builder('post','/administration/content_types/add.json')
            ->add_fields( $this->_fields( $content_type ) );

        $this->add_data( array(
                'title'        => $this->lang->line('content_type_title_add'),
                'content_type' => (object) array(
                    'form' => $content_type_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * edit: Find Content Type to edit, and build Content Type Form.
     *
     * @access public
     * @param  string $id, Content Type Identifier
     * @return void
    **/
    public function edit( $id ) 
    {
        // Find Content Type to Edit.
        $content_type = new Content_Type();
        $content_type->get_by_id( $id );

        if ( ! $content_type->exists() )
            return;

        // Add Breadcrumb to edit Content Type.
        $this->breadcrumb->add( array(
                'text' => sprintf(
                    $this->lang->line('content_type_breadcrumb_edit'),
                    $content_type->name
                ),
                'href' => uri_string(),
            )
        );

        // Inicialize Content Type Form Object.
        $content_type_form = new Form();

        // Build Content Type Form.
        $content_type_form
            ->builder('post', '/administration/content_types/edit/' . $content_type->id . '.json')
            ->add_fields( $this->_fields( $content_type ), $content_type );

        $this->add_data( array(
                'title'        => $this->lang->line('content_type_title_edit'),
                'content_type' => (object) array(
                    'form' => $content_type_form->render_form()
                ),
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in content type form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $content_type, [Required] Content Type Object.
     * @return array
    **/
    private function _fields( $content_type ) 
    {
        // Get Content Type Base Fields.
        $fields = $content_type->validation;

        // Define Contenrt Type Fields Attributes.
        $attrs = array(
            'active_flag' => array(
                'values' => array(
                    $this->lang->line('content_type_active_yes') => 1,
                    $this->lang->line('content_type_active_no')  => 0,
                ),
            )
        );

        return array_replace_recursive( $fields, $attrs );
    }

}