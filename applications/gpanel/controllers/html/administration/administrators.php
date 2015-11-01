<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrators extends HTML_Controller {

    /**
     * __construct: Administrators Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        // Add Administrators Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('administrator_breadcrumb'),
                'href' => 'administration/administrators',
            )
        );
    }

    /**
     * index: Add Administrators data and render Administrators list page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $data = (object) array(
            'source' => 'administration/administrators.json',
            'header' => array(
                $this->lang->line('administrator_name'),
                $this->lang->line('administrator_username'),
                $this->lang->line('administrator_creation_date'),
                $this->lang->line('administrator_status'),
            ),
        );

        $this->add_data( array(
                'title'   => $this->lang->line('administrator_title'),
                'table'   => $data,
                'actions' => array(
                    $this->lang->line('add') => 'administration/administrators/add',
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render Administrator Form.
     *
     * @access public
     * @return void
    **/
    public function add() {

        // Add Breadcumbs to Add Administrator.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('administrator_breadcrumb_add'),
                'href' => uri_string()
            )
        );

        // Inicialize Administrator Object and Form Object.
        $administrator_form = new Form();
        $administrator      = new Administrator();

        // Build Administrator Form.
        $administrator_form
        ->builder( 'post', '/administration/administrators/add.json' )
        ->add_fields( $this->_fields( $administrator ) );

        $this->add_data( array(
                'title' => $this->lang->line('administrator_title_add'),
                'administrator' => (object) array(
                    'form' => $administrator_form->render_form(),
                ),
            )
        );

        parent::index();
    }

    /**
     * edit: Find Administrator to edit, and build Administrator Form.
     *
     * @access public
     * @param  string $id, Administrator Identifier
     * @return void
    **/
    public function edit( $id ) {

        // Find Administrator to Edit.
        $administrator = new Administrator();
        $administrator->get_by_id( $id );

        if ( ! $administrator->exists() )
            return;

        // Add Breadcrumb to edit Administrator.
        $this->breadcrumb->add( array(
                'text' => sprintf(
                    $this->lang->line('administrator_breadcrumb_edit'),
                    $administrator->name
                ),
                'href' => uri_string(),
            )
        );

        // Inicialize Administrator Form Object.
        $administrator_form = new Form();

        // Remove Password Fields.
        $fields = $this->_fields( $administrator );
        unset( $fields['password'] );
        unset( $fields['confirm_password'] );

        // Build Administrator Form.
        $administrator_form
        ->builder( 'post', '/administration/administrators/edit/' . $administrator->id . '.json')
        ->add_fields( $fields, $administrator );

        $this->add_data( array(
                'title'   => $this->lang->line('administrator_title_edit'),
                'administrator' => (object) array(
                    'form' => $administrator_form->render_form()
                )
            )
        );

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in administrator form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $administrator, [Required] Administrator Object.
     * @return array
    **/
    private function _fields( $administrator ) {

        // Get Administrator base fields.
        $fields = $administrator->validation;

        // TODO: Remove This!
        unset( $fields['avatar'] );

        // Define Administrator Fields Attributes.
        $attrs = array(
            'username' => array(
                'help' => $this->lang->line('form_field_no_spaces'),
            ),
            'password' => array(
                'help' => $this->lang->line('form_field_no_spaces'),
            ),
            'confirm_password' => array(
                'help' => $this->lang->line('form_field_no_spaces'),
            ),
            'sex' => array(
                'values' => array(
                    $this->lang->line('administrator_sex_male')   => 'M',
                    $this->lang->line('administrator_sex_female') => 'F',
                ),
            ),
            'super_admin_flag' => array(
                'values' => array(
                    $this->lang->line('administrator_super_admin_yes') => 1,
                    $this->lang->line('administrator_super_admin_no')  => 0,
                ),
            ),
            'active_flag' => array(
                'values' => array(
                    $this->lang->line('administrator_active_yes') => 1,
                    $this->lang->line('administrator_active_no')  => 0,
                ),
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

}

/* End of file administrators.php */
/* Location: ../applications/gpanel/controllers/html/administration/administrators.php */
