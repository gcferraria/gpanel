<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends JSON_Controller {

    /**
     * __construct: Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'public' );
    }

    /**
     * index: Check if is a valid login.
     *
     * @access public
     * @return json
    **/
    public function index() {

        $administrator = $this->authentication->login(
                $this->input->post('username'),
                $this->input->post('password'),
                $this->input->post('remember') ? TRUE : FALSE
            );

        if ( $administrator ) { // Valid Login.
            $data = array(
                'redirect' => array(
                    'url'      => site_url('dashboard'),
                    'duration' => 100,
                ),
            );

        }
        else // Invalid Login.
            $data = array( 'notification' => array('error', $this->lang->line('login_error')) );

        parent::index( $data );
    }
}

/* End of file login.php */
/* Location: ./applications/gpanel/controllers/ajax/login.php */
