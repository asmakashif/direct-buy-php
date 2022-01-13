<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('backend/MyProfileModel','mpm');
		$this->load->model('backend/MyShopModel','msm');
		$this->load->model('backend/PaymentModel','pm');
		$this->load->model('AdminModel','am');
		$this->load->helper('form');
		$this->load->library('session');
        $this->load->library('form_validation');
		date_default_timezone_set("Asia/Kolkata");
	}

    public function index()
    {
        $data = explode('.',$_SERVER['SERVER_NAME']);
        $this->db->where('domainname',$data[0]);
        $data['userData'] = $this->db->get('tbl_user')->row();
        $this->load->view('backend/auth/login',$data);
    }
    
    public function auth()
	{
	    $this->form_validation->set_rules('domainname','Domain','required');
        $this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');

        $domainname=$this->input->post('domainname');
        $email=$this->input->post('email');
        $password=$this->input->post('password');
        
        
        $ceklogin=$this->am->login($email,$password,$domainname);
        if($ceklogin)
        {
            foreach($ceklogin as $row);

            $userdata=array();
            $userdata['id']=$row->id;
            $userdata['domainname']=$row->domainname;
            $userdata['firstname']=$row->firstname;
            $userdata['lastname']=$row->lastname;
            $userdata['contact']=$row->contact;
            $userdata['password']=$row->password;
            $userdata['email']=$row->email;
            $userdata['verify_email']=$row->verify_email;
            $userdata['is_logged_in'] = TRUE ;
            
            $this->session->set_userdata('ci_session_key_generate', TRUE);
            $this->session->set_userdata('ci_seesion_key', $userdata);
            
            $this->session->set_userdata($userdata);
           
            if(($row->verify_email)=='0')
            {
                $this->session->set_flashdata('flashError', 'Please verify email.!!!');
                redirect("Login");
            }
            else
            {
                if(!empty($this->input->post("remember"))) {
                    setcookie ("domainName", $domainname, time()+ (86400 * 30));  
                    // setcookie ("loginId", $email, time()+ (10 * 365 * 24 * 60 * 60));  
                    setcookie ("loginId", $email, time()+ (86400 * 30)); 
                    setcookie ("loginPass", $password,  time()+ (86400 * 30));
                } else {
                    setcookie ("domainName",""); 
                    setcookie ("loginId",""); 
                    setcookie ("loginPass","");
                }
                
	            $user_id=$this->session->userdata('id');
	            $this->db->where('id',$user_id);
	            $cartdata=array('verify_email'=>1,'login_status'=>'on');
	            $this->db->update('tbl_user',$cartdata);

	            $this->session->set_flashdata('flashSuccess', 'Login Successful');
	            redirect("backend/MyShopController/index");
	            
	        }
        }
        else
        {
            $this->session->set_flashdata('flashError', 'Incorrect combination of domainname/username/password');
            redirect('Login');
        }
    }
    
    public function dashboard()
    {
        $data['shopDetails']=$this->msm->fetchShopDetails();
        $data['paymentDetails']=$this->pm->fetchPaymentDetails();
        $data['userData'] = $this->mpm->fetchUserData($this->session->userdata('id'));
        $data['main_content']='backend/include/main_content';
        $this->load->view('backend/include/template', $data);
    }
    
    public function logout()
    {
        $this->session->unset_userdata('userdata');
        $this->session->sess_destroy();
        redirect('Login');
    }
}
