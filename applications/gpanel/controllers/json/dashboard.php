<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends JSON_Controller {

    /**
     * @var Object, Google Analitycs Object.
     * @access private
     */ 
    private $ga;

    /**
     * __construct: Ajax Dashboard Class constructor.
     *              Initialize Google Analitycs.
     *
     * @access public
     * @return void
    **/
    public function __construct() {
        parent::__construct( 'restrict' );

        // Initialize GA Api Object.
        $this->ga = new Ga_api();

        // Login in Google Analytics.
        if ( !$this->ga->login() ) {
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
     * ga_stats: Get Google Analitycs Statistics
     *
     * @access public
     * @return json
    **/
    public function ga_visits() {
        // Get Statistic profile ( website ).
        $this->ga->profile_id = $this->input->post('profile');

        switch ( $this->input->post('metric') ) {
            case 'unique_pageviews':
                parent::index( array( $this->_unique_page_views() ) );
                break;
            case 'pageviews':
                parent::index( array( $this->_page_views() ) );
                break;
            case 'visits':
                parent::index( array( $this->_sessions() ) );
                break;
            default:
                parent::index( array('error' => 1, 'message' => 'Não foi possível obter as estatísticas') );
                break;
        }
    }

    /**
     * _unique_page_views: Get Unique Page Views by month for current Year.
     *
     * @access private
     * @return array
    **/
    private function _unique_page_views() {
        $data = array(
            'label' => 'Visualizações de Página Únicas',
            'color' => '#f89133',
            'data'  => array(),
            'lines' => array(
                'fill' =>  0.6,
                'lineWidth' => 0,
            ),
        );

        // Get Visitors by month for current year
        $ga_data = $this->ga
            ->dimension('month')
            ->metric( 'uniquepageviews' )
            ->sort_by('month')
            ->when( date('Y') . '-01-01', date('Y') . '-12-31')
            ->get_array();

        // Delete summary info
        unset( $ga_data['summary'] );

        for ( $i=1; $i<=12; $i++ ) {
            $month = str_pad($i, 2, "0", STR_PAD_LEFT);
            $data['data'][] = array($i, $ga_data[ $month ]['uniquepageviews']);
        }

        return $data;
    }

    /**
     * _page_views: Get Page Views by month for current Year.
     *
     * @access private
     * @return array
    **/
    private function _page_views() {
        $data = array(
            'label' => 'Visualizações de Página',
            'color' => '#f89453',
            'data'  => array(),
            'lines' => array(
                'fill' =>  0.6,
                'lineWidth' => 0,
            ),
        );

        // Get Visitors by month for current year
        $ga_data = $this->ga
            ->dimension('month')
            ->metric( 'pageviews' )
            ->sort_by('month')
            ->when( date('Y') . '-01-01', date('Y') . '-12-31')
            ->get_array();

        // Delete summary info
        unset( $ga_data['summary'] );

        for ( $i=1; $i<=12; $i++ ) {
            $month = str_pad($i, 2, "0", STR_PAD_LEFT);
            $data['data'][] = array($i, $ga_data[ $month ]['pageviews']); 
        }

        return $data;
    }

   /**
     * _sessions: Get Sessions by month for current Year.
     *
     * @access private
     * @return array
    **/
    private function _sessions() {
        $data = array(
            'label' => 'Visitas',
            'color' => '#f89f9f',
            'data'  => array(),
            'lines' => array(
                'fill' =>  0.6,
                'lineWidth' => 0,
            ),
        );

        // Get Visitors by month for current year
        $ga_data = $this->ga
            ->dimension('month')
            ->metric( 'sessions' )
            ->sort_by('month')
            ->when( date('Y') . '-01-01', date('Y') . '-12-31')
            ->get_array();

        // Delete summary info
        unset( $ga_data['summary'] );

        for ( $i=1; $i<=12; $i++ ) {
            $month = str_pad($i, 2, "0", STR_PAD_LEFT);
            $data['data'][] = array($i, $ga_data[ $month ]['sessions']);
        }

        return $data;
    }

}

/* End of file dashboard.php */
/* Location: ./applications/gpanel/controllers/json/dashboard.php */
