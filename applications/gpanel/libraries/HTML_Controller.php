<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HTML_Controller extends GP_Controller 
{
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
        if ( $access == 'restrict' ) 
        {
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
    public function index( $template = 'index' ) 
    {
        $segments = $this->uri->segment_array();

        foreach( $segments as $index => $segment ) 
        {
            if ( is_numeric( $segment ) )
                unset( $segments[ $index ] );
        }

        // Add Template as first directory.
        array_unshift( $segments, $template );

        // Load content based on URI segments
        $this->add_data( array(
                'breadcrumbs'   => $this->breadcrumb->show(),
                'sidebar'       => $this->find( $segments, '_sidebar'),
                'menu_data'     => $this->_menu_data(),
                'content'       => $this->find( $segments ),
            )
        );

        // Display Template.
        $this->load->view( 'html/_header'    , $this->data );
        $this->load->view( 'html/'. $template, $this->data );
        $this->load->view( 'html/_footer'    , $this->data );
    }

    /**
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

        if ( ! is_file( APPPATH . "views/html/$path.php") ) {

            // Remove Last position
            array_pop( $segments );

            // Search in previous directory.
            return $this->find( $segments, $file );
        }

        return $this->load->view( 'html/' . $path, $this->data, true );
    }
    
    /**
     * _menu_data: Define menu struture for admin and normal users
     * 
     * @access private
     * @return array 
     */
    private function _menu_data() {
        $data = array(
            array(
                'title'    => $this->lang->line('menu_dashboard'),
                'url'      => 'dashboard',
                'path'     => 'dashboard',
            ),
            array(
                'title'    => $this->lang->line('menu_contents'),
                'url'      => 'categories/contents/index/1',
                'path'     => 'categories/',
            ),
            array(
                'title'    => $this->lang->line('menu_media'),
                'url'      => 'media',
                'path'     => 'media',
            ),
            array(
                'title'    => $this->lang->line('menu_notifications'),
                'url'      => 'notifications',
                'path'     => 'notifications',
            ),
            array(
                'title'    => $this->lang->line('menu_private_area'),
                'path'     => 'private-area', 
                'children' => array(
                    array(
                        'title'    => $this->lang->line('menu_users'),
                        'url'      => 'private-area/users',
                        'path'     => 'private-area/users', 
                        'icon'     => 'user',
                    ),
                    array(
                        'title'    => $this->lang->line('menu_roles'),
                        'url'      => 'private-area/roles',
                        'path'     => 'private-area/roles', 
                        'icon'     => 'puzzle-piece',
                    ),
                ),
            ),
            array(
                'title'    => $this->lang->line('menu_newsletters'),
                'path'     => 'newsletters',
                'children' => array(
                    array(
                        'title'    => $this->lang->line('menu_contacts'),
                        'url'      => 'newsletters/contacts',
                        'path'     => 'newsletters/contacts',  
                        'icon'     => 'male',
                    ),
                    array(
                        'title'    => $this->lang->line('menu_newsletters'),
                        'url'      => 'newsletters/newsletters',
                        'path'     => 'newsletters/newsletters',  
                        'icon'     => 'envelope',
                    ),
                ),
            ),
        );

        $admin_data = array(
            array(
                'title'    => $this->lang->line('menu_administration'),
                'path'     => 'administration',
                'children' => array(
                    array(
                        'title'    => $this->lang->line('menu_access'),
                        'path'     => 'administration/access',
                        'children' => array(
                            array(
                                'title'    => $this->lang->line('menu_administrators'),
                                'url'      => 'administration/administrators',
                                'path'     => 'administration/access/administrators',
                            ),
                        ),
                    ),
                    array(
                        'title'    => $this->lang->line('menu_content_types'),
                        'url'      => 'administration/content_types',
                        'path'     => 'administration/content_types',
                    ),
                    array(
                        'title'    => $this->lang->line('menu_i18N'),
                        'path'     => 'administration/i18N',
                        'children' => array(
                            array(
                                'title'    => $this->lang->line('menu_languages'),
                                'url'      => 'administration/i18n/languages',
                                'path'     => 'administration/i18N/languages',
                                'children' => array()       
                            ),
                        ),
                    ),
                    array(
                        'title'    => $this->lang->line('menu_settings'),
                        'path'     => 'administration/settings',
                        'children' => array(
                            array(
                                'title'    => $this->lang->line('menu_websites'),
                                'url'      => 'administration/settings/websites',
                                'path'     => 'administration/settings/websites',
                            )
                        ),
                    ),
                ),
            ),
        );

        if ( $this->authentication->is_admin() ) {
            $data = array_merge_recursive($data,$admin_data); 
        }
        
        // Add selected attribute for menu entry
        foreach ( $data as &$entry ) {
            $entry['selected'] = ( preg_match( '/^(\/)?' . preg_quote( $entry['path'], '/i' ) . '/',  $this->uri->uri_string() ) );
        }

        return $data;
    }
}