<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paytm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/PaytmModel', 'Paytm');
        $this->load->model('frontend/CustomerModel','cm');
        $this->load->library('session');
        date_default_timezone_set("Asia/Kolkata");
    }

    public function index() {
        // $data['main_content']='backend/paymentIntegration/paytm';
        
        $this->load->view('frontend/payment_integrations/paytm');
    }

    public function pgRedirect() 
    
    {
       
        $this->load->view("frontend/payment_integrations/PaytmKit/pgRedirect");
    }

    public function pgResponse($store_id) {
       
        $data = array(
            "Paytm" => $this->Paytm
        );
     
        $txn=rand(10000000,99999999);
         $this->db->select('*');
     $this->db->from('customers');
     $this->db->where('id',$this->session->userdata('id'));
     $customer=$this->db->get()->row();
        
         $order_code=$this->cm->get_ordercode($_POST['ORDERID']);
      
        $save=array(
                "order_code" =>$_POST['ORDERID'],
                "transaction_id"=>$txn,
                "amt_paid"=>$_POST['TXNAMOUNT'],
                "payment_date"=>date("Y-m-d H:i:s"),
               'payment_total'=>$_POST['TXNAMOUNT'],
                'Payment_method'=>'Paytm',
                "payment_status"=>1
               );
              $store_name=$this->session->userdata('store_name');
            //   $store_id=$this->session->userdata('store_id');
               $this->db->insert("cust_payment_details",$save);
               $this->dbConnection($store_id);
           $result= $this->db->insert("cust_payment_details",$save);
       if($result)
       {
    
        $id=$_POST['ORDERID'];
         $this->db->select('*');
                    $this->db->from('order_items');
                    $this->db->where('order_code',$id);
                    $orders=$this->db->get()->result();
                    // print_r($orders);
                    // die();
                     $this->db->select('*');
                    $this->db->from('order_items');
                    $this->db->where('order_code',$id);
                    $cust_data=$this->db->get()->row();
                    
                $subject =$cust_data->shop_name."-".$cust_data->order_code. " Payment successfull";
           
            $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
            <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
            <table style="width:70%">
<td style="width:30%">
<p>Order Id : '. $cust_data->order_code.'</p>
</td>
<td style="width:30%">
<p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
</td>
<td style="width:30%">
<p>Shop Name : '. $cust_data->shop_name.'</p>
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
              $this->cart->destroy();  
               $this->session->set_flashdata('flashSuccess', "Payment is Successfull");
             redirect('frontend/Checkout/Success/'.$id);
            }
            else
            {
                $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
               redirect('frontend/Checkout/failed');
               
            }
       }
        
         // $this->load->view("payment_integrations/PaytmKit/pgResponse");
    }
    	public function dbConnection($store_id)
	{
	   // print_r('hi');
    //   die();  
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
