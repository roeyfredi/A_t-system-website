<?php

class Products_model extends CI_Model {

//put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_products() {
        $query = $this->db->query("select * from products");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_proudct_quantity($product_code) {
        $query = $this->db->query("select quantity from quantity_in_stock where product_code_fk='" . $product_code . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_multimedia_system_products() {
        $query = $this->db->query("select * from products where product_type='מערכת מולטימדיה'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_accessories_for_automobiles_products() {
        $query = $this->db->query("select * from products where product_type='אביזרי קמפינג לרכב'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_batteries_and_electronics_products() {
        $query = $this->db->query("select * from products where product_type='מצברים ואלקטרוניקה'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_car_accessories_products() {
        $query = $this->db->query("select * from products where product_type='אביזרים לרכב'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_pelephone_accessories_products() {
        $query = $this->db->query("select * from products where product_type='אביזרים לפלאפון'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_seat_coverings_products() {
        $query = $this->db->query("select * from products where product_type='כיסויי מושבים'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    function get_product_by_product_code($product_code) {
        $query = $this->db->query("select * from products where product_code='" . $product_code . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

}
