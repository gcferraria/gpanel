<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Administrator
 *
 * @uses      DataMapper
 * @package   Administration
 * @copyright Copyright (c) 2012, Gonçalo Ferraria
 * @author    Gonçalo Ferraria <gferraria@gmail.com>
 */

class Administrator extends DataMapper {

    public $table    = 'administrator';
    public $has_many = array(
        'sessions'   => 'administrator_session',
        'contents'  => array(
            'class'          => 'content',
            'other_field'    => 'administrator',
            'join_self_as'   => 'creator',
            'join_table'     => 'content',
        ),
        'categories'  => array(
            'class'          => 'category',
            'other_field'    => 'administrator',
            'join_self_as'   => 'creator',
            'join_table'     => 'category',
        ),
    );

    public $validation = array(
        'name' => array(
            'type'  => 'text',
            'rules' => array('required'),
        ),
        'username' => array(
            'type'  => 'text',
            'rules' => array('required','unique','spaces','trim'),
        ),
        'password' => array(
            'type'  => 'password',
            'rules' => array('required','encrypt','spaces','trim'),
        ),
        'confirm_password' => array(
            'type'  => 'password',
            'rules' => array('encrypt','required','matches' => 'password','spaces','trim')
        ),
        'email' => array(
            'type'  => 'email',
            'rules' => array('required','unique','trim','valid_email'),
        ),
        'sex' => array(
            'type'  => 'radiogroup',
            'rules' => array('required'),
            'value' => 'M',
        ),
        'super_admin_flag' => array(
            'type'  => 'radiogroup',
            'rules' => array('required'),
            'value' => '0',
        ),
        'active_flag' => array(
            'type'   => 'radiogroup',
            'rules'  => array('required'),
            'value'  => '1',
        ),
        'avatar' => array(
            'type' => 'file',
        ),
    );

    /**
     * __construct: Administrator class constructor.
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

    /**
     * login: Check if Administrator have a valid login.
     *
     * @access public
     * @return boolean
    **/
    public function login() {

        // Validate and get this user by their property values and active status.
        $this->validate()->where('active_flag', 1)->get();

        // Login Success.
        return ( $this->exists() ) ? TRUE : FALSE;
    }

    /**
     * last_login: Get Last Login Record
     *
     * @access public
     * @return object.
    **/
    public function last_login() {

        // Get Last 2 sessions.
        $session =
            $this->sessions
                 ->order_by( 'creation_date', 'desc' )
                 ->limit( 1 )
                 ->get();

        return $session;
    }

    /**
     * encrypt: Encryption of a value in the SHA1 algorithm.
     *
     * @access public
     * @param  string $field, [Required] $field to encrypt.
     * @return void.
    **/
    public function _encrypt( $field ) {

        // Don't encrypt an empty value.
        if ( !empty( $this->{ $field } ) )
            $this->{ $field } = sha1( $this->{ $field } );
    }

    /**
     * is_admin: Check if administrator is a super administrator
     *
     * @access public
     * @return boolean
    **/
    public function isAdmin() {
        return ( $this->super_admin_flag == 1 ) ? TRUE : FALSE; 
    }

    /**
     * get_created_contents_number: Get the number of created contents by this administrator
     *
     * @access public
     * @return number
     */
    public function get_created_contents_number() {
        return $this->contents->count();
    }

    /**
     * get_created_categories_number: Get the number of created categories by this administrator
     *
     * @access public
     * @return number
     */
    public function get_created_categories_number() {
        return $this->categories->count();
    }

    /**
     * get_created_media_number: Get the number of created Media Files by this administrator
     *
     * @access public
     * @return number
     */
    public function get_created_media_number() {
        return 0;
    }

}
