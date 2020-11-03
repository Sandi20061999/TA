<?php

class Login_model extends CI_Model{
    function validate($emp,$key){
        return $this->db->get_where('tblkey',array('empCode'=>$emp, 'key'=>$key))->row_array();
    }
}