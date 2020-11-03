<?php

class Allreport_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function tanggal($ta = null, $tb = null)
    {
        if ($ta != null && $tb != null) {
            $this->db->select('DISTINCT(Dt)');
            $this->db->from('tblempworkschedule');
            $array = array('Dt >=' => $ta, 'Dt <=' => $tb);
            $this->db->where($array);
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select('DISTINCT(Dt)');
            $this->db->from('tblempworkschedule');
            $query = $this->db->get();
            return $query->result_array();
        }
    }
    function jammasuk()
    {
        $this->db->from('tblempworkschedule');
        $this->db->join('tblworkschedule', 'tblempworkschedule.WSCode = tblworkschedule.WSCode');
        $query = $this->db->get();
        return $query->result_array();
    }

    function cek($emp, $dt)
    {
        $this->db->from('tblempworkschedule');
        $this->db->join('tblworkschedule', 'tblempworkschedule.WSCode = tblworkschedule.WSCode');
        $array = array('EmpCode' => $emp, 'Dt' => $dt);
        $this->db->where($array);
        $query = $this->db->get();
        return $query->result_array();
    }



    function absenmasuk($emp, $dt, $ra, $rb)
    {
        $this->db->from('tblattendancelog');
        $array = array('EmpCode' => $emp, 'Dt' => $dt, 'Tm >=' => $ra, 'Tm <=' => $rb);
        $this->db->where($array);
        $this->db->order_by('Tm', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function absenpulang($emp, $dt, $ra, $rb)
    {
        $this->db->from('tblattendancelog');
        $array = array('EmpCode' => $emp, 'Dt' => $dt, 'Tm >=' => $ra, 'Tm <=' => $rb);
        $this->db->where($array);
        $this->db->order_by('Tm', 'DESC');
        $query = $this->db->get();
        return $query->row_array();
    }
    function user()
    {
        $this->db->from('tblemployee');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function ambilEmployee($empCode)
    {
        $this->db->from('tblemployee');
        $array = array('EmpCode' => $empCode);
        $this->db->where($array);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function ambilJadwal($empCode)
    {
        $this->db->from('tblempworkschedule');
        $this->db->join('tblworkschedule', 'tblempworkschedule.WSCode = tblworkschedule.WSCode');
        $array = array('EmpCode' => $empCode);
        $this->db->where($array);
        $this->db->order_by('Dt', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function ambilLogMasuk($empCode, $tgl, $bIn1, $aIn1)
    {
        $this->db->from('tblattendancelog');
        $array = array('EmpCode' => $empCode, 'Dt' => $tgl, 'Tm >=' => $bIn1, 'Tm <=' => $aIn1);
        $this->db->order_by('Tm', 'ASC');
        $this->db->where($array);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function ambilLogKeluar($empCode, $tgl, $bOut1, $aOut1)
    {
        $this->db->from('tblattendancelog');
        $array = array('EmpCode' => $empCode, 'Dt' => $tgl, 'Tm >=' => $bOut1, 'Tm <=' => $aOut1);
        $this->db->order_by('Tm', 'DESC');
        $this->db->where($array);
        $query = $this->db->get();
        return $query->row_array();
    }
}
