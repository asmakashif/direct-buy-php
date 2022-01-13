<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mainHelper');
		$this->load->model('frontend/CustomerModel','cm');
		$this->load->library('session');
		if(!$this->session->userdata('is_logged_in'))
        {
            redirect('Welcome');
        }
	}


	

	 public function customer_profile()
 {
 	   $data['main_content']='frontend/customer_profile';
 	   $data['address']=$this->cm->update_address_of_user($this->session->userdata('id'));
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
	
	
	public function Home($store_id,$store_name)
	{
	     $url = explode('.',$_SERVER['SERVER_NAME']);
		$domain=$url[0];
	    $data['logo']=$this->cm->getLogo($domain);
	   // print_r($data['logo']->logo);
	   // die();
		$this->session->set_userdata('store_id',$store_id);
		$this->session->set_userdata('store_name',$store_name);
        $store_id=$this->session->userdata('store_id');
        $this->db->select('*');
        $this->db->from('shop_details as sd');
        $this->db->join('tbl_user as tb','sd.user_id=tb.id');

         $this->db->where('sd.shop_id',$store_id);
        $query= $this->db->get()->row();
      
        $data['store_name']=$this->session->userdata('store_name');
        $this->dbConnection($store_name);
		$menus = $this->cm->menus();
		$data = array('menus' => $menus);
		$data['min_max_prices']=$this->cm->min_max_prices();
        
	    
		$data['brand_data'] = $this->cm->fetch_filter_type('product_brand');
		$data['category_data'] = $this->cm->fetch_filter_type('product_category');
		$data['products']=$this->cm->get_products();
		$data['store_data']=$this->cm->getShopOwnerDetails($store_id);
		$data['main_content']='frontend/include/main_content';
		$this->load->view('frontend/include/template', $data);
	}
	
	public function select_store()
	{
	    $data = explode('.',$_SERVER['SERVER_NAME']);
		$this->db->select("*");
		$this->db->from('customer_default_store');
		$this->db->where('customer_id',$this->session->userdata('id'));
		$this->db->where('domain_name',$data[0]);
		$query=$this->db->get()->row();
	
		if(empty($query))
		{
		    $data['store']=$this->cm->getSHopByUser();
		$data['main_content']='frontend/index';
		$this->load->view('frontend/include/template', $data);
		}
		else
		{
		  //  $this->session->set_flashdata('flashSuccess', "Please check your email for registeration");
		    redirect('frontend/Dashboard/Home/'.$query1->shop_id.'/'.$query1->shop_name);
		}
	}
	
	public function fetch_data()
	{
		$store_name= $this->session->userdata('store_name');
		$this->dbConnection($store_name);
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
			'pagination_link'		=>	$this->pagination->create_links(),
			'product_list'			=>	$this->cm->fetch_data($config["per_page"], $start, $minimum_price, $maximum_price, $brand, $ram)
		);
		echo json_encode($output);
	}
	
	public function add($id,$title,$price)
	{
		$store_name= $this->session->userdata('store_name');
		$this->dbConnection($store_name);

		$this->load->library("cart");

		$this->db->select('*');
		$this->db->from('tbl_products');

		$this->db->where('product_id',$id);
		$query= $this->db->get()->row();
		
// 			$this->db->from('tbl_products');

// 		$this->db->where('product_id',$query->free_product);
// 		$query1= $this->db->get()->row();


		$data = array(
		    
			"id"  => $id ,
			"name"  =>$query->product_name,
			"qty"  => 1,
			"brand"=>$query->product_brand,
			"price"  => $price
		);
			$result= $this->cart->insert($data);
// 		$insert_data=array(
// 		    "rowid"=>row_id,
// 		    "product_id"=>$id ,
// 		    "product_name"=>$query->product_name,
// 		    "price"=>$price,
// 		    "qty"=>1,
// 		    "subtotal"=>
// 		    )
// 		if($query->free_product!=0)
// 		{
// 		  $data1 = array(
// 			"product_id"  =>$query1->product_id,
// 			"user_id"=>$this->session->userdata('id'),
// 			"product_name"  =>$query1->product_name,
// 			"qty"  => 1,
// 			"product_brand"=>$query1->product_brand,
// 			"price"  =>0,
// 			"free_id"=>$query->free_product,
// 			"subtotal"=>0
// 		);
	
// 		$result1= $this->db->insert("cart_details",$data1);
// 		}
		if($result)
		{
		    $this->session->set_flashdata('flashSuccess', "Product is added to cart");
			redirect('welcome/Home/'.$this->session->userdata('store_id').'/'.$store_name);
		}
	}
	
	public function remove($row_id)
	{
	   $store_name= $this->session->userdata('store_name');
		$this->dbConnection($store_name);
	  
		
		
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
// 		$this->dbConnection($store_name);
// 		$data['free_items']=$this->cm->getFreeItems($this->session->userdata('id'));
		$this->load->view('frontend/include/template', $data);
	}
	
	public function clear()
	{
		$this->load->library("cart");
		$this->cart->destroy();
		$this->session->set_flashdata('flashSuccess', "Cart is cleared successfully");
		$store_name= $this->session->userdata('store_name');
		$this->dbConnection($store_name);
		  $this->db->where('user_id', $this->session->userdata('id'));
		     
             $this->db->delete('cart_details');
		redirect('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));
	}
	
	public function search()
	{
		$store_name= $this->session->userdata('store_name');
		$store_id= $this->session->userdata('store_id');
		$this->dbConnection($store_name);
		$key=$this->input->post('search');
		 
		 $this->db->select("product_category");
		 $this->db->from('tbl_products');
		 $res=$this->db->get()->result();
		 $this->db->select("product_brand");
		 $this->db->from('tbl_products');
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
        
		$data['brand_data'] = $this->cm->fetch_filter_type('product_brand');
		$data['category_data'] = $this->cm->fetch_filter_type('product_category');
		$data['products']=$this->cm->get_products();
		$data['min_max_prices']=$this->cm->min_max_prices();
		$data['menus'] = $this->cm->menus();
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
		$this->dbConnection($store_name);

		$user = $_GET['term'];

		$query = $this
		->db
		->select('product_name')
		->like('product_name',$user)
		->get('tbl_products');

		if($query->num_rows() > 0){
			foreach($query->result_array() as $row) {
				$row_set[] = $row['product_name'];
			}

			echo json_encode($row_set); 
		}
	}
	
	public function filter()
	{
		$store_name= $this->session->userdata('store_name');
		$this->dbConnection($store_name);

		$filter=implode(" ,",$this->input->post('filter'));

		foreach ($this->input->post('filter') as $like)
		{
			$this->db->like('product_brand',$like);
			$this->db->or_like('product_category', $like);

			$datas=  $this->db->get(' tbl_products ')->result();
		}
		$this->filtered($datas);
	}
	
	public function filtered($datas)
	{
		if ($datas != false) {
			$data['filtered'] = $datas;
		} else {
			$data['filtered'] = "No record found !";
		}

		$data['products']=$this->cm->get_products();
		
		$data['main_content']='frontend/include/main_content';
		$this->load->view('frontend/include/template', $data);
		return true;    
	}
	
	public function update_address()
	{
		$result=$this->cm->update_address_of_user($this->session->userdata('id'));
		if($this->input->post('Submit')=='Submit')
		{
			if(empty($result))
			{
				$data=array('address1'=>$this->input->post('building_name'),
					'address2'=>$this->input->post('street_address'),
					'City'=>$this->input->post('City'),
					'Pincode'=>$this->input->post('Pincode'));

				$insert=$this->db->insert('customers',$data);
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
			else
			{
				$data=array('address1'=>$this->input->post('building_name'),
					'address2'=>$this->input->post('street_address'),
					'City'=>$this->input->post('City'),
					'Pincode'=>$this->input->post('Pincode'));
				$this->db->where('id',$this->session->userdata('id'));
				$update=$this->db->update('customers',$data);

				if($update)
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
	public function dbConnection($store_name)
	{
		$c['hostname'] = "localhost:3306";
		$c['username'] = "direcbuy_directbuy";
		$c['password'] = "Default!@#123";
		$c['database'] = "direcbuy_".$store_name;
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
}
