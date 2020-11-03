<?php
error_reporting(0);
class Listuser_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function listuser()
    {
        $this->db->from('tblemployee');
        $query = $this->db->get();
        return $query->result_array();
    }

    function detailuser($emp)
    {
        $this->db->from('tblemployee');
        $this->db->where('EmpCode', $emp);
        $query = $this->db->get();
        return $query->row_array();
    }

    // function dat($date)
    // {
    //     $this->db->from('tblattendancelog');
    //     $this->db->where('Dt', $date);
    //     $this->db->order_by('Tm', 'ASC');
    //     $query = $this->db->get();
    //     return $query->row_array();
    // }

    // function pul($date)
    // {
    //     $this->db->from('tblattendancelog');
    //     $this->db->where('Dt', $date);
    //     $this->db->order_by('Tm', 'DESC');
    //     $query = $this->db->get();
    //     return $query->row_array();
    // }

    // function dropdownaddkey()
    // {
    //     // $this->db->select('EmpCode','EmpName','user_id');
    //     $this->db->from('tblemployee');
    //     $this->db->join('tblkey', 'tblemployee.EmpCode = tblkey.empCode', 'left');
    //     $this->db->where('tblkey.empCode', null);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    // function tanggal($emp, $ta = null, $tb = null)
    // {
    //     if ($ta != null && $tb != null) {
    //         $this->db->select('DISTINCT(Dt)');
    //         $this->db->from('tblempworkschedule');
    //         $array = array('EmpCode' => $emp, 'Dt >=' => $ta, 'Dt <=' => $tb);
    //         $this->db->where($array);
    //         $query = $this->db->get();
    //         return $query->result_array();
    //     } else {
    //         $this->db->select('DISTINCT(Dt)');
    //         $this->db->from('tblempworkschedule');
    //         $this->db->where('EmpCode', $emp);
    //         $query = $this->db->get();
    //         return $query->result_array();
    //     }
    // }

    // function jammasuk($emp)
    // {
    //     $this->db->from('tblempworkschedule');
    //     $this->db->join('tblworkschedule', 'tblempworkschedule.WSCode = tblworkschedule.WSCode');
    //     $this->db->where('EmpCode', $emp);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    // function absenmasuk($emp, $dt, $ra, $rb)
    // {
    //     $this->db->from('tblattendancelog');
    //     $array = array('EmpCode' => $emp, 'Dt' => $dt, 'Tm >=' => $ra, 'Tm <=' => $rb);
    //     $this->db->where($array);
    //     $this->db->order_by('Tm', 'ASC');
    //     $query = $this->db->get();
    //     return $query->row_array();
    // }

    // function absenpulang($emp, $dt, $ra, $rb)
    // {
    //     $this->db->from('tblattendancelog');
    //     $array = array('EmpCode' => $emp, 'Dt' => $dt, 'Tm >=' => $ra, 'Tm <=' => $rb);
    //     $this->db->where($array);
    //     $this->db->order_by('Tm', 'DESC');
    //     $query = $this->db->get();
    //     return $query->row_array();
    // }

    function get_all_empworkschedule($emp)
    {
        $this->db->select('tblworkschedule.WSCode, Type, WSName, HolidayInd,In1, Out1, tblempworkschedule.CreateDt, Dt');
        $this->db->where('EmpCode', $emp);
        $this->db->order_by('Dt', 'DESC');
        $this->db->join('tblworkschedule', 'tblempworkschedule.WSCode = tblworkschedule.WSCode');
        return $this->db->get('tblempworkschedule')->result_array();
    }

    function add_schedule($params)
    {
        return $this->db->insert('tblempworkschedule', $params);
    }

    function get_schedule($emp, $Dt)
    {
        $this->db->from('tblempworkschedule');
        $this->db->where('EmpCode', $emp);
        $this->db->where('Dt', $Dt);
        $query = $this->db->get();
        return $query->row_array();
    }

    function edit_schedule($emp, $Dt, $params)
    {
        $this->db->where('EmpCode', $emp);
        $this->db->where('Dt', $Dt);
        return $this->db->update('tblempworkschedule', $params);
    }

    function delete_schedule($emp, $Dt)
    {
        return $this->db->delete('tblempworkschedule', array('EmpCode' => $emp, 'Dt' => $Dt));
    }

    function get_user($EmpCode)
    {
        return $this->db->get_where('tblemployee', array('EmpCode' => $EmpCode))->row_array();
    }
    function add_user($params)
    {
        return $this->db->insert('tblemployee', $params);
    }

    function update_user($EmpCode, $params)
    {
        $this->db->where('EmpCode', $EmpCode);
        return $this->db->update('tblemployee', $params);
    }

    function delete_user($EmpCode)
    {
        $this->db->delete('tbllogin', array('EmpCode' => $EmpCode));

        $this->db->delete('tblkey', array('empCode' => $EmpCode));
        $this->db->delete('tblempworkschedule', array('EmpCode' => $EmpCode));

        return $this->db->delete('tblemployee', array('EmpCode' => $EmpCode));
    }

    public function cek($Emp, $Dt)
    {
        $this->db->from('tblempworkschedule');
        $this->db->join('tblworkschedule', 'tblempworkschedule.WSCode = tblworkschedule.WSCode');
        $this->db->where('EmpCode', $Emp);
        $this->db->where('Dt', $Dt);
        $this->db->order_by('aOut1', 'DESC');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add_schedule_batch($data_batch){
        return $this->db->insert_batch('tblempworkschedule', $data_batch);
    }
}
