<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JSON_Controller extends GP_Controller 
{
    /**
     * _construct: JSON_Controller Class constructor.
     *
     * @access public
     * @return void
    **/
    function __construct( $access = 'restrict' ) 
    {
        parent::__construct( $access );

        // Check if is an ajax request.
        if ( ! $this->input->is_ajax_request() ) 
        {
            log_message(
                'error',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Access not allowed.'
            );

            show_error('Access not allowed', 500);
        }
    }

    public function redirect() 
    {
        show_error('Access not allowed', 500);
    }

    /**
     * index: Show received data in json.
     *
     * @access public
     * @param  string $data, [Optional] Data to output.
     * @return void
    **/
    public function index( $data = array() ) 
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output( json_encode( $data ) );
    }

}
