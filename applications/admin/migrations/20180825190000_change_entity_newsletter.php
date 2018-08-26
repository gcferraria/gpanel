<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_entity_newsletter extends CI_Migration {

    public function up() {    

        $this->db->query("
        ALTER TABLE newsletter 
        CHANGE COLUMN name subject VARCHAR(255) NOT NULL;
        ");

        $this->db->query("
        ALTER TABLE newsletter
        ADD COLUMN `status` VARCHAR(1) NOT NULL DEFAULT 'S' AFTER `body`
        ");

        $this->db->query("
        ALTER TABLE newsletter
        ADD COLUMN `phase` INT(1) NOT NULL DEFAULT 1 AFTER `status` 
        ");

        $this->db->query("
        ALTER TABLE newsletter
        ADD COLUMN `sent_to` INT(11) NOT NULL DEFAULT 0 AFTER `phase`
        ");

        $this->db->query("
        ALTER TABLE newsletter
        ADD COLUMN `seen_by` INT(11) NOT NULL DEFAULT 0 AFTER `sent_to`
        ");

        $this->db->query("
            ALTER TABLE newsletter_contact RENAME TO newsletter_subscriber;
        ");

    }

    public function down() {
    }
}