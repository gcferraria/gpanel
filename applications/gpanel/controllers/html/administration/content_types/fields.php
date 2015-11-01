<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fields extends HTML_Controller {

    /**
     * @var Object, Content Type Object.
     * @access private
    **/
    private $content_type;

    /**
     * __construct: Content Type Fields Class constructor.
     *              Get current Content Type Object.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        // Get Content Type id based on action.
        if ( $this->uri->segment(4) == 'add' )
            $id = (int) $this->uri->segment(4);
        elseif ( $this->uri->segment(4) == 'edit' ) {

            $this->content_type_field = new Content_Type_Field();
            $this->content_type_field->get_by_id(
                    (int) $this->uri->segment(5)
                );

            $id = $this->content_type_field->content_type_id;
        }
        else
            $id = (int) $this->uri->segment(5);

        // Inicialize Content Type Object.
        $this->content_type = new Content_Type();

        // Find Content Type Object.
        $this->content_type->get_by_id( $id );

        // Add Content Type Fields Title.
        $this->add_data( array(
                'title' => sprintf(
                    $this->lang->line('content_type_field_title'),
                    $this->content_type->name
                ),
            )
        );

        // Add Content Type and current Page at Breadcrumbs list.
        $this->breadcrumb->add( array(
                array(
                    'text' => $this->lang->line('content_type_breadcrumb'),
                    'href' => 'administration/content_types',
                ),
                array(
                    'text' => $this->content_type->name,
                    'href' => 'administration/content_types/fields/index/' . $this->content_type->id
                ),
            )
        );
    }

    /**
     * index: Add Content Type Field data and render Content Type Field page.
     *
     * @access public
     * @return void
    **/
    public function index( $id ) {

        $data = (object) array(
            'source' => 'administration/content_types/fields/index/' . $this->content_type->id . '.json',
            'header' => array(
                $this->lang->line('content_type_field_name'),
                $this->lang->line('content_type_field_label'),
                $this->lang->line('content_type_field_type'),
                $this->lang->line('content_type_field_status'),
            ),
        );

        $this->add_data( array(
                'table'   => $data,
                'actions' => array(
                    $this->lang->line('add') => '/administration/content_types/fields/add/' . $this->content_type->id,
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Content Type Field Form.
     *
     * @access public
     * @return void
    **/
    public function add() {

        // Add Breadcumb to Add Content Type Field.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('content_type_field_breadcrumb_add'),
                'href' => uri_string(),
            )
        );

        // Inicialize Content Type Field Object and Form Object.
        $content_type_field_form = new Form();
        $content_type_field      = new Content_Type_Field();

        // Build Content Type Field Form.
        $content_type_field_form
        ->builder( 'post', '/administration/content_types/fields/add/' . $this->content_type->id . '.json')
        ->add_fields( $this->_fields( $content_type_field ) );

        $this->add_data( array(
                'title' => $this->lang->line('content_type_field_title_add'),
                'content_type_field' => (object) array(
                    'form' => $content_type_field_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * edit: Build and Render Content Type Field Form with Content Type Field data to edit.
     *
     * @access public
     * @return void
    **/
    public function edit() {

        if ( ! $this->content_type_field->exists() )
            return;

        // Add Breadcrumb to edit Content Type Field.
        $this->breadcrumb->add( array(
                'text' => sprintf(
                    $this->lang->line('content_type_field_breadcrumb_edit'),
                    $this->content_type_field->name
                ),
                'href' => uri_string(),
            )
        );

        // Inicialize Content Type Field Form Object.
        $content_type_field_form = new Form();

        // Build Content Type Field Form.
        $content_type_field_form
        ->builder('post', '/administration/content_types/fields/edit/' . $this->content_type_field->id . '.json')
        ->add_fields(
            $this->_fields( $this->content_type_field ),
            $this->content_type_field
        );

        $this->add_data( array(
                'title'   => $this->lang->line('content_type_field_title_edit'),
                'content_type_field' => (object) array(
                    'form' => $content_type_field_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in content type field form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $content_type_field, [Required] Content Type Field Object.
     * @return array
    **/
    private function _fields( $content_type_field ) {

        // Get Content Type Field Base Fields.
        $fields = $content_type_field->validation;

        // Load allowed type fields.
        $allowed_fields = array();
        foreach( $this->form->config['allowed_fields'] as $field_type ) {
            $allowed_fields[ $field_type ] = $field_type;
        }

        // Define Content Type Field Attributes.
        $attrs = array(
            'type' => array(
                'values' => $allowed_fields,
            ),
            'required' => array(
                'values' => array(
                    $this->lang->line('content_type_field_required_yes') => 1,
                    $this->lang->line('content_type_field_required_no')  => 0,
                ),
            ),
            'args' => array(
                'attrs' => array( 'rows' => 4, 'cols' => 40 ),
            ),
            'active_flag' => array(
                'values' => array(
                    $this->lang->line('content_type_field_active_yes') => 1,
                    $this->lang->line('content_type_field_active_no')  => 0,
                ),
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}

/* End of file fields.php */
/* Location: ../applications/gpanel/controllers/html/administration/content_types/fields.php */
