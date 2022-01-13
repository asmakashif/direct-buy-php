<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function getUserId()
    {
        $data = explode('.',$_SERVER['SERVER_NAME']);
        $this->db->where('domainname',$data[0]);
        $q = $this->db->get('tbl_user')->row();
        $user_id = $q->id;
        return $user_id;
    }
    
    public function fetchPaymentProviders()
    {
        $this->db->select('*');
        $this->db->from('payment_provider as pp');
        $this->db->where('payment_p_name !=', 'CashOnDelivery');
        return $this->db->get()->result();
    }
    
    public function insertPaymentDetails($data)
    {
        // Insert customer data
        $insert = $this->db->insert('payment_integration', $data);
        // Return the status
        return $insert?$this->db->insert_id():false;
    }

    public function fetchPaymentName($provider)
    {
        $this->db->select('*');
        $this->db->from('payment_integration as pi');
        $this->db->join('payment_provider as pp','pp.payment_p_name=pi.provider_type');
        $this->db->join('tbl_user as tu','tu.id=pi.user_id');
        $this->db->where('pi.provider_type',$provider);
        $this->db->where('pi.user_id',$this->session->userdata('id'));
        return $this->db->get()->row();
    }
    
    public function viewPaymentDocumentation($provider)
    {
        $this->db->select('*');
        $this->db->from('payment_provider as pp');
        $this->db->where('pp.payment_p_name',$provider);
        return $this->db->get()->row();
    }

    public function fetchPaymentDetails()
    {
        $this->db->select('*');
        $this->db->from('payment_integration as pi');
        $this->db->join('tbl_user as tu','tu.id=pi.user_id');
        $this->db->where('pi.payment_status',0);
        $this->db->where('pi.user_id',$this->session->userdata('id'));
        return $this->db->get()->result();
    }

    public function getShopData($shop_id)
    {  
        $this->db->select('*');
        $this->db->from('shop_details as sd');
        $this->db->join('tbl_user as tu','tu.id=sd.user_id');
        $this->db->where('shop_id',$shop_id);
        $query=$this->db->get()->row();
        return $query;
    }
    
    public function getShopDBName()
    {
        $q=$this->getUserId();
        $this->db->where('user_id',$q);
        $query = $this->db->get('shop_details')->row();
        return $query;
    }
}