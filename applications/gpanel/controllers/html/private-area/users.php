<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends HTML_Controller {

    /**
     * __construct: Users Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();

        // Add Users Breadcrumb.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('user_breadcrumb'),
                'href' => 'private-area/users',
            )
        );
    }

    /**
     * index: Add User data and render Users list page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $data = (object) array(
            'source' => 'private-area/users.json',
            'header' => array(
                $this->lang->line('user_name'),
                $this->lang->line('user_email'),
                $this->lang->line('user_creation_date'),
                $this->lang->line('user_status'),
            ),
        );

        $this->add_data( array(
                'title'   => $this->lang->line('user_title'),
                'table'   => $data,
                'actions' => array(
                    $this->lang->line('add') => 'private-area/users/add',
                )
            )
        );

        parent::index();
    }

    /**
     * add: Build and Render User Form.
     *
     * @access public
     * @return void
    **/
    public function add() {

        // Add Breadcumbs to Add User.
        $this->breadcrumb->add( array(
                'text' => $this->lang->line('user_breadcrumb_add'),
                'href' => uri_string()
            )
        );

        // Inicialize User Object and Form Object.
        $user_form = new Form();
        $user      = new User();

        // Build User Form.
        $user_form
        ->builder( 'post', '/private-area/users/add.json' )
        ->add_fields( $this->_fields( $user ) );

        $this->add_data( array(
                'title' => $this->lang->line('user_title_add'),
                'user' => (object) array(
                    'form' => $user_form->render_form(),
                ),
            )
        );

        parent::index();
    }

    /**
     * edit: Find User to edit, build User form and display User Summary.
     *
     * @access public
     * @param  string $id, User identifier
     * @return void
    **/
    public function edit( $id ) {
 
        // Find User to Edit.
        $user = new User();
        $user->get_by_id( $id );

        if ( ! $user->exists() )
            return;

        // Add Breadcrumb to edit User.
        $this->breadcrumb->add( array(
                'text' => sprintf(
                    $this->lang->line('user_breadcrumb_edit'),
                    $user->name
                ),
                'href' => uri_string(),
            )
        );

        // Inicialize Form Objects.
        $personal_form    = new Form();
        $change_pass_form = new Form();

        // Get User Roles
        $user_roles = $user->roles;

        // Get Roles for this User and convert to JSON.
        $roles = array();
        foreach( $user_roles->get() as $role )
                $roles[] = $role->id;
        $user->roles = $roles;

        // Build User Data Form.
        $personal_form
        ->builder('post','/private-area/users/edit/' . $user->id . '.json', array('data-jsb-name' => 'userdata'))
        ->add_fields(
            $this->_user_data_fields( $user ),
            $user
        );

        // Build Change Password Form.
        $change_pass_form
        ->builder('post','/private-area/users/change_password/' . $user->id . '.json', array('data-jsb-name' => 'password'))
        ->add_fields(
            $this->_change_password_fields( $user )
        );

        $data = (object) array(
            'object'               => $user,
            'roles'                => $user_roles,
            'sessions'             => $user->sessions->get(),
            'personal_form'        => $personal_form->render_form(),
            'change_password_form' => $change_pass_form->render_form(),
        );

        $this->add_data( array( 'user' => $data ) );
        

        parent::index();
    }

    /**
     * _fields: Define the fields to be displayed in user form as
     *          well as their attributes.
     *
     * @access private
     * @param  object $user, [Required] User Object.
     * @return array
    **/
    private function _fields( $user ) {

        // Get User base fields.
        $fields = $user->validation;

        // TODO: Remove This!
        unset( $fields['avatar'] );

        // Initialize Rolee Object.
        $role = new Role();

        // Get Active Roles.
        $role->where( 'active_flag', 1 )
             ->order_by('name asc');

        // Load available content types.
        $roles = array( 'Seleccione as opções...' => '' );
        foreach ( $role->get() as $object )
            $roles[ $object->name ] = $object->id;

        // Define User Fields Attributes.
        $attrs = array(
            'email' => array(
                'help' => $this->lang->line('form_field_no_spaces'),
            ),
            'password' => array(
                'help' => $this->lang->line('form_field_no_spaces'),
            ),
            'confirm_password' => array(
                'help' => $this->lang->line('form_field_no_spaces'),
            ),
            'active_flag' => array(
                'values' => array(
                    $this->lang->line('user_active_yes') => 1,
                    $this->lang->line('user_active_no')  => 0,
                ),
            ),
            'roles' => array(
                'values' => $roles,
            ),
        );

        return array_replace_recursive( $fields, $attrs );
    }

    /**
     * _user_data_fields: Define the fields to be displayed in data form as
     *                    well as their attributes.
     *
     * @access private
     * @param  object $user, [Required] User Object.
     * @return array
    **/
    private function _user_data_fields( $user ) {

        // Get User Base Fields.
        $fields = $user->validation;

        // Filter User Data Fields.
        $data = array();
        foreach ( array('name', 'email', 'active_flag', 'roles') as $field ) {
            $data[ $field ] = $fields[ $field ];
        }

        // Initialize Role Object.
        $role = new Role();

        // Get Active Roles.
        $role->where( 'active_flag', 1 )
             ->order_by('name asc');

        $roles = array( $this->lang->line('select_options') => '' );
        foreach ( $role->get() as $object )
            $roles[ $object->name ] = $object->id;

        // Define User Data Fields attributes.
        $attrs = array(
            'email' => array(
                'attrs' => array(
                    'readonly' => 'readonly',
                )
            )
            ,'active_flag' => array(
                'values' => array(
                    $this->lang->line('user_active_yes') => 1,
                    $this->lang->line('user_active_no')  => 0,
                ),
            ),
            'roles' => array(
                'values' => $roles,
            ),

        );

        return array_replace_recursive( $data, $attrs );
    }

    /**
     * change_password_fields: Define the fields to be displayed in change
     *                         password form well as their attributes.
     *
     * @access private
     * @param  object $user, [Required] User Object.
     * @return array
    **/
    private function _change_password_fields( $user ) {

        // Get User Base Fields.
        $fields = $user->validation;

        // Filter Change Password Fields.
        $password = array();
        foreach ( array('password', 'confirm_password') as $field ) {
            $password[ $field ] = $fields[ $field ];
        }

        // Define Change Password Fields attributes.
        $attrs = array(
            'password' => array(
                'attrs' => array(
                    'placeholder' => $this->lang->line('new_password'),
                ),
                'help' => $this->lang->line('form_field_no_spaces')
            ),
            'confirm_password' => array(
                'attrs' => array(
                    'placeholder' => $this->lang->line('password_confirm'),
                ),
                'help' => $this->lang->line('form_field_no_spaces')
            ),
        );

        return array_replace_recursive( $password, $attrs );
    }

}

/* End of file users.php */
/* Location: ../applications/gpanel/controllers/html/private-area/users.php */
