<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportExcelController extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('backend/ExportExcelModel','eem');
        $this->load->library("excel");
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

    //Online order export to excel
    public function exportProductData($shopId)
    {
        $this->dbConnection($shopId);
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);

        $table_columns = array("Category", "Sub-Category", "Brand", "Product Name","Product Description","Product Price","Offer Price","Product Image","Hide Product");

        $column = 0;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        
    
        $employee_data = $this->eem->exportProductData($shopId);
        
        
        
        $excel_row = 2;

        foreach($employee_data as $row)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->product_category_id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->product_subCategory);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->product_brand);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->product_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->product_description);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->product_price);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->offer_price);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->product_img);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Product Details.xls"');
        $object_writer->save('php://output');
    }
    
    public function exportProductDataFromBaseDB()
    {
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);

        $table_columns = array("Category","Sub-Category", "Brand", "Product Name","Product Type","Product Sub-Type","Product Description","Product Weight","Product Weight Type","Product Qty","Product Price","Offer Price","Product Image","Hide Product");

        $column = 0;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        
    
        // $employee_data = $this->eem->exportProductDataFromBaseDB();
        
        
        
        $excel_row = 2;

        // foreach($employee_data as $row)
        // {
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->product_category);
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->product_brand);
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->product_name);
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->product_description);
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->product_price);
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->offer_price);
        //     $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->product_img);
        //     $excel_row++;
        // }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Product Details.xls"');
        $object_writer->save('php://output');
    }
    
    public function exportProductDataFromTemp($shopId)
    {
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);

        $table_columns = array("Category","Sub-Category", "Brand", "Product Name","Product Type","Product Sub-Type","Product Description","Product Weight","Product Weight Type","Product Qty","Product Price","Offer Price","Product Image","Hide Product");

        $column = 0;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        
    
        $product_data = $this->eem->exportProductDataFromTemp($shopId);
        
        $excel_row = 2;
        rsort($product_data);
        foreach($product_data as $row)
        {
            
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->category);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sub_category);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->brand);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->product_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->product_type);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->product_sub_type);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->product_description);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->product_weight);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->product_weight_type);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->product_qty);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->product_price);
            $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->offer_price);
            $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->product_img);
            $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->hide_product);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Product Details.xls"');
        $object_writer->save('php://output');
    }
}