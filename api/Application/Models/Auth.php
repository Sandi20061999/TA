<?php

use MVC\Model;

class ModelsAuth extends Model
{

    public function login($empCode, $key)
    {
        $query = $this->db->query("SELECT * FROM tblkey WHERE empCode ='" . $empCode . "' AND tblkey.Key='" . $key . "'");
        return $query->row;
    }

    public function checkKey($keyCode)
    {
        $query = $this->db->query("SELECT * FROM tblkey WHERE tblkey.Key='" . $keyCode . "'");
        return $query->num_rows;
    }
    public function checkEmp($empCode)
    {
        $query = $this->db->query("SELECT * FROM tblkey WHERE empCode ='" . $empCode . "'");
        return $query->num_rows;
    }

    public function checkLoginCode($empCode, $keyCode, $unikCode)
    {
        $query = $this->db->query("SELECT * FROM tbllogin WHERE EmpCode ='" . $empCode . "' AND KeyCode ='" . $keyCode . "' AND UniqueDevice='" . $unikCode . "'");
        return $query->num_rows;
    }
    public function loginCode()
    {
        $query = $this->db->query("SELECT loginCode FROM tbllogin ");
        return $query->rows;
    }
    public function insertLogin($loginCode, $empCode, $keyCode, $unikCode, $createBy, $createDt)
    {
        return $this->db->query("INSERT INTO tbllogin (loginCode, EmpCode, KeyCode, UniqueDevice, CreateBy, CreateDt) values ('" . $loginCode . "','" . $empCode . "','" . $keyCode . "','" . $unikCode . "','".$createBy."','".$createDt."')");
    }

    public function checkKeyLogin($empCode, $keyCode)
    {
        $query = $this->db->query("SELECT * FROM tbllogin WHERE KeyCode='" . $keyCode . "' AND EmpCode='".$empCode."'");
        return $query->num_rows;
    }
    public function checkEmpLogin($empCode)
    {
        $query = $this->db->query("SELECT * FROM tbllogin WHERE EmpCode ='" . $empCode . "'");
        return $query->num_rows;
    }

    public function getToken($empCode, $keyCode, $unikCode)
    {
        $query = $this->db->query("SELECT loginCode FROM tbllogin WHERE EmpCode ='" . $empCode . "' AND KeyCode ='" . $keyCode . "' AND UniqueDevice='" . $unikCode . "'");
        return $query->row;
    }
}
