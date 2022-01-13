<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('mainHelper');
        $this->load->model('frontend/CustomerModel','cm');
        $this->load->library('session');

   }
        public function index()
        {
            $url = explode('.',$_SERVER['SERVER_NAME']);
            $domain=$url[0];
            $data['logo']=$this->cm->getLogo($domain);
            include_once APPPATH . "libraries/vendor/autoload.php";
            $google_client = new Google_Client();
$google_client->setClientId('620394351683-gm7tu4fheks0otb16pucbbiftnos7ld1.apps.googleusercontent.com'); //Define your ClientID
$google_client->setClientSecret('GIm1X6UwVrJkAgBfTaev9ZME'); //Define your Client Secret Key
$google_client->setRedirectUri('https://'.$domain.'.direct-buy.in/welcome'); //Define your Redirect Uri
$google_client->addScope('email');
$google_client->addScope('profile');
if(isset($_GET["code"]))
{
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if(!isset($token["error"]))
    {
        $google_client->setAccessToken($token['access_token']);
        $this->session->set_userdata('access_token', $token['access_token']);
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();
        $current_datetime = date('Y-m-d H:i:s');
        if($this->cm->Is_already_register($data['id']))
        {
//update data
            $userdata = array(
                'login_oauth_uid' => $data['id'],
                'firstname'  => $data['given_name'],
                'lastname'   => $data['family_name'],
                'email'  => $data['email'],
                'password'=>'null',
                'mobile'=>'Not Available',
                'login_status'=>'on',
                'registered_date'  => $current_datetime
            );

            $this->cm->Update_user_data($userdata, $data['id']);
            $user_id=$this->cm->getUserIdByGmailtoken($data['id']);
            $this->session->set_userdata('id',  $user_id->id);
            $this->session->set_userdata('is_logged_in',  'TRUE');
        }
        else
        {
//insert data
            $userdata = array(
                'login_oauth_uid' => $data['id'],
                'firstname'  => $data['given_name'],
                'lastname'   => $data['family_name'],
                'email'  => $data['email'],
                'password'=>'null',
                'mobile'=>'Not Available',
                'login_status'=>'on',
                'registered_date'  => $current_datetime
            );
            $this->cm->Insert_user_data($userdata);
        }
        $this->session->set_userdata('userdata', $userdata);
        $user_id=$this->cm->getUserIdByGmailtoken($data['id']);
        $this->session->set_userdata('id',  $user_id->id);
        $this->session->set_userdata('is_logged_in',  'TRUE');
        redirect('welcome/select_store');
    }
}
$login_button = '';
if(!$this->session->userdata('access_token'))
{
    $login_button = '<a href="'.$google_client->createAuthUrl().'"><img style=" margin:0px" src="'.base_url().'assets/images/gmail.png" /></a>';
    $data['login_button'] = $login_button;
    $data['main_content']='frontend/login';
    $this->load->view('frontend/include/template', $data);
}
else
{
    $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="'.base_url().'assets/images/gmail.png" /></a>';
    $data['login_button'] = $login_button;
    $data['main_content']='frontend/login';
    $this->load->view('frontend/include/template', $data);
} 
}

public function register()
{
    $data['main_content']='frontend/register';
    $this->load->view('frontend/include/template', $data);
}
public function gmail_signin($id)
{
    if(!$this->session->userdata('is_logged_in'))
    {
        $this->session->set_flashdata('flashSuccess', "You have successfully logged in");
    }
    $this->session->set_userdata('is_logged_in',  'TRUE');
    $this->session->set_userdata('id',$id);
    $this->cart->destroy();
    $data = explode('.',$_SERVER['SERVER_NAME']);
    $data['store']=$this->cm->getSHopByUser();
    $user_id=$this->session->userdata('id');

            $this->db->where('id',$user_id);

            $data=array('login_status'=>'on');
            $this->db->update('customers',$data);
            $url = explode('.',$_SERVER['SERVER_NAME']);
            $domain=$url[0];

            $this->db->select('*');
            $this->db->from('shop_details as sd');
            $this->db->join('tbl_user as tb','sd.user_id=tb.id');
            $this->db->where('tb.domainname',$domain);
            $query= $this->db->get();
            $query1=$query->row();

            if($query->num_rows()==1)
            {
                $this->session->set_flashdata('flashSuccess', "Logged in Successfully");
                redirect('welcome/Home/'.$query1->shopId.'/'.$query1->shop_name); 
            }
            else{
                $this->session->set_flashdata('flashSuccess', "Logged in Successfully");
                redirect('welcome/select_store');
            }
}

public function customer_profile()
{
    
    $data['address']=$this->cm->update_address_of_user($this->session->userdata('id'));
    $data['user_address']=$this->cm->getCustomerAdress($this->session->userdata('id'));
     $store_id=$this->session->userdata('store_id');
    $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
   $data['main_content']='frontend/customer_profile';
    $this->load->view('frontend/include/template', $data);
}

public function change_store()
{
    $data['store']=$this->cm->getSHopByUser();
    $data['main_content']='frontend/index';
    $this->load->view('frontend/include/template', $data);
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

public function customer_register()
{
    $verify_code = $this->random_code();

    $email=$this->input->post('email');
    $password=$this->input->post('password');
    $ceklogin=$this->cm->Check_registered($email);
    if(empty($ceklogin))
    {
        $data=array('firstname'=>$this->input->post('firstname'),
            'lastname'=>$this->input->post('lastname'),
            'email'=>$this->input->post('email'),
            "password"=>$this->input->post('password'),
            'mobile'=>$this->input->post('mobile'),
            "registered_date"=>date("Y-m-d H:i:s"),
            "verify_code"=>$verify_code );
        $insert=$this->db->insert('customers',$data);
        if($insert)
        {
            $this->session->set_flashdata('flashSuccess',"Registered Successfully");
            $subject =  "Verify Email";
            $message =  "click on ". base_url()."welcome/email_verify/".$email."/".$verify_code." to email to verify";
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
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);
            if($this->email->send())
            {
                $this->session->set_flashdata('flashSuccess', "Please check your email for registeration");
                redirect ('welcome/index');
            }
            else
            {
                $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
                redirect ( 'welcome/register');
            }
        }
        else{
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect ( 'welcome/register');
        }
    }
    else{
        $this->session->set_flashdata('flashError', "You have 
            already registered");
        redirect ( 'welcome/index');
    }
}

public function email_verify($email,$code)
{
    $ceklogin=$this->cm->Check_registered($email);
    if($ceklogin->verify_code == $code)
    {
        $data=array('status'=>1);
        $this->db->where('email',$email);
        $result=$this->db->update('customers',$data);

        if($result)
        {
            $this->session->set_flashdata('flashSuccess', "You have successfully registered email");
            redirect ( 'welcome/index');
        }
        else
        {
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect ( 'welcome/index');
        }
    }
    else{
        $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
        redirect ( 'welcome/index');
    }
}

public function login()
{
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->library('session');
    $url = explode('.',$_SERVER['SERVER_NAME']);
    $ids=$url[0];

    $email=$this->input->post('email');
    $password=$this->input->post('password');

    $ceklogin=$this->cm->login($email,$password);
    $check_reg = $this->cm->Check_registered($email);

    if($check_reg)
    {
        if($ceklogin)
        {
            foreach($ceklogin as $row);
            $userdata=array();
            $userdata['id']=$row->id;
            $userdata['mobile']=$row->firstname;
            $userdata['email']=$row->email;
            $userdata['password']=$row->password;
            $userdata['is_logged_in'] = TRUE ;
            $this->session->set_userdata($userdata);
            $userdata=array();
            $userdata['is_logged_in'] = TRUE ;

            $this->session->set_userdata($userdata);
            $user_id=$this->session->userdata('id');

            $this->db->where('id',$user_id);

            $data=array('login_status'=>'on');
            $this->db->update('customers',$data);
            $url = explode('.',$_SERVER['SERVER_NAME']);
            $domain=$url[0];

            $this->db->select('*');
            $this->db->from('shop_details as sd');
            $this->db->join('tbl_user as tb','sd.user_id=tb.id');
            $this->db->where('tb.domainname',$domain);
            $query= $this->db->get();
            $query1=$query->row();

            if($query->num_rows()==1)
            {
                $this->session->set_flashdata('flashSuccess', "Logged in Successfully");
                redirect('welcome/Home/'.$query1->shopId.'/'.$query1->shop_name); 
            }
            else{
                $this->session->set_flashdata('flashSuccess', "Logged in Successfully");
                redirect('welcome/select_store');
            }
        }
        else{
            $this->session->set_flashdata('flashError', "Password is wrong, Try again!!");
            redirect ('welcome/index');
        }
    }
    else
    {
        $this->session->set_flashdata('flashError', "You have not registered..Please register here!!");
        redirect ('welcome/register');
    }
}

public function gmail_login()
{
    include_once APPPATH . "libraries/vendor/autoload.php";

    $google_client = new Google_Client();

$google_client->setClientId('620394351683-gm7tu4fheks0otb16pucbbiftnos7ld1.apps.googleusercontent.com'); //Define your ClientID

$google_client->setClientSecret('GIm1X6UwVrJkAgBfTaev9ZME'); //Define your Client Secret Key

$google_client->setRedirectUri('https://demo.direct-buy.in/welcome/login_here'); //Define your Redirect Uri

$google_client->addScope('email');

$google_client->addScope('profile');

if(isset($_GET["code"]))
{
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if(!isset($token["error"]))
    {
        $google_client->setAccessToken($token['access_token']);

        $this->session->set_userdata('access_token', $token['access_token']);

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        $current_datetime = date('Y-m-d H:i:s');

        if($this->cm->Is_already_register($data['id']))
        {
//update data
            $user_data = array(
                'login_oauth_uid' => $data['id'],
                'firstname'  => $data['given_name'],
                'lastname'   => $data['family_name'],
                'email'  => $data['email'],
                'password'=>'null',
                'mobile'=>'Not Available',
                'login_status'=>'on',
                'registered_date'  => $current_datetime
            );

            $this->cm->Update_user_data($user_data, $data['id']);
            $user_id=$this->cm->getUserIdByGmailtoken($data['id']);
            $this->session->set_userdata('id',  $user_id->id);

        }
        else
        {
//insert data
            $user_data = array(
                'login_oauth_uid' => $data['id'],
                'firstname'  => $data['given_name'],
                'lastname'   => $data['family_name'],
                'email'  => $data['email'],
                'password'=>'null',
                'mobile'=>'Not Available',
                'login_status'=>'on',
                'registered_date'  => $current_datetime
            );

            $this->cm->Insert_user_data($user_data);
        }
        $this->session->set_userdata('user_data', $user_data);
        $user_id=$this->cm->getUserIdByGmailtoken($data['id']);
        $this->session->set_userdata('id',  $user_id->id);
        echo"success";

    }
}
$login_button = '';
if(!$this->session->userdata('access_token'))
{
    $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="'.base_url().'asset/sign-in-with-google.png" /></a>';
    $data['login_button'] = $login_button;
    $this->load->view('google_login', $data);
    $this->load->view('frontend/google_login', $data);
    redirect('welcome/select_store');
    $this->load->view('frontend/google_login', $data);
}
else
{
    redirect('welcome/select_store');
    $this->load->view('frontend/google_login', $data);
    $data['main_content']='frontend/google_login';
    $this->load->view('frontend/include/template', $data);
} 
}

public function Home($store_id,$store_name)
{
    $url = explode('.',$_SERVER['SERVER_NAME']);
    $domain='asma';
    if(!$this->session->userdata('is_logged_in'))
    {
        redirect('welcome');
    }

    $this->session->set_userdata('store_id',$store_id);
   
    $store_id=$this->session->userdata('store_id');

    $data['shop']=$this->cm->check_homedelivery($store_id);
     $this->session->set_userdata('store_name',$data['shop']->shop_name);
    
    $this->db->select('*');
    $this->db->from('shop_details as sd');
    $this->db->join('tbl_user as tb','sd.user_id=tb.id');
    $this->db->where('sd.shop_id',$store_id);
    $query= $this->db->get()->row();
    $user_id=$this->session->userdata('id');
    // $data['defStore']=$this->cm->checkDefaultStoreOfUser($user_id);
    // if(empty($data['defStore'])){
    //     $userdata=array('customer_id'=>$user_id,
    //     'default_store_id'=>$store_id);
    //     $this->db->insert(' customer_default_store',$userdata);
    // }
   
    $data['store_name']=$this->session->userdata('store_name');
    $store_id=$this->session->userdata('store_id');
    $data['logo']=$this->cm->getLogo($domain);

    $this->dbConnection($store_id);

//      $menus = $this->cm->menus();
//      $data = array('menus' => $menus);
    $data['min_max_prices']=$this->cm->min_max_prices();
    $data['no_category']=$this->cm->noofcategories();
    $data['no_brand']=$this->cm->noofbrand();

    $data['shop_type']=$this->cm->check_store_type($store_id);

    $data['brand_data'] = $this->cm->fetch_filter_type('brand');
    $data['category_data'] = $this->cm->fetch_filter_type('category');
    $data['products']=$this->cm->get_products();
    $data['store_data']=$this->cm->getShopOwnerDetails($store_id);
    $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
    $data['main_content']='frontend/include/main_content';
    $this->load->view('frontend/include/template', $data);
}

public function select_store()
{
    $this->cart->destroy();
    $data = explode('.',$_SERVER['SERVER_NAME']);
    $data['store']=$this->cm->getSHopByUser();
    $data['main_content']='frontend/index';
    $this->load->view('frontend/include/template', $data);

}

public function fetch_data()
{
    $store_name= $this->session->userdata('store_name');
    $store_id=$this->session->userdata('store_id');
    $this->dbConnection($store_id);
    $minimum_price = $this->input->post('minimum_price');
    $maximum_price = $this->input->post('maximum_price');
    $brand = $this->input->post('brand');
    $ram = $this->input->post('ram');

    $this->load->library("pagination");
    $config = array();
    $config["base_url"] = "#";
    $config["total_rows"] = $this->cm->count_all($minimum_price, $maximum_price, $brand, $ram);
    $config["per_page"] = 10;
    $config["uri_segment"] = 3;
    $config["use_page_numbers"] = TRUE;
    $config["full_tag_open"] = '<ul class="pagination">';
    $config["full_tag_close"] = '</ul>';
    $config["first_tag_open"] = '<li class="page-item">';
    $config["first_tag_close"] = '</li>';
    $config["last_tag_open"] = '<li class="page-item">';
    $config["last_tag_close"] = '</li>';
    $config['next_link'] = '&gt;';
    $config["next_tag_open"] = '<li class="page-item">';
    $config["next_tag_close"] = '</li>';
    $config["prev_link"] = "&lt;";
    $config["prev_tag_open"] = "<li class='page-item'>";
    $config["prev_tag_close"] = "</li>";
    $config["cur_tag_open"] = "<li class='active'><a href='#'>";
    $config["cur_tag_close"] = "</a></li>";
    $config["num_tag_open"] = "<li class='page-item'>";
    $config["num_tag_close"] = "</li>";
    $config["num_links"] = 3;
    $this->pagination->initialize($config);
    $page = $this->uri->segment('3');
    $start = ($page - 1) * $config["per_page"];

    $output = array(
        'pagination_link'       =>  $this->pagination->create_links(),
        'product_list'          =>  $this->cm->fetch_data($config["per_page"], $start, $minimum_price, $maximum_price, $brand, $ram)
    );
    echo json_encode($output);
}

public function add($id,$price)
{
    $store_id=$this->session->userdata('store_id');
    $this->dbConnection($store_id);

    $this->load->library("cart");

    $this->db->select('*');
    $this->db->from('temp_str_config');

    $this->db->where('temp_str_config_id',$id);
    $query= $this->db->get()->row();
    $data = array(

        "id"  => $id ,
        "name"  =>$query->product_name,
        "qty"  => 1,
        "brand"=>$query->brand,
        "price"  => $price,
        "img" =>$query->product_img
    );
    $result= $this->cart->insert($data);
//      $insert_data=array(
//          "rowid"=>row_id,
//          "product_id"=>$id ,
//          "product_name"=>$query->product_name,
//          "price"=>$price,
//          "qty"=>1,
//          "subtotal"=>
//          )
//      if($query->free_product!=0)
//      {
//        $data1 = array(
//          "product_id"  =>$query1->product_id,
//          "user_id"=>$this->session->userdata('id'),
//          "product_name"  =>$query1->product_name,
//          "qty"  => 1,
//          "product_brand"=>$query1->product_brand,
//          "price"  =>0,
//          "free_id"=>$query->free_product,
//          "subtotal"=>0
//      );

//      $result1= $this->db->insert("cart_details",$data1);
//      }
    if($result)
    {
        $this->session->set_flashdata('flashSuccess', "Product is added to cart");
        redirect('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));
    }
    else
    {
        $this->session->set_flashdata('flashError', "Something went wrong..Try again!!");
        redirect('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));
    }
}

public function remove($row_id)
{
    $this->load->library("cart");
    $data = array(
        'rowid'  => $row_id,
        'qty'  => 0
    );
    $update=$this->cart->update($data);

    if($update)
    {
        $this->session->set_flashdata('flashSuccess', "Product is removed");
        redirect("welcome/addtocart");
    }else
    {
        $this->session->set_flashdata('flashSuccess', "Something went wrong..Try again!!");
        redirect("welcome/addtocart");
    }
}
public function remove_item($row_id)
{

    $this->load->library("cart");
    $data = array(
        'rowid'  => $row_id,
        'qty'  => 0
    );
    $update=$this->cart->update($data);

    if($update)
    {
        $this->session->set_flashdata('flashSuccess', "Product is removed");
        redirect('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));
    }else
    {
        $this->session->set_flashdata('flashSuccess', "Something went wrong..Try again!!");
        redirect('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));
    }
}

public function updateQty()
{
    $rowid = $this->input->post('rowid');
    $qty = $this->input->post('qty');
    if(!empty($rowid) && !empty($qty)){
        $data = array(
            'rowid' => $rowid,
            'qty'   => $qty
        );
        $update = $this->cart->update($data);
    }
}

public function addtocart()
{
    $data['main_content']='frontend/addtocart';
    $store_name= $this->session->userdata('store_name');
    $store_id= $this->session->userdata('store_id');
    $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
//      $this->dbConnection($store_name);
//      $data['free_items']=$this->cm->getFreeItems($this->session->userdata('id'));
    $this->load->view('frontend/include/template', $data);
}

public function clear()
{
    if(!$this->session->userdata('is_logged_in'))
    {
        redirect('welcome');
    }
    $this->load->library("cart");
    $this->cart->destroy();
    $this->session->set_flashdata('flashSuccess', "Cart is cleared successfully");
//      $store_name= $this->session->userdata('store_name');
//      $this->dbConnection($store_name);
//        $this->db->where('user_id', $this->session->userdata('id'));

//              $this->db->delete('cart_details');
    redirect('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));
}

public function search()
{
    $store_name= $this->session->userdata('store_name');
    $store_id= $this->session->userdata('store_id');
     $data['shop']=$this->cm->check_homedelivery($store_id);
    $url = explode('.',$_SERVER['SERVER_NAME']);
    $domain=$url[0];
    $data['logo']=$this->cm->getLogo($domain);
    $this->dbConnection($store_id);
    $key=$this->input->post('search');

    $this->db->select("category");
    $this->db->from('temp_str_config');
    $res=$this->db->get()->result();
    $this->db->select("brand");
    $this->db->from('temp_str_config');
    $res1=$this->db->get()->result();
    if(empty($res1))
    {
        $result=$this->cm->searchWithoutBrand($key);
        
    }
    else if(empty($res))
    {
        $result=$this->cm->searchWithoutCat($key);
    }
    else{
        $result=$this->cm->search($key);
      
    }


    if ($result != false) {
        $data['search'] = $result;
    } else {
        $data['search'] = "No record found !";
    } 

    $data['brand_data'] = $this->cm->fetch_filter_type('brand');
    $data['category_data'] = $this->cm->fetch_filter_type('category');
    $data['products']=$this->cm->get_products();
    $data['min_max_prices']=$this->cm->min_max_prices();
//      $data['menus'] = $this->cm->menus();
    $data['no_category']=$this->cm->noofcategories();
    $data['no_brand']=$this->cm->noofbrand();
    $data['shop_type']=$this->cm->check_store_type($store_id);
    $data['store_data']=$this->cm->getShopOwnerDetails($store_id);
    $data['products']=$this->cm->get_products();
    $data['main_content']='frontend/include/main_content';
    $this->load->view('frontend/include/template', $data);
}

public function searching()
{
    echo $this->cm->fetch_data($this->uri->segment(3));
}

public function user_search()
{
    $store_name= $this->session->userdata('store_name');
    $store_id= $this->session->userdata('store_id');
    $this->dbConnection($store_id);

    $user = $_GET['term'];

    $query = $this
    ->db
    ->select('product_name')
    ->like('product_name',$user)
    ->get('temp_str_config');

    if($query->num_rows() > 0){
        foreach($query->result_array() as $row) {
            $row_set[] = $row['product_name'];
        }

        echo json_encode($row_set); 
    }
}

//  public function filter()
//  {
//      $store_name= $this->session->userdata('store_name');
//      $this->dbConnection($store_name);

//      $filter=implode(" ,",$this->input->post('filter'));

//      foreach ($this->input->post('filter') as $like)
//      {
//          $this->db->like('product_brand',$like);
//          $this->db->or_like('product_category', $like);

//          $datas=  $this->db->get(' temp_str_config ')->result();
//      }
//      $this->filtered($datas);
//  }

//  public function filtered($datas)
//  {
//      if ($datas != false) {
//          $data['filtered'] = $datas;
//      } else {
//          $data['filtered'] = "No record found !";
//      }

//      $data['products']=$this->cm->get_products();

//      $data['main_content']='frontend/include/main_content';
//      $this->load->view('frontend/include/template', $data);
//      return true;    
//  }

public function update_address()
{
    $result=$this->cm->update_address_of_user($this->session->userdata('id'));
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
            $this->session->set_flashdata('flashSuccess',"updated Successfully");
            redirect ('welcome/customer_profile');
        }else
        {
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect ( 'welcome/customer_profile');
        }

    }
}

public function update_password()
{
    $email=$this->input->post('email');
    $current_pass=$this->input->post('current_pass');

    $result=$this->cm->update_address_by_id( $email,$current_pass);
    $user_password=$result->password;

    $new_pass=$this->input->post('new_pass');

    if($user_password==$current_pass)
    {
        $OTP      = rand(100000, 999999);
        $data=array('OTP'=>$OTP);

        $this->db->where('password',$current_pass);
        $update=$this->db->update('customers',$data);

        $subject =  "Change password";
        $message =  "password changed 12235";
        $config['protocol']   = 'smtp';
        $config['smtp_host']  = 'ssl://smtp.gmail.com';
        $config['smtp_port']  = '465';
        $config['smtp_user']  =  'soundarya@79gmail.com';
        $config['smtp_pass']  = 'Sandu@123';
        $config['charset']    = 'iso-8859-1';
        $config['newline']    = "\r\n";
        $config['mailtype']   = 'html';
        $config['validation'] = TRUE;

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('soundarya@79gmail.com','MRGWLA');
        $this->email->to('arscnet24@gmail.com');
        $this->email->subject($subject);
        $this->email->message($message);
        if($this->email->send())
        {
// redirect('welcome');
            return true;
        }
        else
        {
// redirect('welcome/customer_profile');
        }
        return true;
    }
}

public function change_password()
{
    $email=$this->input->post('email');
    $current_pass=$this->input->post('current_pass');
    $new_pass=$this->input->post('new_pass');
    $confirm_new_pass=$this->input->post('confirm_new_pass');
    $otp=$this->input->post('otp');
    $result=$this->cm->update_address_by_id($email,$current_pass);
    $user_otp=$result->OTP;
    if($user_otp==$otp)
    {
        $data=array('password'=>$new_pass
    );
        $this->db->where('password',$current_pass);
        $update=$this->db->update('customers',$data);
        if($update){
            $this->session->set_flashdata('flashSuccess',"updated Successfully");
            redirect('welcome/customer_profile');
        }else{
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect('welcome/customer_profile');
        }
    }
}

public function signedin_change_password()
{
    $result=$this->cm->update_address_by_id($this->session->userdata('id'));
    $user_password=$result->password;

    $current_pass=$this->input->post('current_pass');
    $new_pass=$this->input->post('new_pass');
    if( $user_password==$current_pass)
    {
        $data=array('password'=>$new_pass
    );
        $this->db->where('id',$this->session->userdata('id'));
        $update=$this->db->update('customers',$data);
        if($update){
            $this->session->set_flashdata('flashSuccess',"updated Successfully");
            redirect('welcome/customer_profile');
        }else{
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect('welcome/customer_profile');
        }
    }
}

//DB Connection
public function dbConnection($store_id)
{
    $c['hostname'] = "localhost";
    $c['username'] = "root";
    $c['password'] = "";
    $c['database'] = $store_id;
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

public function logout()
{
    $url = explode('.',$_SERVER['SERVER_NAME']);
    $ids=$url[0];
    $user_id=$this->session->userdata('id');

    $this->db->where('id',$user_id);
    $data=array('login_status'=>'off');
    $logout=$this->db->update( 'customers',$data);




    $this->session->unset_userdata('userdata');
    $this->session->sess_destroy();
    if($logout)
    {
        $this->session->set_flashdata('flashSuccess', "Logged out Successfully");
        redirect('Welcome');
    }
}
public function make_default_store()
{
    $url = explode('.',$_SERVER['SERVER_NAME']);

    $this->db->select("*");
    $this->db->from('customer_default_store');
    $this->db->where('customer_id',$this->session->userdata('id'));
    $this->db->where('domain_name',$url[0]);
    $query=$this->db->get()->row();



    if(empty($query))
    {
        $data=array('default_store_id'=>$this->input->post('store_id'),
            'store_name'=>$this->input->post('store_name'),
            'domain_name'=>$url[0],
            'customer_id'=>$this->session->userdata('id'));

        $result=$this->db->insert('customer_default_store',$data);
        if($result)
        {
            $this->session->set_flashdata('flashSuccess', "Submitted Successfully");
            redirect("welcome/select_store");
        }
        else{
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect("welcome/select_store"); 
        }
    }
    else
    {
        $data=array('default_store_id'=>$this->input->post('store_id'),
            'store_name'=>$this->input->post('store_name'),
            'domain_name'=>$url[0],
            'customer_id'=>$this->session->userdata('id'));

        $this->db->where('customer_id',$this->session->userdata('id'));
        $result=$this->db->update('customer_default_store',$data);

        redirect("welcome/Home/".$query->default_store_id.'/'.$query->store_name);
    }
}


public function upload_page()
{
    if(!$this->session->userdata('is_logged_in'))
    {
        redirect('welcome');
    }
    $data['main_content']='frontend/upload_page';
    $store_id= $this->session->userdata('store_id');
    $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
    
    $this->dbConnection($store_id);

//      $data['free_items']=$this->cm->getFreeItems($this->session->userdata('id'));
    $this->load->view('frontend/include/template', $data);
}
public function order_history()
{
    if(!$this->session->userdata('is_logged_in'))
    {
        redirect('welcome');
    }
    $data['main_content']='frontend/order_history';
//      $store_id= $this->session->userdata('store_id');
//      $this->dbConnection($store_id);
$data['homeDelivery']=$this->cm->check_homedelivery($store_id);
    $data['order_items']=$this->cm->getOrderItems($this->session->userdata('id'));

    $this->load->view('frontend/include/template', $data);
}
public function order_details($order_id)
{
    if(!$this->session->userdata('is_logged_in'))
    {
        redirect('welcome');
    }
    $data['user_address']=$this->cm->getCustomerAdress($this->session->userdata('id'));
    $data['homeDelivery']=$this->cm->check_homedelivery($store_id);
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
    $data['cus_data']=$this->cm->getCusDetails($order_id);
    $store_id= $this->session->userdata('store_id');
    $data['cust_details']=$this->cm->getAllOrderDetails($order_id);
    $data['store_data']=$this->cm-> get_store_address($order_id);
    $this->dbConnection($store_id);
    $data['order_details']=$this->cm->getOrderDetails($order_id);
    $data['main_content']='frontend/order_details';
    $this->load->view('frontend/include/template', $data);
}
public function add_address()
{
    if(!$this->session->userdata('is_logged_in'))
    {
        redirect('welcome');
    }
    $data['main_content']='frontend/add_address';
    $store_id= $this->session->userdata('store_id');

    $this->dbConnection($store_id);

    $data['store_data']=$this->cm->getShopOwnerDetails($store_id);
    $this->load->view('frontend/include/template', $data);
}
public function delete_address($id)
{
    $this->db->where('id', $id);
    $result=$this->db->delete('customer_address');
    if($result)
    {
        $this->session->set_flashdata('flashSuccess', "Submitted Successfully");
        redirect("welcome/customer_profile");
    }
    else{
        $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
        redirect("welcome/customer_profile"); 
    }

}
public function make_default_address($id)
{
    $change=array(
        'status'=>0
    );
    $this->db->where('status', 1);
    $this->db->update('customer_address',$change);
    $data=array(
        'status'=>1
    );
    $this->db->where('id', $id);
    $result=$this->db->update('customer_address',$data);
    if($result)
    {
        $this->session->set_flashdata('flashSuccess', "Submitted Successfully");
        redirect("welcome/customer_profile");
    }
    else{
        $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
        redirect("welcome/customer_profile"); 
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

        redirect('welcome/order_details/'.$order_code);
    }
    else
    {
        $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
        redirect('welcome/order_details/'.$order_code);
    }

}
public function add_address_here($order_code)
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

            redirect('welcome/order_details/'.$order_code);
        }
        else
        {
            $this->session->set_flashdata('flashError', "Something went wrong, try again!!");
            redirect('welcome/order_details/'.$order_code);
        }

    }
}
function login_here()
{
    include_once APPPATH . "libraries/vendor/autoload.php";

    $google_client = new Google_Client();

$google_client->setClientId('620394351683-gm7tu4fheks0otb16pucbbiftnos7ld1.apps.googleusercontent.com'); //Define your ClientID

$google_client->setClientSecret('GIm1X6UwVrJkAgBfTaev9ZME'); //Define your Client Secret Key

$google_client->setRedirectUri('https://demo.direct-buy.in/welcome/login_here'); //Define your Redirect Uri

$google_client->addScope('email');

$google_client->addScope('profile');

if(isset($_GET["code"]))
{
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if(!isset($token["error"]))
    {
        $google_client->setAccessToken($token['access_token']);

        $this->session->set_userdata('access_token', $token['access_token']);

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        $current_datetime = date('Y-m-d H:i:s');

        if($this->cm->Is_already_register($data['id']))
        {
//update data
            $user_data = array(
                'login_oauth_uid' => $data['id'],
                'firstname'  => $data['given_name'],
                'lastname'   => $data['family_name'],
                'email'  => $data['email'],
                'password'=>'null',
                'mobile'=>'Not Available',
                'login_status'=>'on',
                'registered_date'  => $current_datetime
            );

            $this->cm->Update_user_data($user_data, $data['id']);
            $user_id=$this->cm->getUserIdByGmailtoken($data['id']);
            $this->session->set_userdata('id',  $user_id->id);
        }
        else
        {
//insert data
            $user_data = array(
                'login_oauth_uid' => $data['id'],
                'firstname'  => $data['given_name'],
                'lastname'   => $data['family_name'],
                'email'  => $data['email'],
                'password'=>'null',
                'mobile'=>'Not Available',
                'login_status'=>'on',
                'registered_date'  => $current_datetime
            );

            $this->cm->Insert_user_data($user_data);
        }
        $this->session->set_userdata('user_data', $user_data);
        $user_id=$this->cm->getUserIdByGmailtoken($data['id']);
        $this->session->set_userdata('id',  $user_id->id);

    }
}
$login_button = '';
if(!$this->session->userdata('access_token'))
{
    $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="'.base_url().'asset/sign-in-with-google.png" /></a>';
    $data['login_button'] = $login_button;
//   $this->load->view('google_login', $data);
//  $this->load->view('frontend/google_login', $data);
// redirect('welcome/select_store');
    $this->load->view('frontend/google_login', $data);
}
else
{
//   redirect('welcome/select_store');
    $this->load->view('frontend/google_login', $data);
//     $data['main_content']='frontend/google_login';
//      $this->load->view('frontend/include/template', $data);
}
}

function logout_here()
{
    $this->session->unset_userdata('access_token');

    $this->session->unset_userdata('user_data');

    $this->load->view('frontend/google_login', $data);
}

}
