<?php
class Contact_controller extends CI_Controller {
    
     public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }
    
    function contact() {
        $user = $this->session->all_userdata();   
        
        $data['title'] = 'צור קשר';
        $data['user'] = $this->session->all_userdata();
        
        $this->load->view('templates/header', $data);
        $this->load->view('pages/Contact', $data);
        $this->load->view('templates/footer', $data);
    }
}
