<?php

class Registration_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('javascript');
        $this->load->library('session');
    }

    public function register() {

        $data['title'] = 'הרשמה';
        $data['user'] = NULL;
        $this->load->view('templates/header', $data);
        $this->load->view('users/Registration', $data);
        $this->load->view('templates/footer', $data);
    }

    public function registerNotes() {

        $validate = $this->validate();
        if ($validate == "") {
            $gotData = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')),
                'city' => $this->input->post('city'),
                'adress' => $this->input->post('adress'),
            );
            $info = $this->Users_model->save_user($gotData);

            if ($info == NULL) {
                $data['info'] = array("message" => "1");
            } else {
                $data['info'] = array("message" => "שם משתמש קיים במערכת, אנא נסה שנית");
            }
            echo $data['info']['message'];
        } else {
            echo $validate;
        }
    }

    public function validate() {
        if ($_POST) {
            $error = "";
            if (!$_POST['first_name'] || !$_POST['last_name'] || !$_POST['phone'] || !$_POST['email'] || !$_POST['username'] || !$_POST['password'] || !$_POST['passwordConf'] || !$_POST['city'] || !$_POST['adress']) {
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
            if (!preg_match("/^[a-zA-Z]*$/", $_POST['username']))  {
                $error.="שם המשתמש יכול להכיל אותיות באנגלית בלבד" . '<br>';
                
            }
            if (($_POST['password']) != ($_POST['passwordConf'])) {
                $error.="הסיסמאות אינן תואמות" . '<br>';
            }
            if (!preg_match("/^[א-ת ]*$/", $_POST['city'])) {
                $error.="שם העיר יכול להכיל אותיות בעברית בלבד" . '<br>';
            }

            if(preg_match("/^[a-zA-Z]*$/", $_POST['adress'])){
                $error.="הכתובת שהוזנה לא חוקית".'<br>';
            }

        }
        return $error;
    }

}
?>