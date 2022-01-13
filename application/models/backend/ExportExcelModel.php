<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportExcelModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    //Online Orders Export
    public function exportProductData($shopId)
    {
        $this->db->select('*');
        $this->db->from('tbl_products as tp');
        return $this->db->get()->result();
    }
    
    public function exportProductDataFromBaseDB()
    {
        $this->db->select('*');
        $this->db->from('tbl_products as tp');
        return $this->db->get()->result();
    }
    
     public function exportProductDataFromTemp($shopId)
    {
        $this->db->select('*');
        $this->db->from('temp_str_config as tsc');
        $this->db->where('temp_shopId',$shopId);
        return $this->db->get()->result();
    }
}