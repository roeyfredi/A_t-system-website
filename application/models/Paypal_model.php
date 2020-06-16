<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paypal_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->library('cart');
    }

    /* This function create new Service. */

    function create($user_number, $Total, $SubTotal, $Tax, $PaymentMethod, $PayerStatus, $PayerMail, $saleId, $CreateTime, $UpdateTime, $State, $supply) {
        $this->db->set('user_number_fk', $user_number);
        $this->db->set('txn_id', $saleId);
        $this->db->set('PaymentMethod', $PaymentMethod);
        $this->db->set('PayerStatus', $PayerStatus);
        $this->db->set('PayerMail', $PayerMail);
        $this->db->set('Total', $Total);
        $this->db->set('SubTotal', $SubTotal);
        $this->db->set('Tax', $Tax);
        $this->db->set('Payment_state', $State);
        $this->db->set('CreateTime', $CreateTime);
        $this->db->set('UpdateTime', $UpdateTime);
        $this->db->set('supply', $supply);
        $this->db->insert('payments');
        $id = $this->db->insert_id();
        return $id;
    }

    function insert_to_db_costumers_orders($last_order) {

        $order_number = $last_order[0]['order_number'];
        $user_number = $last_order[0]['user_number_fk'];
        $supply = $last_order[0]['supply'];
        $status = $last_order[0]['PayerStatus'];
        $total_price = $last_order[0]['Total'];

        $this->db->set('order_number_fk', $order_number);
        $this->db->set('user_number_fk', $user_number);
        $this->db->set('supply', $supply);
        $this->db->set('order_status', $status);
        $this->db->set('total_price', $total_price);
        $this->db->insert('costumers_orders');
    }

    function update_table_products_in_costumer_order($last_order) {

        $order_number = $last_order[0]['order_number'];

        $cart = $this->cart->contents();


        foreach ($cart as $item):

            $product_code = $item['id'];
            $quantity = $item['qty'];
            $price_per_unit = $this->Paypal_model->get_product_price_by_product_code_from_products_table($product_code);

            $price_per_unit = $price_per_unit[0]['retail_price'];

            $this->db->set('order_number_fk', $order_number);
            $this->db->set('product_code_fk', $product_code);
            $this->db->set('quantity', $quantity);
            $this->db->set('price_per_unit', $price_per_unit);
            $this->db->insert('products_in_order_of_costumers');

            $quantity_of_product = $this->db->query("select quantity from quantity_in_stock where product_code_fk='" . $product_code . "'");

            $quantity_array = $quantity_of_product->result_array();
            $convert_quantity_in_stock_to_int = (int) ($quantity_array[0]['quantity']);

            $quantity_in_order = (int) $quantity;
            $new_quantity_to_update = $convert_quantity_in_stock_to_int - $quantity_in_order;

            $data = array(
                'quantity' => $new_quantity_to_update
            );

            $this->db->where('product_code_fk', $product_code);
            $this->db->update('quantity_in_stock', $data);

        endforeach;
    }

    public function get_last_row_from_payments_table() {
        $query = $this->db->query("SELECT * FROM payments ORDER BY order_number DESC LIMIT 1");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_product_price_by_product_code_from_products_table($product_code) {
        $query = $this->db->query("SELECT products.retail_price FROM `products` WHERE product_code='" . $product_code . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

}
