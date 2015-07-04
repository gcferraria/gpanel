<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HTML_Controller extends GP_Controller {

    /**
     * _construct: HTML_Controller Class constructor.
     *
     * @access public
     * @return void
    **/
    function __construct( $access = 'restrict' ) {
        parent::__construct( $access );

        // Default Data.
        $this->data = array( 'title' => $this->lang->line('title') );

        // Restrict Access. Only logged administrators.
        if ( $access == 'restrict' ) {
            $notifications = new Notification();

            // Add Authentication data.
            $this->add_data(
                array(
                    'module' => $this->uri->segment(1),
                    'notifications' => array(
                        'list'   => $notifications->get_unread_messages(),
                        'number' => $notifications->get_unread_messages_number(),
                    )
                )
            );
        }
    }

    /**
     * index: Display Site Render based on Data and URI Segments.
     *
     * @access public
     * @param  array $template, [optional] Template name to render.
     * @return void
    **/
    public function index( $template = 'index' ) {

        $segments = $this->uri->segment_array();

        foreach( $segments as $index => $segment ) {
            if ( is_numeric( $segment ) )
                unset( $segments[ $index ] );
        }

        // Add Template as first directory.
        array_unshift( $segments, $template );

        // Load content based on URI segments
        $this->add_data( array(
                'breadcrumbs'   => $this->breadcrumb->show(),
                'sidebar'       => $this->find( $segments, '_sidebar'),
                'content'       => $this->find( $segments ),
            )
        );

        // Display Template.
        $this->load->view( '_header', $this->data );
        $this->load->view( $template, $this->data );
        $this->load->view( '_footer', $this->data );
    }

    /**
     *
     * find: Find one file in a hierarchical path.
     *
     * @access public
     * @param  array  $segments, [Optional] Path Array.
     * @param  string $file    , [Optional] Name to find an specific file.
     * @return string
    **/
    public function find( $segments = array(), $file = null ) {

        if ( sizeof( $segments ) == 0 )
            return '';

        $path = join( '/', $segments );

        if ( $file )
            $path .= "/$file";

        if ( ! is_file( APPPATH . "views/$path.php") ) {

            // Remove Last position
            array_pop( $segments );

            // Search in previous directory.
            return $this->find( $segments, $file );
        }

        return $this->load->view( $path, $this->data, true );
    }

}

/* End of file HTML_Controller.php */
/* Location: ../applications/gpanel/libraries/HTML_Controller.php */
