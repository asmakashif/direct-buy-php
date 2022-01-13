<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class ImportExcelModel extends CI_Model 
{
	
    public function importData($data) 
    {
        $res = $this->db->insert_batch('tbl_products',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function importDataToBaseDB($data) 
    {
        $res = $this->db->insert_batch('temp_str_config',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }


    // public function getStockOutPackets()
    // {
    //     $created_date=date("Y-m-d");
    //     $query = $this->db->query("SELECT stk.stockin,p.product_name,stk.stockin_packets, SUM(stk.stockout_packets) as sum from stock_out as stk JOIN product as p On p.product_id=stk.product_id WHERE stk.created_date='$created_date' group by stk.stockin");
    //     return $query->result_array();
    // }
}
 
?>