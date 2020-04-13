<?php

class Login_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    public function login() {
        $data['title'] = 'התחברות';
        $data['user'] = NULL;
        $this->load->view('templates/header', $data);
        $this->load->view('users/Login', $data);
        $this->load->view('templates/footer', $data);
    }

    public function logout() {
        $data = array(
            'user',
            'password'
            
        );
        $this->session->unset_userdata($data);
        session_destroy();
        redirect("Homepage_controller/Homepage");
    }

    public function auth() {
        $data = array(
            'user' => $this->input->post('user'),
            'password' => md5($this->input->post('password')),
        );

        $result = $this->Users_model->auth($data);

        if ($result == false) {
            $data['error'] = array("message" => "שם משתמש או סיסמא שגויים, אנא נסה שנית");
            $data['user'] = NULL;
            $data['title'] = 'התחברות';
            $this->load->view('templates/header', $data);
            $this->load->view('users/Login', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data['user'] = $result;
            $this->session->set_userdata($data);
            redirect('Homepage_controller/Homepage');
        }
    }

}
