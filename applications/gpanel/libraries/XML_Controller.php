<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class XML_Controller extends CAS_Controller {

    /**
     * index: Show received data in json.
     *
     * @access public
     * @param  string $data, [Optional] Data to output.
     * @return void
    **/
    public function index( $data = array() ) {
        $this->output
            ->set_content_type('text/xml')
            ->get_output( $this->render() );
    }
}