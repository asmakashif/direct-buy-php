<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller 
{
     function __construct()
     {
          parent::__construct();
          $this->load->model('frontend/CustomerModel','cm');
          $this->load->library('session');
     }
     public function random_code()
     {

          $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
          $pass = array(); 
          $alphaLength = strlen($alphabet) - 1; 
          for ($i = 0; $i < 10; $i++)
          {
               $n = rand(0, $alphaLength);
               $pass[] = $alphabet[$n];
          }
          return implode($pass);
     }
     public function add_address($order_code)
     {

          if($this->input->post('Submit')=='Submit')
          {

               $data=array(
                    'user_id'=>$this->session->userdata('id'),
                    'address1'=>$this->input->post('building_name'),
                    'address2'=>$this->input->post('street_address'),
                    'City'=>$this->input->post('City'),
                    'Pincode'=>$this->input->post('Pincode'));

               $insert=$this->db->insert('customer_address',$data);
               if($insert)
               {
                    $data1=array(
                         'c_address1'=>$this->input->post('building_name'),
                         'c_address2'=>$this->input->post('street_address'),
                         'city'=>$this->input->post('City'),
                         'pincode'=>$this->input->post('Pincode')
                    );
                    $this->db->where('order_code',$order_code);
                    $this->db->update('order_items',$data1);
                    $store_id=$this->session->userdata('store_id');
                    $this->dbConnection($store_id);
                    $this->db->where('order_code',$order_code);
                    $this->db->update('order_items',$data1);
                    $this->session->set_flashdata('flashSuccess', "Submitted successfully");

                    redirect('frontend/Checkout/Checkout/'.$order_code);
               }
               else
               {
                    $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
                    redirect('frontend/Checkout/Checkout/'.$order_code);
               }

          }
     }
     public function upload() 
     {
          $config['upload_path'] = './assets/uploads/prescription';
          $config['allowed_types'] = 'gif|jpg|png';
          $config['max_size'] = 2000;
          $config['max_width'] = 1500;
          $config['max_height'] = 1500;

          $this->load->library('upload', $config);

          if (!$this->upload->do_upload('profile_pic')) 
          {
               $error = array('error' => $this->upload->display_errors());

               $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
               redirect("welcome/upload_page");
          } 
          else 
          {
               $data = array('image_metadata' => $this->upload->data());

               $this->db->select('*');
               $this->db->from('customers');
               $this->db->where('id',$this->session->userdata('id'));
               $customer=$this->db->get()->row();
               $url = explode('.',$_SERVER['SERVER_NAME']);
               $id=$url[0];
               $this->db->select('*');
               $this->db->from('shop_details as sd');
               $this->db->join('tbl_user as tb',"tb.id=sd.user_id");
               $this->db->where('tb.domainname',$id);
               $shopId=$this->db->get()->row();

               $this->db->select('order_code');
               $this->db->from('order_items');
               $select=$this->db->get()->result();

               $this->db->select('order_code');
               $this->db->from('order_items');
               $this->db->order_by('order_code','DESC');
               $this->db->limit(1);
               $query=$this->db->get()->row();
               $alphabets=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];



               if(empty($select))
               {
                    $customid="A000000";
               }
               else
               {
                    $first_letter=$query->order_code[0];
                    $k = array_search($first_letter, $alphabets);
                    $next_letter=$k+1;
                    $next=$alphabets[$next_letter]; 
                    $order_code=$query->order_code;
                    $int_var = (int)filter_var($order_code, FILTER_SANITIZE_NUMBER_INT);



                    if($int_var==999999)
                    {
                         $cc= $int_var+1;

                         $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
                         $first_letter=$query->order_code[0];
                         $k = array_search($first_letter, $alphabets);
                         $next_letter=$k+1;
                         $next=$alphabets[$next_letter];
                         $customid = $next."000000";

                    }
                    else
                    {
                         $cc= $int_var+1;

                         $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
                         $first_letter=$query->order_code[0];
                         $k = array_search($first_letter, $alphabets);
                         $next_letter=$k+1;
                         $next=$alphabets[$next_letter];
                         $cc= $int_var+1;
$coun = str_pad($cc, 6, 0, STR_PAD_LEFT); // Updated line to include '0'
$customid = $first_letter.$coun;
}
}
$saveItems=array('order_code'=>$customid,
     'customer_id'=>$this->session->userdata('id'),
     'product_name'=>"null",
     'product_id'=>"null",
     'product_qty'=>0,
     'product_price'=>0,
     'product_subtotal'=>0,
     'product_img'=>'null',
     'total'=>0,
     'c_fname'=>$customer->firstname,
     'c_lname'=>$customer->lastname,
     'c_mobile'=>$customer->mobile,
     'c_address1'=>$customer->address1,
     'c_address2'=>$customer->address2,
     'city'=>$customer->City,
     'pincode'=>0,
     'discount'=>0,
     'tax'=>0,
     'upload'=>$data['image_metadata']['orig_name'],
     'shop_id'=>$this->session->userdata('store_id'),
     'shopId'=>$shopId->shopId,
     'shop_name'=>$this->session->userdata('store_name'),
     'order_status'=>0,
     'order_placed_date'=>date("Y-m-d H:i:s")
);
$this->db->insert('order_items',$saveItems);
$savePayment=array('order_code'=>$customid,
     'transaction_id'=>0,
     'payment_total'=>0,
     'amt_paid'=>0,
     'Payment_method'=>'null',
     'payment_date'=>date("Y-m-d H:i:s"),
     'payment_status'=>0);
$this->db->insert('cust_payment_details',$savePayment);              
$store_id=$this->session->userdata('store_id');
$this->dbConnection($store_id);
$result=$this->db->insert('order_items',$saveItems);
$this->db->insert('cust_payment_details',$savePayment); 
if($result)
{
     $this->session->set_flashdata('flashSuccess', "Order Placed Successfully");
     redirect("welcome/order_detail/".$customid);
}
}
}
public function store_pickup()
{
     $data['payment']=$this->cm->get_payment_methods();
      $store_id=$this->session->userdata('store_id');
     $store_name=$this->session->userdata('store_name');
      if(!empty($data['payment']))
      {
     $this->db->select('*');
     $this->db->from('customers');
     $this->db->where('id',$this->session->userdata('id'));
     $customer=$this->db->get()->row(); 
     $cartItems = $this->cart->contents();
     $order_code = $this->random_code();
     $ordItemData = array();
     $i=0;
     $this->db->select('order_code');
     $this->db->from('order_items');
     $select=$this->db->get()->result();

     $this->db->select('order_code');
     $this->db->from('order_items');
     $this->db->order_by('order_code','DESC');
     $this->db->limit(1);
     $query=$this->db->get()->row();
     $alphabets=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];



     if(empty($select))
     {
          $customid="A000000";
     }
     else
     {
          $first_letter=$query->order_code[0];
          $k = array_search($first_letter, $alphabets);
          $next_letter=$k+1;
          $next=$alphabets[$next_letter]; 
          $order_code=$query->order_code;
          $int_var = (int)filter_var($order_code, FILTER_SANITIZE_NUMBER_INT);



          if($int_var==999999)
          {
               $cc= $int_var+1;

               $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
               $first_letter=$query->order_code[0];
               $k = array_search($first_letter, $alphabets);
               $next_letter=$k+1;
               $next=$alphabets[$next_letter];
               $customid = $next."000000";

          }
          else
          {
               $cc= $int_var+1;

               $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
               $first_letter=$query->order_code[0];
               $k = array_search($first_letter, $alphabets);
               $next_letter=$k+1;
               $next=$alphabets[$next_letter];
               $cc= $int_var+1;
$coun = str_pad($cc, 6, 0, STR_PAD_LEFT); // Updated line to include '0'
$customid = $first_letter.$coun;
}
}
$url = explode('.',$_SERVER['SERVER_NAME']);
$id=$url[0];
$this->db->select('*');
$this->db->from('shop_details as sd');
$this->db->join('tbl_user as tb',"tb.id=sd.user_id");
$this->db->where('tb.domainname',$id);
$shopId=$this->db->get()->row();

foreach($cartItems as $item){
  
     $ordItemData[$i]['order_code'] = $customid;
     $ordItemData[$i]['customer_id'] =$this->session->userdata('id');
     $ordItemData[$i]['upload']="null";
     $ordItemData[$i]['product_id']  = $item['id'];
     $ordItemData[$i]['product_name']  = $item['name'];
     $ordItemData[$i]['product_img']  = $item['img'];
     $ordItemData[$i]['product_qty']   = $item['qty'];
     $ordItemData[$i]['product_price']  = $item['price'];
     $ordItemData[$i]['product_subtotal']  = $item["subtotal"];
     $ordItemData[$i]['total']     = $this->cart->total();
     $ordItemData[$i]['c_fname']  =  $customer->firstname ;
     $ordItemData[$i]['c_lname']  =  $customer->lastname ;
     $ordItemData[$i]['c_mobile']  = $customer->mobile;
     $ordItemData[$i]['c_address1']  ='null';
     $ordItemData[$i]['c_address2']  = 'null';
     $ordItemData[$i]['city']  = 'null';
     $ordItemData[$i]['pincode']  ='null';
     $ordItemData[$i]['shop_id'] =$this->session->userdata('store_id');
     $ordItemData[$i]['shopId'] = $shopId->shopId;
     $ordItemData[$i]['store_pickup']=1;
      $ordItemData[$i]['slot']  = 'null';
     $ordItemData[$i]['shop_name']  =$this->session->userdata('store_name');
     $ordItemData[$i]['discount']  = 0;
     $ordItemData[$i]['tax']  = 0;
     $ordItemData[$i]['order_status']  =0;
     $ordItemData[$i]['order_placed_date']=date('Y-m-d H:i:s');

     if(!empty($ordItemData)){
          $main_db=$this->cm->insertOrderItems($ordItemData);

     
     }
}

   
   $this->db->select('*');
$this->db->from('order_items');
$this->db->where('order_code',$customid);
$this->db->group_by('product_id');
$res=$this->db->get()->result();

foreach($res as $item){
     $ordItemData[$i]['order_code'] = $item->order_code;
     $ordItemData[$i]['customer_id'] =$this->session->userdata('id');
     $ordItemData[$i]['upload']="null";
     $ordItemData[$i]['product_id']  = $item->product_id;
     $ordItemData[$i]['product_name']  = $item->product_name;
     $ordItemData[$i]['product_img']  = $item->product_img;
     $ordItemData[$i]['product_qty']   = $item->product_qty;
     $ordItemData[$i]['product_price']  = $item->product_price;
     $ordItemData[$i]['product_subtotal']  = $item->product_subtotal;
     $ordItemData[$i]['total']     = $this->cart->total();
     $ordItemData[$i]['c_fname']  =  $item->c_fname; 
     $ordItemData[$i]['c_lname']  =  $item->c_lname;
     $ordItemData[$i]['c_mobile']  = $item->c_mobile;
     $ordItemData[$i]['c_address1']  = $item->c_address1;
     $ordItemData[$i]['c_address2']  = $item->c_address2;
     $ordItemData[$i]['city']  = $item->city;
     $ordItemData[$i]['pincode']  =$item->pincode;
     $ordItemData[$i]['shop_id'] =$this->session->userdata('store_id');
     $ordItemData[$i]['shopId'] =$shopId->shopId;
     $ordItemData[$i]['shop_name']  =$this->session->userdata('store_name');
     $ordItemData[$i]['order_placed_date']=date('Y-m-d H:i:s');

$this->dbConnection($store_id);
     $this->cm->insertOrderItems($ordItemData);

}
$this->db->select('*');
$this->db->from('order_items');
$this->db->where('order_code',$customid);
$orders=$this->db->get()->result(); 

     $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$customid);
     $cust_data=$this->db->get()->row();
     
     

 

  
          $this->session->set_flashdata('flashSuccess', "Your order placed successfully");
          redirect('frontend/Checkout/Checkout/'.$customid);
     


}
else
{
    $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
          redirect('welcome/Home/'.$store_id.'/'.$store_name);
}
}
public function place_order()
{



     $store_id=$this->session->userdata('store_id');
     $store_name=$this->session->userdata('store_name');
$data['payment']=$this->cm->get_payment_methods();
     
      if(!empty($data['payment']))
      {
     $this->db->select('*');
     $this->db->from('customers');
     $this->db->where('id',$this->session->userdata('id'));
     $customer=$this->db->get()->row();

     $this->db->select('*');
     $this->db->from('customer_address');
     $this->db->where('user_id',$this->session->userdata('id'));
     $customer_addr=$this->db->get()->num_rows();
     $this->db->select('*');
     $this->db->from('customer_address');
     $this->db->where('user_id',$this->session->userdata('id'));
     $this->db->where('status',1);
     $default_addr=$this->db->get()->row();
     if($customer_addr==1)
     {
          $this->db->select('*');
          $this->db->from('customer_address');
          $this->db->where('user_id',$this->session->userdata('id'));
          $cust_addr=$this->db->get()->row();  
     }
     else if(!empty($default_addr)){
          $this->db->select('*');
          $this->db->from('customer_address');
          $this->db->where('user_id',$this->session->userdata('id'));
          $this->db->where('status',1);
          $default_addr=$this->db->get()->row();
     }

     $url = explode('.',$_SERVER['SERVER_NAME']);
     $id=$url[0];
     $this->db->select('*');
     $this->db->from('shop_details as sd');
     $this->db->join('tbl_user as tb',"tb.id=sd.user_id");
     $this->db->where('tb.domainname',$id);
     $shopId=$this->db->get()->row();
     $cartItems = $this->cart->contents();
     $order_code = $this->random_code();
     $ordItemData = array();
     $i=0;
     $this->db->select('order_code');
     $this->db->from('order_items');
     $select=$this->db->get()->result();

     $this->db->select('order_code');
     $this->db->from('order_items');
     $this->db->order_by('order_code','DESC');
     $this->db->limit(1);
     $query=$this->db->get()->row();
     $alphabets=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];



     if(empty($select))
     {
          $customid="A000000";
     }
     else
     {
          $first_letter=$query->order_code[0];
          $k = array_search($first_letter, $alphabets);
          $next_letter=$k+1;
          $next=$alphabets[$next_letter]; 
          $order_code=$query->order_code;
          $int_var = (int)filter_var($order_code, FILTER_SANITIZE_NUMBER_INT);



          if($int_var==999999)
          {
               $cc= $int_var+1;

               $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
               $first_letter=$query->order_code[0];
               $k = array_search($first_letter, $alphabets);
               $next_letter=$k+1;
               $next=$alphabets[$next_letter];
               $customid = $next."000000";

          }
          else
          {
               $cc= $int_var+1;

               $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
               $first_letter=$query->order_code[0];
               $k = array_search($first_letter, $alphabets);
               $next_letter=$k+1;
               $next=$alphabets[$next_letter];
               $cc= $int_var+1;
$coun = str_pad($cc, 6, 0, STR_PAD_LEFT); // Updated line to include '0'
$customid = $first_letter.$coun;
}
}

if($customer_addr==1)
{
     foreach($cartItems as $item){
          $ordItemData[$i]['order_code'] = $customid;
          $ordItemData[$i]['customer_id'] =$this->session->userdata('id');
          $ordItemData[$i]['upload']="null";
          $ordItemData[$i]['product_id']  = $item['id'];
          $ordItemData[$i]['product_name']  = $item['name'];
          $ordItemData[$i]['product_img']  = $item['img'];
          $ordItemData[$i]['product_qty']   = $item['qty'];
          $ordItemData[$i]['product_price']  = $item['price'];
          $ordItemData[$i]['product_subtotal']  = $item["subtotal"];
          $ordItemData[$i]['total']     = $this->cart->total();
          $ordItemData[$i]['c_fname']  =  $customer->firstname ;
          $ordItemData[$i]['c_lname']  =  $customer->lastname ;
          $ordItemData[$i]['c_mobile']  = $customer->mobile;
          $ordItemData[$i]['c_address1']  = $cust_addr->address1;
          $ordItemData[$i]['c_address2']  = $cust_addr->address2;
          $ordItemData[$i]['city']  = $cust_addr->City;
          $ordItemData[$i]['pincode']  =$cust_addr->pincode;
           $ordItemData[$i]['slot']  = 'null';
          $ordItemData[$i]['shop_id'] =$this->session->userdata('store_id');
          $ordItemData[$i]['shopId'] = $shopId->shopId;
          $ordItemData[$i]['shop_name']  =$this->session->userdata('store_name');
          $ordItemData[$i]['discount']  = 0;
          $ordItemData[$i]['tax']  = 0;
          $ordItemData[$i]['order_status']  =0;
          $ordItemData[$i]['order_placed_date']=date('Y-m-d H:i:s');

          if(!empty($ordItemData)){
// Insert order items


               $main_db=$this->cm->insertOrderItems($ordItemData);

          }

     }
}
else if(!empty($default_addr)){
     foreach($cartItems as $item){
          $ordItemData[$i]['order_code'] = $customid;
          $ordItemData[$i]['customer_id'] =$this->session->userdata('id');
          $ordItemData[$i]['upload']="null";
          $ordItemData[$i]['product_id']  = $item['id'];
          $ordItemData[$i]['product_name']  = $item['name'];
          $ordItemData[$i]['product_img']  = $item['img'];
          $ordItemData[$i]['product_qty']   = $item['qty'];
          $ordItemData[$i]['product_price']  = $item['price'];
          $ordItemData[$i]['product_subtotal']  = $item["subtotal"];
          $ordItemData[$i]['total']     = $this->cart->total();
          $ordItemData[$i]['c_fname']  =  $customer->firstname ;
          $ordItemData[$i]['c_lname']  =  $customer->lastname ;
          $ordItemData[$i]['c_mobile']  = $customer->mobile;
          $ordItemData[$i]['c_address1']  = $default_addr->address1;
          $ordItemData[$i]['c_address2']  = $default_addr->address2;
          $ordItemData[$i]['city']  = $default_addr->City;
          $ordItemData[$i]['pincode']  =$default_addr->pincode;
           $ordItemData[$i]['slot']  = 'null';
          $ordItemData[$i]['shop_id'] =$this->session->userdata('store_id');
          $ordItemData[$i]['shopId'] = $shopId->shopId;
          $ordItemData[$i]['shop_name']  =$this->session->userdata('store_name');
          $ordItemData[$i]['discount']  = 0;
          $ordItemData[$i]['tax']  = 0;
          $ordItemData[$i]['order_status']  =0;
          $ordItemData[$i]['order_placed_date']=date('Y-m-d H:i:s');

          if(!empty($ordItemData)){
// Insert order items


               $main_db=$this->cm->insertOrderItems($ordItemData);

          }

     }
}
else
{
     foreach($cartItems as $item){
          $ordItemData[$i]['order_code'] = $customid;
          $ordItemData[$i]['customer_id'] =$this->session->userdata('id');
          $ordItemData[$i]['upload']="null";
          $ordItemData[$i]['product_id']  = $item['id'];
          $ordItemData[$i]['product_name']  = $item['name'];
          $ordItemData[$i]['product_img']  = $item['img'];
          $ordItemData[$i]['product_qty']   = $item['qty'];
          $ordItemData[$i]['product_price']  = $item['price'];
          $ordItemData[$i]['product_subtotal']  = $item["subtotal"];
          $ordItemData[$i]['total']     = $this->cart->total();
          $ordItemData[$i]['c_fname']  =  $customer->firstname ;
          $ordItemData[$i]['c_lname']  =  $customer->lastname ;
          $ordItemData[$i]['c_mobile']  = $customer->mobile;
          $ordItemData[$i]['c_address1']  = 'null';
          $ordItemData[$i]['c_address2']  = 'null';
          $ordItemData[$i]['city']  = 'null';
          $ordItemData[$i]['pincode']  ='null';
           $ordItemData[$i]['slot']  = 'null';
          $ordItemData[$i]['shop_id'] =$this->session->userdata('store_id');
          $ordItemData[$i]['shopId'] = $shopId->shopId;
          $ordItemData[$i]['shop_name']  =$this->session->userdata('store_name');
          $ordItemData[$i]['discount']  = 0;
          $ordItemData[$i]['tax']  = 0;
          $ordItemData[$i]['order_status']  =0;
          $ordItemData[$i]['order_placed_date']=date('Y-m-d H:i:s');

          if(!empty($ordItemData)){
// Insert order items


               $main_db=$this->cm->insertOrderItems($ordItemData);
//  if($main_db){
//      $this->freeData($main_db);
//  }
          }

     }
} 

//   $freedata = array();
//      $i=0;
//  foreach($_POST as $val)
//  {
//      $freedata[$i]['order_code']=$order_code;
//  $freedata[$i]['customer_id'] =$this->session->userdata('id');
//  $freedata[$i]['product_id']=$this->input->post('pid');
//  $freedata[$i]['product_name']=$this->input->post('pname');
//  $freedata[$i]['product_qty']=1;
//  $freedata[$i]['product_price']=0;
//  $freedata[$i]['product_subtotal']=0;
//  $freedata[$i]['total']=$this->cart->total();
//  $freedata[$i]['c_fname']=$customer->firstname;
//  $freedata[$i]['c_lname']=$customer->lastname;
//  $freedata[$i]['c_mobile']=$customer->mobile;
//  $freedata[$i]['c_address1']=$customer->address1;
//  $freedata[$i]['c_address2']=$customer->address2;
//  $freedata[$i]['city']=$customer->City;
//  $freedata[$i]['pincode']=$customer->Pincode;
//  $freedata[$i]['shop_name']=$this->session->userdata('store_name');
//  $freedata[$i]['discount']=0;
//  $freedata[$i]['tax']=0;
//  $freedata[$i]['order_status']=0;


//   $this->cm->insertFreeItems($freedata);
//  }

$this->db->select('*');
$this->db->from('order_items');
$this->db->where('order_code',$customid);
$this->db->group_by('product_id');
$res=$this->db->get()->result();
$this->dbConnection($store_id);
foreach($res as $item){
     $ordItemData[$i]['order_code'] = $item->order_code;
     $ordItemData[$i]['customer_id'] =$this->session->userdata('id');
     $ordItemData[$i]['upload']="null";
     $ordItemData[$i]['product_id']  = $item->product_id;
     $ordItemData[$i]['product_name']  = $item->product_name;
     $ordItemData[$i]['product_img']  = $item->product_img;
     $ordItemData[$i]['product_qty']   = $item->product_qty;
     $ordItemData[$i]['product_price']  = $item->product_price;
     $ordItemData[$i]['product_subtotal']  = $item->product_subtotal;
     $ordItemData[$i]['total']     = $this->cart->total();
     $ordItemData[$i]['c_fname']  =  $item->c_fname; 
     $ordItemData[$i]['c_lname']  =  $item->c_lname;
     $ordItemData[$i]['c_mobile']  = $item->c_mobile;
     $ordItemData[$i]['c_address1']  = $item->c_address1;
     $ordItemData[$i]['c_address2']  = $item->c_address2;
     $ordItemData[$i]['city']  = $item->city;
     $ordItemData[$i]['pincode']  =$item->pincode;
      $ordItemData[$i]['slot']  = 'null';
     $ordItemData[$i]['shop_id'] =$this->session->userdata('store_id');
     $ordItemData[$i]['shopId'] =$shopId->shopId;
     $ordItemData[$i]['shop_name']  =$this->session->userdata('store_name');
     $ordItemData[$i]['order_placed_date']=date('Y-m-d H:i:s');

     $this->cm->insertOrderItems($ordItemData);

}


$this->db->select('*');
$this->db->from('order_items');
$this->db->where('order_code',$customid);
$orders=$this->db->get()->result();

$this->db->select('*');
$this->db->from('order_items');
$this->db->where('order_code',$customid);
$cust_data=$this->db->get()->row();


     $this->session->set_flashdata('flashSuccess', "Your order placed successfully");
   redirect('frontend/Checkout/Checkout/'.$customid);
}
else
{
    $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
          redirect('welcome/Home/'.$store_id.'/'.$store_name);
}
}


public function Checkout($order_code)
{
    $data['store_data']=$this->cm->get_store_address($order_code);
     $store_name1=$this->session->set_userdata('store_name',$data['store_data']->shop_name);
     $store_id1=$this->session->set_userdata('store_id',$data['store_data']->shopId);
     $this->session->set_userdata('id',$data['store_data']->customer_id);
      $this->session->set_userdata('is_logged_in',  'TRUE');
          $store_name=$this->session->userdata('store_name');
     $store_id=$this->session->userdata('store_id');
      $data['payment']=$this->cm->get_payment_methods();
      $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
       $data['shop']=$this->cm->check_homedelivery($store_id);
 
      if(!empty($data['payment']))
      {
     $data['user_address']=$this->cm->getCustomerAdress($this->session->userdata('id'));
     $this->db->select('*');
     $this->db->from('customer_address');
     $this->db->where('user_id',$this->session->userdata('id'));
     $customer_addr=$this->db->get()->num_rows();
     $this->db->select('*');
     $this->db->from('customer_address');
     $this->db->where('user_id',$this->session->userdata('id'));
     $this->db->where('status',1);
     $default_addr=$this->db->get()->row();
     $data['customer_addr']=$customer_addr;
     $data['default_addr']=$default_addr;
     $data['slots']=$this->cm->getStoreHomeDelSlots($store_id);
    //  print_r($data['slots']);
    //  die();
     $data['store_data']=$this->cm->get_store_address($order_code);
     $data['default_method']=$this->cm->get_single_payment_method();
     $data['totals']=$this->cm->getOrderTotal($order_code);
     $this->dbConnection($store_id);
     $url = explode('.',$_SERVER['SERVER_NAME']);
     $id=$url[0];
     if(!$this->session->userdata('is_logged_in'))
     {
          redirect('welcome');
     }
     $this->db->select('*');
     $this->db->from('payment_integration as pi');
     $this->db->join('shop_payment_info as sh',"sh.pInfo_userId=pi.user_id");
     $this->db->join('tbl_user as tb',"tb.id=pi.user_id");
     $this->db->where('tb.domainname',$id);
     $this->db->where('pi.provider_type','Razorpay');
     $key=$this->db->get()->row();
     $data['key']=$key;
     $data['store_data']=$this->cm->get_store_address($order_code);
     $data['cus_data']=$this->cm->getCusDetails($order_code);
     $store_id=$this->session->userdata('store_id');
     $data['return_url'] = base_url().'payment_integrations/razorpay/callback';
     $data['surl'] = base_url().'Razorpay/Success/'.$order_code;
     $data['furl'] = base_url().'Razorpay/Failed';
     $data['currency_code'] = 'INR';
     $data['order_data']=$this->cm->get_order_details($order_code);
     
    //  print_r($data['totals']);
    //  die();
     $data['main_content']='frontend/checkout';
     $this->load->view('frontend/include/template', $data);
      }
      else
      {
          $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
          redirect('welcome/Home/'.$store_id.'/'.$store_name);
      }
}
public function update_slots($order_code)
{
     $data=array('slot'=>$this->input->post('selValue'));
    $this->db->where('order_code',$order_code);
   $result=$this->db->update('order_items',$data);
   if($result)
   {
       $store_id=$this->session->userdata('store_id');
       $this->dbConnection($store_id);
       $this->db->where('order_code',$order_code);
       $result1=$this->db->update('order_items',$data);
        if($result1)
     {
          $this->session->set_flashdata('flashSuccess', "You have selected Home Delivery");
          $this->cart->destroy();  
          redirect('welcome/order_details/'.$order_code);
     }
     else
     {
          $this->session->set_flashdata('flashError', 'Try again!!');
          redirect('welcome/order_details/'.$order_code);
     }
   }
}
public function updateSeletedAdrr($order_code)
{
     $address_id=$this->input->post('address');
     $this->db->select('*');
     $this->db->from('customer_address');
     $this->db->where('id', $address_id);
     $addr=$this->db->get()->row();
     $data=array('c_address1'=>$addr->address1,
          'c_address2'=>$addr->address2,
          'c_address1'=>$addr->address1,
          'city'=>$addr->City,
          'pincode'=>$addr->pincode
     );
     $this->db->where('order_code',$order_code);
     $this->db->update('order_items',$data);
     $store_id=$this->session->userdata('store_id');
     $this->dbConnection($store_id);
     $result=$this->db->update('order_items',$data);
     if($result)
     {

          $this->session->set_flashdata('flashSuccess', "Submitted successfully");

          redirect('frontend/Checkout/Checkout/'.$order_code);
     }
     else
     {
          $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
          redirect('frontend/Checkout/Checkout/'.$order_code);
     }

}
public function Success($order_code) {

     $data['cus_data']=$this->cm->getCusDetails($order_code);
     $this->session->set_userdata('id',$data['cus_data']->customer_id);
     $this->session->set_userdata('is_logged_in',  'TRUE');
     $this->session->set_userdata('store_name',$data['cus_data']->shop_name);
     $this->session->set_userdata('store_id',$data['cus_data']->shopId);
     $store_name=$this->session->userdata('store_name');
     $store_id=$this->session->userdata('store_id');
     $data['payment_data']=$this->cm->getPaymentDetails($order_code);
     $data['totals']=$this->cm->getOrderTotal($order_code);
     $data['main_content']='frontend/success';
     $this->load->view('frontend/include/template', $data);
}  
public function Failed() {

     $data['main_content']='frontend/fail';
     $this->load->view('frontend/include/template', $data);
} 

public function CashOnDelivery($order_code)
{

     $store_id=$this->session->userdata('store_id');
     $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
  
       $this->db->select('*');
                    $this->db->from('customers');
                    $this->db->where('id',$this->session->userdata('id'));
                    $customer=$this->db->get()->row();
     
          $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$order_code);
     $orders=$this->db->get()->result();

     $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$order_code);
     $cust_data=$this->db->get()->row();
     $data=array('order_code'=>$order_code,
          'amt_paid'=>0,
          'transaction_id'=>0,
          'payment_total'=>$this->input->post('total'),
          'payment_date'=>date("Y-m-d H:i:s"),
          'Payment_method'=>'Cash On Delivery',
          "payment_status"=>0);
     $this->db->insert("cust_payment_details",$data);
     
      $this->db->select('*');
     $this->db->from('tbl_user as tb');
     $this->db->join('shop_details as sd','tb.id=sd.user_id');
     $this->db->where('sd.shopId', $store_id);
     $logo=$this->db->get()->row();
    
     $total_order=$logo->total_orders+1;
     $pending_order=$logo->pending_orders+1;
     
      $updatedata=array("pending_orders"=>$pending_order,
    "total_orders"=>$total_order) ;
  
    $this->db->where('shopId',$store_id);
    $this->db->update('shop_details',$updatedata);
    
   
     $this->dbConnection($store_id);
      foreach($orders as $row)
    {
        $qty=$this->cm->getProductQty($row->product_id);
        $newqty=$qty->product_qty-1;
        $sold_count=$qty->sold_count+1;
        $updateqty=array("product_qty"=>$newqty,
        "sold_count"=>$sold_count);
        
        $this->db->where('temp_str_config_id',$row->product_id);
       $this->db->update('temp_str_config',$updateqty);
    }
     $result= $this->db->insert("cust_payment_details",$data);
     
      $this->db->where('shopId',$store_id);
    $this->db->update('shop_details',$updatedata);
     
     if($result)
     {
         $url = explode('.',$_SERVER['SERVER_NAME']);
          $domain=$url[0];
          $data['logo']=$this->cm->getLogo($domain);
          $subject = $cust_data->shop_name."-".$order_code." Order Placed";

          $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
          <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
          <table style="width:70%">
          <td style="width:20%">
          <p>Order Id : '. $order_code.'</p>
          </td>
          <td style="width:20%">
          <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
          </td>
          <td style="width:20%">
          <p>Shop Name : '. $cust_data->shop_name.'</p>
          </td>
          <td style="width:20%">
          <p>Payment Method : Cash On Delivery</p>
          </td>
          </table>
           <table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
     <thead>
     <tr>
     <td valign="top" style="width:35%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Products</td>
     <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Qty</td>
     <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Price</td>
     <td valign="top" style="width:10%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Total</td>
     </tr>
     </thead>
     <tbody>';
     foreach($orders as $row){ 
          $message.='<tr>
          <td valign="top" style="width:35%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_name .'</span></td>
          <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_qty.'</span></td>
          <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_price .'</span></td>
          <td valign="top" style="width:10%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_subtotal .'</span></td>
          </tr>';
     } 
     $message.=' <tr>
     <td colspan="3" align="right">Grand Total : </td>
     <td>&nbsp;&#8377;'. $cust_data->total .'</td>
     </tr>
     </tbody>
     </table>';
     if($cust_data->c_address1=='null' && $cust_data->c_address2=='null')
     {
    $message.=' <div class="row">
     <p>Home Delivery Address:'. $cust_data->c_address1 .','. $cust_data->c_address2 .','. $cust_data->city .','. $cust_data->pincode.'</p>

     </div>';
     }
     else
     {
          $message.=' <div class="row">
          <p>Shop Name : '. $data['homeDelivery']->shop_name.' </p>
     <p>Store Pickup Address:'.$data['homeDelivery']->shop_address.'</p>

     </div>';
     }
        
          $config['protocol']   = 'smtp';
          $config['smtp_host']  = "mail.direct-buy.in";
          $config['smtp_port']  = 587;
          $config['smtp_user']  = "info@direct-buy.in";
          $config['smtp_pass']  = "Default!@#123";
          $config['charset']    = 'iso-8859-1';
          $config['newline']    = "\r\n";
          $config['mailtype']   = 'html';
          $config['validation'] = TRUE;


          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('info@direct-buy.in');
          $this->email->to($data['logo']->email);
          $this->email->subject($subject);
          $this->email->message($message);
          if($this->email->send())
          {
                        $subject = $cust_data->shop_name."-".$order_code." Order Placed";

          $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
          <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
          <table style="width:70%">
          <td style="width:20%">
          <p>Order Id : '. $order_code.'</p>
          </td>
          <td style="width:20%">
          <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
          </td>
          <td style="width:20%">
          <p>Shop Name : '. $cust_data->shop_name.'</p>
          </td>
          <td style="width:20%">
          <p>Payment Method : Cash On Delivery</p>
          </td>
          </table>
           <table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
     <thead>
     <tr>
     <td valign="top" style="width:35%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Products</td>
     <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Qty</td>
     <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Price</td>
     <td valign="top" style="width:10%;padding:0 0 11.25pt 12pt;border-style:none none solid none;">Total</td>
     </tr>
     </thead>
     <tbody>';
     foreach($orders as $row){ 
          $message.='<tr>
          <td valign="top" style="width:35%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_name .'</span></td>
          <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_qty.'</span></td>
          <td valign="top" style="width:5%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_price .'</span></td>
          <td valign="top" style="width:10%;padding:0 0 11.25pt 12pt;border-style:none none solid none;border-bottom-width:1pt;border-bottom-color:#E0E0E0;"><span>'. $row->product_subtotal .'</span></td>
          </tr>';
     } 
     $message.=' <tr>
     <td colspan="3" align="right">Grand Total : </td>
     <td>&nbsp;&#8377;'. $cust_data->total .'</td>
     </tr>
     </tbody>
     </table>';
     if($cust_data->c_address1=='null' && $cust_data->c_address2=='null')
     {
    $message.=' <div class="row">
     <p>Home Delivery Address:'. $cust_data->c_address1 .','. $cust_data->c_address2 .','. $cust_data->city .','. $cust_data->pincode.'</p>

     </div>';
     }
     else
     {
          $message.=' <div class="row">
          <p>Shop Name : '. $data['homeDelivery']->shop_name.' </p>
     <p>Store Pickup Address:'.$data['homeDelivery']->shop_address.'</p>

     </div>';
     }
        
          $config['protocol']   = 'smtp';
          $config['smtp_host']  = "mail.direct-buy.in";
          $config['smtp_port']  = 587;
          $config['smtp_user']  = "info@direct-buy.in";
          $config['smtp_pass']  = "Default!@#123";
          $config['charset']    = 'iso-8859-1';
          $config['newline']    = "\r\n";
          $config['mailtype']   = 'html';
          $config['validation'] = TRUE;


          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('info@direct-buy.in');
          $this->email->to($customer->email);
          $this->email->subject($subject);
          $this->email->message($message);
          if($this->email->send())
          {
                $this->session->set_flashdata('flashSuccess', "You have selected Cash on Delivery");
          $this->cart->destroy();  
          redirect('frontend/Checkout/Success/'.$order_code);
          }
          }
        
     }
     else
     {
          $this->session->set_flashdata('flashError', 'Payment Failed');
          redirect('frontend/Checkout/Failed');
     }
}
public function dbConnection($store_id)
{
     $c['hostname'] = "localhost:3306";
     $c['username'] = "direcbuy_directbuy";
     $c['password'] = "Default!@#123";
     $c['database'] = "direcbuy_".$store_id;
     $c['dbdriver'] = "mysqli";
     $c['dbprefix'] = "";
     $c['pconnect'] = TRUE;
     $c['db_debug'] = TRUE;
     $c['cache_on'] = FALSE;
     $c['cachedir'] = "";
     $c['char_set'] = "utf8";
     $c['dbcollat'] = "utf8_general_ci"; 
     $active_record = TRUE;
     $_SESSION['c'] = $c;
     $this->db = $this->load->database($_SESSION['c'], TRUE, TRUE);
}
public function uploadImageStorePick() { 

     if(!empty($_FILES['images']['name'])){ 
          $filesCount = count($_FILES['images']['name']); 
          for($i = 0; $i < $filesCount; $i++){ 
               $_FILES['file']['name']     = $_FILES['images']['name'][$i]; 
               $_FILES['file']['type']     = $_FILES['images']['type'][$i]; 
               $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i]; 
               $_FILES['file']['error']    = $_FILES['images']['error'][$i]; 
               $_FILES['file']['size']     = $_FILES['images']['size'][$i]; 

// File upload configuration 

               $config['upload_path'] = './assets/uploads/prescription'; 
               $config['allowed_types'] = 'jpg|jpeg|png'; 

// Load and initialize upload library 
               $this->load->library('upload', $config); 
               $this->upload->initialize($config); 

// Upload file to server 
               if($this->upload->do_upload('file')){ 
                    $this->db->select('*');
                    $this->db->from('customers');
                    $this->db->where('id',$this->session->userdata('id'));
                    $customer=$this->db->get()->row();
                    $url = explode('.',$_SERVER['SERVER_NAME']);
                    $id=$url[0];
                    $this->db->select('*');
                    $this->db->from('shop_details as sd');
                    $this->db->join('tbl_user as tb',"tb.id=sd.user_id");
                    $this->db->where('tb.domainname',$id);
                    $shopId=$this->db->get()->row();

                    $this->db->select('order_code');
                    $this->db->from('order_items');
                    $select=$this->db->get()->result();

                    $this->db->select('order_code');
                    $this->db->from('order_items');
                    $this->db->order_by('order_code','DESC');
                    $this->db->limit(1);
                    $query=$this->db->get()->row();
                    $alphabets=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];



                    if(empty($select))
                    {
                         $customid="A000000";
                    }
                    else
                    {
                         $first_letter=$query->order_code[0];
                         $k = array_search($first_letter, $alphabets);
                         $next_letter=$k+1;
                         $next=$alphabets[$next_letter]; 
                         $order_code=$query->order_code;
                         $int_var = (int)filter_var($order_code, FILTER_SANITIZE_NUMBER_INT);



                         if($int_var==999999)
                         {
                              $cc= $int_var+1;

                              $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
                              $first_letter=$query->order_code[0];
                              $k = array_search($first_letter, $alphabets);
                              $next_letter=$k+1;
                              $next=$alphabets[$next_letter];
                              $customid = $next."000000";

                         }
                         else
                         {
                              $cc= $int_var+1;

                              $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
                              $first_letter=$query->order_code[0];
                              $k = array_search($first_letter, $alphabets);
                              $next_letter=$k+1;
                              $next=$alphabets[$next_letter];
                              $cc= $int_var+1;
$coun = str_pad($cc, 6, 0, STR_PAD_LEFT); // Updated line to include '0'
$customid = $first_letter.$coun;
}
}

$saveItems=array('order_code'=>$customid,
     'customer_id'=>$this->session->userdata('id'),
     'product_name'=>"null",
     'product_img'=>"null",
     'product_id'=>"null",
     'product_qty'=>0,
     'product_price'=>0,
     'product_subtotal'=>0,
     'total'=>0,
     'c_fname'=>$customer->firstname,
     'c_lname'=>$customer->lastname,
     'c_mobile'=>$customer->mobile,
     'c_address1'=>'null',
     'c_address2'=>'null',
     'city'=>'null',
     'pincode'=>'null',
      'slot' => 'null',
     'discount'=>0,
     'tax'=>0,
     'upload'=> $_FILES['images']['name'][$i],
     'shop_id'=>$this->session->userdata('store_id'),
     'shopId'=>$shopId->shopId,
     'store_pickup'=>1,
     'shop_name'=>$this->session->userdata('store_name'),
     'order_status'=>0,
     'order_placed_date'=>date("Y-m-d H:i:s")


);
$this->db->insert('order_items',$saveItems);
$savePayment=array('order_code'=>$customid,
     'transaction_id'=>0,
     'payment_total'=>0,
     'amt_paid'=>0,
     'Payment_method'=>'Cash On Delivery',
     'payment_date'=>date("Y-m-d H:i:s"),
     'payment_status'=>0);
$this->db->insert('cust_payment_details',$savePayment);              
$store_id=$this->session->userdata('store_id');
$this->dbConnection($store_id);
$result=$this->db->insert('order_items',$saveItems);
$this->db->insert('cust_payment_details',$savePayment);
if($result)
{
     $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$customid);
     $orders=$this->db->get()->result();

     $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$customid);
     $cust_data=$this->db->get()->row();

     $subject = $cust_data->shop_name."-".$customid." Order Placed";

     $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
     <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
     <table style="width:70%">
     <td style="width:30%">
     <p>Order Id : '. $customid.'</p>
     </td>
     <td style="width:30%">
     <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
     </td>
     <td style="width:30%">
     <p>Shop Name : '. $cust_data->shop_name.'</p>
     </td>
     </table>
     <p>We have recieved the uploaded prescription we will reach you back</p>';
     $config['protocol']   = 'smtp';
     $config['smtp_host']  = "mail.direct-buy.in";
     $config['smtp_port']  = 587;
     $config['smtp_user']  = "info@direct-buy.in";
     $config['smtp_pass']  = "Default!@#123";
     $config['charset']    = 'iso-8859-1';
     $config['newline']    = "\r\n";
     $config['mailtype']   = 'html';
     $config['validation'] = TRUE;


     $this->load->library('email', $config);
     $this->email->set_newline("\r\n");
     $this->email->from('info@direct-buy.in');
     $this->email->to($customer->email);
     $this->email->subject($subject);
     $this->email->message($message);
     if($this->email->send())
     {
          $url = explode('.',$_SERVER['SERVER_NAME']);
          $domain=$url[0];
          $data['logo']=$this->cm->getLogo($domain);
          $subject = $cust_data->shop_name."-".$customid." Order Placed";

          $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
          <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
          <table style="width:70%">
          <td style="width:30%">
          <p>Order Id : '. $customid.'</p>
          </td>
          <td style="width:30%">
          <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
          </td>
          <td style="width:30%">
          <p>Shop Name : '. $cust_data->shop_name.'</p>
          </td>
          </table>
          <p>Cutomer has uploaded the presciption</p>';
          $config['protocol']   = 'smtp';
          $config['smtp_host']  = "mail.direct-buy.in";
          $config['smtp_port']  = 587;
          $config['smtp_user']  = "info@direct-buy.in";
          $config['smtp_pass']  = "Default!@#123";
          $config['charset']    = 'iso-8859-1';
          $config['newline']    = "\r\n";
          $config['mailtype']   = 'html';
          $config['validation'] = TRUE;


          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('info@direct-buy.in');
          $this->email->to($data['logo']->email);
          $this->email->subject($subject);
          $this->email->message($message);
          if($this->email->send())
          {
               $this->session->set_flashdata('flashSuccess', "Order Placed Successfully");
               redirect("welcome/order_details/".$customid);
          }
     }
}
}
}
}
}

public function update_home_delivery($order_code)
{
    $data=array('store_pickup'=>0);
    $this->db->where('order_code',$order_code);
   $result=$this->db->update('order_items',$data);
   if($result)
   {
       $store_id=$this->session->userdata('store_id');
       $this->dbConnection($store_id);
       $result1=$this->db->update('order_items',$data);
        if($result1)
     {
          $this->session->set_flashdata('flashSuccess', "You have selected Home Delivery");
          $this->cart->destroy();  
          redirect('frontend/Checkout/checkout/'.$order_code);
     }
     else
     {
          $this->session->set_flashdata('flashError', 'Try again!!');
          redirect('frontend/Checkout/checkout/'.$order_code);
     }
   }
}
public function update_store_pickup($order_code)
{
    $data=array('store_pickup'=>1);
    $this->db->where('order_code',$order_code);
   $result=$this->db->update('order_items',$data);
   if($result)
   {
       $store_id=$this->session->userdata('store_id');
       $this->dbConnection($store_id);
       $result1=$this->db->update('order_items',$data);
        if($result1)
     {
          $this->session->set_flashdata('flashSuccess', "You have selected Home Delivery");
          $this->cart->destroy();  
          redirect('welcome/order_details/'.$order_code);
     }
     else
     {
          $this->session->set_flashdata('flashError', 'Try again!!');
          redirect('welcome/order_details/'.$order_code);
     }
   }
}
public function uploadImage() { 

     if(!empty($_FILES['images']['name'])){ 
          $filesCount = count($_FILES['images']['name']); 
          for($i = 0; $i < $filesCount; $i++){ 
               $_FILES['file']['name']     = $_FILES['images']['name'][$i]; 
               $_FILES['file']['type']     = $_FILES['images']['type'][$i]; 
               $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i]; 
               $_FILES['file']['error']    = $_FILES['images']['error'][$i]; 
               $_FILES['file']['size']     = $_FILES['images']['size'][$i]; 

// File upload configuration 

               $config['upload_path'] = './assets/uploads/prescription'; 
               $config['allowed_types'] = 'jpg|jpeg|png'; 

// Load and initialize upload library 
               $this->load->library('upload', $config); 
               $this->upload->initialize($config); 

// Upload file to server 
               if($this->upload->do_upload('file')){ 
                    $this->db->select('*');
                    $this->db->from('customers');
                    $this->db->where('id',$this->session->userdata('id'));
                    $customer=$this->db->get()->row();
                    $url = explode('.',$_SERVER['SERVER_NAME']);
                    $id=$url[0];
                    $this->db->select('*');
                    $this->db->from('shop_details as sd');
                    $this->db->join('tbl_user as tb',"tb.id=sd.user_id");
                    $this->db->where('tb.domainname',$id);
                    $shopId=$this->db->get()->row();

                    $this->db->select('order_code');
                    $this->db->from('order_items');
                    $select=$this->db->get()->result();

                    $this->db->select('order_code');
                    $this->db->from('order_items');
                    $this->db->order_by('order_code','DESC');
                    $this->db->limit(1);
                    $query=$this->db->get()->row();
                    $this->db->select('*');
                    $this->db->from('customer_address');
                    $this->db->where('user_id',$this->session->userdata('id'));
                    $customer_addr=$this->db->get()->num_rows();

                    $this->db->select('*');
                    $this->db->from('customer_address');
                    $this->db->where('user_id',$this->session->userdata('id'));
                    $this->db->where('status',1);
                    $default_addr=$this->db->get()->row();
                    if($customer_addr==1)
                    {
                         $this->db->select('*');
                         $this->db->from('customer_address');
                         $this->db->where('user_id',$this->session->userdata('id'));
                         $cust_addr=$this->db->get()->row();  
                    }
                    else if(!empty($default_addr)){
                         $this->db->select('*');
                         $this->db->from('customer_address');
                         $this->db->where('user_id',$this->session->userdata('id'));
                         $this->db->where('status',1);
                         $default_addr=$this->db->get()->row();
                    }

                    $alphabets=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];



                    if(empty($select))
                    {
                         $customid="A000000";
                    }
                    else
                    {
                         $first_letter=$query->order_code[0];
                         $k = array_search($first_letter, $alphabets);
                         $next_letter=$k+1;
                         $next=$alphabets[$next_letter]; 
                         $order_code=$query->order_code;
                         $int_var = (int)filter_var($order_code, FILTER_SANITIZE_NUMBER_INT);



                         if($int_var==999999)
                         {
                              $cc= $int_var+1;

                              $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
                              $first_letter=$query->order_code[0];
                              $k = array_search($first_letter, $alphabets);
                              $next_letter=$k+1;
                              $next=$alphabets[$next_letter];
                              $customid = $next."000000";

                         }
                         else
                         {
                              $cc= $int_var+1;

                              $coun = str_pad($cc, 6, 0, STR_PAD_LEFT);
                              $first_letter=$query->order_code[0];
                              $k = array_search($first_letter, $alphabets);
                              $next_letter=$k+1;
                              $next=$alphabets[$next_letter];
                              $cc= $int_var+1;
$coun = str_pad($cc, 6, 0, STR_PAD_LEFT); // Updated line to include '0'
$customid = $first_letter.$coun;
}
}
if($customer_addr==1)
{
     $saveItems=array('order_code'=>$customid,
          'customer_id'=>$this->session->userdata('id'),
          'product_name'=>"null",
          'product_img'=>"null",
          'product_id'=>"null",
          'product_qty'=>0,
          'product_price'=>0,
          'product_subtotal'=>0,
          'total'=>0,
          'c_fname'=>$customer->firstname,
          'c_lname'=>$customer->lastname,
          'c_mobile'=>$customer->mobile,
          'c_address1'=>$cust_addr->address1,
          'c_address2'=>$cust_addr->address2,
          'city'=>$cust_addr->City,
          'pincode'=>$cust_addr->pincode,
          'discount'=>0,
          'tax'=>0,
          'store_pickup'=>0,
          'upload'=> $_FILES['images']['name'][$i],
          'shop_id'=>$this->session->userdata('store_id'),
             'slot' => 'null',
          'shopId'=>$shopId->shopId,
          'shop_name'=>$this->session->userdata('store_name'),
          'order_status'=>0,
          'order_placed_date'=>date("Y-m-d H:i:s")
     );

}
else if(!empty($default_addr)){

     $saveItems=array('order_code'=>$customid,
          'customer_id'=>$this->session->userdata('id'),
          'product_name'=>"null",
          'product_img'=>"null",
          'product_id'=>"null",
          'product_qty'=>0,
          'product_price'=>0,
          'product_subtotal'=>0,
          'total'=>0,
          'c_fname'=>$customer->firstname,
          'c_lname'=>$customer->lastname,
          'c_mobile'=>$customer->mobile,
          'c_address1'=>$default_addr->address1,
          'c_address2'=>$default_addr->address2,
          'city'=>$default_addr->City,
          'pincode'=>$default_addr->pincode,
          'discount'=>0,
          'tax'=>0,
          'store_pickup'=>0,
             'slot' => 'null',
          'upload'=> $_FILES['images']['name'][$i],
          'shop_id'=>$this->session->userdata('store_id'),
          'shopId'=>$shopId->shopId,
          'shop_name'=>$this->session->userdata('store_name'),
          'order_status'=>0,
          'order_placed_date'=>date("Y-m-d H:i:s")
     );  
}
else
{
     $saveItems=array('order_code'=>$customid,
          'customer_id'=>$this->session->userdata('id'),
          'product_name'=>"null",
          'product_img'=>"null",
          'product_id'=>"null",
          'product_qty'=>0,
          'product_price'=>0,
          'product_subtotal'=>0,
          'total'=>0,
          'c_fname'=>$customer->firstname,
          'c_lname'=>$customer->lastname,
          'c_mobile'=>$customer->mobile,
          'c_address1'=>'null',
          'c_address2'=>'null',
          'city'=>'null',
          'pincode'=>'null',
          'discount'=>0,
          'tax'=>0,
          'store_pickup'=>0,
          'slot' => 'null',
          'upload'=> $_FILES['images']['name'][$i],
          'shop_id'=>$this->session->userdata('store_id'),
          'shopId'=>$shopId->shopId,
          'shop_name'=>$this->session->userdata('store_name'),
          'order_status'=>0,
          'order_placed_date'=>date("Y-m-d H:i:s")
     );   
}
$this->db->insert('order_items',$saveItems);
$savePayment=array('order_code'=>$customid,
     'transaction_id'=>0,
     'payment_total'=>0,
     'amt_paid'=>0,
     'Payment_method'=>'Cash On Delivery',
     'payment_date'=>date("Y-m-d H:i:s"),
     'payment_status'=>0);
$this->db->insert('cust_payment_details',$savePayment);              
$store_id=$this->session->userdata('store_id');
$this->dbConnection($store_id);
$result=$this->db->insert('order_items',$saveItems);
$this->db->insert('cust_payment_details',$savePayment); 
if($result)
{
     $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$customid);
     $orders=$this->db->get()->result();
     $this->db->select('*');
     $this->db->from('order_items');
     $this->db->where('order_code',$customid);
     $cust_data=$this->db->get()->row();

     $subject = $cust_data->shop_name."-".$customid." Order Placed";

     $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
     <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
     <table style="width:70%">
     <td style="width:30%">
     <p>Order Id : '. $customid.'</p>
     </td>
     <td style="width:30%">
     <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
     </td>
     <td style="width:30%">
     <p>Shop Name : '. $cust_data->shop_name.'</p>
     </td>
     </table>
     <p>We have recieved the uploaded prescription we will reach you back</p>';
     $config['protocol']   = 'smtp';
     $config['smtp_host']  = "mail.direct-buy.in";
     $config['smtp_port']  = 587;
     $config['smtp_user']  = "info@direct-buy.in";
     $config['smtp_pass']  = "Default!@#123";
     $config['charset']    = 'iso-8859-1';
     $config['newline']    = "\r\n";
     $config['mailtype']   = 'html';
     $config['validation'] = TRUE;


     $this->load->library('email', $config);
     $this->email->set_newline("\r\n");
     $this->email->from('info@direct-buy.in');
     $this->email->to($customer->email);
     $this->email->subject($subject);
     $this->email->message($message);
     if($this->email->send())
     {
          $url = explode('.',$_SERVER['SERVER_NAME']);
          $domain=$url[0];
          $data['logo']=$this->cm->getLogo($domain);
          $subject = $cust_data->shop_name."-".$customid." Order Placed";

          $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
          <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
          <table style="width:70%">
          <td style="width:30%">
          <p>Order Id : '. $customid.'</p>
          </td>
          <td style="width:30%">
          <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
          </td>
          <td style="width:30%">
          <p>Shop Name : '. $cust_data->shop_name.'</p>
          </td>
          </table>
          <p>Cutomer has uploaded the presciption</p>';
          $config['protocol']   = 'smtp';
          $config['smtp_host']  = "mail.direct-buy.in";
          $config['smtp_port']  = 587;
          $config['smtp_user']  = "info@direct-buy.in";
          $config['smtp_pass']  = "Default!@#123";
          $config['charset']    = 'iso-8859-1';
          $config['newline']    = "\r\n";
          $config['mailtype']   = 'html';
          $config['validation'] = TRUE;


          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('info@direct-buy.in');
          $this->email->to($data['logo']->email);
          $this->email->subject($subject);
          $this->email->message($message);
          if($this->email->send())
          {
               $this->session->set_flashdata('flashSuccess', "Order Placed Successfully");
               redirect("welcome/order_details/".$customid);
          }
     }
}
}else{ 
     $this->session->set_flashdata('flashError', 'Upload failed. Image file must be jpg|png|jpeg');
// echo "Upload failed. Image file must be jpg|png|jpeg";
     redirect('welcome/upload_page');
} 
} 

// File upload error message 
$errorUpload = !empty($errorUpload)?' Upload Error: '.trim($errorUpload, ' | '):'';
}
}
}