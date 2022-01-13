<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MyShopController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('backend/MyShopModel','msm');
        $this->load->model('backend/PaymentModel','pm');
        $this->load->model('backend/TableCreation','tc');
        $this->load->model('backend/MyProfileModel','mpm');
        $this->load->helper('mainHelper');
		$this->load->helper('form');
		$this->load->library('session');
        $this->load->library('form_validation');
		date_default_timezone_set("Asia/Kolkata");
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('Login');
        }
	}

    public function index()
    {
        $data['strMsg']=$this->msm->fetchRetailerDetails();
        $data['shopDetails']=$this->msm->fetchShopDetails();
        $data['paymentDetails']=$this->pm->fetchPaymentDetails();
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/include/main_content';
        $this->load->view('backend/include/template', $data);
    }
    
    public function addShopType()
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/myshops/addShopType';
        $this->load->view('backend/include/template', $data);
    }
    
    public function saveShopType()
    {
        $data = array('shop_type_name'=>$this->input->post('shop_type'),'shop_type_added'=>date("Y-m-d H:i:s"));
        // mkdir($shop_name);
        $insert = $this->db->insert('shop_types',$data);
        if($insert)
        {
            $this->session->set_flashdata('flashSuccess', 'Added Successfully.');
            redirect('backend/MyShopController/addShopType');
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            redirect('backend/MyShopController/addShopType');
        }
    }

    // public function storeInfo()
    // {
    //     $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
    //     $data['shopType']=$this->msm->fetchShopType();
    //     $data['main_content']='backend/myshops/storeInfo';
    //     $this->load->view('backend/include/template', $data);
    // }

    public function randomStrCode()
    {
        $alphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 6; $i++)
        {
          $n = rand(0, $alphaLength);
          $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    
    public function storeInfo($shopId='')
    {
        if(!empty($shopId))
        {
            $data['shopId']=$shopId;
            $data['shopData']=$this->msm->getShopDetailsById($shopId);
            $data['shopType']=$this->msm->fetchShopType();
            $data['shopTypebyid']=$this->msm->fetchShopDetailTypeById($shopId);
            $data['shopProducts']=$this->msm->getTempShopProducts($shopId);
            $data['shopSummary']=$this->msm->getStoreSummary($shopId);
            $data['shopSummaryType']=$this->msm->getStoreSummaryType($shopId);
            $data['productCount']=$this->msm->getCountofProducts($shopId);
            $data['main_content']='backend/myshops/editStrInfo';
            $this->load->view('backend/include/template', $data);
        }
        else
        {
            $data['shopId']=$shopId;
            $data['shopType']=$this->msm->fetchShopType();
            $data['main_content']='backend/myshops/strInfo';
            $this->load->view('backend/include/template', $data);
        }
    }
    
    public function fetchShopByName()
    {
        $shopName = $this->input->post('shopName');
        $this->db->select('sd.shop_name');//columns
        $this->db->from('shop_details as sd');
        $this->db->where('sd.shop_name', $shopName);
        $this->db->where('sd.user_id', $this->session->userdata('id'));
        $query=$this->db->get()->row();
        if($query)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }

    public function saveShopDetails()
    {
        $submit=$this->input->post('submit');
        if($submit)
        {
            $user_id = $this->session->userdata('id');
            $shopId = $this->randomStrCode();
            $shop_name   = ucfirst($this->input->post('shop_name'));
            $shopDBName = preg_replace('/\s+/', '', $shop_name);
            $shop_type   = $this->input->post('shop_type',TRUE);
            $shop_gst   = $this->input->post('shop_gst');
            $shop_address   = $this->input->post('shop_address');
            $shop_added_date   = date("Y-m-d H:i:s");
            $data = explode('.',$_SERVER['SERVER_NAME']);
            if($data[0] == 'demo') {
                $this->db->where('shop_name',$shop_name);
                $this->db->where('user_id',$this->session->userdata('id'));
                $get=$this->db->get('shop_details')->result();
                if(empty($get))
                {
                    $data = array('user_id'=>$user_id,'shopId'=>$shopId,'shop_name'=>$shop_name,'shop_address'=>$shop_address,'shop_db_name'=>$shopDBName,'shop_added_date'=>$shop_added_date,'demo_shop'=>1);
                    $insert = $this->msm->insertShopDetails($data);
                    if($insert)
                    {
                        $result = array();
                        foreach($shop_type AS $key => $val){
                            $result[] = array(
                                'shop_type_id'   => $val,
                                'shop_id'   => $insert,
                            );
                        }    
                        $query=$this->db->insert_batch('shop_detail_type', $result);
                        if($query)
                        {
                            $this->session->set_flashdata('flashSuccess', 'Saved & Table created Successfully.');
                            redirect('backend/MyShopController/configureStore/'.$shopId);
                            
                        }
                        else
                        {
                            $this->session->set_flashdata('flashError', 'Something went wrong');
                            redirect('backend/MyShopController/index');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
			    else
                {
                    $this->session->set_flashdata('flashError', 'Shop already exists');
                    redirect('backend/MyShopController/index');
                }
            }
            else
            {
                $this->db->where('shop_name',$shop_name);
                $this->db->where('user_id',$this->session->userdata('id'));
                $get=$this->db->get('shop_details')->result();
                if(empty($get))
                {
                    $data = array('user_id'=>$user_id,'shopId'=>$shopId,'shop_name'=>$shop_name,'shop_address'=>$shop_address,'shop_db_name'=>$shopDBName,'shop_added_date'=>$shop_added_date);
                    $insert = $this->msm->insertShopDetails($data);
                    if($insert)
                    {
                        $result = array();
                        foreach($shop_type AS $key => $val){
                            $result[] = array(
                                'shop_type_id'   => $val,
                                'shop_id'   => $insert,
                            );
                        }    
                        $query=$this->db->insert_batch('shop_detail_type', $result);
                        if($query)
                        {
                            $this->session->set_flashdata('flashSuccess', 'Saved & Table created Successfully.');
                            redirect('backend/MyShopController/configureStore/'.$shopId);
                            
                        }
                        else
                        {
                            $this->session->set_flashdata('flashError', 'Something went wrong');
                            redirect('backend/MyShopController/index');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('flashError', 'Something went wrong');
                        redirect('backend/MyShopController/index');
                    }
                }
			    else
                {
                    $this->session->set_flashdata('flashError', 'Shop already exists');
                    redirect('backend/MyShopController/index');
                }
            }
        }
    }
    
    public function updateShopDetails()
    {
        $submit=$this->input->post('submit');
        if($submit)
        {
            // $q=$this->getUserId();
            // $this->load->dbforge();
            $user_id = $this->session->userdata('id');
            $shopId   = $this->input->post('shopId');
            $shop_id   = $this->input->post('shop_id');
            $shop_name   = ucfirst($this->input->post('shop_name'));
            $shopDBName = preg_replace('/\s+/', '', $shop_name);
            $shop_type   = $this->input->post('shop_type',TRUE);
            $shop_address   = $this->input->post('shop_address');
            $shop_modified_date   = date("Y-m-d H:i:s");
            if($shop_type)
            {
                $data = array('user_id'=>$user_id,'shop_name'=>$shop_name,'shop_address'=>$shop_address,'shop_db_name'=>$shopDBName,'shop_modified_date'=>$shop_modified_date);

                $update = $this->msm->updateShopDetails($data);
                if($update)
                {
                    $this->db->where('shop_id',$shop_id);
                    $delete=$this->db->delete('shop_detail_type');
                    if($delete)
                    {
                        $result = array();
                        foreach($shop_type AS $key => $val){
                            $result[] = array(
                                'shop_type_id'   => $val,
                                'shop_id'   => $shop_id,
                            );
                        }

                        $query=$this->db->insert_batch('shop_detail_type', $result);
                        if($query)
                        {
                            $this->updateStoreDB($data,$shop_type,$shopId,$shop_id);
                            $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                            redirect('backend/MyShopController/storeInfo/'.$shopId);
                        }
                        else
                        {
                            $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                            redirect('backend/MyShopController/storeInfo/'.$shopId);
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                    }
                }
                else
                {
                    $this->session->set_flashdata('flashError', 'Something went wrong');
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
            }
            else
            {
                $data = array('user_id'=>$user_id,'shop_name'=>$shop_name,'shop_address'=>$shop_address,'shop_db_name'=>$shopDBName,'shop_modified_date'=>$shop_modified_date);

                $update = $this->msm->updateShopDetails($data);
                if($update)
                {
                    $this->updateStoreDB($data,$shop_type,$shopId);
                    $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
                else
                {
                    $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
            }
        }
    }

    public function updateStoreDB($data,$shop_type,$shopId,$shop_id)
    {
        $this->dbConnection($shopId);
        if($shop_type)
        {
            $update = $this->msm->updateShopDetails($data);
            if($update)
            {
                $this->db->where('shop_id',$shop_id);
                $delete=$this->db->delete('shop_detail_type');
                if($delete)
                {
                    $result = array();
                    foreach($shop_type AS $key => $val){
                        $result[] = array(
                            'shop_type_id'   => $val,
                            'shop_id'   => $shop_id,
                        );
                    }

                    $query=$this->db->insert_batch('shop_detail_type', $result);
                    if($query)
                    {
                        $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                    }
                    else
                    {
                        $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                    }
                }
                else
                {
                    $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/storeInfo/'.$shopId);
            }
        }
        else
        {
            $update = $this->msm->updateShopDetails($data);
        }
    }
    
    public function configureStore($shopId='')
    {
        $data['shopData']=$this->msm->getShopDetailsById($shopId);
        $data['shopType']=$this->msm->fetchShopType();
        //$data['main_content']='backend/myshops/configureStore';
        $data['main_content']='backend/myshops/strConfigure';
        $this->load->view('backend/include/template', $data);
    }
    
    public function continueWithoutProductUpload($shopId)
    {
        $editStrInfo=$this->input->post('editStrInfo');
        $notuploadedbycustomer='notuploadedbycustomer';
        $phamra=$this->input->post('pharma');
        if(!empty($phamra))
        {
            $this->db->where('shopId',$shopId);
            $updated=$this->db->update('shop_details',array('upload_status'=>$notuploadedbycustomer,'pharma_status'=>1));
            if($updated)
            {
                if($editStrInfo)
                {
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
                else
                {
                    redirect('backend/MyShopController/viewProductsByShopId/'.$shopId.'/'.$notuploadedbycustomer);
                }
            }
            else
            {
                if($editStrInfo)
                {
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
                else
                {
                    redirect('backend/MyShopController/configureStore/'.$shopId);
                }
            }
        }
        else{
            $this->db->where('shopId',$shopId);
            $updated=$this->db->update('shop_details',array('upload_status'=>$notuploadedbycustomer,'pharma_status'=>0));
            if($updated)
            {
                if($editStrInfo)
                {
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
                else
                {
                    redirect('backend/MyShopController/viewProductsByShopId/'.$shopId.'/'.$notuploadedbycustomer);
                }
            }
            else
            {
                if($editStrInfo)
                {
                    redirect('backend/MyShopController/storeInfo/'.$shopId);
                }
                else
                {
                    redirect('backend/MyShopController/configureStore/'.$shopId);
                }
            }
        }
    }
    
    public function updatePharmaStatus($shopId)
    {
        $pharmaYes=$this->input->post('pharmaYes');
        
        $editStrInfo=$this->input->post('editStrInfo');
        
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('pharma_status'=>$pharmaYes));
        if($updated)
        {
            if($editStrInfo)
            {
                redirect('backend/MyShopController/storeInfo/'.$shopId);
            }
            else
            {
                redirect('backend/MyShopController/viewProductsByShopId/'.$shopId.'/'.$pharmaYes);
            }
        }
        else
        {
            if($editStrInfo)
            {
                redirect('backend/MyShopController/storeInfo/'.$shopId);
            }
            else
            {
                redirect('backend/MyShopController/configureStore/'.$shopId);
            } 
        }
    }
    
    public function strProductConfig($shopId,$datafrombaseDB)
    {
        $phamra=$this->input->post('pharma');
        if(!empty($phamra))
        {
            $this->db->where('shopId',$shopId);
            $this->db->update('shop_details',array('upload_status'=>'Uploaded from base DB','pharma_status'=>1));
        }
        else
        {
            $this->db->where('shopId',$shopId);
            $this->db->update('shop_details',array('upload_status'=>'Uploaded from base DB','pharma_status'=>0));
        }
        $data['shopId']=$shopId;
        $data['shopData']=$this->msm->getShopDetailsById($shopId);
        $data['shopType']=$this->msm->fetchShopType();
        $data['baseProducts']=$this->msm->getBaseDBProducts();
        $data['main_content']='backend/myshops/strProductConfig';
        $this->load->view('backend/include/template', $data);
    }
    
    public function editStrProductConfig($shopId,$datafrombaseDB)
    {
        $this->db->where('shopId',$shopId);
        $this->db->update('shop_details',array('upload_status'=>'Uploaded from base DB'));
        $data['shopId']=$shopId;
        $data['shopData']=$this->msm->getShopDetailsById($shopId);
        $data['shopType']=$this->msm->fetchShopType();
        $data['baseProducts']=$this->msm->getBaseDBProducts();
        $data['main_content']='backend/myshops/editStrProductConfig';
        $this->load->view('backend/include/template', $data);
    }

    public function fetchBaseProductsById()
    {
        $id = $this->input->post('id');
        if($id)
        {
            $result = $this->msm->fetchBaseProductsById($id);
            echo json_encode($result);
        }
    }
    
    public function fetchBaseProducts()
    {
        $this->db->select('bp.base_product_id,bp.category,bp.sub_category,bp.brand,bp.product_name,bp.product_type,bp.product_sub_type,bp.product_description,bp.product_weight,bp.product_weight_type,bp.product_qty,bp.product_price,bp.offer_price,bp.product_img');//columns
        $this->db->from('base_products as bp');
        $query=$this->db->get()->result();
        
        echo json_encode($query);
    }
    
    public function fetchStrTempProducts($storeId)
    {
        $this->db->select('tsc.temp_str_config_id ,tsc.category,tsc.sub_category,tsc.brand,tsc.product_name,tsc.product_type,tsc.product_sub_type,tsc.product_description,tsc.product_weight,tsc.product_weight_type,tsc.product_qty,tsc.product_price,tsc.offer_price,tsc.product_img,tsc.product_status');//columns
        $this->db->from('temp_str_config as tsc')->where('temp_shopId',$storeId);
        $query=$this->db->get()->result();
        echo json_encode($query);
    }

    public function  checkBaseProductInTemp($storeId)
    { 
        if($storeId)
        {  
            $this->db->where('temp_shopId',$storeId);
            $result = $this->db->delete('temp_str_config');
            if($result)
            {
                echo 1;    
            }
            else
            {
                echo 0;   
            }  
        }         
    }

    public function checkStrBaseProductInTemp($shopId)
    {
        $this->dbConnection($shopId);
        if($this->input->post('shopId'))
        {  
            $this->db->where('temp_shopId',$shopId);
            $result = $this->db->delete('temp_str_config');
            if($result)
            {
                echo 1;    
            }
            else
            {
                echo 0;   
            }  
        }   
    }

    public function saveBaseProductsToTemp()
    {
        $user_id=$this->session->userdata('id');
        $storeid= json_decode($this->input->post('storeid'));
        $cat= json_decode($this->input->post('cat'));
        $subcat= json_decode($this->input->post('subcat')); 
        $brand= json_decode($this->input->post('brand'));
        $productName= json_decode($this->input->post('productName'));
        $productType= json_decode($this->input->post('productType'));
        $productSubType= json_decode($this->input->post('productSubType'));
        $productDescription= json_decode($this->input->post('productDescription'));
        $productWeight= json_decode($this->input->post('productWeight'));
        $productWeightType= json_decode($this->input->post('productWeightType'));
        $productQty= json_decode($this->input->post('productQty'));
        $productPrice= json_decode($this->input->post('productPrice'));
        $offerPrice= json_decode($this->input->post('offerPrice'));
        $productImg= json_decode($this->input->post('productImg'));
        $sku= 'DB-'.$cat.$subcat.$brand.$productName.$productType.$productSubType.$productWeight.$productWeightType;
        $added_date=date('Y-m-d: H:i:s');

        
        $data=array(
            'user_id'=>$user_id,
            'temp_shopId'=> $storeid,
            'db_SKU'=> $sku,
            'category'=> $cat,
            'sub_category'=> $subcat,
            'brand'=> $brand,
            'product_name'=> $productName,
            'product_type'=> $productType,
            'product_sub_type'=> $productSubType,
            'product_description'=> $productDescription,
            'product_weight'=> $productWeight,
            'product_weight_type'=> $productWeightType,
            'product_qty'=> $productQty,
            'product_price'=> $productPrice,
            'offer_price'=> $offerPrice,
            'product_img'=> $productImg, 
            'product_added_date'=> $added_date,
        );
        $result= $this->db->insert('temp_str_config',$data);
        if($result)
        {
            echo  1;    
        }
        else
        {
            echo  0;    
        }
    }

    public function saveBaseProductsToStrTemp($shopId)
    {
        $this->dbConnection($shopId);
        $user_id=$this->session->userdata('id');
        //$sku= json_decode($this->input->post('sku'));
        $cat= json_decode($this->input->post('cat'));
        $subcat= json_decode($this->input->post('subcat')); 
        $brand= json_decode($this->input->post('brand'));
        $productName= json_decode($this->input->post('productName'));
        $productType= json_decode($this->input->post('productType'));
        $productSubType= json_decode($this->input->post('productSubType'));
        $productDescription= json_decode($this->input->post('productDescription'));
        $productWeight= json_decode($this->input->post('productWeight'));
        $productWeightType= json_decode($this->input->post('productWeightType'));
        $productQty= json_decode($this->input->post('productQty'));
        $productPrice= json_decode($this->input->post('productPrice'));
        $offerPrice= json_decode($this->input->post('offerPrice'));
        $productImg= json_decode($this->input->post('productImg'));
        $sku= 'DB-'.$cat.$subcat.$brand.$productName.$productType.$productSubType.$productWeight.$productWeightType;
        $added_date=date('Y-m-d: H:i:s');
        
        $data=array(
            'user_id'=>$user_id,
            'temp_shopId'=> $shopId,
            'db_SKU'=> $sku,
            'category'=> $cat,
            'sub_category'=> $subcat,
            'brand'=> $brand,
            'product_name'=> $productName,
            'product_type'=> $productType,
            'product_sub_type'=> $productSubType,
            'product_description'=> $productDescription,
            'product_weight'=> $productWeight,
            'product_weight_type'=> $productWeightType,
            'product_qty'=> $productQty,
            'product_price'=> $productPrice,
            'offer_price'=> $offerPrice,
            'product_img'=> $productImg, 
            'store_SKU'=> 0,
            'hide_product'=>0,
            'product_added_date'=> $added_date,
            'product_status'=> 0,
            'demo_products'=>0,
        );
        $result= $this->db->insert('temp_str_config',$data);
        if($result)
        {
            echo  1;    
        }
        else
        {
            echo  0;    
        }
    }
    
    public function countInsertedRow()
    {
        $shopId=$this->input->post('shopId');
        $this->db->where('temp_shopId',$shopId);
        $result = $this->db->count_all_results('temp_str_config');
        if($result)
        {
            echo json_encode($result);    
        }
        else
        {
            echo 0;   
        }  
    }
    
    public function updateBaseProduct()
    {
        $user_id=$this->session->userdata('id');
        // $storeid= $this->input->post('storeid');
        $id= $this->input->post('id');
        $cat= $this->input->post('cat');
        $subcat= $this->input->post('subcat'); 
        $brand= $this->input->post('brand');
        $productName= $this->input->post('productName');
        $productType= $this->input->post('productType');
        $productSubType= $this->input->post('productSubType');
        $productDescription= $this->input->post('productDescription');
        $productWeight= $this->input->post('productWeight');
        $productWeightType= $this->input->post('productWeightType');
        $productQty= $this->input->post('productQty');
        $productPrice= $this->input->post('productPrice');
        $offerPrice= $this->input->post('offerPrice');
        $productImg= $this->input->post('productImg');

        
        $data=array(
            // 'user_id'=>$user_id,
            // 'temp_shopId'=> $storeid,
            'db_SKU'=> 'DB-'.$cat.$subcat.$brand.$productName.$productType.$productSubType.$productWeight.$productWeightType,
            'category'=> $cat,
            'sub_category'=> $subcat,
            'brand'=> $brand,
            'product_name'=> $productName,
            'product_type'=> $productType,
            'product_sub_type'=> $productSubType,
            'product_description'=> $productDescription,
            'product_weight'=> $productWeight,
            'product_weight_type'=> $productWeightType,
            'product_qty'=> $productQty,
            'product_price'=> $productPrice,
            'offer_price'=> $offerPrice,
            'product_img'=> $productImg, 
            'product_added_date'=> $added_date,
        );
        
        $this->db->where('temp_str_config_id ',$id);
        $result= $this->db->update('temp_str_config',$data);
        if($result)
        {
            echo  1;    
        }
        else
        {
            echo  0;    
        }
    }
    
    public function fetchStrProducts()
    {
        $shopId = $this->input->post('storeId');
        if($shopId)
        {
            $result = $this->msm->getTempShopProducts($shopId);
            echo json_encode($result);
        }
    }

    public function viewProductsByShopId($shopId,$datafrombaseDB='')
    {
        $data['proConfig']='datafrombaseDB';
        $data['shopId']=$shopId;
        $data['shopData']=$this->msm->getShopDetailsById($shopId);
        $data['shopType']=$this->msm->fetchShopType();
        $data['baseProducts']=$this->msm->getBaseDBProducts();
        $data['shopProducts']=$this->msm->getTempShopProducts($shopId);
        // $data['main_content']='backend/myshops/viewProductsByShopId';
        $data['main_content']='backend/myshops/strProducts';
        $this->load->view('backend/include/template', $data);
    }
    
    public function storeSummary($shopId,$datafrombaseDB='')
    {
        $data['proConfig']='datafrombaseDB';
        $data['shopId']=$shopId;
        $data['shopData']=$this->msm->getShopDetailsById($shopId);
        $data['shopType']=$this->msm->fetchShopType();
        $data['shopSummary']=$this->msm->getStoreSummary($shopId);
        $data['shopSummaryType']=$this->msm->getStoreSummaryType($shopId);
        $data['productCount']=$this->msm->getCountofProducts($shopId);
        $data['shopProducts']=$this->msm->getTempShopProducts($shopId);

        // $data['main_content']='backend/myshops/storeSummary';
        $data['main_content']='backend/myshops/strSummary';
        $this->load->view('backend/include/template', $data);
    }

    public function saveStoreSummary($shopId)
    {
        $editStrInfo=$this->input->post('editStrInfo');
        $productUpdate_status=$this->input->post('productUpdates');
        $this->db->where('shopId',$shopId);
        $update=$this->db->update('shop_details',array('productUpdate_status'=>$productUpdate_status,'shop_status'=>1));
        if($update)
        {
            if($editStrInfo)
            {
                $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                redirect('backend/MyShopController/storeInfo/'.$shopId);
            }else{
                $this->session->set_flashdata('flashSuccess', 'Saved Successfully.');
                redirect('backend/MyShopController/congratulations/'.$shopId);
            }
        }
        else
        {
            if($editStrInfo)
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/storeInfo/'.$shopId);
            }else{
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/index');
            }
        }
    }

    public function activateTrailPeriod($shopId)
    {
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('shop_payment_amount'=>0,'shop_payment_date'=>date("Y-m-d H:i:s"),'shop_exp_date'=>date('Y-m-d H:i:s', strtotime('+3 months')),'trial_activate'=>1,'shop_status'=>1,'shop_payment_status'=>1));
        if($updated)
        {
            $this->db->where('id',$this->session->userdata('id'));
            $updateSuccess=$this->db->update('tbl_user',array('trail_activate'=>1));
            if($updateSuccess)
            {
                $ip_server = $_SERVER['SERVER_ADDR'];
                $cPanel = new cPanel("direcbuy", "Default!@#123", $ip_server);
          
                // Check the example_test database.
                $check_db = $cPanel->uapi(
                    'Mysql', 'check_database',
                    array(
                        'name'       => "direcbuy_".$shopId,
                    )
                );
                if($check_db->status == 0 )
                {
                    $dbsuccess=$this->createDatabase($shopId);
                    $this->session->set_flashdata('flashSuccess', 'Trail period activated');
                    redirect('backend/MyShopController/congratulations/'.$shopId);
                }
                else
                {
                    $this->session->set_flashdata('flashSuccess', 'Trail period activated');
                    redirect('backend/MyShopController/congratulations/'.$shopId);
                }
                
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/storeSummary/'.$shopId);
            }
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            redirect('backend/MyShopController/storeSummary/'.$shopId);
        }
    }
    
    public function congratulations($shopId)
    {
        $data['shopId']=$shopId;
        $data['shopSummary']=$this->msm->getStoreSummary($shopId);
        $data['main_content']='backend/myshops/strCreated';
        $this->load->view('backend/include/template', $data);
    }
    
    public function createDatabase($shopId)
    {
        $shopDB ='direcbuy_'.$shopId;
        $ip_server = $_SERVER['SERVER_ADDR'];
        $cPanel = new cPanel("direcbuy", "Default!@#123", $ip_server);
        
        //Create a new database.
        $create_db = $cPanel->uapi(
            'Mysql', 'create_database',
            array(
                'name'    => $shopDB,
            )
        );
        if($create_db)
        {
            $create_db_user = $cPanel->uapi(
                'Mysql', 'create_user',
                array(
                    'name'       => "direcbuy_directbuy",
                    'password'   => 'Default!@#123',
                )
            );
            
            if($create_db_user)
            {
                $set_dbuser_privs = $cPanel->uapi(
                    'Mysql', 'set_privileges_on_database',
                    array(
                        'user'       => "direcbuy_directbuy",
                        'database'   => $shopDB,
                        'privileges' => 'ALL PRIVILEGES',
                    )
                );
                if($set_dbuser_privs)
                {
                    $this->copyTables($shopDB);
                    // redirect('backend/MyShopController/index');
                }
            }
        }
    }
    
    public function copyTables($shopDB)
    {
        $shop_DB=explode("direcbuy_",$shopDB);
        $data['shopId'] = $shop_DB[1];
        $data['db2'] = $shopDB;
        $this->load->view('backend/createTable',$data);
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
    

    //shop details page start
    public function myShop($shopId)
    {
        $ip_server = $_SERVER['SERVER_ADDR'];
        $cPanel = new cPanel("direcbuy", "Default!@#123", $ip_server);
  
        // Check the example_test database.
        $check_db = $cPanel->uapi(
            'Mysql', 'check_database',
            array(
                'name'       => "direcbuy_".$shopId,
            )
        );
        if($check_db->status == 0 )
        {
            $this->session->set_flashdata('flashError', 'No Database found');
            redirect('backend/MyShopController/index');
        }
        else
        {
            $this->dbConnection($shopId);
            $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
            $data['fetchdatabyid']=$this->msm->fetchShopName($shopId);
            // $data['gst']=$this->msm->fetchGST($shopId);
            
            $shpId=$data['fetchdatabyid']->shopId;
            $data['shopProducts']=$this->msm->getShopProducts();
            $data['shopCustPendingOrders']=$this->msm->fetchCustomerPendingOrder();
            $data['shopCustOrders']=$this->msm->fetchCustomerCompletedOrders();
            $data['shopPaymentData']=$this->msm->fetchShopPaymentDetails($shpId);
            $data['main_content']='backend/myshops/myShop';
            $this->load->view('backend/include/template', $data);
        }
    }

    //Data migration
    public function migrateMultiData($shopId)
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['fetchdatabyid']=$this->msm->fetchShopName($shopId);
        $data['category'] = $this->msm->fetchCategory();
        $data['main_content']='backend/myshops/migrateMultiData';
        $this->load->view('backend/include/template', $data);
    }

    public function migrateMultiDataToStoreDb($shopId)
    {
        $categoryId   = $this->input->post('categoryId',TRUE);
        $this->db->where_in('categoryId',$categoryId);
        $q = $this->db->get('category')->result();
        $this->db->where_in('product_category_id',$categoryId);
        $qs = $this->db->get('tbl_products')->result();
        $this->moveCategory($q,$qs,$shopId);
        $this->session->set_flashdata('flashSuccess', 'Migration Successful.');
        redirect('backend/MyShopController/myShop/'.$shopId);
    }

    public function moveCategory($q,$qs,$shopId)
    {
        $this->dbConnection($shopId);
        foreach($q as $r) 
        { // loop over results
            $this->db->insert('category', $r);
        }
        foreach($qs as $rs) 
        { // loop over results
            $this->db->insert('tbl_products', $rs);
        }
    }
    
    //Store orders
    public function pendingOrderDetails($order_code,$shopId)
    {
        $this->dbConnection($shopId);
        $data['shopId'] = $shopId;
        $data['pendingOrders'] = $this->msm->fetchCustomerPendingOrderDetails($order_code);
        $data['orderData'] = $this->msm->fetchCustomerPendingOrderByCode($order_code);
        $data['orderDataRow'] = $this->msm->fetchCustPendingOrderByCode($order_code);
        $data['main_content']='backend/myshops/pendingOrderDetails';
        $this->load->view('backend/include/template', $data);
    }
    
    // public function printData($order_code,$shopId)
    // {
    //     $this->dbConnection($shopId);
    //     $data['pendingOrders'] = $this->msm->fetchCustomerPendingOrderDetails($order_code);
    //     $data['orderData'] = $this->msm->fetchCustomerPendingOrderByCode($order_code);
        
    //     $data['main_content']='backend/myshops/printData';
    //     $this->load->view('backend/include/template', $data);
    // }
    
    public function printData($order_code,$shopId)
    {
        $this->dbConnection($shopId);
        $data['pendingOrders'] = $this->msm->fetchCustomerPendingOrderDetails($order_code);
        $data['orderData'] = $this->msm->fetchCustomerPendingOrderByCode($order_code);
        $data['orderDataRow'] = $this->msm->fetchCustPendingOrderByCode($order_code);
        $this->load->view('backend/myshops/printData', $data);
    }
    
    public function completedOrderDetails($order_code,$shopId)
    {
        $this->dbConnection($shopId);
        $data['shopId'] = $shopId;
        $data['completedOrders'] = $this->msm->fetchCustomerCompletedOrderDetails($order_code);
        $data['orderData'] = $this->msm->fetchCustomerCompletedOrderByCode($order_code);
        $data['orderDataRow'] = $this->msm->fetchCustPendingOrderByCode($order_code);
        $data['main_content']='backend/myshops/completedOrderDetails';
        $this->load->view('backend/include/template', $data);
    }

    public function updateCustomerOrder($shopId)
    {
        $this->dbConnection($shopId);
        if($this->input->post('orderAccept'))
        {
            $order_code=$this->input->post('order_code');
            $this->db->where('order_code',$order_code);
            $updated=$this->db->update('order_items',array('order_status'=>1));
            if($updated)
            {
                $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                redirect('backend/MyShopController/myShop/'.$shopId);
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Please Try again');
                redirect('backend/MyShopController/pendingOrderDetails/'.$order_code.'/'.$shopId);
            }
        }
    }

    //store setting start
    public function activateStore($shopId)
    {
        
        $this->db->where('shopId',$shopId);
        $update=$this->db->update('shop_details',array('shop_status' =>1));
        if($update)
        {
            $this->activateStoreDB($shopId);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/index/');
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function activateStoreDB($shopId)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $this->db->update('shop_details',array('shop_status' =>1));
    }

    public function deactivateStore($shopId)
    {
        
        $this->db->where('shopId',$shopId);
        $update=$this->db->update('shop_details',array('shop_status' =>2));
        if($update)
        {
            $this->deactivateStoreDB($shopId);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/index/');
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function deactivateStoreDB($shopId)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $this->db->update('shop_details',array('shop_status' =>2));
    }

    public function send_otp()
    {
        $result=$this->db->select('email')
        ->from('tbl_user')
        ->where('email',$this->input->post('email'))
        ->get()->row();
        
        if(isset($result))
        {
            $email   = $this->input->post('email');
            $shopId   = $this->input->post('shopId');
            $rndno      = rand(100000, 999999);
            $message    = 'The One Time Password for your account is ' .$rndno. '. - Regards, Direct-buy';

            $this->db->where('email',$email);
            $res=$this->db->update('tbl_user',array('otp'=>$rndno));
            if($res)
            {
                $this->updateOTPInShopDB($shopId,$email,$rndno);
            }
            
            $subject = 'Verify Email';

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
            $this->email->from("info@direct-buy.in",'Direct-buy');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);

            if($this->email->send())
            {
                echo 'OTP Sent Successfully!!!';
            }
            else
            {
                show_error($this->email->print_debugger());
                redirect('backend/MyShopController/myShop/'.$shopId);
            }
        }
        else{
            echo "0";
        }

    }

    public function updateOTPInShopDB($shopId,$email,$rndno)
    {
        $this->dbConnection($shopId);
        $this->db->where('email',$email);
        $this->db->update('tbl_user',array('otp' =>$rndno));
    }

    public function deleteStore($shopId)
    {
        $email= $this->input->post('email');
        $otp= $this->input->post('otp');

        $ceklogin=$this->msm->verifyOTP($otp,$email);

        if($ceklogin)
        {
            $this->db->where('shopId',$shopId);
            $update=$this->db->update('shop_details',array('remove_shop' =>1));
            if($update)
            {
                $this->deleteStoreDB($shopId);
                $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                redirect('backend/MyShopController/index/');
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/myShop/'.$shopId);
            }
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Wrong OTP');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function deleteStoreDB($shopId)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $this->db->update('shop_details',array('remove_shop' =>1));
    }
    
    public function paymentSettingByStore($shopId)
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['fetchdatabyid']=$this->msm->fetchShopName($shopId);
        $data['paymentData']=$this->msm->fetchPaymentDetailsById($shopId);
        // echo '<pre>';
        // print_r($data['paymentData']);
        // echo '</pre>';
        // die();
        $data['main_content']='backend/myshops/paymentSettingByStore';
        $this->load->view('backend/include/template', $data);
    }
    
    public function updateStoreInfo()
    {
        $user_id = $this->session->userdata('id');
        $shopId   = $this->input->post('shopId');
        $shop_name   = $this->input->post('shop_name');
        $shop_type   = $this->input->post('shop_type');
        $shop_gst   = $this->input->post('shop_gst');
        $shop_address   = $this->input->post('shop_address');
        $shop_modified_date   = date("Y-m-d H:i:s");

        $data = array('user_id'=>$user_id,'shop_name'=>$shop_name,'shop_gst'=>$shop_gst,'shop_address'=>$shop_address,'shop_modified_date'=>$shop_modified_date);
        $this->db->where('shopId',$shopId);
        $update = $this->db->update('shop_details',$data);
        if($update)
        {
            $this->db->where('id',$user_id);
            $res=$this->db->update('tbl_user',array('gst'=>$shop_gst));
            if($res)
            {
                $this->updateStoreInfoInStoreDB($data,$shopId,$user_id,$shop_gst);
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
    
    public function updateStoreInfoInStoreDB($data,$shopId,$user_id,$shop_gst)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $update = $this->db->update('shop_details',$data);
        if($update)
        {
            $this->db->where('id',$user_id);
            $res=$this->db->update('tbl_user',array('gst'=>$shop_gst));
        }
    }

    public function saveShopPaymentDetails()
    {
        $pInfo_userId = $this->session->userdata('id');
        $pInfo_shopId   = $this->input->post('shopId');
        $pInfo_paymentId   = $this->input->post('payment_id');
        $pInfo_added_date   = date("Y-m-d H:i:s");

        $this->db->where('pInfo_shopId',$pInfo_shopId);
        $this->db->where('pInfo_paymentId',$pInfo_paymentId);
        $query=$this->db->get('shop_payment_info')->result();
        
        
        if(empty($query))
        {
            $data = array('pInfo_userId'=>$pInfo_userId,'pInfo_shopId'=>$pInfo_shopId,'pInfo_paymentId'=>$pInfo_paymentId,'pInfo_status'=>1,'pInfo_added_date'=>$pInfo_added_date,'demo_shop_payment'=>1);
            $insert = $this->db->insert('shop_payment_info',$data);
            if($insert)
            {
                $this->session->set_flashdata('flashSuccess', 'Inserted Successfully.');
                redirect('backend/MyShopController/myShop/'.$pInfo_shopId);
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/myShop/'.$pInfo_shopId);
            }
        }
        else
        {
            $data = array('pInfo_userId'=>$pInfo_userId,'pInfo_shopId'=>$pInfo_shopId,'pInfo_paymentId'=>$pInfo_paymentId,'pInfo_added_date'=>$pInfo_added_date,'demo_shop_payment'=>1);
            $this->db->where('pInfo_shopId',$pInfo_shopId);
            $this->db->where('pInfo_paymentId',$pInfo_paymentId);
            $update = $this->db->update('shop_payment_info',$data);
            if($update)
            {
                $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
                redirect('backend/MyShopController/myShop/'.$pInfo_shopId);
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/myShop/'.$pInfo_shopId);
            }
        }
        
    }
    
    public function is_active($shopId)
    {
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('home_delivery' =>0));
        if($updated)
        {
            $this->is_activeInStrDB($shopId);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function is_activeInStrDB($shopId)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('home_delivery' =>0));
        if($updated)
        {
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function in_active($shopId)
    {
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('home_delivery' =>1));
        if($updated)
        {
            $this->in_activeInStrDB($shopId);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function in_activeInStrDB($shopId)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('home_delivery' =>1));
        if($updated)
        {
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function updateMinOrderVal($shopId)
    {
        $min_order_val   = $this->input->post('min_order_val');
        $this->db->where('shopId',$shopId);
        $res=$this->db->update('shop_details',array('min_order_val'=>$min_order_val));
        if($res)
        {
            $this->updateMinOrderValInStrDB($shopId,$min_order_val);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
        else
        {
            $this->session->set_flashdata('flashSuccess', 'Something went wrong');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }

    public function updateMinOrderValInStrDB($shopId,$min_order_val)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $res=$this->db->update('shop_details',array('min_order_val'=>$min_order_val));
        if($res)
        {
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
        else
        {
            $this->session->set_flashdata('flashSuccess', 'Something went wrong');
            redirect('backend/MyShopController/myShop/'.$shopId);
        }
    }
    
    //Communication tab code
    public function updateStrMsg()
    {
        $user_id = $this->session->userdata('id');
        $store_message=$this->input->post('store_message');
        
        $data = array('str_msg'=>$store_message);
        $this->db->where('id',$user_id);
        $update = $this->db->update('tbl_user',$data);
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
    
    public function googlePay()
    {
        $data['main_content']='backend/googlePayNew';
        $this->load->view('backend/googlePayNew');
    }

}
