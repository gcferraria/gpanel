<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends HTML_Controller 
{
    /**
     * __construct: Roles Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Add Roles Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('role_breadcrumb'),
                'href' => 'private-area/roles',
            )
        );
    }

    /**
     * index: Add Role data and render Roles list page.
     *
     * @access public
     * @return void
    **/
    public function index($template = 'index') 
    {
        $data = (object) array(
            'source' => 'private-area/roles.json',
            'header' => array(
                $this->lang->line('role_name'),
                $this->lang->line('role_creation_date'),
                $this->lang->line('role_status'),
            ),
        );

        $this->add_data( array(
                'title'   => $this->lang->line('role_title'),
                'table'   => $data,
                'actions' => array(
                    $this->lang->line('add') => 'private-area/roles/add',
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Role Form.
     *
     * @access public
     * @return void
    **/
    public function add() 
    {
        // Add Breadcumbs to Add Role.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('role_breadcrumb_add'),
                'href' => uri_string()
            )
        );

        // Inicialize Role Object and Form Object.
        $role_form = new Form();
        $role      = new Role();

        // Build Role Form.
        $role_form
            ->builder( 'post', '/private-area/roles/add.json' )
            ->add_fields( $this->_fields( $role ) );

        $this->add_data( array(
                'title' => $this->lang->line('role_title_add'),
                'role' => (object) array(
                    'form' => $role_form->render_form(),
                ),
            )
        );

        parent::index();
    }

    /**
     * edit: Find Role to edit, and build Role Form.
     *
     * @access public
     * @param  string $id, Role Identifier
     * @return void
    **/
    public function edit( $id ) 
    {
        // Find Role to Edit.
        $role = new Role();
        $role->get_by_id( $id );

        if ( ! $role->exists() )
            return;

        // Add Breadcrumb to edit Role.
        $this->breadcrumb->add( array(
                'text' => sprintf(
                    $this->lang->line('role_breadcrumb_edit'),
                    $role->name
                ),
                'href' => uri_string(),
            )
        );

        // Inicialize Role Form Object.
        $role_form = new Form();

        // Build Role Form.
        $role_form
            ->builder('post', '/private-area/roles/edit/' . $role->id . '.json')
            ->add_fields( $this->_fields( $role ), $role );

        $this->add_data( array(
                'title' => $this->lang->line('role_title_edit'),
                'role'  => (object) array(
                    'form' => $role_form->render_form()
                ),
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in role form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $role, [Required] Role Object.
     * @return array
    **/
    private function _fields( $role ) 
    {
        // Get Role base fields.
        $fields = $role->validation;

        // Define Role Fields Attributes.
        $attrs = array(
            'active_flag' => array(
                'values' => array(
                    $this->lang->line('role_active_yes') => 1,
                    $this->lang->line('role_active_no')  => 0,
                ),
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}