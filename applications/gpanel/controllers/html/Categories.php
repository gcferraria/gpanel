<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends HTML_Controller 
{
    /**
     * @var Object, Category Object.
     * @access public
    **/
    public $category;

    /**
     * __construct: Categories Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() 
    {
        parent::__construct();

        // Initialize Category Object.
        $this->category = new Category();

        // Get Category id based on action.
        $id = is_numeric( $this->uri->segment(3) )
            ? (int) $this->uri->segment(3)
            : (int) $this->uri->segment(4);

        if( $this->uri->segment(3) == 'translations' )
            $id = (int) $this->uri->segment(5);

        // Find Category by id.
        $this->category->get_by_id( $id );

        if ( ! $this->category->exists() )
            show_404();

        // Add Category selected.
        $this->add_data( array(
                'title'             => $this->category->name,
                'description'       => $this->category->description,
                'category_title'    => $this->lang->line('category_title'),
                'category_selected' => $this->category->id,
            )
        );

        // Add Bredcrumbs based on hierarchy of categories.
        $breadcrumbs = array();
        foreach( $this->category->parents() as $object ) 
        {
            array_push( $breadcrumbs, array(
                    'text'  => $object->name,
                    'title' => $object->uripath,
                    'href'  => 'categories/contents/index/' . $object->id,
                )
            );
        }

        $this->breadcrumb->add( $breadcrumbs );
    }

    /**
     * add: Build and Render Category Form.
     *
     * @access public
     * @return void
    **/
    public function add() 
    {
        // Add Breadcumbs to Add Category.
        $this->breadcrumb->add( array(
                array(
                    'text'  => $this->lang->line('category_breadcrumb_add'),
                    'href'  => uri_string(),
                ),
            )
        );

        // Build Category Form.
        $form = new Form();
        $form->builder( 'post', '/categories/add/' . $this->category->id . '.json')
             ->add_fields( $this->_fields() );

        $this->add_data( array(
                'title' => $this->lang->line('category_title_add'),
                'form'  => $form->render_form()
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Category Form.
     *
     * @access public
     * @return void
    **/
    public function edit( $id ) 
    {
        // Add Breadcrumb to edit Category.
        $this->breadcrumb->add( array(
                array(
                    'text' => sprintf(
                        $this->lang->line('category_breadcrumb_edit'),
                        $this->category->name
                    ),
                    'href' => uri_string(),
                ),
            )
        );

        // Get Content Types for this Category.
        $content_types = array();
        foreach( $this->category->content_types->get() as $content_type )
            $content_types[] = $content_type->id;

        // Get Category Fields and set content types with json format.
        $this->category->content_types = $content_types;

        // Get Views for this Category and convert to JSON.
        $categories = array();
        foreach ( $this->category->views->get() as $view ) 
        {
            $category = new Category();
            $category->get_by_id( $view->dest_category_id );
            array_push( $categories, array(
                    'name'  => $category->id,
                    '$name' => $category->name,
                    '$path' => implode( ' » ', $category->path_name_array() ),
                )
            );
        }

        $this->category->views = htmlentities( json_encode( $categories ) );

        // Get fields
        $fields = $this->_fields( $this->category->id );

        if( ! $this->administrator->isAdmin() ) 
        {
            if( $this->administrator->id != $this->category->administrator->get()->id )
                $fields['uriname']['attrs']['readonly'] = "readonly";
        }

        // Build Category Form.
        $form = new Form();
        $form->builder( 'post', '/categories/edit/' . $this->category->id . '.json' )
             ->add_fields( $fields , $this->category );

        $this->add_data( array(
                'title' => sprintf(
                    $this->lang->line('category_title_edit'),
                    $this->category->name
                ),
                'form' => $form->render_form()
            )
        );

        parent::index();
    }

    /**
     * delete: Build and Render Delete Category Form.
     *
     * @access public
     * @return void
    **/
    public function delete() 
    {
        // Add Breadcrumb to delete Category.
        $this->breadcrumb->add( array(
                array(
                    'text' => sprintf(
                        $this->lang->line('category_breadcrumb_delete'),
                        $this->category->name
                    ),
                    'title' => $this->category->uripath,
                    'href' => uri_string()
                ),
            )
        );

        // Build Category Form.
        $form = new Form();
        $form->builder('post', '/categories/delete/' . $this->category->id . '.json')
             ->add_fields( array(
                    'name' => array(
                        'field' => 'name',
                        'label' => $this->lang->line('category_name'),
                        'type'  => 'text',
                        'rules' => array('required'),
                        'help'  => $this->lang->line('category_delete_name_help'),
                    ),
                )
            );

        $this->add_data( array(
                'title' => sprintf(
                    $this->lang->line('category_title_delete'),
                    $this->category->name
                ),
                'category' => (object) array(
                    'warning_title' => $this->lang->line('category_delete_warning_title'),
                    'warning_step1' => $this->lang->line('category_delete_warning_step1'),
                    'warning_step2' => $this->lang->line('category_delete_warning_step2'),
                    'warning_step3' => $this->lang->line('category_delete_warning_step3'),
                    'form'          => $form->render_form()
                ),
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in category form as
     *          well as their attributes.
     *
     * @access private
     * @param  $category_id, Current Category Object
     * @return array
    **/
    private function _fields( $category_id = NULL) 
    {
        // Get Category base fields.
        $fields = $this->category->validation;

        // Initialize Content Type Object.
        $content_type = new Content_Type();

        // Get Content Types.
        $content_type
            ->where( 'active_flag', 1 )
            ->order_by('name asc');

        // Load available content types.
        $content_types = array( $this->lang->line('select_options') => '' );
        foreach ( $content_type->get() as $object )
            $content_types[ $object->name ] = $object->id;

        // Define Category Fields Attributes.
        $attrs = array(
            'content_types' => array(
                'values' => $content_types,
            ),
            'publish_flag' => array(
                'values' => array(
                    $this->lang->line('category_publish_yes') => 1,
                    $this->lang->line('category_publish_no')  => 0,
                ),
            ),
            'views'   => array(
                'attrs' => array(
                    'placeholder'  => $this->lang->line('category_content_types_search'),
                    'data-jsb-url' => base_url( '/categories/search.json?current_id=' . $category_id ),
                ),
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}