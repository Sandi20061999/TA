<?php

class Dashboard_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
    function totaluser(){
        $this->db->from('tblemployee');
        return $this->db->count_all_results();
    }
    function totallog(){
        $this->db->from('tblattendancelog');
        return $this->db->count_all_results();
    }

    function totalkey(){
        $this->db->from('tblkey');
        return $this->db->count_all_results();
    }

}