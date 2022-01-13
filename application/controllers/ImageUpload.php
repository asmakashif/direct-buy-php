<?php

class ImageUpload extends CI_Controller {


   public function __construct() { 
      
      parent::__construct(); 
      $this->load->helper(array('form', 'url')); 
   }

   public function index() { 
      $this->load->view('frontend/upload_image_form', array('error' => '' )); 
   } 


   /**
    * Method to upload image 
    *
    * @return Response
   */
//   public function uploadImage() { 
//       header('Content-Type: application/json');
      
//       $config['upload_path']   = './assets/uploads/prescription'; 
//       $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
//       $config['max_size']      = 2048;
//       $this->load->library('upload', $config);
    
//       if ( ! $this->upload->do_upload('file')) {
//          $error = array('error' => $this->upload->display_errors()); 
//          echo json_encode($error);
//       }else { 
//          $data = $this->upload->data();
//          $success = ['success'=>$data['file_name']];
//          echo json_encode($success);
//       } 
//   }
 public function saveProduct()
    {
        
                    if(!empty($_FILES['images']['name'])){ 
                        $filesCount = count($_FILES['images']['name']); 
                        for($i = 0; $i < $filesCount; $i++){ 
                            $_FILES['file']['name']     = $_FILES['images']['name'][$i]; 
                            $_FILES['file']['type']     = $_FILES['images']['type'][$i]; 
                            $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i]; 
                            $_FILES['file']['error']    = $_FILES['images']['error'][$i]; 
                            $_FILES['file']['size']     = $_FILES['images']['size'][$i]; 
                             
                            // File upload configuration 
                          
                            $config['upload_path'] = './assets/uploads/prescription'; 
                            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                             
                            // Load and initialize upload library 
                            $this->load->library('upload', $config); 
                            $this->upload->initialize($config); 
                             
                            // Upload file to server 
                            if($this->upload->do_upload('file')){ 
                                // // Uploaded file data 
                                // $fileData = $this->upload->data(); 
                                // $uploadData[$i]['product_id'] = $productID; 
                                // $uploadData[$i]['file_name'] = $fileData['file_name']; 
                                // $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                                echo "Success";
                            }else{ 
                                echo "Upload failed. Image file must be gif|jpg|png|jpeg|bmp|pdf";
                            } 
                        } 
                         
                        // File upload error message 
                        $errorUpload = !empty($errorUpload)?' Upload Error: '.trim($errorUpload, ' | '):''; 
                         
                     
               
            }
        }
    
     
    }




?>