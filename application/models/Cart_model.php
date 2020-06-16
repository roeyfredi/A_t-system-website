<?php

class Cart_model extends CI_Model {

    public function __construct() {
        //$this->load->database();
    }

    function update_cart($rowid, $qty, $price, $amount) {
        $data = array(
            'rowid' => $rowid,
            'qty' => $qty,
            'price' => $price,
            'amount' => $amount
        );

        $this->cart->update($data);
    }

    public function remove_after_order($rowid) {
        if ($rowid == "all") {
            $this->cart->destroy();
        } else {
            $data = array(
                'rowid' => $rowid,
                'qty' => 0
            );

            $this->cart->update($data);
        }
    }

}
