<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends DataMapper 
{
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

}