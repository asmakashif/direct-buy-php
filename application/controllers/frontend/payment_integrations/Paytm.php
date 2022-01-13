<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Paytm extends CI_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/PaytmModel', 'Paytm');
        $this->load->model('frontend/CustomerModel','cm');
        $this->load->model('frontend/NotificationModel', 'nm');
        $this->load->library('session');
        date_default_timezone_set("Asia/Kolkata");
    }

    public function index() {
        $this->load->view('frontend/payment_integrations/paytm');
    }

    public function pgRedirect($store_id) 
    {
        $store_id1=$this->session->set_userdata('store_id',$store_id);
        $data['this_session']=$this->session->userdata('store_id');
        $this->load->view("frontend/payment_integrations/PaytmKit/pgRedirect",$data);
    }

    public function pgResponse() 
    {
        $this_session=$this->session->userdata('store_id');
        $data['details']=$this->cm->getPaytmDetails($this_session);
        $data = array(
            "Paytm" => $this->Paytm
        );
        $this->db->select('*');
        $this->db->from('order_items');
        $this->db->where('id', $_POST['ORDERID']);
        $ordercode=$this->db->get()->row();

        $this->db->select('*');
        $this->db->from('order_items');
        $this->db->where('order_code',$ordercode->order_code);
        $orders=$this->db->get()->result();

        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('id', $ordercode->customer_id);
        $customer=$this->db->get()->row();

        $this->db->select('*');
        $this->db->from('tbl_user as tb');
        $this->db->join('shop_details as sd','tb.id=sd.user_id');
        $this->db->where('sd.shopId', $ordercode->shopId);
        $data['logo']=$this->db->get()->row();
        $total_order=$data['logo']->total_orders+1;
        $pending_order=$data['logo']->pending_orders+1;
        $data['homeDelivery']=$this->cm->check_homedelivery($ordercode->shopId);
        if($_POST['RESPMSG']=='Txn Success')
        {
            $updatedata=array("pending_orders"=>$pending_order,
                "total_orders"=>$data['logo']->total_orders+1) ;
            $this->db->where('shopId',$ordercode->shopId);
            $this->db->update('shop_details',$updatedata);
            $save=array(
                "order_code" => $ordercode->order_code,
                "transaction_id"=>$_POST['TXNID'],
                "amt_paid"=>$_POST['TXNAMOUNT'],
                "payment_date"=>date("Y-m-d H:i:s"),
                'payment_total'=>$_POST['TXNAMOUNT'],
                'Payment_method'=>'Paytm',
                "payment_status"=>1
            );
        }
        else
        {
            $save=array(
                "order_code" => $ordercode->order_code,
                "transaction_id"=>0,
                "amt_paid"=>$_POST['TXNAMOUNT'],
                "payment_date"=>date("Y-m-d H:i:s"),
                'payment_total'=>$_POST['TXNAMOUNT'],
                'Payment_method'=>'Paytm',
                "payment_status"=>0
            ); 
        }
        $store_name=$this->session->userdata('store_name');
        $store_id=$ordercode->shopId;

        $res=$this->db->insert("cust_payment_details",$save);
        if($res){
            $shopId=$ordercode->shopId;
            $nd=[
                'NotificationContent'=>'Customer Placed an order',
                'NotificationRedirect'=>'http://localhost:4200/00-murgiwala/StoreController/custOrders/',//path to be passed inside site_url()
                'Iscomplete'=>0,
                'NotificationStatus'=>0,
                'CreatedDateTime'=>date('Y-m-d')
            ];
            $insertNotification = $this->nm->addNotification($nd);
            if($insertNotification)
            {
                $this->notificationReceiver($insertNotification,$shopId);
            }
        }
        $this->dbConnection($store_id);
        $result= $this->db->insert("cust_payment_details",$save);
        if($_POST['RESPMSG']=='Txn Success')
        {
            $updatedata=array("pending_orders"=>$pending_order,
            "total_orders"=>$data['logo']->total_orders+1) ;
            $this->db->where('shopId',$ordercode->shopId);
            $this->db->update('shop_details',$updatedata);
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
        }
        if($result)
        {
            $shopId=$ordercode->shopId;
            $nd=[
                'NotificationContent'=>'Customer Placed an order',
                'NotificationRedirect'=>'http://localhost:4200/00-murgiwala/StoreController/custOrders/',//path to be passed inside site_url()
                'Iscomplete'=>0,
                'NotificationStatus'=>0,
                'CreatedDateTime'=>date('Y-m-d');
            ];
            $insertNotification = $this->nm->addNotification($nd);
            if($insertNotification)
            {
                $this->notificationReceiver($insertNotification,$shopId);
            }
            $order_code=$this->cm->get_ordercode($ordercode->order_code);
            $id=$ordercode->order_code;
            $this->db->select('*');
            $this->db->from('order_items');
            $this->db->where('order_code',$id);
            $orders=$this->db->get()->result();

            $this->db->select('*');
            $this->db->from('order_items');
            $this->db->where('order_code',$id);
            $cust_data=$this->db->get()->row();
            if($_POST['RESPMSG']=='Txn Success')
            { 
                $subject =$cust_data->shop_name. "-" .$cust_data->order_code. " Payment successfull";
            }
            else
            {
                $subject =$cust_data->shop_name. "-" .$cust_data->order_code. " Payment Failure";
            }
            $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
                <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
                <table style="width:70%">
                <td style="width:20%">
                <p>Order Id : '. $cust_data->order_code.'</p>
                </td>
                <td style="width:20%">
                <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
                </td>
                <td style="width:20%">
                <p>Shop Name : '. $cust_data->shop_name.'</p>
                </td>
                <td style="width:20%">
                <p>Payment Method : Paytm</p>
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
                if($cust_data->store_pickup==0)
                {
                    $message.='<div class="row">
                    <p>Address:'. $cust_data->c_address1 .','. $cust_data->c_address2 .','. $cust_data->city .','. $cust_data->pincode.'</p>

                    </div>';
                }
                else
                {
                    $message.=' <div class="row">
                    <p>Shop Name : '. $data['homeDelivery']->shop_name.' </p>
                    <br/>
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
                    if($_POST['RESPMSG']=='Txn Success')
                    { 
                        $subject =$cust_data->shop_name. "-" .$cust_data->order_code. " Payment successfull";
                    }
                    else
                    {
                        $subject =$cust_data->shop_name. "-" .$cust_data->order_code. " Payment Failure";
                    }
                    $message='<div class="row" style="width:100%; background-color:#fc814c; height:50px">
                    <h4 style="text-align:center; color:white;padding-top:20px">Your Order Details</h4></div>
                    <table style="width:70%">
                    <td style="width:20%">
                    <p>Order Id : '. $cust_data->order_code.'</p>
                    </td>
                    <td style="width:20%">
                    <p>Name : '. $cust_data->c_fname.''. $cust_data->c_lname.'</p>
                    </td>
                    <td style="width:20%">
                    <p>Shop Name : '. $cust_data->shop_name.'</p>
                    </td>
                    <td style="width:20%">
                    <p>Payment Method : Paytm</p>
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
                    if($cust_data->store_pickup==0)
                    {
                        $message.='<div class="row">
                        <p>Address:'. $cust_data->c_address1 .','. $cust_data->c_address2 .','. $cust_data->city .','. $cust_data->pincode.'</p>

                        </div>';
                    }
                    else
                    {
                        $message.=' <div class="row">
                        <p>Shop Name : '. $data['homeDelivery']->shop_name.' </p>
                        <br/>
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
                        if($_POST['RESPMSG']=='Txn Success')
                        {
                            $this->cart->destroy();  
                            $this->session->set_flashdata('flashSuccess', "Payment is Successfull");
                            redirect('frontend/Checkout/Success/'.$id);
                        }
                        else
                        {
                            redirect('frontend/Checkout/Failed');
                        }
                    }
                }
                $store_id1=$this->session->set_userdata('store_id',$store_id);
                $store_id=$this->session->userdata('store_id');
                $data['session_id']=$session_id;
                $this->load->view("frontend/payment_integrations/PaytmKit/pgResponse",$data);
            }
        }

        public function notificationReceiver($NotificationID,$shopId)
        {
            $this->db->select('*');
            $this->db->from('tbl_user as tb');
            $this->db->join('shop_details as sd','tb.id=sd.user_id');
            $this->db->where('sd.shopId', $shopId);
            $result=$this->db->get()->row();
            $receiverId = $result->id;
            $receiverName = $result->firstname;
       
            
            $data=[
                'NotificationReceiverID'=>$receiverId,'NotificationReceiverName'=>$receiverName,'NotificationRID' =>$NotificationID
            ];
            $query = $this->nm->addNotificationReceiver($data);
        
            // $query=$this->db->insert('notification_receivers', $result);
        
            if($query)
            {
                $this->session->set_flashdata('flashSuccess',"Added Successfully");
            }
            else
            {
                $this->session->set_flashdata('flashError',"Something went wrong");  
            }
        }

        public function config()
        {
            $store_id=$this->session->userdata('store_id');
            $data['store_id']=$store_id;
            $this->load->view("frontend/payment_integrations/PaytmKit/lib/config_paytm.php",$data);
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
