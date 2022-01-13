<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class PaytmModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function pay($username, $tid, $amount, $state) {
        $date = new DateTime();
        if ($this->check_txt_id($tid) == 0) {
            $tdate = $this->member_since = $date->format('Y/m/d H:i:s');
            $this->db->query("INSERT INTO `membership`(`username`, `tr_id`, `amount`, `state`, `tra_date` ) VALUES( '$username', '$tid', '$amount', '$state', '$tdate' )");
            return TRUE;
        }else{
            header("Location:". base_url().'ln');
        }
    }

    public function check_txt_id($tid) {
        $query = $this->db->query("SELECT COUNT(id) as total FROM membership WHERE tr_id = '$tid'");
        foreach ($query->result_array() as $total) {
            return $total['total'];
        }
    }

    public function update_membership($username) {
        $this->db->query("UPDATE signup SET membership = '1' WHERE username = '$username'");
    }

}
