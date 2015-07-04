<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Authentication Class
 *
 * @package    CodeIgniter
 * @subpackage Libraries
 * @category   Authentication
 * @author     Gonçalo Ferraria <gferraria@gmail.com>
 * @copyright  2012 - 2013 Gonçalo Ferraria
 * @version    1.1 Authentication.php 2013-12-23 gferraria $
 */

class Authentication {

    /**
     * @var object, Codeigniter Instance
     * @access private
    **/
    private $CI;

    /**
     * __construct: Ahthentication Class Constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {

        // Get CI Object.
        $this->CI =& get_instance();

        log_message(
            'debug',
            __CLASS__ . 'Class Initialized;'
        );
    }

    /**
     * logged_in: Check if exist any administrator logged in.
     *
     * @access public
     * @return boolean
    **/
    public function logged_in() {

        if ( $administrator = $this->administrator() ) {

            $sessions = $administrator->sessions->where( array(
                        'session_id' => $this->CI->session->userdata('session_id')
                    )
                )->count();

            if ( $sessions == 1 ) {

                log_message(
                    'debug',
                    'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                    'Already exist one Session for Administrator.'
                );

                return TRUE;
            }

            return FALSE;
        }

        return FALSE;
    }

    /**
     * login: Checks if the administrator login credentials are valid
     *        and this is not locked.
     *
     * @access public
     * @param string  $username, [Required] username of the administrator.
     * @param string  $password, [Required] password of the administrator.
     * @param boolean $remember, [Required] Remember Login Option.
     * @return mixed
    **/
    public function login( $username, $password, $remember ) {

        $administrator = new Administrator;

        $administrator->username = $username;
        $administrator->password = $password;

        if ( $administrator->login() ) {

            // Set Login Cookies.
            $this->CI->session->set_userdata( array(
                    'logged_in' => TRUE,
                    'admin_id'  => $administrator->id,
                )
            );

            // Register Administrator Session.
            $session = new Administrator_Session;
            $session->session_id       = $this->CI->session->userdata('session_id');
            $session->user_agent       = $this->CI->session->userdata('user_agent');
            $session->ip_address       = $this->CI->session->userdata('ip_address');
            $session->browser          = $this->CI->agent->browser();
            $session->operating_system = $this->CI->agent->platform();

            $session->save( $administrator );

            log_message(
                'debug',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Successful Login for Administrator ' . $administrator->name . '.'
            );

            return TRUE;
        }

        log_message(
            'debug',
            'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
            'Invalid Login.'
        );

        return FALSE;
    }

    /**
     * administrator: Get the Administrator logged in.
     *
     * @access public
     * @return Object or null.
    **/
    public function administrator() {

        if ( $this->_check_login_cookies() ) {

            $administrator = new Administrator;

            return $administrator->get_by_id(
                    $this->CI->session->userdata('admin_id')
                );
        }

        return;
    }

    /**
     * is_logged: Check if Administrator is Logged
     *
     * @access public
     * @return boolean
    **/
    public function isLogged() {
        return is_empty( $this->administrator() ) ? FALSE : TRUE; 
    }

    /**
     * is_admin: Checks if administrator logged in is an super administrator.
     *
     * @access public
     * @return boolean
    **/
    public function is_admin() {

        if ( $administrator = $this->administrator )
            return $administrator->super_admin_flag == 1 ? TRUE : FALSE;

        return FALSE;
    }

    /**
     * _check_login_cookies: Checks if login cookies are defined.
     *
     * @access private
     * @return boolean
    **/
    private function _check_login_cookies() {

        // Checks if login cookies are defined.
        if( ! $this->CI->session->userdata('logged_in') ||
            ! $this->CI->session->userdata('admin_id')
        ) {

            log_message(
                'debug',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'No data found for Administrator Session.'
            );

            return FALSE;
        }

        return TRUE;
    }

    /**
     * logout: Destroy the Administrator Sessions.
     *
     * @access public
     * @param  string $redirect, [Optional] Logout Redirect.
     * @return void
    **/
    public function logout( $redirect = 'login' ) {

        // Destroy Administrator Sessions Variables.
        $this->CI->session->unset_userdata();

        // Destroy session.
        $this->CI->session->sess_destroy();

        // Redirect.
        redirect( $redirect, 'refresh');
    }

}

/* End of file authentication.php */
/* Location: ../applications/gpanel/libraries/authentication.php */
