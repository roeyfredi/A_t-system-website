<?php

class Purchases_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_purchases_of_costumer($user_number) {
        $query = $this->db->query("select * from costumers_orders where user_number_fk='" . $user_number . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }
    
    public function get_products_in_purchase_of_costumer() {
        //$query = $this->db->query("select * from products_in_order_of_costumers where order_number_fk='" . $order_number . "'");
        $query = $this->db->query("select products_in_order_of_costumers.order_number_fk, products_in_order_of_costumers.product_code_fk, products_in_order_of_costumers.quantity, products_in_order_of_costumers.price_per_unit, products.image, products.model from products inner join products_in_order_of_costumers on products_in_order_of_costumers.product_code_fk = products.product_code ORDER BY(products_in_order_of_costumers.order_number_fk)");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

}
?>