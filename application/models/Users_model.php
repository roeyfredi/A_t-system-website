<?php

class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_costumers() {
        $query = $this->db->query("select * from users");
        return $query->result_array();
    }

    public function save_user($data) {
        $this->db->db_debug = FALSE;
        $error = NULL;
        if (!$this->db->insert('users', $data)) {
            $error = $this->db->error();
        }
        return $error;
    }

    public function auth($data) {
        $query = $this->db->query("select * from users where username='" . $data['user'] . "' and password='" . $data['password'] . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function insert_contact_message_to_db($data) {
        $this->db->db_debug = FALSE;
        $error = NULL;
        if (!$this->db->insert('contact_message', $data)) {
            $error = $this->db->error();
        }
        return $error;
    }

    public function get_user_information($user_number) {
        $query = $this->db->query("select * from users where user_number='" . $user_number . "'");
        if ($query) {
            return $query->result_array();
        }
        return false;
    }

    public function update_profile($data) {
        $this->db->db_debug = FALSE;


        $error = NULL;

        $this->db->where('user_number', $data['user_number']);
        $errorData = $this->db->update('users', $data);

        if (!$errorData) {
            $error = $this->db->error();
        }

        return $error;
    }

}
?>
    



