<?php

class Management_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    public function products_management() {

        $data['title'] = 'ניהול מלאי';
        $this->load->view('templates/header', $data);
        $this->load->view('management/Add_product', $data);
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

        $error = $this->checkProduct($data);
        if ($error == '') {
            $error_info = $this->Products_model->save_product($data);
            if ($error_info == NULL) {
                $data['info'] = array("message" => "1");
            } else {
                $data['info'] = array("message" => "המוצר שהזנת קיים במערכת(קוד מוצר קיים במאגר), אנא נסה שנית");
            }
            echo $data["info"]["message"];
        } else {
            echo $error;
        }
    }

    public function checkProduct($data) {
        $error = '';

        if ($data['product_code'] == NULL) {
            $error .= "יש  למלא קוד המוצר" . "<br>";
        }
        if ($data['product_type'] == NULL) {
            $error .= "יש למלא  סוג המוצר" . "<br>";
        }
        if ($data['model'] == NULL) {
            $error .= "יש למלא דגם המוצר" . "<br>";
        }
        if ($data['company'] == NULL) {
            $error .= "יש למלא חברת המוצר" . "<br>";
        }
        if ($data['description'] == NULL) {
            $error .= "יש למלא תיאור מוצר" . "<br>";
        }
        if (!isset($_FILES['image_file']['tmp_name'])) {
            $error .= "יש לעלות תמונת מוצר" . "<br>";
        }
        if ($data['supplier'] == NULL) {
            $error .= "יש למלא ספק מוצר" . "<br>";
        }

        if ($data['price_per_unit'] == NULL) {
            $error .= "יש למלא מחיר המוצר" . "<br>";
        }

        if ($data['retail_price'] == NULL) {
            $error .= "יש למלא את מחיר המוצר לצרכן" . "<br>";
        }
        if (strlen($data['product_code']) != 4) {
            $error .= "קוד מוצר צריך להיות 4 מספרים בלבד" . "<br>";
        }
        if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['product_type'])) {
            $error .= "סוג המוצר מחוייב באותיות בלבד" . "<br>";
        }
        if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['company'])) {
            $error .= "החברה מחוייבת באותיות בלבד" . "<br>";
        }
        if (!preg_match("/^[a-zA-Zא-ת ]*$/", $data['supplier'])) {
            $error .= "הספק מחוייב באותיות בלבד" . "<br>";
        }
        if (!is_numeric($data['product_code'])) {
            $error .= "קוד מוצר מחוייב במספרים בלבד" . "<br>";
        }
        if (!is_numeric($data['price_per_unit'])) {
            $error .= "מחיר מוצר מחוייב במספרים בלבד" . "<br>";
        }

        if (!is_numeric($data['retail_price'])) {
            $error .= "מחיר לצרכן מחוייב במספרים בלבד" . "<br>";
        }

        return $error;
    }

}

?>