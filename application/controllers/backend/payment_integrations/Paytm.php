<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paytm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('payment_integration/PaytmModel', 'Paytm');
        $this->load->library('session');
    }

    public function index() {
        // $data['main_content']='backend/paymentIntegration/paytm';
        $this->load->view('payment_integrations/paytm');
    }

    public function pgRedirect() 
    {
        $this->load->view("payment_integrations/PaytmKit/pgRedirect");
    }

    public function pgResponse() {
        $data = array(
            "Paytm" => $this->Paytm
        );
        $this->load->view("payment_integrations/PaytmKit/pgResponse", $data);
    }

}
