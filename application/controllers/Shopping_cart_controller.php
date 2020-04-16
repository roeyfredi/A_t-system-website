<?php

class Shopping_cart_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Products_model');
        $this->load->model('Cart_model');
        $this->load->library('cart');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    function shopping_cart_page() {

        $data['title'] = "הסל שלי";

        $this->load->view('templates/header', $data);
        $this->load->view('pages/shopping_cart', $data);
        $this->load->view('templates/footer');
    }

    function add_to_shopping_cart() {

        $cart_data = array(
            'id' => $this->input->post('product_code'),
            'price' => $this->input->post('product_price'),
            'qty' => $this->input->post('qty'),
            'name' => $this->input->post('model'),
        );
        $this->cart->insert($cart_data);

        redirect('Shopping_cart_controller/shopping_cart_page');
//        print_r($cart_data);
    }

    function remove($rowid) {
        if ($rowid == "all") {
            $this->cart->destroy();
        } else {
            $data = array(
                'rowid' => $rowid,
                'qty' => 0
            );

            $this->cart->update($data);
        }

        redirect('Shopping_cart_controller/shopping_cart_page');
    }

    function update_cart() {
        foreach ($_POST['cart'] as $id => $cart) {
            $price = $cart['price'];
            $amount = $price * $cart['qty'];

            $this->Cart_model->update_cart($cart['rowid'], $cart['qty'], $price, $amount);
        }

        redirect('Shopping_cart_controller/shopping_cart_page');
    }

}
