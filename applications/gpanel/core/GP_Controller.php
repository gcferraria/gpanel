<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GP_Controller extends CI_Controller {

    /**
     * @var array, data to render in template
     * @access public
    **/
    public $data = array();

    /**
     * _construct: GP_Controller Class constructor.
     *             Restrict Access.
     *
     * @access public
     * @return void
    **/
    function __construct( $access = 'public' ) {
        parent::__construct( $access );

        // Restrict Access. Only logged administrators.
        if ( $access == 'restrict' ) {

            // Redirects to the login area.
            if ( ! $this->authentication->logged_in() ) {
                redirect();
            } else {
                $this->administrator = $this->authentication->administrator();
            }
        }
    }

    /**
     * add_data: Add data to render in template.
     *
     * @access public
     * @param array $data, [Optional] Data.
     * @return void
    **/
    public function add_data ( $data = array() ) {
        $this->data = array_replace_recursive( $this->data, $data );
    }

}