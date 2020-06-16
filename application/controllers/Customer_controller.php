<?php

class Customer_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Purchases_model');
        $this->load->model('Products_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
    }

    public function personal_area() {
        $data['title'] = "איזור אישי";
        $data['user'] = $this->session->all_userdata();
        $user_number = $data['user']['user'][0]['user_number'];
        $data['user_info'] = $this->Users_model->get_user_information($user_number);
        $data['purchases'] = $this->Purchases_model->get_purchases_of_costumer($user_number);
        $data['product_purchase'] = $this->Purchases_model->get_products_in_purchase_of_costumer();
        $this->load->view('templates/header', $data);
        $this->load->view('users/personal_area', $data);
        $this->load->view('templates/footer');
        //echo $order_number;
    }

    public function contact() {
        $user = $this->session->all_userdata();

        $data['title'] = 'צור קשר';
        $data['user'] = $this->session->all_userdata();

        $this->load->view('templates/header', $data);
        $this->load->view('pages/Contact', $data);
        $this->load->view('templates/footer', $data);
    }

    public function contactNotes() {

        $contact_name = $this->input->post('contact_name');
        $contact_email = $this->input->post('contact_email');
        $contact_phone = $this->input->post('contact_phone');
        $contact_subject = $this->input->post('contact_subject');
        $contact_message = $this->input->post('contact_message');

        $validate = $this->validate();
        if ($validate == "") {

            $gotData = array(
                'contact_name' => $this->input->post('contact_name'),
                'contact_phone' => $this->input->post('contact_phone'),
                'contact_subject' => $this->input->post('contact_subject'),
                'contact_message' => $this->input->post('contact_message'),
            );
            $info = $this->Users_model->insert_contact_message_to_db($gotData);

            if ($info == NULL) {
                $data['info'] = array("message" => "1");
                $this->send_email($contact_name, $contact_email, $contact_phone, $contact_subject, $contact_message);
            }

            echo $data['info']['message'];
        } else {
            echo $validate;
        }
    }

    public function send_email($name, $email, $phone, $contact_subject, $contact_message) {
        
        
        $to = "business.a.t.system@gmail.com";
        $subject = "הודעה חדשה התקבלה באתר בנושא: " . $contact_subject . " בתאריך: " . date('d-m-Y');

        $message = "
<html>
<head>
<title>הודעה התקבלה מ- " . $name . " בתאריך: " . date('Y-m-d') . "</title>
</head>
<body>
<p>$contact_message</p>
<p>טלפון לחזרה: " . $phone . "</p>
<p>איימיל לחזרה: " . $email . " </p>

</body>
</html>
";

        // Always set content-type when sending HTML email
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


// More headers
        $headers .= 'From:' .$email;

        mail($to, $subject, $message, $headers);

       
    }


    public function validate() {
        if ($_POST) {
            $error = "";
            if (!$_POST['contact_name'] || !$_POST['contact_phone'] || !$_POST['contact_subject'] || !$_POST['contact_message']) {
                $error.="אין להשאיר שדות ריקים" . '<br>';
                return $error;
            }
            if (!preg_match("/^[א-ת ]*$/", $_POST['contact_name'])) {
                $error.="שם יכול להכיל אותיות בעברית בלבד" . '<br>';
            }


            if (!preg_match("/^[0-9 ]*$/", $_POST['contact_phone'])) {
                $error.="מספר הטלפון יכול להכיל מספרים בלבד" . '<br>';
            }
            if ($_POST['contact_phone']) {
                if (strlen($_POST['contact_phone']) != 10) {
                    $error.="מספר הטלפון חייב להכיל 10 ספרות" . '<br>';
                }
            }
        }
        return $error;
    }

    public function update_customer_profile() {
        $data['title'] = "עדכון פרופיל";
        $data['user'] = $this->session->all_userdata();
        $user_number = $this->input->get('user_number');
//echo ( $user_number );
        $data['user_info'] = $this->Users_model->get_user_information($user_number);
        $this->load->view('templates/header', $data);
        $this->load->view('users/update_customer_profile', $data);
        $this->load->view('templates/footer');
    }

    public function update_profile_notes() {

        $data = array(
            'user_number' => $this->input->post('user_number'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'adress' => $this->input->post('adress'),
            'city' => $this->input->post('city'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
        );

        $error = $this->validate_profile_update($data);

        if ($error == '') {
            $error_info = $this->Users_model->update_profile($data);
            if ($error_info == NULL) {
                $data['info'] = array("message" => "1");
            } else {
                $data['info'] = array("message" => "התגלתה טעות בהזנת הפרטים, אנא נסה שנית!");
            }
            echo $data["info"]["message"];
            print_r($error_info);
        } else {
            echo $error;
        }
    }

    public function validate_profile_update() {
        if ($_POST) {
            $error = "";
            if (!$_POST['first_name'] || !$_POST['last_name'] || !$_POST['phone'] || !$_POST['email'] || !$_POST['city'] || !$_POST['adress']) {
                $error.="אין להשאיר שדות ריקים" . '<br>';
                return $error;
            }
            if (!preg_match("/^[א-ת ]*$/", $_POST['first_name'])) {
                $error.="שם פרטי יכול להכיל אותיות בעברית בלבד" . '<br>';
            }
            if (!preg_match("/^[א-ת ]*$/", $_POST['last_name'])) {
                $error.="שם המשפחה יכול להכיל אותיות בעברית בלבד" . '<br>';
            }
            if ($_POST['email'] && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error .= "האימייל אינו תקין" . '<br>';
            }
            if (!preg_match("/^[0-9 ]*$/", $_POST['phone'])) {
                $error.="מספר הטלפון יכול להכיל מספרים בלבד" . '<br>';
            }
            if ($_POST['phone']) {
                if (strlen($_POST['phone']) != 10) {
                    $error.="מספר הטלפון חייב להכיל 10 ספרות" . '<br>';
                }
            }

            if (!preg_match("/^[א-ת ]*$/", $_POST['city'])) {
                $error.="שם העיר יכול להכיל אותיות בעברית בלבד" . '<br>';
            }

            if (preg_match("/^[a-zA-Z]*$/", $_POST['adress'])) {
                $error.="הכתובת שהוזנה לא חוקית" . '<br>';
            }
        }
        return $error;
    }

}
