<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TableCreation extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }


    public function createTable($shopDB)
    {
        // switch over to Library DB
        $this->db->query('use direcbuy_Test');

        // define table fields
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),  
            'firstname' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'lastname' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'domainname' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'contact' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'otp' => array(
                'type' => 'INT'
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'verify_email' => array(
                'type' => 'INT'
            ),
            'registered_date' => array(
                'type' => 'DATE'
            ),
            'password_changed_date' => array(
                'type' => 'DATE'
            ),
            'login_status' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'status' => array(
                'type' => 'INT'
            )
         );

        $this->dbforge->add_field($fields);

        // define primary key
        $this->dbforge->add_key('id', TRUE);

        // create table
        $this->dbforge->create_table('tbl_user');

        //shop table
        $fields = array(
            'shop_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),  
            'user_id' => array(
                'type' => 'INT'
            ),
            'shopId' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'shop_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'shop_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'shop_address' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'shop_gst' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'shop_payment_amount' => array(
                'type' => 'INT'
            ),
            'shop_payment_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'shop_payment_date' => array(
                'type' => 'DATE'
            ),
            'shop_exp_date' => array(
                'type' => 'DATE'
            ),
            'shop_payment_status' => array(
                'type' => 'INT'
            ),
            'shop_added_date' => array(
                'type' => 'DATE'
            ),
            'shop_modified_date' => array(
                'type' => 'DATE'
            ),
            'status' => array(
                'type' => 'INT'
            )
         );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('shop_id', TRUE);
        $this->dbforge->create_table('shop_details');
    }
}