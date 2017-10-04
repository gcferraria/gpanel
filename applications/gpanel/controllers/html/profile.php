<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends HTML_Controller {

    /**
     * __construct: Profile Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {

        // Call parent constructor.
        parent::__construct( 'restrict' );

        // Add Administrator name to Breadcrumb.
        $message = sprintf(
                $this->lang->line('profile_breadcrumb'),
                $this->administrator->name
            );

        // Add Profile Title.
        $this->add_data( array(
                    'administrator'     => $this->administrator,
                    'total_contents'    => $this->administrator->get_created_contents_number(),
                    'total_categories'  => $this->administrator->get_created_categories_number(),
                    'total_media'       => $this->administrator->get_created_media_number(),
                    'class'             => 'page-container-bg-solid',
                    'sidebarClass'      => 'col-md-2',
                    'contentClass'      => 'col-md-10',
                    'title'             => $this->lang->line('profile_title') . ' | ' . $this->administrator->name,
                )
            );

        // Add Breadcrumb Profile
        $this->breadcrumb->add( array(
                    'text' => $message,
                    'href' => 'profile',
                )
            );
    }

    /**
     * index: Add Profile data and render Profile dashboard page.
     *
     * @access public
     * @return void
    **/
    public function index() {

        $data = (object) array(
            'contents' => $this->_get_last_contents(),
            'sessions' => $this->_get_last_sessions(),
        );

        $this->add_data( array( 'profile' => $data ) );

        parent::index();
    }

    /**
     * index: Add Profile data and render Profile settings page.
     *
     * @access public
     * @return void
    **/
    public function settings() {

        $this->breadcrumb->add( array(
                array(
                    'text'  => $this->lang->line('profile_breadcrumb_settings'),
                    'href'  => uri_string(),
                ),
            )
        );

        // Inicialize Form Objects.
        $personal_form    = new Form;
        $change_pass_form = new Form;

        // Build Personal Data Form.
        $personal_form
            ->builder('post','/profile.json', array('data-jsb-name' => 'personal'))
            ->add_fields(
                $this->_personal_fields(),
                $this->administrator
            );

        // Build Change Password Form.
        $change_pass_form
            ->builder('post','/profile/change_password.json', array('data-jsb-name' => 'password'))
            ->add_fields(
                $this->_change_password_fields()
            );


        $data = (object) array(
            'personal_form'        => $personal_form->render_form(),
            'change_password_form' => $change_pass_form->render_form(),
        );

        $this->add_data( array( 'profile' => $data ) );

        parent::index();
    }

    /**
     * _personal_fields: Define the fields to be displayed in personal data form as
     *                   well as their attributes.
     *
     * @access private
     * @return array
    **/
    private function _personal_fields() {

        // Get Adminitrator Base Fields.
        $fields = $this->administrator->validation;

        // Filter Personal Fields.
        $personal = array();
        foreach ( array('name','username','email','sex') as $field ) {
            $personal[ $field ] = $fields[ $field ];
        }

        // Define Personal Fields attributes.
        $attrs = array(
            'username' => array(
                'attrs' => array(
                    'readonly' => 'readonly',
                )
            ),
            'sex' => array(
                'values' => array(
                    $this->lang->line('administrator_sex_male')   => 'M',
                    $this->lang->line('administrator_sex_female') => 'F',
                )
            ),
        );

        return array_replace_recursive( $personal, $attrs );
    }

    /**
     * change_password_fields: Define the fields to be displayed in change
     *                         password form well as their attributes.
     *
     * @access private
     * @return array
    **/
    private function _change_password_fields() {

        // Get Adminitrator Base Fields.
        $fields = $this->administrator->validation;

        // Filter Change Password Fields.
        $password = array();
        foreach ( array('password', 'confirm_password') as $field ) {
            $password[ $field ] = $fields[ $field ];
        }

        // Define Change Password Fields attributes.
        $attrs = array(
            'password' => array(
                'attrs' => array(
                    'placeholder' => 'Nova Password',
                ),
                'help' => $this->lang->line('form_field_no_spaces')
            ),
            'confirm_password' => array(
                'attrs' => array(
                    'placeholder' => 'Confirmação de Password',
                ),
                'help' => $this->lang->line('form_field_no_spaces')
            ),
        );

        return array_replace_recursive( $password, $attrs );
    }

    /**
     * _get_last_contents: Get Last 10 contents published by this administrator.
     *
     * @access private
     * @return array
     */
    private function _get_last_contents() {

        $contents = $this->administrator->contents
            ->where( array( 'publish_flag' => 1 ) )
            ->order_by( 'publish_date DESC' )
            ->limit(10);

        $data = array();
        foreach ( $contents->get() as $content ) {
            $categories = array();

            foreach ( $content->categories->get() as $category ) {
                array_push( $categories, (object) array(
                        'id'   => $category->id,
                        'name' => $category->name,
                        'link' => site_url('categories/contents/edit/' . $category->id . '/' . $content->id)
                    )
                );
            }

            array_push( $data, (object) array(
                    'id'           => $content->id,
                    'name'         => $content->name,
                    'publish_date' => $content->publish_date,
                    'publish'      => $content->publish_flag,
                    'categories'   => $categories,
                )
            );
        }

        return $data;
    }

    /**
     * _get_last_sessions: Get Last 10 sessions for this administrator.
     *
     * @access private
     * @return array
     */
    private function _get_last_sessions() {

        $sessions = $this->administrator->sessions
            ->order_by( 'creation_date DESC' )
            ->limit(10);

        $data = array();
        foreach ( $sessions->get() as $session ) {
            array_push( $data, (object) array(
                    'ip_address'       => $session->ip_address,
                    'browser'          => $session->browser,
                    'operating_system' => $session->operating_system,
                    'creation_date'    => $session->creation_date,
                )
            );
        }

        return $data;
    }
}