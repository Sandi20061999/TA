<?php

use MVC\Model;

class ModelsCekgps extends Model
{
    public function cek($EmpCode, $Dt){
        $query = $this->db->query("SELECT * FROM tblempworkschedule JOIN tblworkschedule ON 
        tblempworkschedule.WSCode = tblworkschedule.WSCode WHERE tblempworkschedule.EmpCode='".$EmpCode."' AND 
        tblempworkschedule.Dt='".$Dt."' ORDER BY tblempworkschedule.Dt ASC LIMIT 5");
        return $query->row;
    }

 
}