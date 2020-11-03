<?php

use MVC\Model;

class ModelsAbsen extends Model
{
    public function checkToken($token){
        $query = $this->db->query("SELECT * FROM tbllogin WHERE loginCode='".$token."'");
        return $query->row;
    }

    public function insertData($EmpCode, $Dt, $Tm, $Machine, $IPAddress, $Latitude, $Longitude ,$CreateBy, $CreateDt)
    {
        return $this->db->query("INSERT INTO tblattendancelog (EmpCode, Dt, Tm, Machine, IPAddress, Latitude, Longitude ,CreateBy, CreateDt) values ('".$EmpCode."','".$Dt."','".$Tm."','".$Machine."','".$IPAddress."','".$Latitude."','".$Longitude."','".$CreateBy."','".$CreateDt."')");
    }
}