<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Razorpay extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    // index page
    public function index() {
        $data['title'] = 'Razorpay | TechArise';            
        $this->load->view('razorpay/index', $data);
    }
 
    // initialized cURL Request
    private function get_curl_handle($payment_id, $amount)  {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = 'rzp_test_xFaGl7So24RVzR';
        $key_secret = 'TcSxQNmVnSsRapv6oXbbzzfh';
        $fields_string = "amount=$amount";

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
                $txn_id=$response_array['notes']['soolegal_order_id'];
                $shop_id=$response_array['notes']['shop_id'];
                $shopDBName=$response_array['notes']['shop_db_name'];
                $exp_date=$response_array['notes']['exp_date'];
                $amount=$response_array['notes']['amount'];
                $payment_date=$response_array['notes']['payment_date'];

                $this->db->where('shop_id',$shop_id);
                $data= array('shop_payment_amount'=>$amount,'shop_payment_id'=>$razorpay_payment_id,'shop_payment_date'=>$payment_date,'shop_exp_date'=>$exp_date,'shop_payment_status'=>1);
                $update=$this->db->update('shop_details',$data);
                if($update)
                {
                    // $this->session->set_userdata($data);
                    $this->saveStoreDB($data,$shop_id,$shopDBName);
                    $this->session->set_flashdata('flashSuccess', 'Payment Successful Store is active.');
                    redirect('backend/MyShopController/index');
                }
 
            } else {
                $this->session->set_flashdata('flashError', 'Payment Failed');
                redirect('backend/MyShopController/index');
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    }  
    
    public function saveStoreDB($data,$shop_id,$shopDBName)
    {
        $this->dbConnection($shopDBName);
        $this->db->where('shop_id',$shop_id);
        $this->db->update('shop_details',$data);
    }
    
    //DB Connection
    public function dbConnection($shopId)
    {
        $c['hostname'] = "localhost:3306";
        $c['username'] = "direcbuy_directbuy";
        $c['password'] = "Default!@#123";
        $c['database'] = "direcbuy_".$shopId;
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