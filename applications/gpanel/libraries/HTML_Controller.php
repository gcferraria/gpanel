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
                'menu_data'     => $this->_menu_data(),
                'content'       => $this->find( $segments ),
            )
        );

        // Display Template.
        $this->load->view( '_header', $this->data );
        $this->load->view( $template, $this->data );
        $this->load->view( '_footer', $this->data );
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

        if ( ! is_file( APPPATH . "views/$path.php") ) {

            // Remove Last position
            array_pop( $segments );

            // Search in previous directory.
            return $this->find( $segments, $file );
        }

        return $this->load->view( $path, $this->data, true );
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
                'title'    => 'Dashboard',
                'url'      => 'dashboard',
                'selected' => 'active', 
                'children' => array(),
            ),
            array(
                'title'    => 'Gestão de Conteúdos',
                'url'      => 'categories/contents/index/1',
                'selected' => '', 
                'children' => array(),
            ),
            array(
                'title'    => 'Multimédia',
                'url'      => 'media',
                'selected' => '', 
                'children' => array(),
            ),
            array(
                'title'    => 'Notificações',
                'url'      => 'notifications',
                'selected' => '', 
                'children' => array(),
            ),
            array(
                'title'    => 'Área Privada',
                'url'      => '',
                'selected' => '', 
                'children' => array(
                    array(
                        'title'    => 'Utilizadores',
                        'url'      => 'users',
                        'selected' => '',
                        'icon'     => 'user',
                        'children' => array()
                    ),
                    array(
                        'title'    => 'Funções',
                        'url'      => 'roles',
                        'selected' => '',
                        'icon'     => 'puzzle-piece',
                        'children' => array()
                    ),
                ),
            ),
            array(
                'title'    => 'Newsletters',
                'url'      => '',
                'selected' => '', 
                'children' => array(
                    array(
                        'title'    => 'Contatos',
                        'url'      => 'newsletter_contacts',
                        'selected' => '',
                        'icon'     => 'male',
                        'children' => array()
                    ),
                    array(
                        'title'    => 'Newsletters',
                        'url'      => 'newsletters',
                        'selected' => '',
                        'icon'     => 'envelope',
                        'children' => array()
                    ),
                ),
            ),
        );

        $admin_data = array(
            array(
                'title'    => 'Administração',
                'url'      => '',
                'selected' => '', 
                'children' => array(
                    array(
                        'title'    => 'Acesso',
                        'url'      => '',
                        'selected' => '',
                        'icon'     => '',
                        'children' => array(
                            array(
                                'title'    => 'Administradores',
                                'url'      => 'administrators',
                                'selected' => '',
                                'icon'     => '',
                                'children' => array()       
                            ),
                        ),
                    ),
                    array(
                        'title'    => 'Conteúdos',
                        'url'      => '',
                        'selected' => '',
                        'icon'     => '',
                        'children' => array(
                            array(
                                'title'    => 'Tipos de Conteúdos',
                                'url'      => 'content_types',
                                'selected' => '',
                                'icon'     => '',
                                'children' => array()       
                            ),
                        ),
                    ),
                    array(
                        'title'    => 'i18N',
                        'url'      => '',
                        'selected' => '',
                        'icon'     => '',
                        'children' => array(
                            array(
                                'title'    => 'Línguas',
                                'url'      => 'i18n/languages',
                                'selected' => '',
                                'icon'     => '',
                                'children' => array()       
                            ),
                        ),
                    ),
                    array(
                        'title'    => 'Definições',
                        'url'      => '',
                        'selected' => '',
                        'icon'     => '',
                        'children' => array(
                            array(
                                'title'    => 'Websites',
                                'url'      => 'settings/website',
                                'selected' => '',
                                'icon'     => '',
                                'children' => array()       
                            )
                        ),
                    ),
                ),
            ),
        );

        if ( $this->authentication->is_admin() ) {
            $data = array_merge_recursive($data,$admin_data); 
        }

        return $data;
    }
}

/* End of file HTML_Controller.php */
/* Location: ../applications/gpanel/libraries/HTML_Controller.php */
