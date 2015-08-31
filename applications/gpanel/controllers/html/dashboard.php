<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends HTML_Controller {

    /**
     * __construct: Dashboard Class constructor.
     *
     * @access public
     * @return void
    **/
    public function __construct() {

        // Call parent constructor.
        parent::__construct( 'restrict' );

        // Load Language File.
        $this->load->language('dashboard');

        // Add Dashboard Title.
        $this->add_data( array(
                'title'      => $this->lang->line('dashboard_title'),
                'date_range' => TRUE,
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

        $notifications = new Notification();
        $counters      = new Content_Counter();
        $contents      = new Content();
        $users         = new Newsletter_Contact();

        $data = (object) array(
            'statistics' => (object) array(
                'notifications'       => number_format( $notifications->count() ),
                'counters'            => number_format( $counters->count() ),
                'contents'            => number_format( $contents->count() ),
                'newsletter_contacts' => number_format( $users->count() ),
            ),
            'activity' => (object) array(
                'contents' => $this->_get_last_contents(),
                'sessions' => $this->_get_last_sessions(),
            ),
            'visits' => (object)array(
                'url' => '/dashboard/ga_visits.json',
            ),
            'domains' => $this->config->item('ga_profiles'),
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

            array_push( $data, (object) array(
                    'name'       => $content->name,
                    'publish'    => $time,
                    'categories' => $categories,
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

        // Get the Last 10 Administrator Sessions.
        $sessions
            ->order_by( 'creation_date DESC' )
            ->limit(10);

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

/* End of file dashboard.php */
/* Location: ../applications/gpanel/controllers/dashboard.php */
