<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PaymentController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('backend/PaymentModel','pm');
		$this->load->model('backend/MyProfileModel','mpm');
		$this->load->helper('form');
		$this->load->library('session');
        $this->load->library('form_validation');
		date_default_timezone_set("Asia/Kolkata");
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('Login');
        }
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
    
    public function gPay()
    {
        $data['main_content']='backend/paymentIntegration/gPay';
        $this->load->view('backend/include/template', $data);
    }

    public function addPaymentMethod()
    {
        $data['shopDBName']=$this->pm->getShopDBName();
        $data['paymentProvider']=$this->pm->fetchPaymentProviders();
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/paymentIntegration/addPaymentMethod';
        $this->load->view('backend/include/template', $data);
    }

    public function savePaymentDetails()
    {
        if(!empty($this->input->post('submit')))
        {
            // $data = explode('.',$_SERVER['SERVER_NAME']);
            // $this->db->where('domainname',$data[0]);
            // $q = $this->db->get('tbl_user')->row();
            $user_id = $this->session->userdata('id');
            $shopDBName = $this->input->post('shopDbName');
            $provider_type   = $this->input->post('provider_type');
            $payment_name   = $this->input->post('payment_name');
            $payment_api_key   = $this->input->post('payment_api_key');
            $payment_secret_key   = $this->input->post('payment_secret_key');
            $channel_id='WEB';
            $industry_type   = $this->input->post('industry_type');
            $merchant_website   = $this->input->post('merchant_website');
            $merchant_mid   = $this->input->post('merchant_mid');
            $merchant_secret_key   = $this->input->post('merchant_secret_key');
            $payee_vpa   = $this->input->post('payee_vpa');
            $payee_name   = $this->input->post('payee_name');
            $trns_note   = $this->input->post('trns_note');
            $merchant_code   = $this->input->post('merchant_code');
            $payment_added_date   = date("Y-m-d H:i:s");
            $data = explode('.',$_SERVER['SERVER_NAME']);
            if($data[0] == 'demo') {
                if($provider_type=='Razorpay')
                {
                    $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$payment_api_key,'payment_secret_key'=>$payment_secret_key,'payment_added_date'=>$payment_added_date,'demo_payment'=>1);
                    $insert = $this->pm->insertPaymentDetails($data);
                    if($insert)
                    {
                        // $this->saveStoreDB($data,$shopDBName);
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/index');
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
                elseif($provider_type=='Paytm')
                {
                    $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$merchant_mid,'payment_secret_key'=>$merchant_secret_key,'channel_id'=>$channel_id,'industry_type'=>$industry_type,'merchant_website'=>$merchant_website,'payment_added_date'=>$payment_added_date,'demo_payment'=>1);
                    $insert = $this->pm->insertPaymentDetails($data);
                    if($insert)
                    {
                        // $this->saveStoreDB($data,$shopDBName);
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/index');
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
                elseif($provider_type=='GooglePay')
                {
                    $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$payee_vpa,'payment_secret_key'=>$payee_name,'transaction_note'=>$trns_note,'merchant_code'=>$merchant_code,'payment_added_date'=>$payment_added_date,'demo_payment'=>1);
                    $insert = $this->pm->insertPaymentDetails($data);
                    if($insert)
                    {
                        // $this->saveStoreDB($data,$shopDBName);
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/index');
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
                else{
                    $this->session->set_flashdata('flashError', 'Select Provider type');
                    redirect('backend/MyShopController/index');
                }
            }
            else
            {
                if($provider_type=='Razorpay')
                {
                    $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$payment_api_key,'payment_secret_key'=>$payment_secret_key,'payment_added_date'=>$payment_added_date);
                    $insert = $this->pm->insertPaymentDetails($data);
                    if($insert)
                    {
                        // $this->saveStoreDB($data,$shopDBName);
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/index');
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
                elseif($provider_type=='Paytm')
                {
                    $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$merchant_mid,'payment_secret_key'=>$merchant_secret_key,'channel_id'=>$channel_id,'industry_type'=>$industry_type,'merchant_website'=>$merchant_website,'payment_added_date'=>$payment_added_date);
                    $insert = $this->pm->insertPaymentDetails($data);
                    if($insert)
                    {
                        // $this->saveStoreDB($data,$shopDBName);
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/index');
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
                elseif($provider_type=='GooglePay')
                {
                    $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$payee_vpa,'payment_secret_key'=>$payee_name,'transaction_note'=>$trns_note,'merchant_code'=>$merchant_code,'payment_added_date'=>$payment_added_date);
                    $insert = $this->pm->insertPaymentDetails($data);
                    if($insert)
                    {
                        // $this->saveStoreDB($data,$shopDBName);
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/index');
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
                else{
                    $this->session->set_flashdata('flashError', 'Select Provider type');
                    redirect('backend/MyShopController/index');
                }
            }
        }
    }
    
    public function editPaymentConfiguration($provider)
    {
        $data['provider'] = $this->uri->segment(4);
        $data['payment'] = $this->pm->fetchPaymentName($provider);
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/paymentIntegration/editPaymentConfiguration';
        $this->load->view('backend/include/template', $data);
    }

    public function updatePaymentConfiguration()
    {
        if(!empty($this->input->post('submit')))
        {
            $user_id = $this->session->userdata('id');
            $provider_type   = $this->input->post('provider_type');
            $payment_id   = $this->input->post('payment_id');
            $payment_name   = $this->input->post('payment_name');
            $payment_api_key   = $this->input->post('payment_api_key');
            $payment_secret_key   = $this->input->post('payment_secret_key');
            $industry_type   = $this->input->post('industry_type');
            $merchant_website   = $this->input->post('merchant_website');
            $payee_vpa   = $this->input->post('payee_vpa');
            $payee_name   = $this->input->post('payee_name');
            $trns_note   = $this->input->post('trns_note');
            $merchant_code   = $this->input->post('merchant_code');
            $payment_added_date   = date("Y-m-d H:i:s");
            
            if($provider_type=='GooglePay')
            {
                $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$payee_vpa,'payment_secret_key'=>$payee_name,'transaction_note'=>$trns_note,'merchant_code'=>$merchant_code,'payment_added_date'=>$payment_added_date);
                $this->db->where('payment_id',$payment_id);
                $update = $this->db->update('payment_integration', $data);
                if($update)
                {
                    $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                    redirect('backend/MyShopController/index');
                }
                else
                {
                    $this->session->set_flashdata('flashError', 'Something went wrong');
                    redirect('backend/MyShopController/index');
                }
            }
            else
            {
                $data = array('user_id'=>$user_id,'provider_type'=>$provider_type,'payment_name'=>$payment_name,'payment_api_key'=>$payment_api_key,'payment_secret_key'=>$payment_secret_key,'channel_id'=>$channel_id,'industry_type'=>$industry_type,'merchant_website'=>$merchant_website,'payment_added_date'=>$payment_added_date);
                $this->db->where('payment_id',$payment_id);
                $update = $this->db->update('payment_integration', $data);
                if($update)
                {
                    $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                    redirect('backend/MyShopController/index');
                }
                else
                {
                    $this->session->set_flashdata('flashError', 'Something went wrong');
                    redirect('backend/MyShopController/index');
                }
            }
        }
    }
    
    public function saveStoreDB($data,$shopId)
    {
        $this->dbConnection($shopId);
        $insert = $this->pm->insertPaymentDetails($data);
    }

    public function viewPaymentDocumentation($provider)
    {
        $data['payment'] = $this->pm->viewPaymentDocumentation($provider);
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/paymentIntegration/viewPaymentDocumentation';
        $this->load->view('backend/include/template', $data);
    }

    // public function checkPayment()
    // {
    //     $shopId= $this->input->post('shopId');
    
    //     if($this->input->post('shopId'))
    //     {  
    //         $this->db->where('pInfo_shopId',$shopId);
    //         $result = $this->db->delete('shop_payment_info');
    //         if($result)
    //         {
    //             echo 1;    
    //         }
    //         else
    //         {
    //             echo 0;   
    //         }  
    //     }   
    // }

    // public function checkPaymentofStrDB()
    // {
    //     $shopId= $this->input->post('shopId');
    //     $this->dbConnection($shopId);
    //     if($this->input->post('shopId'))
    //     {  
    //         $this->db->where('pInfo_shopId',$shopId);
    //         $result = $this->db->delete('shop_payment_info');
    //         if($result)
    //         {
    //             echo 1;    
    //         }
    //         else
    //         {
    //             echo 0;   
    //         }  
    //     }   
    // }

    // public function savePaymentSetting()
    // {
    //     $payment_name= $this->input->post('payment_name');
    //     $paymentId= $this->input->post('paymentId');
    //     $provider_type= $this->input->post('provider_type');
    //     $shopId= $this->input->post('shopId'); 
    //     $user_id = $this->session->userdata('id');
    //     $pInfo_added_date=date('Y-m-d: H:i:s');
        
        
        
    //     $data=array(
    //         'paymentId'=> $paymentId,
    //         'pInfo_userId'=> $user_id,
    //         'pInfo_shopId'=> $shopId,
    //         'pInfo_provider'=> $provider_type,
    //         'pInfo_payment_name'=> $payment_name,
    //         'pInfo_added_date'=> $pInfo_added_date,
    //     );
    //     $result= $this->db->insert('shop_payment_info',$data);
    //     if($result)
    //     {
            
    //         $this->savePaymentInfoToStrDB($paymentId,$provider_type,$shopId,$payment_name);
    //         echo  1;    
    //     }
    //     else
    //     {
    //         echo  0;    
    //     }
        
    // }

    // public function savePaymentInfoToStrDB($provider_type,$shopId,$payment_name)
    // {
    //     $this->dbConnection($shopId);
    //     $user_id = $this->session->userdata('id');
    //     $pInfo_added_date = date("Y-m-d H:i:s");
        
    //     $this->db->where('pInfo_userId',$user_id);
    //     $this->db->where('pInfo_shopId',$shopId);
    //     $delete = $this->db->delete('shop_payment_info');
    //     if($delete)
    //     {
    //         $result = array();
    //         foreach($payment_name AS $key => $val){
    //             $result[] = array(
    //                 'pInfo_userId'   => $user_id,
    //                 'pInfo_shopId'   => $shopId,
    //                 'pInfo_provider'   => $_POST['provider_type'][$key],
    //                 'pInfo_payment_name'   => $val,
    //                 'pInfo_added_date' => $pInfo_added_date,
    //                 'default_payment' => 0,
    //                 'pInfo_status' => 0,
    //             );
    //         }    
    //         $this->db->insert_batch('shop_payment_info', $result);
    //     }
        
       
    // }
    
    public function savePaymentSetting($shopId)
    {
        $submit=$this->input->post('submit');
        if($submit)
        {
            // $data = explode('.',$_SERVER['SERVER_NAME']);
            // $this->db->where('domainname',$data[0]);
            // $q = $this->db->get('tbl_user')->row();
            
            $provider_type = $this->input->post('provider_type',TRUE);
            $payment_id = $this->input->post('payment_id',TRUE);
            $shopId = $this->input->post('shopId',TRUE);
            $user_id = $this->session->userdata('id');
            $pInfo_added_date = date("Y-m-d H:i:s");

            
            $this->db->where('pInfo_userId',$user_id);
            $this->db->where('pInfo_shopId',$shopId);
            $delete = $this->db->delete('shop_payment_info');
            if($delete)
            {
                $data = explode('.',$_SERVER['SERVER_NAME']);
                if($data[0] == 'demo') 
                {
                    $result = array();
                    foreach($payment_id AS $key => $val){
                        $result[] = array(
                            'pInfo_userId'   => $user_id,
                            'pInfo_shopId'   => $shopId,
                            'pInfo_provider'   => $_POST['provider_type'][$key],
                            'pInfo_payment_name'   => $val,
                            'pInfo_added_date' => $pInfo_added_date,
                            'default_payment' => 0,
                            'pInfo_status' => 0,
                            'demo_shop_payment'=>1
                        );
                        
                    }    
                    
                    $query=$this->db->insert_batch('shop_payment_info', $result);
                    if($query)
                    {
                        $this->savePaymentInfoToStrDB($payment_id,$provider_type,$shopId,$user_id);
                        $this->session->set_flashdata('flashSuccess', 'Inserted Successfully.');
                        $this->close_method();
                        //redirect('backend/MyShopController/myShop/'.$shopId.'/'.$shopDBName);
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        $this->close_method();
                        //redirect('backend/MyShopController/myShop/'.$shopId.'/'.$shopDBName);
                    }
                }
                else{
                    $result = array();
                    foreach($payment_id AS $key => $val){
                        $result[] = array(
                            'pInfo_userId'   => $user_id,
                            'pInfo_shopId'   => $shopId,
                            'pInfo_provider'   => $_POST['provider_type'][$key],
                            'pInfo_payment_name'   => $val,
                            'pInfo_added_date' => $pInfo_added_date,
                            'default_payment' => 0,
                            'pInfo_status' => 0,
                            'demo_shop_payment'=>0
                        );
                        
                    }    
                    
                    $query=$this->db->insert_batch('shop_payment_info', $result);
                    if($query)
                    {
                        $this->savePaymentInfoToStrDB($payment_id,$provider_type,$shopId,$user_id);
                        $this->session->set_flashdata('flashSuccess', 'Inserted Successfully.');
                        $this->close_method();
                        //redirect('backend/MyShopController/myShop/'.$shopId.'/'.$shopDBName);
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        $this->close_method();
                        //redirect('backend/MyShopController/myShop/'.$shopId.'/'.$shopDBName);
                    }
                }
            }
        }
    }

    public function savePaymentInfoToStrDB($payment_id,$provider_type,$shopId,$user_id)
    {
        $this->dbConnection($shopId);
        $pInfo_added_date = date("Y-m-d H:i:s");
        $this->db->where('pInfo_userId',$user_id);
        $this->db->where('pInfo_shopId',$shopId);
        $delete = $this->db->delete('shop_payment_info');
        if($delete)
        {
            $result = array();
            foreach($payment_id AS $key => $val){
                $result[] = array(
                    'pInfo_userId'   => $user_id,
                    'pInfo_shopId'   => $shopId,
                    'pInfo_provider'   => $_POST['provider_type'][$key],
                    'pInfo_payment_name'   => $val,
                    'pInfo_added_date' => $pInfo_added_date,
                    'default_payment' => 0,
                    'pInfo_status' => 0,
                    'demo_shop_payment'=>0
                );
            }    
            $this->db->insert_batch('shop_payment_info', $result);
        }
    }
    
    public function close_method(){
        echo  "<script type='text/javascript'>";
        // echo "Inserted Successfully";
        echo "window.close();";
        echo "</script>";
        //header("Location: https://demo.direct-buy.in/backend/MyShopController/myShop/bLOao6", true, 301);
    }
    
    // public function redirection()
    // {
    //     header("Location: https://demo.direct-buy.in/backend/MyShopController/myShop/bLOao6", true, 301);
    // }
    
    public function updatePaymentSetting($shopId)
    {
        $this->dbConnection($shopId);
        $submit=$this->input->post('submit');
        if($submit)
        {
            $shop_pInfo_id = $this->input->post('shop_pInfo_id');

            $this->db->where('pInfo_shopId',$shopId);
            $query=$this->db->update('shop_payment_info', array('default_payment'=>0));

            if($query)
            {
                $this->db->where('shop_pInfo_id',$shop_pInfo_id);
                $query=$this->db->update('shop_payment_info', array('default_payment'=>1));
                if($query)
                {
                    $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                    redirect('backend/MyShopController/myShop/'.$shopId);
                }
                else
                {
                    $this->session->set_flashdata('flashError', 'Something went wrong');
                    redirect('backend/MyShopController/myShop/'.$shopId);
                }
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/myShop/'.$shopId);
            }
        }
    }

    public function activateShop($shop_id)
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
    	$data['data_info']=$this->pm->getShopData($shop_id);
        $data['return_url'] = base_url().'backend/razorpay/callback';
        $data['surl'] = base_url().'backend/razorpay/success';
        $data['furl'] = base_url().'backend/razorpay/failed';
        $data['currency_code'] = 'INR';
        $data['shop_id']=$shop_id;
        $data['main_content']='backend/shopCheckout';
        $this->load->view('backend/include/template', $data);
    }
}
