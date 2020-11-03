<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

use MVC\Controller;

class ControllersAbsen extends Controller
{
    public function absen()
    {
        $model = $this->model('absen');
        // $modelgps = $this->model('cekgps');
        $file = FITUR . "gps.json";
        $gps = file_get_contents($file);
        $data = json_decode($gps, true);
        // var_dump($data['status']);
        $token = $this->request->post('token');
        $type = $this->request->post('type');
        $IPAddress = $this->request->post('ipAddress');
        $Machine = $this->request->post('machine');
        $Latitude = $this->request->post('latitude');
        $Longitude = $this->request->post('longitude');
        // $EmpCode = $this->decryptToken($token);
        // $Dt = date("Ymd");
        // $Tm = date("Hi");
        // $ambil = $modelgps->cek($EmpCode, $Dt, $Tm);
        if ($type == 'WFH') {
            if ($IPAddress != null && $Machine != null && $Latitude != null && $Longitude != null) {
                if ($token != null || !empty($token)) {
                    $checkToken = $model->checkToken($token);
                    if ($checkToken['EmpCode'] != null) {
                        $EmpCode = $checkToken['EmpCode'];
                        $Dt = date('Ymdi');
                        $Tm = date('Hi');
                        $CreateBy = $EmpCode;
                        $CreateDt =  date("YmdHi");
                        $model->insertData($EmpCode, $Dt, $Tm, $Machine, $IPAddress, $Latitude, $Longitude, $CreateBy, $CreateDt);
                        $data = ['pesan' => 'Absen Berhasil'];
                        $this->response->sendStatus(200);
                        $this->response->setContent($data);
                    } else {
                        $data = ['pesan' => 'Token Salah!!!'];
                        $this->response->sendStatus(404);
                        $this->response->setContent($data);
                    }
                } else {
                    $data = ['pesan' => 'Token Kosong!!!'];
                    $this->response->sendStatus(404);
                    $this->response->setContent($data);
                }
            } else {
                $data = ['pesan' => 'Data Kosong!!!'];
                $this->response->sendStatus(404);
                $this->response->setContent($data);
            }
        } elseif ($type == 'WFO') {
            $token = $this->request->post('token');
            $qr = $this->request->post('qr');
            $IPAddress = $this->request->post('ipAddress');
            $Machine = $this->request->post('machine');
            $Latitude = $this->request->post('latitude');
            $Longitude = $this->request->post('longitude');
            $latkiriatas = $data['data']['latkiriatas'];
            $longkiriatas = $data['data']['longkiriatas'];
            $latkananatas = $data['data']['latkananatas'];
            $longkananatas = $data['data']['longkananatas'];
            $latkananbawah = $data['data']['latkananbawah'];
            $longkananbawah = $data['data']['longkananbawah'];
            $latkiribawah = $data['data']['latkiribawah'];
            $longkiribawah = $data['data']['longkiribawah'];
            if ($Latitude <= $latkiriatas && $Latitude >= $latkiribawah && $Latitude <= $latkananatas && $Latitude >= $latkananbawah) {
                if ($Longitude >= $longkiriatas && $Longitude <= $longkananatas && $Longitude >= $longkiribawah && $Longitude <= $longkananbawah) {
                    if ($qr != null && $IPAddress != null && $Machine != null && $Latitude != null && $Longitude != null) {
                        if ($token != null || !empty($token)) {
                            $checkToken = $model->checkToken($token);
                            if ($checkToken['EmpCode'] != null) {
                                $checkQR = $this->checkFormatQR($qr);
                                if ($checkQR['status'] == true) {
                                    $EmpCode = $checkToken['EmpCode'];
                                    $Dt = $checkQR['Dt'];
                                    $Tm = $checkQR['Tm'];
                                    $CreateBy = $EmpCode;
                                    $CreateDt =  date("YmdHi");
                                    $model->insertData($EmpCode, $Dt, $Tm, $Machine, $IPAddress, $Latitude, $Longitude, $CreateBy, $CreateDt);
                                    $data = ['pesan' => 'Absen Berhasil'];
                                    $this->response->sendStatus(200);
                                    $this->response->setContent($data);
                                } else {
                                    $data = ['pesan' => 'Format QR Code salah!!!'];
                                    $this->response->sendStatus(404);
                                    $this->response->setContent($data);
                                }
                            } else {
                                $data = ['pesan' => 'Token Salah!!!'];
                                $this->response->sendStatus(404);
                                $this->response->setContent($data);
                            }
                        } else {
                            $data = ['pesan' => 'Token Kosong!!!'];
                            $this->response->sendStatus(404);
                            $this->response->setContent($data);
                        }
                    } else {
                        $data = ['pesan' => 'Data Kosong!!!'];
                        $this->response->sendStatus(404);
                        $this->response->setContent($data);
                    }
                } else {
                    $data = ['pesan' => 'Lokasi Tidak Sesuai!!!'];
                    $this->response->sendStatus(404);
                    $this->response->setContent($data);
                }
            } else {
                $data = ['pesan' => 'Lokasi Tidak Sesuai!!!'];
                $this->response->sendStatus(404);
                $this->response->setContent($data);
            }
        }
        // cek fitur gps
    }
    private function checkFormatQR($qr)
    {
        $keyEnchiper = "ab53ns1ku";
        $data = $this->base64_decrypt($qr, $keyEnchiper);
        $split = explode(",", $data);
        $Dt = intval($split[0]);
        $Tm = $split[1];
        // $test = $this->base64_encrypt("20200827,0118", $keyEnchiper);
        // var_dump($test);
        if (is_int($Dt) && strlen($Dt) == '8' && strlen($Tm) == '4') {
            return array(
                'status' => true,
                'Dt' => $Dt,
                'Tm' => $Tm
            );
        } else {
            return false;
        }
    }
}
