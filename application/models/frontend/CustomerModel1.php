<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        	$this->load->library('session');
    }

    public function login($email,$password)

    {
         $url = explode('.',$_SERVER['SERVER_NAME']);
         $id=$url[0];
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $this->db->where('status',1);

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

    public function Check_registered($email)
    {
         
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('email',$email);
        $query=$this->db->get()->row(); 
        return $query;
    }
    public function get_products()
    {
        $store_name= $this->session->userdata('store_name');
        $this->db->select('*');
        $this->db->from('tbl_products as p');
//$this->db->join('product_types as pt','pt.id=p.product_type');
        $query=$this->db->get()->result();
        return $query;
    }
    public function get_stores()
    {
        
        $this->db->select('*');
          $this->db->from('shop_details');
        $query= $this->db->get()->result();
        return $query;
    }
    public function getSHopByUser()
    {
         $url = explode('.',$_SERVER['SERVER_NAME']);
         $domain=$url[0];
        
         $this->db->select('*');
         $this->db->from('shop_details as sd');
         $this->db->join('tbl_user as tb','sd.user_id=tb.id');
         $this->db->where('tb.domainname',$domain);
        $query= $this->db->get()->result();
        return $query;
    }
    public function getShopOwnerDetails($id)
    {
        $this->db->select('*');
          $this->db->from('shop_details as sd');
          $this->db->join('tbl_user as tb','sd.user_id=tb.id');
          $this->db->where('sd.shopId',$id);
        $query= $this->db->get()->row();

        return $query;
    }
 
    public function min_max_prices()
    {
         $store_name= $this->session->userdata('store_name'); 
         
        $this->db->select('MAX(offer_price) as max_price, MIN(offer_price) as min_price');
        $this->db->from('tbl_products');
        $query = $this->db->get()->result();
        return $query;
    }
    public function search($key)
    {
        $store_name= $this->session->userdata('store_name');
        $this->db->like('product_name', $key);
        $this->db->or_like('product_brand', $key);
        $this->db->or_like('product_category', $key);
        $this->db->from('tbl_products');
        $query=$this->db->get()->result();
        return $query;

    }
     public function searchWithoutBrand($key)
    {
        $store_name= $this->session->userdata('store_name');
        $this->db->like('product_name', $key);
   
        $this->db->or_like('product_category', $key);
        $this->db->from('tbl_products');
        $query=$this->db->get()->result();
        return $query;

    }
     public function searchWithoutCat($key)
     {
          $this->db->like('product_name', $key);
        $this->db->or_like('product_brand', $key);
        $this->db->from('tbl_products');
        $query=$this->db->get()->result();
        return $query;
     }

//    public   function fetch_data($query)
// {
//  $this->db->like('product_name', $query);
//  $query = $this->db->get('tbl_products');
//  if($query->num_rows() > 0)
//  {
//   foreach($query->result_array() as $row)
//   {
//    $output[] = array(
//     'product_name'  => $row["product_name"],
//     'product_img' =>$row["product_img"]

//    );
//   }
//   echo json_encode($output);
//  }
// }
    function fetch_filter_type($type)
    {
         
        $store_id= $this->session->userdata('store_id');
        $store_name= $this->session->userdata('store_name');
        $this->db->distinct();
        $this->db->select($type);
        $this->db->from('tbl_products');
        //$this->db->where('product_shopId', $store_id);
        $this->db->order_by('product_id', 'DESC');
        return $this->db->get();
    }

    function make_query($minimum_price, $maximum_price, $brand, $ram)
    {
        $store_name= $this->session->userdata('store_name');
        $ids=$this->session->userdata('store_id');
        $query = '
        SELECT * FROM  tbl_products 
        WHERE  product_status = 0
        ';

        if(isset($minimum_price, $maximum_price) && !empty($minimum_price) && !empty($maximum_price))
        {
            $query .= '
            AND offer_price BETWEEN '.$_POST["minimum_price"].' AND '.$_POST["maximum_price"].'
            ';
        }

        if(isset($brand))
        {
            $brand_filter = implode("','", $brand);
            $query .= "
            AND product_brand IN('".$brand_filter."')
            ";
        }
        if(isset($ram))
        {
            $ram_filter = implode("','", $ram);
            $query .= "
            AND product_category IN('".$ram_filter."')
            ";
        }

        return $query;
    }

    function fetch_data($limit, $start, $minimum_price, $maximum_price, $brand, $ram)
    {
        $query = $this->make_query($minimum_price, $maximum_price, $brand, $ram);

        $query .= ' LIMIT '.$start.', ' . $limit;

        $data = $this->db->query($query);

        $output = '';

        if($data->num_rows() > 0)
        {


            foreach($data->result_array() as $row)
            {
                // if($row["free_product"]!=0) {
                // $this->db->select('*');
                // $this->db->from('tbl_products');
                // $this->db->where('product_id',$row['free_product']);
                // $free_item=$this->db->get()->row();
                // }
             
               
                $output .= '
                <div class="col-sm-12">
                <div class="card" style="margin-top:15px">
                <div class="card-body">
                <div class="row">
                <div class="col-md-2">
                 <img style="width:100%" src="'. $row['product_img'] .'" alt="" class="productImage" >
                </div>
                <div class="col-md-3">
             
                <p align="center" style="margin-bottom:5px"  ><strong style="color:#555555">'. $row['product_name'] .'</strong></p>
                 <p align="center"  class="text-muted" style="font-size:12px">'.  substr($row['product_description'], 0, 40).'</p>
      
                </div>

                <div class="col-md-2">
                 <p align="center" > Brand : '. $row['product_brand'] .' </p>
                </div>

                <div class="col-md-2">
                <p align="center"  >&#8377;'. $row['offer_price'] .' <del style="color:#6e6c6c;"> '.$row['product_price'] .'</del></p>
                </div>
                 <div class="col-md-2" style="align-items:center;margin-top:10px">
                 <a  class="btn btn-success btn-sm" href="'. base_url('welcome/add/'.$row['product_id'].'/'.$row['product_name'].'/'. $row['offer_price']).'">Add to cart</a>
                 </div>
                </div>
                
                </div>
             
                </div>
                </div>
                <br>
                </div>
                ';
                
            }
        }
        else
        {
            $output = '<h3>No Data Found</h3>';
        }
        return $output;
    }

    function count_all($minimum_price, $maximum_price, $brand, $ram)
    {
        $query = $this->make_query($minimum_price, $maximum_price, $brand, $ram);
        $data = $this->db->query($query);
        return $data->num_rows();
    }
    public function update_address_by_id($email,$password)
    {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $query=$this->db->get()->row();
        return $query;
    }
    public function update_address_of_user($id)
    {
            $url = explode('.',$_SERVER['SERVER_NAME']);
         $ids=$url[0];
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('id',$id);
        $query=$this->db->get()->row();
        return $query;
    }
   
    function menus() {
    $store_id= $this->session->userdata('store_id');
    $store_name= $this->session->userdata('store_name');
    $this->db->select("*");
    $this->db->from("category as p");
    
    $this->db->join('tbl_products as tp','tp.product_category_id=p.categoryId');
    $this->db->group_by("p.categoryId");
    $q = $this->db->get();

    $final = array();
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $row) {

            $this->db->select("*");
            $this->db->from("tbl_products");
            $this->db->where("product_category_id", $row->categoryId);
            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                $row->children = $q->result();
            }
            array_push($final, $row);
        }
    }
    return $final;
}
 public function insertOrderItems($data = array()) 
    {
        // Insert order items
        $insert = $this->db->insert_batch('order_items', $data);

        // Return the status
        return $insert?true:false;
    }
    public function insertFreeItems($data = array())
    {
       // Insert order items
        $insert = $this->db->insert_batch('order_items', $data);

        // Return the status
        return $insert?true:false; 
    }
    public function get_order_details($order_code)
    {
       $store_name= $this->session->userdata('store_name');
       $this->db->select('*');
        $this->db->from('order_items as o');
        $this->db->join('tbl_products as tb','tb.product_id=o.product_id');
        //$this->db->join($store_name.'_customers as c','c.id=o.customer_id');
        $this->db->where('o.order_code',$order_code);
        $query=$this->db->get()->result();
        return $query; 
    }
    public function getOrderTotal($user_id)
    {
       $this->db->select('*');
        $this->db->from(' customer_address');
        $this->db->where('user_id',$user_id);
        $query=$this->db->get()->result();
        return $query; 
    }
     public function getPaymentDetails($order_code)
    {
       $this->db->select('*');
        $this->db->from('cust_payment_details');
        $this->db->where('order_code',$order_code);
        $query=$this->db->get()->row();
        return $query; 
    }
     public function getCusDetails($order_code)
    {
        
        $this->db->select('*');
        $this->db->from( 'order_items');
        // $this->db->join('order_items as o','o.customer_id=c.id');
        $this->db->where('order_code',$order_code);
        $query=$this->db->get()->row();
        return $query; 
    }
    public function get_payment_methods()
{
    $url = explode('.',$_SERVER['SERVER_NAME']);
         $id=$url[0];
    $this->db->select('*');
     $this->db->from("shop_payment_info as spi");
      
       $this->db->join(' payment_integration as pi',"pi.payment_name=spi.pInfo_provider","left");
       $this->db->join(' payment_provider as pp',"pp.payment_p_name=pi.provider_type","left");
     $this->db->join('tbl_user as tb','tb.id=spi.pInfo_userId','left');
     $this->db->where('tb.domainname',$id);
     $query=$this->db->get()->result();
        return $query;
}
 public function get_single_payment_method()
{
     $url = explode('.',$_SERVER['SERVER_NAME']);
     $id=$url[0];
     $this->db->select("*");
     $this->db->from("shop_payment_info as pi");
     $this->db->join(' payment_provider as pp',"pp.payment_p_name=pi.pInfo_provider");
     $this->db->join(' payment_integration as pn',"pn.payment_name=pi.pInfo_provider");
     $this->db->join('tbl_user as tb','tb.id=pi.pInfo_userId');
     $this->db->where('tb.domainname',$id);
     $query=$this->db->get()->num_rows();
     return $query;
}

public function get_ordercode($order_id)
{
        $this->db->select('*');
        $this->db->from('order_items');
        $this->db->where('id',$order_id);
        $query=$this->db->get()->row();
        return $query; 
}

// public function getFreeItems($id)
// {
//         $this->db->select('*');
//         $this->db->from('cart_details');
//         $this->db->where('user_id',$id);
//         $query=$this->db->get()->result();
//         return $query;
// }
public function getLogo($domain)
{
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('domainname',$domain);
        $query=$this->db->get()->row();
        return $query;
}
public function getOrderItems($user_id)
{
        $this->db->select('*');
        $this->db->from('order_items as oi');
        $this->db->join('cust_payment_details as cp','oi.order_code=cp.order_code');
        $this->db->where('oi.customer_id',$user_id);
        $this->db->group_by('oi.order_code');
        $query=$this->db->get()->result();
        return $query; 
}
public function getOrderDetails($order_id)
{
    $this->db->select('*');
    $this->db->from('order_items');
    $this->db->where('order_code',$order_id);
    $query=$this->db->get()->result();
        return $query; 
}
}
?>