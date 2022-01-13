<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function insertUser($data)
    {
        // Insert customer data
        $insert = $this->db->insert('tbl_user', $data);
        // Return the status
        return $insert?$this->db->insert_id():false;
    }

    public function loginOTP($otp,$contact)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('otp',$otp);
        $this->db->where('contact',$contact);

        $query=$this->db->get();
        
        if($query->num_rows()==1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function activate($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_user', $data);
    }

    public function getUser($id)
    {
        $query = $this->db->get_where('tbl_user',array('id'=>$id));
        return $query->row_array();
    }

    public function login($email,$password,$domainname)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $this->db->where('domainname',$domainname);

        $query=$this->db->get();
        
        if($query->num_rows()==1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
}