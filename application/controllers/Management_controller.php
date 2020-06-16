<?php

class Management_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Management_model');
        $this->load->model('Products_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    public function management_welcome_page() {

        $data['title'] = 'ניהול';
        $data['user'] = $this->session->all_userdata();
        $data['product_details'] = $this->Management_model->get_product_details();
        $data['top_products_sales'] = $this->Management_model->get_products_top_sales();
        $data['monthly_expenses'] = $this->Management_model->get_monthly_expenses();
        $data['monthly_income'] = $this->Management_model->get_monthly_income();
        $data['products_unit_sales_by_categories'] = $this->Management_model->get_products_unit_sales_by_categories();
        $data['products_sales_income_by_categories'] = $this->Management_model->get_products_sales_income_by_categories();
        $this->load->view('templates/header', $data);
        $this->load->view('management/management_welcome_page', $data);

        $this->load->view('templates/footer');
    }

    public function contacts_messages() {
        $data['title'] = 'הודעות מלקוחות';
        $data['user'] = $this->session->all_userdata();
        $data['messages'] = $this->Management_model->get_contacts_messages_from_db();

        $this->load->view('templates/header', $data);
        $this->load->view('management/contacts_messages', $data);
        $this->load->view('templates/footer');
    }

    public function remove_message_from_db() {
        $message_id = $this->input->get('message_id');
        $this->Management_model->remove_message_from_db($message_id);
        redirect('Management_controller/contacts_messages');
    }

    public function registered_customers() {
        $data['title'] = 'מאגר לקוחות';
        $data['user'] = $this->session->all_userdata();
        $data['customers'] = $this->Management_model->get_customers_from_db();
        $this->load->view('templates/header', $data);
        $this->load->view('management/registered_customers', $data);
        $this->load->view('templates/footer');
    }

    public function customer_orders() {
        $user_number = $this->input->get('user_number');
        $data['title'] = 'עסקאות לקוח';
        $data['user'] = $this->session->all_userdata();

        $data['customer_orders'] = $this->Management_model->get_customers_orders_from_db($user_number);
        $data['products_in_order'] = $this->Management_model->get_products_in_purchase_of_costumer();

        $this->load->view('templates/header', $data);
        $this->load->view('management/customer_orders', $data);
        $this->load->view('templates/footer');
    }

    public function remove_customer_from_db() {
        $user_number = $this->input->get('user_number');
        $this->Management_model->remove_customers_from_db($user_number);
        redirect('Management_controller/registered_customers');
    }

    public function add_new_product() {

        $data['title'] = 'הוסף מוצר חדש';
        $this->load->view('templates/header', $data);
        $this->load->view('management/Add_product');
        $this->load->view('templates/footer');
    }

    public function products_table() {

        $data['title'] = 'טבלת מוצרים';
        $data['user'] = $this->session->all_userdata();
        $data['product_details'] = $this->Management_model->get_product_details();
        $this->load->view('templates/header', $data);
        $this->load->view('management/quantity_in_stock', $data);
        $this->load->view('templates/footer');
    }

    public function inventory_orders() {

        $data['title'] = 'הזמנת מלאי';
        $data['product_details'] = $this->Management_model->get_product_details();
        $this->load->view('templates/header', $data);
        $this->load->view('management/inventory_orders', $data);
        $this->load->view('templates/footer');
    }

    public function inventory_orders_status() {

        $data['title'] = 'סטטוס הזמנות';
        $data['inventory_orders'] = $this->Management_model->get_inventory_orders();
        $data['products_details_in_inventory_order'] = $this->Management_model->get_products_details_in_inventory_order();
        $this->load->view('templates/header', $data);
        $this->load->view('management/inventory_orders_status', $data);
        $this->load->view('templates/footer');
    }

    public function create_new_order_inventory() {
        $data = array(
            'total_price' => 0,
        );
        $order_number = $this->Management_model->create_new_order_inventory($data);
        return $order_number;
    }

    public function update_inventory() {

        $i = 0;
        $calculate = 0;
        $total_price = 0;
        $order_number = $this->create_new_order_inventory();

        $data['product_details'] = $this->Management_model->get_product_details();
        $arrayt = ($this->input->post('quantity_of_product_to_order'));


        foreach ($data['product_details'] as $product):
            $quantity_of_product = (int) $arrayt[$i];
            if ($quantity_of_product != 0) {
                $calculate = 0;
                $data = array(
                    'order_number_fk' => $order_number[0]['order_number'],
                    'product_code_fk' => $product['product_code'],
                    'quantity_in_order' => $quantity_of_product,
                );

                $calculate = (int) ( ((int) $product['price_per_unit']) * (int) ($arrayt[$i]));
                $total_price = (int) ($total_price + $calculate);
                $send_to_db = $this->Management_model->update_product_quantity_in_order_inventory_details($data);
            }
            $i++;
        endforeach;
        $this->Management_model->update_total_price_in_table_inventory_orders($total_price, $order_number[0]['order_number']);
        echo "<script>
        alert('הזמנת מלאי בוצעה בהצלחה, צפה בה טבלת הזמנות המלאי');
        window.location.href='management_welcome_page';
        </script>";
    }

    public function update_product() {

        $data['title'] = 'עדכון מוצר';
        $product_code = $this->input->get('product_code');
        $data['product'] = $this->Management_model->get_product_by_product_code($product_code);
        $data['product_quantity'] = $this->Management_model->get_quantity_of_product($product_code);
        $this->load->view('templates/header', $data);
        $this->load->view('management/update_product', $data);
        $this->load->view('templates/footer');
    }

    public function add_products_notes() {

        if (isset($_FILES['image_file']['tmp_name'])) {
            $image = $_FILES['image_file']['tmp_name'];
            $data = array(
                'product_code' => $this->input->post('product_code'),
                'product_type' => $this->input->post('product_type'),
                'model' => $this->input->post('model'),
                'company' => $this->input->post('company'),
                'description' => $this->input->post('description'),
                'supplier' => $this->input->post('supplier'),
                'price_per_unit' => $this->input->post('price_per_unit'),
                'retail_price' => $this->input->post('retail_price'),
                'image' => file_get_contents(addslashes($image)),
            );
        } else {
            $data = array(
                'product_code' => $this->input->post('product_code'),
                'product_type' => $this->input->post('product_type'),
                'model' => $this->input->post('model'),
                'company' => $this->input->post('company'),
                'description' => $this->input->post('description'),
                'supplier' => $this->input->post('supplier'),
                'price_per_unit' => $this->input->post('price_per_unit'),
                'retail_price' => $this->input->post('retail_price'),
            );
        }
        $quantity_data = array(
            'product_code_fk' => $this->input->post('product_code'),
            'quantity' => $this->input->post('quantity'),
        );



        $error = $this->Management_model->checkProduct($data);
        $error_quantity = $this->Management_model->checkProductQuantity($quantity_data);
        if ($error == '' && $error_quantity == '') {
            $error_info = $this->Management_model->save_new_product($data);
            $error_info_quantity = $this->Management_model->save_new_quantity($quantity_data);
            if ($error_info == NULL && $error_info_quantity == NULL) {
                $data['info'] = array("message" => "1");
            } else {
                $data['info'] = array("message" => "המוצר שהזנת קיים במערכת(קוד מוצר קיים במאגר), אנא נסה שנית");
            }
            echo $data["info"]["message"];
        } else {
            echo $error;
            echo $error_quantity;
        }
    }

    public function update_products_notes() {


        $data = array(
            'product_code' => $this->input->post('product_code'),
            'model' => $this->input->post('model'),
            'company' => $this->input->post('company'),
            'description' => $this->input->post('description'),
            'supplier' => $this->input->post('supplier'),
            'price_per_unit' => $this->input->post('price_per_unit'),
            'retail_price' => $this->input->post('retail_price'),
        );

        $error = $this->Management_model->checkUpdateProduct($data);
        if ($error == '') {
            $error_info = $this->Management_model->update_product($data);
            if ($error_info == NULL) {
                $data['info'] = array("message" => "1");
            } else {
                $data['info'] = array("message" => "התגלתה טעות בהזנת פרטי מוצר, אנא נסה שנית!");
            }
            echo $data["info"]["message"];
            print_r($error_info);
        } else {
            echo $error;
        }
    }

    public function remove_product() {
        $product_code = $this->input->get('product_code');

        $error = $this->Management_model->remove_product_from_DB($product_code);
        if ($error == NULL) {
            echo "<script>
        alert('המוצר נמחק בהצלחה');
        window.location.href='products_table';
        </script>";
        } else {
            echo '<script language="javascript">';
            echo 'alert("ישנה שגיאה, המוצר לא נמחק!")';
            echo '</script>';
        }
    }

    public function update_quantity_in_stock_from_inventory_orders_status_page() {
        $order_number = $this->input->post('order_number');
        $get_order_details = $this->Management_model->get_order_details_from_inventory_orders_by_order_number($order_number);
        $update_quantity_in_stock = $this->Management_model->update_quantity_in_stock_from_inventory_orders($get_order_details);
        $update_order_status = $this->Management_model->update_order_status_in_inventory_orders_table($order_number);

        //print_r($get_order_details);
        // echo "<br>";
        //print_r($update_quantity_in_stock);
        echo "<script>
        alert('המלאי עודכן בהצלחה, הנך מועבר לעמוד ניהול');
        window.location.href='management_welcome_page';
        </script>";
    }

}

?>