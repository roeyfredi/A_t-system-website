<?php

class Products_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Products_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    public function multi_media_systems_page() {
        $data['title'] = 'מערכות ואביזרים לרכב';
        $data['multimedia_systems_products'] = $this->Products_model->get_multimedia_system_products();
        $this->load->view('templates/header', $data);
        $this->load->view('products/multimedia_systems', $data);
        $this->load->view('templates/footer', $data);
    }

    public function accessories_for_automobiles_page() {
        $data['title'] = 'אביזרי קמפינג לרכב';
        $data['accessories_for_automobiles'] = $this->Products_model->get_accessories_for_automobiles_products();
        $this->load->view('templates/header', $data);
        $this->load->view('products/accessories_for_automobiles', $data);
        $this->load->view('templates/footer', $data);
    }

    public function batteries_and_electronics_page() {
        $data['title'] = 'מצברים ואלקטרוניקה';
        $data['batteries_and_electronics'] = $this->Products_model->get_batteries_and_electronics_products();
        $this->load->view('templates/header', $data);
        $this->load->view('products/batteries_and_electronics', $data);
        $this->load->view('templates/footer', $data);
    }

    public function car_accessories_page() {
        $data['title'] = 'אביזרים לרכב';
        $data['car_accessories'] = $this->Products_model->get_car_accessories_products();
        $this->load->view('templates/header', $data);
        $this->load->view('products/car_accessories', $data);
        $this->load->view('templates/footer', $data);
    }

    public function pelephone_accessories_page() {
        $data['title'] = 'אביזרים לטלפון';
        $data['pelephone_accessories'] = $this->Products_model->get_pelephone_accessories_products();
        $this->load->view('templates/header', $data);
        $this->load->view('products/pelephone_accessories', $data);
        $this->load->view('templates/footer', $data);
    }

    public function seat_coverings_page() {
        $data['title'] = 'כיסויי מושבים';
        $data['seat_coverings'] = $this->Products_model->get_seat_coverings_products();
        $this->load->view('templates/header', $data);
        $this->load->view('products/seat_coverings', $data);
        $this->load->view('templates/footer', $data);
    }

    public function product_page() {

        $product_code = $this->input->get('product_code');
        $product = $this->Products_model->get_product_by_product_code($product_code);

        $data['title'] = '';
        $data['user'] = null;
        $data['user'] = $this->session->all_userdata();
        $data['product_details'] = $product;
        $this->load->view('templates/header', $data);
        $this->load->view('products/product_page', $data);
        $this->load->view('templates/footer', $data);
    }
}
