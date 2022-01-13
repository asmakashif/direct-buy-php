<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyProfileModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        
    }
    
    public function fetchUserData($userId)
    {
        $this->db->where('id', $userId);
        $query = $this->db->get('tbl_user');
        return  $query->row();
    }

    public function updateProfile($image)
    {
        $userid=$this->input->post('userid');
        $firstname=$this->input->post('firstname');
        $lastname=$this->input->post('lastname');
        $contact=$this->input->post('contact');
        $email=$this->input->post('email');
        $password=$this->input->post('password');
        $address=$this->input->post('address');

        $uploadProfile=array
        (
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'contact'=>$contact,
            'email'=>$email,
            'password'=>$password,
            'address'=>$address,
            'logo'=>$image,
        );
        $this->db->where('id',$userid);
        $insert_success=$this->db->update('tbl_user',$uploadProfile);
        return $insert_success;
    }

}