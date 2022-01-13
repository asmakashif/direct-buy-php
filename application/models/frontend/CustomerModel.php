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
        $this->db->from(' temp_str_config as p');
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
         $domain='asma';
        // print_r($domain);
        // die();
         $this->db->select('*');
         $this->db->from('shop_details as sd');
         $this->db->join('tbl_user as tb','tb.id=sd.user_id','left');
        $this->db->where('tb.domainname',$domain);
    $this->db->where('sd.remove_shop',0);
         $this->db->where('sd.shop_payment_status',1);
         $this->db->where('sd.shop_status',1);
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
        $this->db->from(' temp_str_config');
        $query = $this->db->get()->result();
        return $query;
    }
    public function search($key)
    {
        $store_name= $this->session->userdata('store_name');
         $ids=$this->session->userdata('store_id');
        $this->db->select('*');
        $this->db->from('shop_details');
        $this->db->where('shopId',$ids);
        $shop=$this->db->get()->row();
        if($shop->hide_0productQty==0)
        {
        $this->db->where('product_status','1');
        $this->db->like('product_name', $key);
        $this->db->or_like('brand', $key);
        $this->db->or_like('category', $key);
        $this->db->from(' temp_str_config');
        $query=$this->db->get()->result();
        return $query;
        }
        else
        {
        $this->db->where('product_status','1');
        $this->db->where('product_qty!=','0');
        $this->db->like('product_name', $key);
        $this->db->or_like('brand', $key);
        $this->db->or_like('category', $key);
        $this->db->from(' temp_str_config');
        $query=$this->db->get()->result();
        return $query;
        }

    }
     public function searchWithoutBrand($key)
    {
        $ids=$this->session->userdata('store_id');
        $this->db->select('*');
        $this->db->from('shop_details');
        $this->db->where('shopId',$ids);
        $shop=$this->db->get()->row();
        if($shop->hide_0productQty==0)
        {
        $this->db->where('product_status','1');
        $this->db->like('product_name', $key);
        $this->db->or_like('category', $key);
        $this->db->from('temp_str_config');
        $query=$this->db->get()->result();
        return $query;
        }else
        {
        $this->db->where('product_status','1');
        $this->db->where('product_qty!=','0');
        $this->db->like('product_name', $key);
        $this->db->or_like('category', $key);
        $this->db->from('temp_str_config');
        $query=$this->db->get()->result();
        return $query;
            
        }

    }
     public function searchWithoutCat($key)
     {
        $ids=$this->session->userdata('store_id');
        $this->db->select('*');
        $this->db->from('shop_details');
        $this->db->where('shopId',$ids);
        $shop=$this->db->get()->row();
        if($shop->hide_0productQty==0)
        {
        $this->db->where('product_status','1');
        $this->db->like('product_name', $key);
        $this->db->or_like('brand', $key);
        $this->db->from(' temp_str_config');
        $query=$this->db->get()->result();
        return $query;
        }
        else
        {
        $this->db->where('product_status','1');
        $this->db->where('product_qty!=','0');
        $this->db->like('product_name', $key);
        $this->db->or_like('brand', $key);
        $this->db->from(' temp_str_config');
        $query=$this->db->get()->result();
        return $query; 
        }
     }

//     public   function fetch_data($query)
// {
//  $this->db->like('product_name', $query);
//  $query = $this->db->get(' temp_str_config');
//  if($query->num_rows() > 0)
//  {
//   foreach($query->result_array() as $row)
//   {
//     $output[] = array(
//     'product_name'  => $row["product_name"],
//     'product_img' =>$row["product_img"]

//     );
//   }
//   echo json_encode($output);
//  }
// }
    function fetch_filter_type($type)
    {
         $this->db->distinct();
        $this->db->select($type);
        $this->db->from(' temp_str_config');
        $this->db->order_by('temp_str_config_id', 'DESC');
        return $this->db->get();
    }

    function make_query($minimum_price, $maximum_price, $brand, $ram)
    {
        $store_name= $this->session->userdata('store_name');
        $ids=$this->session->userdata('store_id');
        $this->db->select('*');
        $this->db->from('shop_details');
        $this->db->where('shopId',$ids);
        $shop=$this->db->get()->row();
        if($shop->hide_0productQty==0)
        {
         
        $query = '
        SELECT * FROM   temp_str_config 
        WHERE   product_status=1 
        ';
        }
        else
        {
            $query = '
        SELECT * FROM   temp_str_config 
        WHERE   product_status=1 AND product_qty!=0 
        ';
        }

        if(isset($minimum_price, $maximum_price) && !empty($minimum_price) && !empty($maximum_price))
        {
            $query .= '
            AND offer_price BETWEEN '.$_POST["minimum_price"].' AND '.$_POST["maximum_price"]. '
            ORDER BY sold_count  DESC';
        }

       else if(isset($brand))
        {
            $brand_filter = implode("','", $brand);
            $query .= "
            AND brand IN('".$brand_filter."')
            ORDER BY sold_count  DESC";
        }
       else if(isset($ram))
        {
            $ram_filter = implode("','", $ram);
            $query .= "
            AND category IN('".$ram_filter."')
            ORDER BY sold_count  DESC";
        }
        else
        {
            $query .= 'ORDER BY sold_count  DESC';
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
                // $this->db->from(' temp_str_config');
                // $this->db->where('temp_str_config_id',$row['free_product']);
                // $free_item=$this->db->get()->row();
                // }
             
               
                $output .= '
                <div class="col-sm-12" style="margin-top:5px">
                <div class="card" >
                <div class="card-body">
                <div class="row">
                <div class="col-md-2">
                 <img id="prd_img" src="'. $row['product_img'] .'" alt="" class="productImage" >
                </div>
                <div class="col-md-3">
             
                <p align="center" style="margin-bottom:5px"  ><strong style="color:#555555;font-size:13px">'. $row['product_name'] .'</strong></p>
                 <p align="center"  class="text-muted" style="font-size:12px;margin:0px">'.  substr($row['product_description'], 0, 40).'</p>
      
                </div>

                <div class="col-md-2">
                 <p align="center" class="text-muted" style="font-size:13px"> Brand : '. $row['brand'] .' </p>
                </div>

                <div class="col-md-2">
                <p align="center"  >&#8377;'. $row['offer_price'] .' <del style="color:#6e6c6c;"> '.$row['product_price'] .'</del></p>
                </div>
                 <div class="col-md-2" style="align-items:center;margin-top:7px">
                 <a  class="btn btn-success btn-sm" style="font-size:13px" href="'. base_url('welcome/add/'.$row['temp_str_config_id'].'/'. $row['offer_price']).'">Add to cart</a>
                 </div>
                </div>
                
                </div>
             
                </div>
                </div>
                
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
    
    $this->db->join(' temp_str_config as tp','tp.category_id=p.categoryId');
    $this->db->group_by("p.categoryId");
    $q = $this->db->get();

    $final = array();
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $row) {

            $this->db->select("*");
            $this->db->from(" temp_str_config");
            $this->db->where("category_id", $row->categoryId);
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
        $this->db->join(' temp_str_config as tb','tb.temp_str_config_id=o.product_id');
        //$this->db->join($store_name.'_customers as c','c.id=o.customer_id');
        $this->db->where('o.order_code',$order_code);
        $query=$this->db->get()->result();
        return $query; 
    }
    public function getOrderTotal($order_code)
    {
       $this->db->select('*');
        $this->db->from('order_items ');
        $this->db->where('order_code',$order_code);
        $query=$this->db->get()->row();
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
    $this->db->from("payment_integration as pi");
    $this->db->join('shop_payment_info as spi',"pi.payment_name=spi.pInfo_payment_name");
    $this->db->join('payment_provider as pp',"pp.payment_p_name=pi.provider_type");
    $this->db->join('tbl_user as tb','tb.id=pi.user_id');
    $this->db->where('tb.domainname',$id);
    $this->db->group_by('pi.provider_type');
    $query=$this->db->get()->result();
    return $query;
  }
//   public function get_payment_methods()
//     {
//         $shopId=$this->session->userdata('store_id');
//         $user_id=$this->session->userdata('id');
//         $this->db->select('*');
//         $this->db->from('shop_payment_info as spi');
//         $this->db->where('spi.pInfo_shopId',$shopId);
//         $res=$this->db->get()->row();
//         if(empty($res->pInfo_shopId))
//         {
//             $this->db->select('*');
//             $this->db->from('payment_integration as pi');
            
//             $this->db->join('tbl_user as tu','tu.id=pi.user_id','left');
//             $this->db->where('pi.user_id',3);
//             return $this->db->get()->result();
//         }
//         else
//         {
//             $query = $this->db->query("SELECT * from ((SELECT pi.payment_id,pi.user_id,pi.payment_name,pi.provider_type,spi.pInfo_payment_name,spi.pInfo_shopId FROM payment_integration as pi LEFT JOIN shop_payment_info as spi ON spi.pInfo_payment_name=pi.payment_name WHERE pi.user_id = '$user_id' AND spi.pInfo_shopId = '$shopId') UNION (SELECT pi.payment_id,pi.user_id,pi.payment_name,pi.provider_type,pi.payment_api_key,pi.payment_secret_key FROM payment_integration as pi WHERE pi.user_id='3')) as payment group by payment.payment_name");
//             return $query->result();
//         }
//     }
 public function get_single_payment_method()
{
     $url = explode('.',$_SERVER['SERVER_NAME']);
     $id=$url[0];
     $this->db->select("*");
  $this->db->from("shop_payment_info as spi");
      
       $this->db->join('payment_integration as pi',"pi.payment_name=spi.pInfo_provider");
       $this->db->join('payment_provider as pp',"pp.payment_p_name=pi.provider_type");
     $this->db->join('tbl_user as tb','tb.id=spi.pInfo_userId');
    
     $this->db->where('tb.domainname',$id);
     $query=$this->db->get()->num_rows();
     return $query;
}

public function get_ordercode($order_id)
{
        $this->db->select('*');
        $this->db->from('order_items');
        $this->db->where('order_code',$order_id);
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
    $this->db->from('order_items as oi');
    $this->db->join('temp_str_config as tm','tm.temp_str_config_id=oi.product_id','left');
    $this->db->where('oi.order_code',$order_id);
    $query=$this->db->get()->result();
        return $query; 
}
public function getAllOrderDetails($order_id)
{
      $this->db->select('*');
    $this->db->from('order_items as oi');
    $this->db->where('oi.order_code',$order_id);
    $query=$this->db->get()->row();
        return $query; 
}
public function check_store_type($store_id)
{
         $this->db->select('*');
        $this->db->from('shop_details as sd');
        $this->db->join('tbl_user as tb','sd.user_id=tb.id');

         $this->db->where('sd.shopId',$store_id);
        $query= $this->db->get()->row();
        return $query; 
}
public function noofcategories()
{
    $this->db->select('*');
    $this->db->from('temp_str_config');
    $this->db->group_by('category');
    $query=$this->db->get()->num_rows();
    return $query;
}
public function noofbrand()
{
    $this->db->select('*');
    $this->db->from('temp_str_config');
    $this->db->group_by('brand');
    $query=$this->db->get()->num_rows();
    return $query;
}
public function getCustomerAdress($user_id)
{
     $this->db->select('*');
    $this->db->from('customer_address');
    $this->db->where('user_id',$user_id);
    $query=$this->db->get()->result();
    return $query;  
}
function Is_already_register($id)
 {
  $this->db->where('login_oauth_uid', $id);
  $query = $this->db->get(' customers');
  if($query->num_rows() > 0)
  {
   return true;
  }
  else
  {
   return false;
  }
 }

 function Update_user_data($data, $id)
 {
  $this->db->where('login_oauth_uid', $id);
  $this->db->update('customers', $data);
 }

 function Insert_user_data($data)
 {
  $this->db->insert('customers', $data);
 }
 public function getUserIdByGmailtoken($token_id)
 {
      $this->db->select('*');
    $this->db->from('customers');
    $this->db->where('login_oauth_uid',$token_id);
    $query=$this->db->get()->row();
    return $query; 
 }
 public function check_homedelivery($store_id)
 {
    $this->db->select('*');
    $this->db->from(' shop_details');
    $this->db->where('shopId',$store_id);
    $query=$this->db->get()->row();
    return $query;
 }
  public function get_store_address($order_code)
 {
    $this->db->select('*');
    $this->db->from('shop_details as sd');
    $this->db->join('order_items as ot','sd.shopId=ot.shopId');
    $this->db->where('ot.order_code',$order_code);
    $query=$this->db->get()->row();
    return $query;
 }
 public function getStoreHomeDelSlots($store_id)
 {
    $this->db->select('*');
    $this->db->from('user_time_slots as u');
    $this->db->join('shop_working_time as s','u.id=s.slot_id');
    $this->db->where('s.shopId',$store_id);
    $this->db->where('u.day',date('l', strtotime(date( 'd-M-y'))));
    
    $query=$this->db->get()->result();
    return $query; 
 }
 public function getCompletedOrders($store_id)
 {
      $this->db->select('*');
    $this->db->from('shop_details');
    $this->db->where('shopId',$store_id);
    $query=$this->db->get()->row();
    return $query;
 }
 public function checkDefaultStoreOfUser($user_id)
 {
     $this->db->select('*');
    $this->db->from('customer_default_store');
    $this->db->where('customer_id',$user_id);
    $query=$this->db->get()->row();
    return $query;
     
 }
 public function getPaytmDetails($store_id)
 {
     $this->db->select('*');
    $this->db->from('payment_integration as p');
     $this->db->join('shop_details as t','t.user_id=p.user_id');
    $this->db->where('t.shopId',$store_id);
    $this->db->where('p.provider_type','Paytm');
    $query=$this->db->get()->row();
    return $query;
 }
 public function getProductQty($id)
 {
     $this->db->select('*');
    $this->db->from('temp_str_config');
    $this->db->where('temp_str_config_id',$id);
    $query=$this->db->get()->row();
    return $query;
 }
}
?>