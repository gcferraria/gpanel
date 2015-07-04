<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Administrator Session
 *
 * @uses      DataMapper
 * @package   Administration
 * @copyright Copyright (c) 2012, Gonçalo Ferraria
 * @author    Gonçalo Ferraria <gferraria@gmail.com>
 */

class Administrator_Session extends DataMapper {

    public $table 	= 'administrator_session';
    public $has_one = array(
        'administrator' => array(
            'other_field' => 'sessions',
        ),
    );

    /**
     * __construct: Administrator Session class constructor.
     *              Call parent Construct.
     *
     * @access public
     * @return void
    **/
    public function __construct( $id = NULL ) {

        // Call parent constructor.
        parent::__construct( $id );

        log_message(
            'debug',
            'Model: ' . __CLASS__ . '; Initialized.'
        );
    }

}

/* End of file administrator_session.php */
/* Location: ./applications/gpanel/models/administrator_session.php */
