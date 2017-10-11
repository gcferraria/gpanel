<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends JSON_Controller 
{
    /**
     * index: Update profile settings.
     *
     * @access public
     * @return json
    **/
    public function index() 
    {
        // Get administrator logged to update.
        $administrator = $this->administrator;

        $administrator->name  = $this->input->post('name');
        $administrator->email = $this->input->post('email');
        $administrator->sex   = $this->input->post('sex');

        // If the Administrator is valid updates the data.
        if ( $administrator->save() ) 
        {
            $data = array(
                'show_errors'  => array(),
                'notification' => array('success', $this->lang->line('personal_update_success') ),
            );
        }
        else 
        {
            $data = array(
                'show_errors'  => $administrator->errors->all,
                'notification' => array('error', $this->lang->line('personal_update_error') ),
            );
        }

        parent::index( $data );
    }

    /**
     * change_password: Change Administrator Password.
     *
     * @access public
     * @return json
    **/
    public function change_password() 
    {
        // Get administrator logged to change password.
        $administrator = $this->administrator;

        $administrator->password         = $this->input->post('password');
        $administrator->confirm_password = $this->input->post('confirm_password');

        // If the Administrator is valid, change the password.
        if ( $administrator->save() ) 
        {
            $data = array(
                'reset'        => 1,
                'notification' => array('success', $this->lang->line('change_password_success') ),
            );
        }
        else 
        {
            $data = array(
                'show_errors'  => $administrator->errors->all,
                'notification' => array('error', $this->lang->line('change_password_error') ),
            );
        }

        parent::index( $data );
    }

}