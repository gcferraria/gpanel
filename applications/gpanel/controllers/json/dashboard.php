<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends JSON_Controller {

    /**
     * __construct: Ajax Dashboard Class constructor.
     *              Initialize Google Analitycs.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct();
        
        // Load library
        $this->load->library('ga_api');

        // Check Login in Google Analytics.
        if ( !$this->ga_api->is_logged() ) {
            log_message(
                'error',
                'Controller: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; '.
                'Cannot Login in Google Analytics.'
            );

            // Show 500 error page.
            show_error('Cannot Login in Google Analytics', 500);
        }
    }
    
    /**
     * general_stats: Gets general stats
     *
     * @access public
     * @return json
     *
    **/
    public function general_stats() {
        $range = $this->input->post('date');
        $range = explode( '/', $range );

        $notifications = new Notification();
        $counters      = new Content_Counter();
        $contents      = new Content();
        $users         = new Newsletter_Contact();

        parent::index(
            array(
                '$notifications' => number_format( $notifications->where( array(
                        'creation_date >=' => date("Y-m-d H:i:s", strtotime(trim($range[0]))),
                        'creation_date <=' => date("Y-m-d H:i:s", strtotime(trim($range[1]))),
                    ))->count() 
                ),
                '$counters' => number_format( $counters->where( array(
                        'creation_date >=' => date("Y-m-d H:i:s", strtotime(trim($range[0]))),
                        'creation_date <=' => date("Y-m-d H:i:s", strtotime(trim($range[1]))),
                    ))->count() 
                ),
                '$contents' => number_format( $contents->where( array(
                        'creation_date >=' => date("Y-m-d H:i:s", strtotime(trim($range[0]))),
                        'creation_date <=' => date("Y-m-d H:i:s", strtotime(trim($range[1]))),
                    ))->count() 
                ),
                '$contacts' => number_format( $users->where( array(
                        'creation_date >=' => date("Y-m-d H:i:s", strtotime(trim($range[0]))),
                        'creation_date <=' => date("Y-m-d H:i:s", strtotime(trim($range[1]))),
                    ))->count() 
                ),
            )
        );
    }

    /**
     * browsers: Get Google Analitycs Browser Statistics
     *
     * @access public
     * @return json
    **/
    public function browsers() {
        $rows = $this->_get_data('browser','sessions', '-', 3);
        $total = 0;
        foreach ( $rows as $row ) {
            $total = $total + (int)$row[1]; 
        }
    
        $data = array();
        foreach ( $rows as $row ) {
            $data[] = array('value' => round((($row[1]*100)/$total),0), 'text' => $row[0] );
        }

        parent::index( $data );
    }

    /**
     * devices: Get Google Analitycs General Statistics
     *
     * @access public
     * @return json
    **/
    public function devices() {
        $rows = $this->_get_data('deviceCategory','sessions', '-', 3);
        $total = 0;
        foreach ( $rows as $row ) {
            $total = $total + (int)$row[1]; 
        }
    
        $data = array();
        foreach ( $rows as $row ) {
            $data[] = array('value' => round((($row[1]*100)/$total),0), 'text' => $this->lang->line( 'dashboard_box_device_' . $row[0]) );
        }

        parent::index( $data );
    }
    /**
     * ga_visits: Get Google Analitycs Visits Statistics
     *
     * @access public
     * @return json
    **/
    public function ga_visits() {
        $profile = $this->input->post('profile');
        if ( !empty($profile) ){
            $data = array();
            foreach ( $this->_get_data() as $row ) {
                $data[] = array($row[0] . '/' . date('Y'), $row[1]);
            }

            return parent::index( $data );
        }
        else {
            parent::index( array('error' => 1, 'message' => $this->lang->line('unespected_message') ) );
        }
    }

    /**
     * _ga_data: Get dynamic Google Analytics data based on profile and metric.
     *
     * @access private
     * @return array
    **/
    private function _get_data( $dimension = 'month', $sort = 'month', $direction = NULL, $max_results = 99999 ) {
        $range = $this->input->post('date');
        $range = explode( '/', $range );

        $ga_data = $this->ga_api->analytics->data_ga->get(
            'ga:' . $this->input->post('profile'),
            trim($range[0]), 
            trim($range[1]),
            'ga:' . $this->input->post('metric'),
            array(
                'sort'        => $direction .'ga:' . $sort,
                'dimensions'  => 'ga:' . $dimension,
                'max-results' => $max_results
            )  
        );
         
        
        return $ga_data->getRows();;
    }
}