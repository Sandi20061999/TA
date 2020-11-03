<?php
date_default_timezone_set('Asia/Jakarta');

use MVC\Controller;

class ControllersAuth extends Controller
{

    public function login()
    {
        $model = $this->model('auth');
        if ($this->request->getMethod() == "POST") {
            if ($this->request->post('token') == null || empty($this->request->post('token'))) {
                $empCode = $this->request->post('empCode');
                $keyCode = $this->request->post('keyCode');
                $unikCode = $this->request->post('unikCode');
                if ($this->check($empCode, $keyCode) == true) {
                    if ($model->checkEmpLogin($empCode) == 1) {
                        if ($model->checkKeyLogin($empCode, $keyCode) == 1) {
                            if ($model->checkLoginCode($empCode, $keyCode, $unikCode) == 1) {
                                $getToken = $model->getToken($empCode, $keyCode, $unikCode);
                                $data = ['token' => $getToken['loginCode']];
                                $this->response->sendStatus(200);
                                $this->response->setContent($data);
                            } else {
                                $data = ['pesan' => 'Perangkat berubah!!!'];
                                $this->response->sendStatus(404);
                                $this->response->setContent($data);
                            }
                        } else {
                            $data = ['pesan' => 'Key tidak sesuai!!!'];
                            $this->response->sendStatus(404);
                            $this->response->setContent($data);
                        }
                    } else {
                        $getLoginCode = $this->getLoginCode($empCode, $keyCode, $unikCode);
                        $createBy = $empCode;
                        $createDt =  date("YmdHi");
                        $model->insertLogin($getLoginCode, $empCode, $keyCode, $unikCode, $createBy, $createDt);
                        $data = ['token' => $getLoginCode];
                        $this->response->sendStatus(200);
                        $this->response->setContent($data);
                    }
                } else {
                    $data = ['pesan' => 'keyCode atau empCode salah!!!'];
                    $this->response->sendStatus(404);
                    $this->response->setContent($data);
                }
            }
        }
    }

    private function check($empCode, $keyCode)
    {
        $model = $this->model('auth');

        if ($model->checkKey($keyCode) == 1) {
            if ($model->checkEmp($empCode) == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function getLoginCode($empCode, $keyCode, $unikCode)
    {
        $model = $this->model('auth');
        $keyEnchiper = "ab53n51Ku";
        $gabung = "empCode:" . $empCode . ",keyCode:" . $keyCode . ",unikCode:" . $unikCode;
        $loginCode = $this->base64_encrypt($gabung, $keyEnchiper);
        $ambil = $model->loginCode();
        foreach ($ambil as $a) {
            if ($a['loginCode'] == $loginCode) {
                $loginCode = $this->base64_encrypt($gabung, $keyEnchiper);
            }
        }
        return $loginCode;
    }
}
