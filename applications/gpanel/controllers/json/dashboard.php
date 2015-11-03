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
     * browsers: Get Google Analitycs Browser Statistics
     *
     * @access public
     * @return json
    **/
    public function browsers() {
        parent::index(array(
            array('value' => 60, 'text' => 'Google Chrome'),
            array('value' => 30, 'text' => 'Internet Explorer'),
            array('value' => 10, 'text' => 'Safari'),
        ));
    }

    /**
     * general_stats: Get Google Analitycs General Statistics
     *
     * @access public
     * @return json
    **/
    public function general_stats() {
        parent::index(array(
            array('value' => 60 , 'text' => 'Sessões'),
            array('value' => 30 , 'text' => 'Novas Visitas'),
            array('value' => 43 , 'text'  => 'Regressos'),
        ));
    }
    /**
     * ga_visits: Get Google Analitycs Visits Statistics
     *
     * @access public
     * @return json
    **/
    public function ga_visits() {
        if ( !empty($this->input->post('profile'))  ){
            return parent::index( $this->_get_data() );
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
    private function _get_data( $dimension = 'month', $sort = 'month' ) {
        $ga_data = $this->ga_api->analytics->data_ga->get(
            'ga:' . $this->input->post('profile'),
            date('Y') . '-01-01', 
            date('Y') . '-12-31',
            'ga:' . $this->input->post('metric'),
            array(
                'sort'       => 'ga:' . $sort,
                'dimensions' => 'ga:' . $dimension,
            )  
        );
         
        $data = array();
        foreach ( $ga_data->getRows() as $row ) {
            $data[] = array($row[0] . '/' . date('Y'), $row[1]);
        }

        return $data;
    }
}

/* End of file dashboard.php */
/* Location: ./applications/gpanel/controllers/json/dashboard.php */
