<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_Session extends DataMapper 
{
    public $table 	= 'administrator_session';
    public $has_one = array(
        'administrator' => array(
            'other_field' => 'sessions',
        ),
    );

}