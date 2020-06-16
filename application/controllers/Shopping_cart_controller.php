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
        $data['user'] = $this->session->all_userdata();
        $this->load->view('templates/header', $data);
        $this->load->view('pages/shopping_cart', $data);
        $this->load->view('templates/footer');
    }

    function add_to_shopping_cart() {

        $product_code = $this->input->post('product_code');
        $data['product_quantity'] = $this->Products_model->get_proudct_quantity($product_code);

        $cart_data = array(
            'id' => $this->input->post('product_code'),
            'price' => $this->input->post('product_price'),
            'qty' => $this->input->post('qty'),
            'name' => $this->input->post('model'),
        );
        $this->cart->insert($cart_data);

//        redirect('' . $data);
//        $this->session->set_flashdata('product_quantity','data');

        return redirect('Shopping_cart_controller/shopping_cart_page/')->with('data', $data);

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

            $product_code = $cart['id'];
            $data['product_quantity'] = $this->Products_model->get_proudct_quantity($product_code);

            if ($data['product_quantity'][0]['quantity'] < $cart['qty'] && is_numeric($cart['qty'])) {
                $cart['qty'] = $data['product_quantity'][0]['quantity'];
            }

            if (!is_numeric($cart['qty'])) {
                echo "<script>
                alert('כמות המוצר באחד מן השדות מולא לא כראוי, הכמות עודכנה ל-1');
                </script>";
                $cart['qty'] = 1;
            }

            $price = $cart['price'];
            $amount = $price * $cart['qty'];


            $this->Cart_model->update_cart($cart['rowid'], $cart['qty'], $price, $amount);
        }
        echo "<script>
        alert('העגלה עודכנה בהצלחה');
        window.location.href='shopping_cart_page';
        </script>";  
    }

}
