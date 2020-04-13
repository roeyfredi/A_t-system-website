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
}
    ?>
    



