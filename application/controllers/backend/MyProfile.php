<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MyProfile extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('backend/MyProfileModel','mpm');
		$this->load->model('backend/MyShopModel','msm');
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

    public function myprofile()
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
    	$data['main_content']='backend/auth/profile';
        $this->load->view('backend/include/template', $data);
    }
    
    public function editProfile()
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/auth/editProfile';
        $this->load->view('backend/include/template', $data);
    }

    public function updateProfile()
    {
        $config['upload_path'] = "assets1/uploads"; //path folder
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //Allowing types
        $config['encrypt_name'] = False; //encrypt file name 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        

        if(!empty($_FILES['comp_logo']['name'])){
 
            if ($this->upload->do_upload('comp_logo'))
            {
                $data   = $this->upload->data();
                $image  = $data['file_name']; //get file name
                $update=$this->mpm->updateProfile($image);
                $this->uploadBaseFolder();
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }else
            {
                $error = ['error' => $this->upload->display_errors()];
                $this->session->set_flashdata('flashError', $error);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
                      
        }
        else
        {
            $data = array('firstname'=>$this->input->post('firstname'),'lastname'=>$this->input->post('lastname'),'contact'=>$this->input->post('contact'),'email'=>$this->input->post('email'),'password'=>$this->input->post('password'),'address'=>$this->input->post('address'));
            $this->db->where('id',$this->input->post('userid'));
            $insert_success=$this->db->update('tbl_user',$data);
            if($insert_success)
            {
                $this->session->set_flashdata('flashSuccess', 'Updated Successfully');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } 
    }
    
    public function uploadBaseFolder()
    {
        $config['upload_path'] = "../assets1/uploads";
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //Allowing types
        $config['encrypt_name'] = False; //encrypt file name 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        
        if(!empty($_FILES['comp_logo']['name'])){
 
            if ($this->upload->do_upload('comp_logo'))
            {
                $data   = $this->upload->data();
            }else
            {
                $error = ['error' => $this->upload->display_errors()];
                $this->session->set_flashdata('flashError', $error);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
                      
        }
    }
    
    public function changePassword($id)
    {
        $data['id'] = $id;
        $data['main_content']='backend/auth/changePassword';
        $this->load->view('backend/include/template', $data);
    }

    public function updatePassword()
    {
        $id=$this->input->post('id');
        $old_password=$this->input->post('old_password');
        $new_password=$this->input->post('new_password');
        $this->db->where('id',$id);
        $this->db->where('password',$old_password);
        $updated=$this->db->update('tbl_user',array('password'=>$new_password));
        $this->session->set_flashdata('flashSuccess', 'Updated Successfully');
        if($updated)
        {
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully');
            $this->close_method();
            //redirect('backend/MyProfile/myprofile');
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Password doesnt match');
            $this->close_method();
            //redirect('backend/MyProfile/myprofile');
        }
    }

    public function close_method(){
        echo  "<script type='text/javascript'>";
        echo "window.close();";
        echo "</script>";
    }

    public function myaccount()
    {
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['shopDetails']=$this->msm->fetchShopDetails();
        $data['main_content']='backend/auth/myaccount';
        $this->load->view('backend/include/template', $data);
    }
    
    public function reActivateShop($shopId)
    {
        $this->db->where('shopId',$shopId);
        $update=$this->db->update('shop_details',array('shop_status' =>1));
        if($update)
        {
            $this->reActivateStoreDB($shopId);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully.');
            redirect('backend/MyProfile/myaccount');
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            redirect('backend/MyProfile/myaccount');
        }
    }

    public function reActivateStoreDB($shopId)
    {
        $this->dbConnection($shopId);
        $this->db->where('shopId',$shopId);
        $this->db->update('shop_details',array('shop_status' =>1));
    }
    
    public function activateTrailPeriod($shopId)
    {
        $data['shopSummary']=$this->msm->getStoreSummary($shopId);
        $shopDBName=$data['shopSummary']->shop_db_name;
        $this->db->where('shopId',$shopId);
        $updated=$this->db->update('shop_details',array('shop_payment_amount'=>0,'shop_payment_date'=>date("Y-m-d H:i:s"),'shop_exp_date'=>date('Y-m-d H:i:s', strtotime('+3 months')),'shop_payment_status'=>1));
        if($updated)
        {
            $this->db->where('id',$this->session->userdata('id'));
            $updateSuccess=$this->db->update('tbl_user',array('trail_activate'=>1));
            if($updateSuccess)
            {
                //$dbsuccess=$this->createDatabase($shopDBName);
                $this->session->set_flashdata('flashSuccess', 'Trail period activated');
                redirect('backend/MyShopController/congratulations/'.$shopId);
            }
            else
            {
                $this->session->set_flashdata('flashError', 'Something went wrong');
                redirect('backend/MyShopController/congratulations/'.$shopId);
            }
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            redirect('backend/MyShopController/storeSummary/'.$shopId);
        }
    }
    
    public function saveGST()
    {
        
        $userid=$this->input->post('userid');
        $gst=$this->input->post('shop_gst');
        $this->db->where('id',$userid);
        $res=$this->db->update('tbl_user',array('gst'=>$gst));

        if($res)
        {
            //$this->updateGSTInStrDB($gst,$userid);
            $this->session->set_flashdata('flashSuccess', 'Updated Successfully');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Something went wrong');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        
    }
    
    // public function updateGSTInStrDB($gst,$userid)
    // {
        
    // }
}
