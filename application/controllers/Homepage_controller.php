<?php

class Homepage_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Products_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    function Homepage() {
        $user = $this->session->all_userdata();   
        
        $data['title'] = 'אביזרים ומערכות לרכב A.T System';
        $data['user'] = $this->session->all_userdata();
        $data['products']=$this->Products_model->get_products();
        
        $this->load->view('templates/header', $data);
        $this->load->view('pages/Homepage', $data);
        $this->load->view('templates/footer', $data);
    }

}
