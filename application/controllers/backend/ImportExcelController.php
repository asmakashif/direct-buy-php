<?php 
defined('BASEPATH') OR exit('No direct script access allowed');  

class ImportExcelController extends CI_Controller 
{  
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('backend/ImportExcelModel', 'import');
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

    public function importProductData($shopId)
    {
        $this->dbConnection($shopId);
   
        if ($this->input->post('submit')) 
        {
            $path = 'assets1/uploads/product_data/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $newname = 'test-'.$_FILES['uploadFile']['name'];
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = False;
            $config['file_name'] =$newname;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('uploadFile')) 
            {
                $error = array('error' => $this->upload->display_errors());
            } else 
            {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error))
            {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                try 
                {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    
                    $flag = true;
                    $i=0;
                    
                    foreach ($allDataInSheet as $value) 
                    {
                        $delete=$this->db->truncate('tbl_products');
                        if($delete)
                        {
                            $date = new DateTime("now");
                            $curr_date = $date->format('Y-m-d ');
                            $product_category_id = $value['A'];
                            $sub_category = $value['B'];
                            $product_brand = $value['C'];
                            $product_name = $value['D'];
                            $product_description = $value['E'];
                            $product_price = $value['F'];
                            $offer_price = $value['G'];
                            $product_img = $value['H'];
                            if($flag)
                            {
                                $flag =false;
                                continue;
                            }
                            else
                            {
                                $inserdata[$i]['product_category_id'] = $product_category_id;
                                $inserdata[$i]['product_subCategory'] = $sub_category;
                                $inserdata[$i]['product_brand'] = $product_brand;
                                $inserdata[$i]['product_name'] = $product_name;
                                $inserdata[$i]['product_description'] = $product_description;
                                $inserdata[$i]['product_price'] = $product_price;
                                $inserdata[$i]['offer_price'] = $offer_price;
                                $inserdata[$i]['product_img'] = $product_img;
                                $inserdata[$i]['product_added_date'] =$curr_date;
                                $inserdata[$i]['product_status'] =0;
                                $i++;
                            }
                        }
                    }
                    $result = $this->import->importdata($inserdata); 
                    if($result)
                    {
                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                        redirect('backend/MyShopController/myShop/'.$shopId);
                    }
                    else
                    {
                        $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                        redirect('backend/MyShopController/myShop/'.$shopId);
                    }  
                             
                } 
                catch (Exception $e) 
                {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' .$e->getMessage());
                }
            }else{
                echo $error['error'];
            }
        }
    }
    
    public function importProductDataToBaseDB($shopId)
    {
        $fullyuploadedbycustomer=$this->input->post('fullyuploadedbycustomer');
        $partiallyuploadedbycustomer=$this->input->post('partiallyuploadedbycustomer');
        if ($this->input->post('submit')) 
        {
            $this->db->where('temp_shopId',$shopId);
            $query=$this->db->delete('temp_str_config');
            if($query)
            {
                $path = 'assets1/uploads/product_data/';
                require_once APPPATH . "/third_party/PHPExcel.php";
                $newname = 'test-'.$_FILES['uploadFile']['name'];
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'xlsx|xls';
                $config['remove_spaces'] = False;
                $config['file_name'] =$newname;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);            
                if (!$this->upload->do_upload('uploadFile')) 
                {
                    $error = array('error' => $this->upload->display_errors());
                } else 
                {
                    $data = array('upload_data' => $this->upload->data());
                }
                if(empty($error))
                {
                    if (!empty($data['upload_data']['file_name'])) {
                        $import_xls_file = $data['upload_data']['file_name'];
                    } else {
                        $import_xls_file = 0;
                    }
                    $inputFileName = $path . $import_xls_file;
                    try 
                    {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                        
                        $flag = true;
                        $i=0;
                        
                        foreach ($allDataInSheet as $value) 
                        {
                            
                            $date = new DateTime("now");
                            
                            $category = $value['A'];
                            $sub_category = $value['B'];
                            $brand = $value['C'];
                            $product_name = $value['D'];
                            $product_type = $value['E'];
                            $product_sub_type = $value['F'];
                            $product_description= $value['G'];
                            $product_weight = $value['H'];
                            $product_weight_type = $value['I'];
                            $product_qty = $value['J'];
                            $product_price = $value['K'];
                            $offer_price = $value['L'];
                            $product_img = $value['M'];
                            $hide_product = $value['N'];
                            $product_added_date = $date->format('Y-m-d ');
                            // $store_SKU = $value['Q'];
    
                            if($flag)
                            {
                                $flag =false;
                                continue;
                            }
                            else
                            {
                                $inserdata[$i]['user_id'] = $this->session->userdata('id');
                                $inserdata[$i]['temp_shopId'] = $shopId;
                                $inserdata[$i]['db_SKU'] =0;
                                $inserdata[$i]['category'] = $category;
                                $inserdata[$i]['sub_category'] = $sub_category;
                                $inserdata[$i]['brand'] = $brand;
                                $inserdata[$i]['product_name'] = $product_name;
                                $inserdata[$i]['product_type'] = $product_type;
                                $inserdata[$i]['product_sub_type'] = $product_sub_type;
                                $inserdata[$i]['product_description'] = $product_description;
                                $inserdata[$i]['product_weight'] = $product_weight;
                                $inserdata[$i]['product_weight_type'] = $product_weight_type;
                                $inserdata[$i]['product_qty'] = $product_qty;
                                $inserdata[$i]['product_price'] = $product_price;
                                $inserdata[$i]['offer_price'] = $offer_price;
                                $inserdata[$i]['product_img'] = $product_img;
                                // $inserdata[$i]['store_SKU'] = $store_SKU;
                                $inserdata[$i]['store_SKU'] = 'SK-'.$category.$sub_category.$brand.$product_name.$product_type.$product_sub_type.$product_weight.$product_weight_type;
                                $inserdata[$i]['hide_product'] =$hide_product;
                                $inserdata[$i]['product_added_date'] =$product_added_date;
                                $inserdata[$i]['product_status'] =0;
                                $i++;
                            }
                            
                        }
                        $result = $this->import->importDataToBaseDB($inserdata); 
                        if($result)
                        {
                            if($fullyuploadedbycustomer)
                            {
                                $editStrInfo=$this->input->post('editStrInfo');
                                $phamra=$this->input->post('pharma');
                                if(!empty($phamra))
                                {
                                    if($editStrInfo)
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'Fully uploaded by customer','pharma_status'=>1));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                                    }
                                    else
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'Fully uploaded by customer','pharma_status'=>1));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/viewProductsByShopId/'.$shopId);
                                    }
                                }
                                else
                                {
                                    if($editStrInfo)
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'Fully uploaded by customer','pharma_status'=>0));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                                    }
                                    else
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'Fully uploaded by customer','pharma_status'=>0));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/viewProductsByShopId/'.$shopId);
                                    }
                                }
                            }
                            
                            elseif($partiallyuploadedbycustomer)
                            {
                                $editStrInfo=$this->input->post('editStrInfo');
                                $phamra=$this->input->post('pharma');
                                if(!empty($phamra))
                                {
                                    if($editStrInfo)
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'partiallyuploadedbycustomer','pharma_status'=>1));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                                    }
                                    else
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'partiallyuploadedbycustomer','pharma_status'=>1));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/viewProductsByShopId/'.$shopId);
                                    }
                                }
                                else
                                {
                                    if($editStrInfo)
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'partiallyuploadedbycustomer','pharma_status'=>0));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/storeInfo/'.$shopId);
                                    }
                                    else
                                    {
                                        $this->db->where('shopId',$shopId);
                                        $update=$this->db->update('shop_details',array('upload_status'=>'partiallyuploadedbycustomer','pharma_status'=>0));
                                        $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                        redirect('backend/MyShopController/viewProductsByShopId/'.$shopId);
                                    }
                                }
                            }
                            else
                            {
                                $this->db->where('shopId',$shopId);
                                $update=$this->db->update('shop_details',array('upload_status'=>'Not uploaded by customer'));
                                if($update)
                                {
                                    $this->session->set_flashdata('flashSuccess', 'Data imported successfully');
                                    redirect('backend/MyShopController/viewProductsByShopId/'.$shopId);
                                }
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('flashSuccess', 'Something went wrong');
                            redirect('backend/MyShopController/configureStore/'.$shopId);
                        }  
                                 
                    } 
                    catch (Exception $e) 
                    {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage());
                    }
                }else{
                    echo $error['error'];
                }
            }
        }
    }
    
    public function importUpdatedProductDataToTemp($shopId,$proConfig)
    {
        if ($this->input->post('submit')) 
        {
            $this->db->where('temp_shopId',$shopId);
            $query=$this->db->delete('temp_str_config');
            if($query)
            {
                $path = 'assets1/uploads/product_data/';
                require_once APPPATH . "/third_party/PHPExcel.php";
                $newname = 'test-'.$_FILES['uploadFile']['name'];
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'xlsx|xls';
                $config['remove_spaces'] = False;
                $config['file_name'] =$newname;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);            
                if (!$this->upload->do_upload('uploadFile')) 
                {
                    $error = array('error' => $this->upload->display_errors());
                } else 
                {
                    $data = array('upload_data' => $this->upload->data());
                }
                if(empty($error))
                {
                    if (!empty($data['upload_data']['file_name'])) {
                        $import_xls_file = $data['upload_data']['file_name'];
                    } else {
                        $import_xls_file = 0;
                    }
                    $inputFileName = $path . $import_xls_file;
                    try 
                    {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                        
                        $flag = true;
                        $i=0;
                        
                        foreach ($allDataInSheet as $value) 
                        {
                            
                            $date = new DateTime("now");
                            $category = $value['A'];
                            $sub_category = $value['B'];
                            $brand = $value['C'];
                            $product_name = $value['D'];
                            $product_type = $value['E'];
                            $product_sub_type = $value['F'];
                            $product_description= $value['G'];
                            $product_weight = $value['H'];
                            $product_weight_type = $value['I'];
                            $product_qty = $value['J'];
                            $product_price = $value['K'];
                            $offer_price = $value['L'];
                            $product_img = $value['M'];
                            $hide_product = $value['N'];
                            $product_added_date = $date->format('Y-m-d ');
                            $store_SKU = 0;
    
                            if($flag)
                            {
                                $flag =false;
                                continue;
                            }
                            else
                            {
                                $inserdata[$i]['user_id'] = $this->session->userdata('id');
                                $inserdata[$i]['temp_shopId'] = $shopId;
                                $inserdata[$i]['db_SKU'] = 'DB-'.$category.$sub_category.$brand.$product_name.$product_type.$product_sub_type.$product_weight.$product_weight_type;
                                $inserdata[$i]['category'] = $category;
                                $inserdata[$i]['sub_category'] = $sub_category;
                                $inserdata[$i]['brand'] = $brand;
                                $inserdata[$i]['product_name'] = $product_name;
                                $inserdata[$i]['product_type'] = $product_type;
                                $inserdata[$i]['product_sub_type'] = $product_sub_type;
                                $inserdata[$i]['product_description'] = $product_description;
                                $inserdata[$i]['product_weight'] = $product_weight;
                                $inserdata[$i]['product_weight_type'] = $product_weight_type;
                                $inserdata[$i]['product_qty'] = $product_qty;
                                $inserdata[$i]['product_price'] = $product_price;
                                $inserdata[$i]['offer_price'] = $offer_price;
                                $inserdata[$i]['product_img'] = $product_img;
                                $inserdata[$i]['store_SKU'] = $store_SKU;
                                $inserdata[$i]['hide_product'] =$hide_product;
                                $inserdata[$i]['product_added_date'] =$product_added_date;
                                $inserdata[$i]['product_status'] =0;
                                $inserdata[$i]['demo_products'] =0;

                                $i++;
                            }
                            
                        }
                        $result = $this->import->importDataToBaseDB($inserdata); 
                        if($result)
                        {
                            $edit=$this->input->post('edit');
                            if($edit)
                            {
                                $this->updateStoreDBTempProducts($shopId,$inserdata);
                                $this->session->set_flashdata('flashSuccess', 'Updated successfully');
                                redirect('backend/MyShopController/storeInfo/'.$shopId);
                            }
                            else
                            {
                                $this->session->set_flashdata('flashSuccess', 'Updated successfully');
                                redirect('backend/MyShopController/viewProductsByShopId/'.$shopId.'/'.$proConfig);
                            }
                        }
                        else
                        {
                            $edit=$this->input->post('edit');
                            if($edit)
                            {
                                $this->session->set_flashdata('flashError', 'Something went wrong');
                                redirect('backend/MyShopController/storeInfo/'.$shopId);
                            }
                            else
                            {
                                $this->session->set_flashdata('flashError', 'Something went wrong');
                                redirect('backend/MyShopController/viewProductsByShopId/'.$shopId.'/'.$proConfig);
                            }
                        }  
                                 
                    } 
                    catch (Exception $e) 
                    {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage());
                    }
                }else{
                    echo $error['error'];
                }
            }
        }
    }
    
    public function updateStoreDBTempProducts($shopId,$inserdata)
    {
        $this->dbConnection($shopId);
        $this->db->where('temp_shopId',$shopId);
        $query=$this->db->delete('temp_str_config');
        if($query)
        {
            $result = $this->import->importDataToBaseDB($inserdata); 
            
        }
    }
}
?>