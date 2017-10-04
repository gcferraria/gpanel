<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends HTML_Controller {

    /**
     * __construct: Dashboard Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();
        
        // Load library
        $this->load->library('ga_api');

        // Add Dashboard Title.
        $this->add_data( array(
                'title'       => $this->lang->line('dashboard_title'),
                'description' => $this->lang->line('dashboard_description'),
                'date_range'  => TRUE,
            )
        );
    }

    /**
     * index: Add Dashboard data and render Dashboard page.
     *
     * @access public
     * @return void
    **/
    public function index() {
        
        $data = (object) array(
            'activity' => (object) array(
                'contents' => $this->_get_last_contents(),
                'sessions' => $this->_get_last_sessions(),
            ),
            'statistics' => (object) array( 'url' => '/dashboard/general_stats.json' ),
            'visits'     => (object) array( 'url' => '/dashboard/ga_visits.json'     ),
            'browsers'   => (object) array( 'url' => '/dashboard/browsers.json'      ),
            'devices'    => (object) array( 'url' => '/dashboard/devices.json'       ),
            'domains'    => $this->ga_api->profiles,
        );

        $this->add_data( array( 'dashboard' => $data ) );

        parent::index();
    }

    /**
     * _get_last_contents: Get Last 10 contents published.
     *
     * @access private
     * @return array
     */
    private function _get_last_contents() {
        $contents = new Content();

        // Get Last 10 Published Contents.
        $contents
            ->where( array( 'publish_flag' => 1 ) )
            ->order_by( 'creation_date DESC' )
            ->limit(10);

        $data = array();
        foreach ( $contents->get() as $content ) {
            $categories = array();
            foreach ( $content->categories->get() as $category ) {
                array_push( $categories, (object) array(
                        'name' => $category->name,
                        'link' => site_url('categories/contents/edit/' . $category->id . '/' . $content->id)
                    )
                );
            }

            $time = new DateTime( date( 'Y-m-d H:i:s', strtotime( $content->creation_date ) ) );
            $now  = new DateTime( date( 'Y-m-d H:i:s') );
            $diff = $now->diff( $time );

            if ( $diff->y >= 1 )
                $time = $diff->y . ' ' .$this->lang->line('years');
            elseif ( $diff->m >= 1 )
                $time = $diff->m . ' ' .$this->lang->line('months');
            elseif ( $diff->d >= 1 )
                $time = $diff->d . ' ' . $this->lang->line('days');
            elseif ( $diff->h >= 1 )
                $time = $diff->h . ' ' .$this->lang->line('hours');
            elseif ( $diff->i >= 1 )
                $time = $diff->i . ' ' .$this->lang->line('minutes');
            else
                $time = $this->lang->line('right_now');

            // Gets creator
            $creator = $content->administrator->get();

            array_push( $data, (object) array(
                    'name'       => $content->name,
                    'publish'    => $time,
                    'categories' => $categories,
                    'creator'    => $creator->name,
                )
            );
        }

        return $data;
    }

    /**
     * _get_last_sessions: Get Last 10 administrator sessions.
     *
     * @access private
     * @return array
     */
    private function _get_last_sessions() {
        $sessions = new Administrator_Session();
        $sessions
            ->order_by( 'creation_date DESC' )
            ->limit(12);

        $data = array();
        foreach ( $sessions->get() as $session ) {
            $administrator = new Administrator();
            $administrator->get_by_id( $session->administrator_id );
            $data[] = (object)array(
                'date'    => $session->creation_date,
                'browser' => $session->browser,
                'name'    => $administrator->name,
                'avatar'  => empty( $administrator->avatar ) ? 'default_avatar_45.png' : $administrator->avatar,
            );
        }

        return $data;
    }
}