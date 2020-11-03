<?php

class Key_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function listkey()
    {
        $this->db->from('tblkey');
        $this->db->join('tblemployee', 'tblkey.empCode=tblemployee.EmpCode');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_key($id)
    {
        return $this->db->get_where('tblkey', array('key' => $id))->row_array();
    }

    /*
     * Get all keys
     */
    function get_all_keys()
    {
        $this->db->order_by('keyCode', 'asc');
        return $this->db->get('tblkey')->result_array();
    }

    /*
     * function to add new key
     */
    function add_key($params)
    {
        
        return $this->db->insert('tblkey', $params);;
    }

    /*
     * function to update key
     */
    function update_key($id, $params)
    {
        $this->db->where('keyCode', $id);
        return $this->db->update('tblkey', $params);
    }

    /*
     * function to delete key
     */
    function delete_key($id)
    {
        return $this->db->delete('tblkey', array('key' => $id));
    }

    function delete_userlog($id)
    {
        return $this->db->delete('tbllogin', array('KeyCode' => $id));
    }

    function getloc()
    {
        $file = base_url('api/Fitur/gps.json');

        $anggota = file_get_contents($file);

        $data = json_decode($anggota, true);
        return $data;
    }
    function update_loc($latitude, $longitude, $vallatitude, $vallongitude)
    {
        $file = base_url('api/Fitur/gps.json');
        $anggota = file_get_contents($file);
        $masuk = json_decode($anggota, true);
        $masuk['data'][$latitude] = $vallatitude;
        $masuk['data'][$longitude] = $vallongitude;

        // $masuk = $data['data'];
        // $masukkuy[$latitude] = $data['data'][$latitude];       
        $jsonfile = json_encode($masuk, JSON_PRETTY_PRINT);
        
        $destination_folder = $_SERVER['DOCUMENT_ROOT'] . '/api/Fitur/gps.json';
        // var_dump($destination_folder);
        // die;
        $anggota = file_put_contents($destination_folder, $jsonfile);
        if ($anggota) {
            return true;
        } else {
            return false;
        }
    }
   
}
