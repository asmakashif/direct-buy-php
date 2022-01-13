<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Razorpay extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        	$this->load->library('session');
        	$this->load->model('frontend/CustomerModel','cm');
    }
    // index page
    public function index() {
        $data['title'] = 'Razorpay | TechArise';            
        $this->load->view('razorpay/index', $data);
    }
 
    // initialized cURL Request
    private function get_curl_handle($payment_id, $amount)  {
          $store_name=$this->session->userdata('store_name');
          $store_id=$this->session->userdata('store_id');
       
        $url = explode('.',$_SERVER['SERVER_NAME']);
         $id=$url[0];
        $this->db->select('*');
        $this->db->from('payment_integration as pi');
        $this->db->join('shop_payment_info as sh',"sh.pInfo_userId=pi.user_id");
        $this->db->join('tbl_user as tb',"tb.id=pi.user_id");
        $this->db->where('tb.domainname',$id);
        $this->db->where('pi.provider_type','Razorpay');
        $key=$this->db->get()->row();
        // print_r($key->payment_secret_key);
        // die();
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id =$key->payment_api_key;
        // print_r($key);
        // die();
        $key_secret = $key->payment_secret_key;
        $fields_string = "amount=$amount";
      $this->dbConnection($store_id);
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }   
        
    // callback method 
     public function callback() {  
         $store_name=$this->session->userdata('store_name');
         $store_id=$this->session->userdata('store_id');
         $this->db->select('*');
     $this->db->from('customers');
     $this->db->where('id',$this->session->userdata('id'));
     $customer=$this->db->get()->row();
         
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {                
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
               //echo curl_error($ch);die();
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true) {
                $order_id=$response_array['notes']['soolegal_order_id'];
                $txn_id=$response_array['notes']['txn_id'];
               $order_code=$response_array['notes']['order_code'];
           

                    $data=array('order_code'=>$order_code,
                     'amt_paid'=>$response_array['notes']['amount'],
                     'transaction_id'=>$razorpay_payment_id,
                     'payment_total'=>$response_array['notes']['amount'],
                     'Payment_method'=>'Razorpay',
                     'payment_date'=>date("Y-m-d H:i:s"),
                     "payment_status"=>1
                    );
                    $this->db->insert("cust_payment_details",$data);
                    $this->dbConnection($store_id);
                   $result= $this->db->insert("cust_payment_details",$data);
                   if($result)
                   {
                       $this->db->select('*');
                    $this->db->from('order_items');
                    $this->db->where('order_code',$order_code);
                    $orders=$this->db->get()->result();
                    // print_r($orders);
                    // die();
                     $this->db->select('*');
                    $this->db->from('order_items');
                    $this->db->where('order_code',$order_code);
                    $cust_data=$this->db->get()->row();
                    $payment_data=$this->cm->getPaymentDetails($order_code);
                    if($payment_data->transaction_id==0)
                    {
                        $txnid='Cash On Delivery';
                    }
                    else{
                       $txnid=$payment_data->transaction_id ;
                    }
                    // print_r($payment_data->transaction_id);
                    // die();
                $subject =$cust_data->shop_name."-".$cust_data->order_code. " Payment successfull";
           
            $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
            <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
            <table style="width:70%">
<td style="width:25%">
<p>Order Id : '. $cust_data->order_code.'</p>
</td>
<td style="width:25%">
<p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
</td>
<td style="width:25%">
<p>Shop Name : '. $cust_data->shop_name.'</p>
</td>
<td style="width:25%">
// <p>'.$txnid.'</p>
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
</table>
<div class="row">
<p>Address:'. $cust_data->c_address1 .','. $cust_data->c_address2 .','. $cust_data->city .','. $cust_data->pincode.'</p>

</div>';
           
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
                    $this->session->set_flashdata('flashSuccess', 'Payment is Successfull');
                    $this->cart->destroy();
                     $this->db->select('*');
                     $this->dbConnection($store_id);
              $this->db->from('order_items');
              $this->db->where('order_code',$order_code);
              $res=$this->db->get()->result();
             
              foreach($res as $item){
                  $this->db->where('user_id',$this->session->userdata('id'));
                  $this->db->where('product_id',$item->product_id);
                    $this->db->delete('cart_details');
              }
              $url = explode('.',$_SERVER['SERVER_NAME']);
		     $domain=$url[0];
                $this->dbConnection($store_id);
               $data['logo']=$this->cm->getLogo($domain);
                   $subject =$cust_data->shop_name."-".$cust_data->order_code. " Payment successfull";
           
            $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
            <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
            <table style="width:70%">
<td style="width:25%">
<p>Order Id : '. $cust_data->order_code.'</p>
</td>
<td style="width:25%">
<p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
</td>
<td style="width:25%">
<p>Shop Name : '. $cust_data->shop_name.'</p>
</td>
<td style="width:25%">
<p>'.$txnid.'</p>
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
</table>
<div class="row">
<p>Address:'. $cust_data->c_address1 .','. $cust_data->c_address2 .','. $cust_data->city .','. $cust_data->pincode.'</p>

</div>';
           
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
                    redirect('frontend/Checkout/Success/'.$order_code);
            }
            }
            else
            {
                 $this->session->set_flashdata('flashError', 'Payment Failed');
               redirect('frontend/Checkout/Failed');
               
            }
        }
                
            } else {
                $this->session->set_flashdata('flashError', 'Payment Failed');
               redirect('frontend/Checkout/Failed');
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
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
  
}
?>