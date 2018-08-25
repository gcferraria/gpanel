<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial_Structure extends CI_Migration {

    public function up() 
    {
        $this->db->query("");
    }

    public function down() 
    {
        $this->db->query('');
    }

}