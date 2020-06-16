<?php

class Management_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_customers_from_db() {
        $query = $this->db->query("select * from users");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_products_top_sales() {
        $query = $this->db->query(" SELECT product_code_fk, products.model, sum(quantity) from products_in_order_of_costumers INNER JOIN products on products.product_code=products_in_order_of_costumers.product_code_fk GROUP BY (product_code_fk) ORDER by SUM(quantity) DESC limit 5");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_monthly_expenses() {
        $query = $this->db->query("select total_price,order_date from inventory_orders WHERE MONTH(inventory_orders.order_date) = MONTH(CURRENT_DATE())
        AND YEAR(inventory_orders.order_date) = YEAR(CURRENT_DATE());");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_monthly_income() {
        $query = $this->db->query("select sum(total_price) from costumers_orders WHERE MONTH(costumers_orders.order_date) = MONTH(CURRENT_DATE()) AND YEAR(costumers_orders.order_date) = YEAR(CURRENT_DATE())");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_hot_products() {
        $query = $this->db->query(" SELECT product_code_fk, products.model, sum(quantity),products.image,products.retail_price from products_in_order_of_costumers INNER JOIN products on products.product_code=products_in_order_of_costumers.product_code_fk GROUP BY (product_code_fk) ORDER by SUM(quantity) DESC limit 7");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_products_unit_sales_by_categories() {
        $query = $this->db->query("select product_type,sum(quantity) from products INNER JOIN products_in_order_of_costumers ON products_in_order_of_costumers.product_code_fk=products.product_code INNER JOIN costumers_orders ON costumers_orders.order_number_fk=products_in_order_of_costumers.order_number_fk WHERE MONTH(costumers_orders.order_date) = MONTH(CURRENT_DATE()) AND YEAR(costumers_orders.order_date) = YEAR(CURRENT_DATE()) GROUP BY(products.product_type);
");
        if ($query) {
            return $query->result_array();
        }
    }

    public function get_products_sales_income_by_categories() {
        $query = $this->db->query("select product_type,sum(products_in_order_of_costumers.price_per_unit*products_in_order_of_costumers.quantity) from products INNER JOIN products_in_order_of_costumers ON products_in_order_of_costumers.product_code_fk=products.product_code INNER JOIN costumers_orders ON costumers_orders.order_number_fk=products_in_order_of_costumers.order_number_fk WHERE MONTH(costumers_orders.order_date) = MONTH(CURRENT_DATE()) AND YEAR(costumers_orders.order_date) = YEAR(CURRENT_DATE()) GROUP BY(products.product_type)");
        if ($query) {
            return $query->result_array();
        }
    }

    public function get_contacts_messages_from_db() {
        $query = $this->db->query("select * from contact_message");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function remove_message_from_db($message_id) {
        $query = $this->db->query("delete from contact_message where message_id='" . $message_id . "'");
        if ($query) {
            return true;
        }
        return false;
    }

    public function remove_customers_from_db($user_number) {
        $query = $this->db->query("delete from users where user_number='" . $user_number . "'");
        if ($query) {
            return true;
        }
        return false;
    }

    public function get_customers_orders_from_db($user_number) {
        $query = $this->db->query("select * from costumers_orders where user_number_fk='" . $user_number . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_products_in_purchase_of_costumer() {
        $query = $this->db->query("select products_in_order_of_costumers.order_number_fk, products_in_order_of_costumers.product_code_fk, products_in_order_of_costumers.quantity, products_in_order_of_costumers.price_per_unit, products.model, products.image from products inner join products_in_order_of_costumers on products_in_order_of_costumers.product_code_fk = products.product_code ORDER BY(products_in_order_of_costumers.order_number_fk)");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function save_new_product($data) {
        $this->db->db_debug = FALSE;

        $error = NULL;
        if (!$this->db->insert('products', $data)) {
            $error = $this->db->error();
        }

        return $error;
    }

    public function save_new_quantity($data) {
        $this->db->db_debug = FALSE;

        $error = NULL;
        if (!$this->db->insert('quantity_in_stock', $data)) {
            $error = $this->db->error();
        }

        return $error;
    }

    public function update_product($data) {
        $this->db->db_debug = FALSE;


        $error = NULL;

        $this->db->where('product_code', $data['product_code']);
        $errorData = $this->db->update('products', $data);

        if (!$errorData) {
            $error = $this->db->error();
        }

        return $error;
    }

    public function remove_product_from_DB($product_code) {
        $this->db->db_debug = FALSE;

        $error = NULL;

        $this->db->where('product_code', $product_code);
        $delete_product = $this->db->delete('products');

        if (!$delete_product) {
            $error = $this->db->error();
        }

        return $error;
    }

    public function update_product_quantity_in_order_inventory_details($data) {
        $this->db->db_debug = FALSE;
        $this->db->insert('order_inventory_details', $data);

        return null;
    }

    public function update_total_price_in_table_inventory_orders($total_price, $order_number) {

        $this->db->set('total_price', $total_price, false);
        $this->db->where('order_number', $order_number);
        $errorQuantity = $this->db->update('inventory_orders');
    }

    public function create_new_order_inventory($data) {
        $this->db->db_debug = FALSE;
        $this->db->insert('inventory_orders', $data);

        $query = $this->db->query("select order_number from inventory_orders order by order_number DESC limit 1");
        return $query->result_array();
    }

    public function get_order_details_from_inventory_orders_by_order_number($order_number) {
        $query = $this->db->query("select product_code_fk, quantity_in_order from order_inventory_details where order_number_fk='" . $order_number . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function update_quantity_in_stock_from_inventory_orders($order_details) {

        $size_of_array = sizeof($order_details);

        for ($i = 0; $i < $size_of_array; $i++) {

            $quantity_in_stock = $this->db->query("select quantity from quantity_in_stock where product_code_fk='" . $order_details[$i]['product_code_fk'] . "'");

            $quantity_array = $quantity_in_stock->result_array();
            $convert_quantity_in_stock_to_int = (int) ($quantity_array[0]['quantity']);

            $quantity_to_update = (int) $order_details[$i]['quantity_in_order'];
            $new_quantity_to_update = $convert_quantity_in_stock_to_int + $quantity_to_update;

            $data = array(
                'quantity' => $new_quantity_to_update
            );

            $this->db->where('product_code_fk', $order_details[$i]['product_code_fk']);
            $this->db->update('quantity_in_stock', $data);
        }
        return true;
    }

    public function update_order_status_in_inventory_orders_table($order_number) {
        $update_status = (int) 1;

        $data = array(
            'order_status' => $update_status
        );

        $this->db->where('order_number', $order_number);
        $this->db->update('inventory_orders', $data);
    }

    public function get_product_details() {
        $query = $this->db->query("select products.product_code, products.product_type, products.model,products.company,products.supplier,products.price_per_unit,products.retail_price, quantity_in_stock.quantity from products inner join quantity_in_stock on quantity_in_stock.product_code_fk=products.product_code ORDER BY(products.product_code);");
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

    function get_quantity_of_product($product_code) {
        $query = $this->db->query("select quantity from quantity_in_stock where product_code_fk='" . $product_code . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    function get_inventory_orders() {
        $query = $this->db->query("select * from inventory_orders");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function get_products_details_in_inventory_order() {
        $query = $this->db->query("select order_inventory_details.order_number_fk, order_inventory_details.product_code_fk, products.model, order_inventory_details.quantity_in_order, products.image, products.price_per_unit from products inner join order_inventory_details on order_inventory_details.product_code_fk = products.product_code ORDER BY(order_inventory_details.order_number_fk);");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function checkProduct($data) {
        $error = '';

        if ($data['product_code'] == NULL) {
            $error .= "יש  למלא קוד המוצר" . "<br>";
        } else if (strlen($data['product_code']) != 4) {
            $error .= "קוד מוצר צריך להיות 4 מספרים בלבד" . "<br>";
        } else if (!is_numeric($data['product_code'])) {
            $error .= "קוד מוצר מחוייב במספרים בלבד" . "<br>";
        }

        if ($data['model'] == NULL) {
            $error .= "יש למלא דגם המוצר" . "<br>";
        }

        if ($data['company'] == NULL) {
            $error .= "יש למלא חברת המוצר" . "<br>";
        } else if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['company'])) {
            $error .= "החברה מחוייבת באותיות בלבד" . "<br>";
        }

        if ($data['description'] == NULL) {
            $error .= "יש למלא תיאור מוצר" . "<br>";
        }
        if (!isset($_FILES['image_file']['tmp_name'])) {
            $error .= "יש לעלות תמונת מוצר" . "<br>";
        }
        if ($data['supplier'] == NULL) {
            $error .= "יש למלא ספק מוצר" . "<br>";
        } else if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['supplier'])) {
            $error .= "הספק מחוייב באותיות בלבד" . "<br>";
        }

        if ($data['price_per_unit'] == NULL) {
            $error .= "יש למלא מחיר המוצר" . "<br>";
        } else if (!is_numeric($data['price_per_unit'])) {
            $error .= "מחיר מוצר מחוייב במספרים בלבד" . "<br>";
        }


        if ($data['retail_price'] == NULL) {
            $error .= "יש למלא את מחיר המוצר לצרכן" . "<br>";
        } else if (!is_numeric($data['retail_price'])) {
            $error .= "מחיר לצרכן מחוייב במספרים בלבד" . "<br>";
        }

        return $error;
    }

    public function checkProductQuantity($data) {

        $error = '';

        if (!is_numeric($data['quantity'])) {
            $error .= "כמות במלאי מחוייב במספרים בלבד" . "<br>";
        }
        if ($data['quantity'] == NULL) {
            $error .= "יש למלא כמות במלאי " . "<br>";
        }

        return $error;
    }

    public function checkUpdateProduct($data) {
        $error = '';

        if ($data['model'] == NULL) {
            $error .= "יש למלא דגם המוצר" . "<br>";
        }

        if ($data['company'] == NULL) {
            $error .= "יש למלא חברת המוצר" . "<br>";
        } else if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['company'])) {
            $error .= "החברה מחוייבת באותיות בלבד" . "<br>";
        }

        if ($data['description'] == NULL) {
            $error .= "יש למלא תיאור מוצר" . "<br>";
        }

        if ($data['supplier'] == NULL) {
            $error .= "יש למלא ספק מוצר" . "<br>";
        } else if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['supplier'])) {
            $error .= "הספק מחוייב באותיות בלבד" . "<br>";
        }

        if ($data['price_per_unit'] == NULL) {
            $error .= "יש למלא מחיר המוצר" . "<br>";
        } else if (!is_numeric($data['price_per_unit'])) {
            $error .= "מחיר מוצר מחוייב במספרים בלבד" . "<br>";
        }

        if ($data['retail_price'] == NULL) {
            $error .= "יש למלא את מחיר המוצר לצרכן" . "<br>";
        } else if (!is_numeric($data['retail_price'])) {
            $error .= "מחיר לצרכן מחוייב במספרים בלבד" . "<br>";
        }

        return $error;
    }

}
