<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

use MVC\Controller;

class ControllersCekgps extends Controller
{
    public function Cek()
    {
        $token = $this->request->post('token');
        $Dt = date("Ymd"); // format tahunbulantanggal
        $Tm = date("Hi"); // format jammenit
        if ($token != null || !empty($token) && $Dt != null || !empty($Dt) && $Tm != null || !empty($Tm)) {
            $EmpCode = $this->decryptToken($token);
            $model = $this->model('cekgps');
            $ambil = $model->cek($EmpCode, $Dt);
            // var_dump($ambil);
            // die;
            if($ambil == null){
                $data = ['pesan' => 'Tidak ada jadwal saat ini'];
            }else{
                $data = ['Dt' => $ambil['Dt'], 'WSCode' => $ambil['WSCode'], 'Type' => $ambil['Type'], 'In' => ($ambil['In1'] == null) ? "-" : $ambil['In1'], 'rangeIn' => $ambil['bIn1'] . "-" . $ambil['aIn1'], 'Out' => ($ambil['Out1'] == null) ? "-" : $ambil['Out1'], 'rangeOut' => $ambil['bOut1'] . "-" . $ambil['aOut1']];
            }

            $this->response->sendStatus(200);
            $this->response->setContent($data);
        }
        // if ($gps) {
        else{
            $data = ['pesan' => 'Belum waktu nya untuk absen'];
            $this->response->sendStatus(404);
            $this->response->setContent($data);
        }
    }

}
