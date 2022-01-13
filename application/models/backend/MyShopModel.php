<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyShopModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    // public function getUserId()
    // {
    //     $data = explode('.',$_SERVER['SERVER_NAME']);
    //     $this->db->where('domainname',$data[0]);
    //     $q = $this->db->get('tbl_user')->row();
    //     $user_id = $q->id;
    //     return $user_id;
    // }
    
    public function fetchRetailerDetails()
    {
        // $q=$this->getUserId();
        $this->db->select('*');
        $this->db->from('tbl_user as tu');
        $this->db->where('tu.id',$this->session->userdata('id'));
        $this->db->group_by('tu.id');
        return $this->db->get()->row();
    }

    public function fetchShopType()
    {
        $this->db->select('*');
        $this->db->from('shop_types as st');
        return $this->db->get()->result();
    }

    public function insertShopDetails($data)
    {
        // Insert customer data
        $insert = $this->db->insert('shop_details', $data);
        // Return the status
        return $insert?$this->db->insert_id():false;
    }
    
    public function updateShopDetails($data) 
    { 
        if(!empty($data))
        { 
            $this->db->where('shopId',$this->input->post('shopId'));
            $update = $this->db->update('shop_details', $data); 
             
            // Return the status 
            return $update?true:false; 
        } 
        return false; 
    } 

    public function fetchShopDetails()
    {
        // $q=$this->getUserId();
        $this->db->select('*');
        $this->db->from('shop_details as sd');
        $this->db->join('tbl_user as tu','tu.id=sd.user_id');
        $this->db->where('sd.user_id',$this->session->userdata('id'));
        $this->db->where('sd.shop_status!=',0);
        $this->db->where('sd.remove_shop!=',1);
        return $this->db->get()->result();
    }
    
    public function fetchGST($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('tbl_user as tu');
        //$this->db->from('tbl_user as tu','tu.id=sd.user_id','left');
        //$this->db->where('sd.shopId', $shopId);
        $this->db->where('tu.id',$this->session->userdata('id'));
        $query=$this->db->get()->row();
        return $query;
    }

    public function getShopProducts()
    {
        $this->db->select('*');//columns
        $this->db->from('tbl_products as tp');
        $query=$this->db->get()->result();
        return $query;
    }
    
    public function getShopDetailsById($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('shop_details as sd');
        $this->db->where('sd.shopId',$shopId);
        $query=$this->db->get()->row();
        return $query;
    }

    public function fetchShopDetailTypeById($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('shop_details as sd');
        $this->db->join('shop_detail_type as sdt','sdt.shop_id=sd.shop_id');
        $this->db->join('shop_types as st','sdt.shop_type_id=st.shop_type_id');
        $this->db->where('sd.shopId',$shopId);
        $query=$this->db->get()->result();
        return $query;
    }
    
    public function getBaseDBProducts()
    {
        $query = $this->db->select('*')
                        ->from('base_products')
                        ->get();
        return $query->result_array();
    }

    public function fetchBaseProductsById($id)
    {
        $this->db->select('*');
        $this->db->from('base_products');
        $this->db->where('base_product_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }
    
    public function getTempShopProducts($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('temp_str_config as tsc');
        $this->db->where('temp_shopId',$shopId);
        $query=$this->db->get()->result();
        return $query;
    }
    
    public function getStoreSummary($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('shop_details as sd');
        $this->db->join('tbl_user as tu','tu.id=sd.user_id','left');
        $this->db->where('shopId',$shopId);
        $query=$this->db->get()->row();
        return $query;
    }

    public function getStoreSummaryType($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('shop_details as sd');
        $this->db->join('shop_detail_type as sdt','sdt.shop_id=sd.shop_id');
        $this->db->join('shop_types as st','sdt.shop_type_id=st.shop_type_id');
        $this->db->where('shopId',$shopId);
        $query=$this->db->get()->result();
        return $query;
    }

    public function getCountofProducts($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('temp_str_config as tsc');
        $this->db->join('shop_details as sd','tsc.temp_shopId=sd.shopId');
        $this->db->where('shopId',$shopId);
        $query = $this->db->get()->result_array();
        $result =array_column($query, 'shopId');
        $output=array_count_values(array_filter($result));
        return $output;
    }

    public function fetchShopName($shopId)
    {
        $this->db->select('*');//columns
        $this->db->from('shop_details as sd');
        $this->db->where('sd.shopId', $shopId);
        $query=$this->db->get()->row();
        return $query;
    }
    
    //Data migration
    public function fetchProducts()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->group_by('product_category');
        $parent = $this->db->get()->result();
        return $parent;
    }
    
    public function fetchCategory()
    {
        $this->db->select('*');
        $this->db->from('category');
        $parent = $this->db->get()->result();
        return $parent;
    }
    
    //customer orders
    public function fetchCustomerPendingOrder()
    {
        $this->db->select('*');//columns
        $this->db->from('order_items as oi');
        $this->db->join('cust_payment_details as cpd','cpd.order_code=oi.order_code');
        $this->db->where('oi.order_status',0);
        $this->db->group_by('oi.order_code');
        $query=$this->db->get()->result();
        return $query;
    }

    public function fetchCustomerPendingOrderByCode($order_code)
    {
        $this->db->select('*');//columns
        $this->db->from('order_items as oi');
        $this->db->join('cust_payment_details as cpd','cpd.order_code=oi.order_code','left');
        $this->db->join('shop_details as sd','sd.shopId=oi.shopId','left');
        $this->db->where('oi.order_code',$order_code);
        //$this->db->where('oi.shopId',$shopId);
        $this->db->group_by('oi.order_code');
        $query=$this->db->get()->result_array();
        return $query;
    }
    
    public function fetchCustPendingOrderByCode($order_code)
    {
        $this->db->select('*');//columns
        $this->db->from('order_items as oi');
        $this->db->join('cust_payment_details as cpd','cpd.order_code=oi.order_code','left');
        $this->db->join('shop_details as sd','sd.shopId=oi.shopId','left');
        $this->db->where('oi.order_code',$order_code);
        $query=$this->db->get()->row_array();
        return $query;
    }

    public function fetchCustomerPendingOrderDetails($order_code)
    {
        $this->db->select('oi.*,tsc.product_img');
        $this->db->from('order_items as oi');
        $this->db->join('temp_str_config as tsc','tsc.temp_str_config_id=oi.product_id','left');
        $this->db->where('oi.order_code',$order_code);
        //$this->db->group_by('p.product_id', $order_code);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function fetchCustomerCompletedOrders()
    {
        $this->db->select('*');//columns
        $this->db->from('order_items as oi');
        $this->db->join('cust_payment_details as cpd','cpd.order_code=oi.order_code');
        $this->db->where('oi.order_status',1);
        $this->db->group_by('oi.order_code');
        $query=$this->db->get()->result();
        return $query;
    }

    public function fetchCustomerCompletedOrderByCode($order_code)
    {
        $this->db->select('*');//columns
        $this->db->from('order_items as oi');
        $this->db->join('cust_payment_details as cpd','cpd.order_code=oi.order_code');
        $this->db->where('oi.order_status',1);
        $this->db->where('oi.order_code',$order_code);
        $this->db->group_by('oi.order_code');
        $query=$this->db->get()->result_array();
        return $query;
    }

    public function fetchCustomerCompletedOrderDetails($order_code)
    {
        $this->db->select('oi.*,tsc.product_img');
        $this->db->from('order_items as oi');
        $this->db->join('temp_str_config as tsc','tsc.temp_str_config_id=oi.product_id','left');
        $this->db->where('oi.order_status',1);
        $this->db->where('oi.order_code',$order_code);
        //$this->db->group_by('p.product_id', $order_code);
        $query = $this->db->get();
        return $query->result_array();
    }

    //store setting starts
    public function fetchPaymentDetails()
    {
        $this->db->select('*');
        $this->db->from('payment_integration as pi');
        $this->db->join('shop_payment_info as spi','spi.pInfo_payment_name=pi.payment_name','left');
        $this->db->join('tbl_user as tu','tu.id=pi.user_id','left');
        $this->db->where('pi.user_id',$this->session->userdata('id'));
        return $this->db->get()->result();
    }
    
    public function fetchPaymentDetailsById($shopId)
    {
        $user_id=$this->session->userdata('id');
        $this->db->select('*');
        $this->db->from('shop_payment_info as spi');
        $this->db->where('spi.pInfo_shopId',$shopId);
        $res=$this->db->get()->row();
        if(empty($res->pInfo_shopId))
        {
            $this->db->select('*');
            $this->db->from('payment_integration as pi');
            $this->db->join('tbl_user as tu','tu.id=pi.user_id','left');
            $this->db->where('pi.user_id',$user_id);
            return $this->db->get()->result();
        }
        else
        {
            $query = $this->db->query("SELECT * from ((SELECT pi.payment_id,pi.user_id,pi.payment_name,pi.provider_type,spi.pInfo_payment_name,spi.pInfo_shopId FROM payment_integration as pi LEFT JOIN shop_payment_info as spi ON spi.pInfo_payment_name=pi.payment_name WHERE pi.user_id = '$user_id' AND spi.pInfo_shopId = '$shopId') UNION (SELECT pi.payment_id,pi.user_id,pi.payment_name,pi.provider_type,pi.payment_api_key,pi.payment_secret_key FROM payment_integration as pi WHERE pi.user_id='$user_id')) as payment group by payment.payment_name");
            return $query->result();
        }
    }

    public function fetchShopPaymentDetails($shopId)
    {
        $this->db->select('spi.*,pp.*');
        $this->db->from('shop_payment_info as spi');
        $this->db->join('payment_provider as pp','pp.payment_p_name=spi.pInfo_provider','left');
        $this->db->join('tbl_user as tu','tu.id=spi.pInfo_userId');
        $this->db->join('shop_details as sd','sd.shopId=spi.pInfo_shopId');
        $this->db->where('spi.pInfo_userId',$this->session->userdata('id'));
        $this->db->where('sd.shopId',$shopId);
        return $this->db->get()->result();
    }
    
    public function verifyOTP($otp,$email)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('otp',$otp);
        $this->db->where('email',$email);

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