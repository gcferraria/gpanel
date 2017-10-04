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
        $errors = array();

        // Checks Login.
        $administrator = $this->authentication->login(
                $this->input->post('username'),
                $this->input->post('password'),
                $this->input->post('remember') ? TRUE : FALSE
            );

        if ( $administrator ) { // Valid Login.
            $data = array(
                'reset'    => 1,
                'redirect' => array(
                    'url'      => site_url('dashboard'),
                    'duration' => 100,
                ),
            );
        }
        else { // Invalid Login.

            // Check for username errors
            if ( empty($this->input->post('username') ) ) {
                $errors['username'] = $this->lang->line('required');
            }
            else if ( !$this->authentication->usernameExists($this->input->post('username')) ) {
                $errors['username'] = $this->lang->line('invalid_value');
            }

            // Check for password errors
            if ( empty($this->input->post('password') ) ) {
                $errors['password'] = $this->lang->line('required');
            }
            elseif ( !isset($errors['username']) ) {
                $errors['password'] = $this->lang->line('invalid_value');
            }

            $data = array('show_errors' => $errors );
        }

        parent::index( $data );
    }

    /**
    * forget: Reset administrator password and send notification for administrator with the new autentication data.
    *
    * @access public
    * @return json
    **/
    public function forget() {
        $errors = array();

        // Set validation rules.
        $this->form_validation->set_rules('email', '', 'trim|required|valid_email');

        if ( $this->form_validation->run() ) {

            // Check if this email is an valid user.
            $password = $this->authentication->forgetPassword( $this->input->post('email') );

            if ( !empty( $password ) ) {

                // Send notification.
                $this->email->send_multipart = FALSE;
                $this->email->from( $this->config->item('noreply_email'), $this->config->item('noreply_name') );
                $this->email->to( $this->input->post('email') );
                $this->email->subject('Recuperação de Password.');
                $this->email->message($this->load->view('_templates/email/change_password', array('password' => $password),true));
                $this->email->send();

                $data = array(
                    'reset'          => 1,
                    'notification'   => array( 'success', 'A sua password foi recuperada com sucesso. Verifique o seu email.'),
                );
            }
            else {
                $errors['email'] = $this->lang->line('invalid_value');
                $data = array( 'show_errors' => $errors );
            }
        }
        else {
            //Get Fields Error Messages.
            foreach ( array('email') as $field ) {
                if ( $error = $this->form_validation->error( $field ) )
                $errors[ $field ] = strip_tags( $error );
            }

            $data = array( 'show_errors' => $errors );
        }

        parent::index( $data );
    }
}