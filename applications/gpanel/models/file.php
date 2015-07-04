<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File
 *
 * @uses      DataMapper
 * @package   File
 * @copyright Copyright (c) 2012, Gonçalo Ferraria
 * @author    Gonçalo Ferraria <gferraria@gmail.com>
 */

class File extends DataMapper {

    public $table = 'file';

    public $validation = array(
        'name' => array(
            'type'  => 'text',
            'rules' => array('required'),
        ),
        'filename' => array(
            'type'  => 'file',
        ),
    );

    /**
     * __construct: File class constructor.
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

/* End of file file.php */
/* Location: ../applications/gpanel/models/file.php */
