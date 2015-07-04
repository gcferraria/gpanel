<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends HTML_Controller {

    /**
     * __construct: Login Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'public' );
    }

    /**
     * index: Show login form if not exist any administrator logged,
     *        or redirect to restricted area.
     *
     * @access public
     * @return void
    **/
    public function index() {

        /*
          If administrator is already logged, redirects to the restricted area,
          otherwise show login form.
        */
        if ( !$this->authentication->logged_in() ) {

            $data = (object) array(
                'title'    => $this->lang->line('login_title'),
                'remember' => $this->lang->line('login_remember'),
                'btn'      => $this->lang->line('login_btn'),
            );

            $this->add_data( array( 'login' => $data ) );

            parent::index('login');
        }
        else {

            log_message(
                'debug',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Administrator is already logged, redirects to the restricted area.'
            );

            // Redirects to the restricted area.
            redirect('/dashboard/', 'refresh');
        }

    }

    /**
     * logout: Destroy administrator session
     *
     * @access public
     * @return void
    **/
    public function logout() {
        return $this->authentication->logout();
    }

}

/* End of file login.php */
/* Location: ../applications/gpanel/controllers/login.php */
