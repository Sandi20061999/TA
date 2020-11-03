<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Listuser extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
        $this->load->model('Listuser_model');
        $this->load->model('Workschedule_model');
        $this->load->library('form_validation');
    }
    function index()
    {
        $data['listuser'] = $this->Listuser_model->listuser();
        $data['_view'] = 'users/listuser';
        $this->load->view('layouts/main', $data);
    }

    function currentlocation($date)
    {
        $data['dat'] = $this->Listuser_model->dat($date);
        $data['_view'] = 'users/location';
        $this->load->view('layouts/main', $data);
    }

    function location($date)
    {
        $data['pul'] = $this->Listuser_model->pul($date);
        $data['_view'] = 'users/locationpul';
        $this->load->view('layouts/main', $data);
    }
    function lastOfMonth($year, $month) {
        return date("Ymd", strtotime('-1 second', strtotime('+1 month',strtotime($month . '/01/' . $year. ' 00:00:00'))));
        }
    function schedule($emp)
    {
        $data['detailuser'] = $this->Listuser_model->detailuser($emp);
        $data['empworkschedule'] = $this->Listuser_model->get_all_empworkschedule($emp);
        // echo $this->lastOfMonth("2020","12");
        // var_dump($data['empworkschedule']);
        // die;
        // $rev = array();
        // foreach($data['empworkschedule'] as $d){
        //     $now = $d['Dt'];
        //     foreach($data['empworkschedule'] as $e){
        //         $now1 = $d['Dt'];
        //         if($d['WSCode'] == $e['WSCode'] && $d['Type'] == $e['Type']){
        //             if((intval($now['Dt']) + 1) == $now1['Dt']){
        //                 if($this->lastOfMonth(substr($now['Dt'], 0, 4),substr($now['Dt'], 4, 2)) >= $now['Dt']){

        //                 }
        //             }
        //         }
        //     }
        // }
        $data['_view'] = 'users/listschedule';
        $this->load->view('layouts/main', $data);
    }

    function addschedule($emp) //p
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('Schedule', 'Schedule', 'required');
        
        if ($this->form_validation->run()) {
            if($this->input->post('choice') == '1'){
                $this->form_validation->set_rules('Dt', 'Date', 'required');
                $Dt = str_replace("-", "", $this->input->post('Dt'));
                $cek = $this->Listuser_model->cek($emp, $Dt);
                $WSCode = $this->Workschedule_model->get_workschedule($this->input->post('Schedule'));
                if($this->input->post('Schedule') == 'Holiday'){
                    $Type = 'WFH';
                }else{
                    $Type = $this->input->post('Type');
                }
                $params = array(
                    'EmpCode' => $emp,
                    'WSCode' => $this->input->post('Schedule'),
                    'Type' => $Type,
                    'Dt' => str_replace("-", "", $this->input->post('Dt')),
                    'CreateBy' => "Administrator",
                    'CreateDt' => date("Ymd"),
                );
                if (count($cek) >= 1) {
                    $TmScheduleLast = $cek['aOut1'];
                    $TmScheduleFirst = $WSCode['bIn1'];
                    if ($TmScheduleFirst > $TmScheduleLast) {
                        $schedule_id = $this->Listuser_model->add_schedule($params);
                        if ($schedule_id != null) {
                            $this->session->set_flashdata(
                                'msg',
                                '<div class="alert alert-success">
                            <h6>Berhasil </h6>
                            <p>Anda berhasil tambah jadwal.</p>
                        </div>'
                            );
                            redirect('listuser/schedule/' . $emp);
                        } else {
                            $this->session->set_flashdata(
                                'msg',
                                '<div class="alert alert-danger">
                            <h6>Gagal </h6>
                            <p>Anda gagal tambah jadwal.</p>
                        </div>'
                            );
                            redirect('listuser/schedule/' . $emp);
                        }
                    } else {
                        $this->session->set_flashdata(
                            'msg',
                            '<div class="alert alert-danger">
                        <h6>Gagal </h6>
                        <p>Anda gagal tambah jadwal karena jadwal konflik.</p>
                    </div>'
                        );
                        redirect('listuser/schedule/' . $emp);
                    }
                }
                if ($this->Listuser_model->add_schedule($params)) {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-success">
                                <h6>Berhasil </h6>
                                <p>Anda berhasil tambah jadwal.</p>
                            </div>'
                    );
                    redirect('listuser/schedule/' . $emp);
                } else {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-danger">
                                <h6>Gagal</h6>
                                <p>Anda gagal tambah jadwal.</p>
                            </div>'
                    );
                    redirect('listuser/schedule/' . $emp);
                }
            }elseif($this->input->post('choice') == '2'){
                $this->form_validation->set_rules('DtFirst', 'Date First', 'required');
                $this->form_validation->set_rules('DtLast', 'Date Last', 'required');
                
                $DtFirst = str_replace("-", "", $this->input->post('DtFirst'));
                $DtLast = str_replace("-", "", $this->input->post('DtLast'));

                $awal = $this->input->post('DtFirst');
                $akhir = $this->input->post('DtLast');
                $tanggal = array();
                while($awal <= $akhir){
                    array_push($tanggal,$awal);
                    // echo $awal;
                    // echo "<br>";
                    $awal = date("Y-m-d", strtotime("+1 day", strtotime($awal)));
                }
                // var_dump($tanggal);
                // die;

                if($DtLast >= $DtFirst){
                    $data_batch = array();
                    for ($i=0; $i < count($tanggal); $i++) { 
                        $cek = $this->Listuser_model->cek($emp, $tanggal[$i]);
                        $WSCode = $this->Workschedule_model->get_workschedule($this->input->post('Schedule'));
                        if($this->input->post('Schedule') == 'Holiday'){
                            $Type = 'WFH';
                        }else{
                            $Type = $this->input->post('Type');
                        }
                        $params = array(
                            'EmpCode' => $emp,
                            'WSCode' => $this->input->post('Schedule'),
                            'Type' => $Type,
                            'Dt' => str_replace("-", "",$tanggal[$i]),
                            'CreateBy' => "Administrator",
                            'CreateDt' => date("Ymd"),
                        );
                        if (count($cek) >= 1) {
                            $TmScheduleLast = $cek['aOut1'];
                            $TmScheduleFirst = $WSCode['bIn1'];
                            if ($TmScheduleFirst > $TmScheduleLast) {
                                array_push($data_batch,$params);
                            } else {
                                $this->session->set_flashdata(
                                    'msg',
                                    '<div class="alert alert-danger">
                                <h6>Gagal </h6>
                                <p>Anda gagal tambah jadwal karena jadwal konflik pada tanggal '.$tanggal[$i].'</p>
                            </div>'
                                );
                                redirect('listuser/schedule/' . $emp);
                                die;
                            }
                        }else{
                            array_push($data_batch,$params);
                        }
                    }
                    // var_dump($data_batch);
                    // die;
                    if ($this->Listuser_model->add_schedule_batch($data_batch)) {
                        $this->session->set_flashdata(
                            'msg',
                            '<div class="alert alert-success">
                                    <h6>Berhasil </h6>
                                    <p>Anda berhasil tambah jadwal.</p>
                                </div>'
                        );
                        redirect('listuser/schedule/' . $emp);
                    } else {
                        $this->session->set_flashdata(
                            'msg',
                            '<div class="alert alert-danger">
                                    <h6>Gagal</h6>
                                    <p>Anda gagal tambah jadwal.</p>
                                </div>'
                        );
                        redirect('listuser/schedule/' . $emp);
                    }
                }
                
            }
        } else {
            $this->load->model('Workschedule_model');
            $data['emp'] = $emp;
            $data['workschedule'] = $this->Workschedule_model->get_all_workschedule();
            $data['_view'] = 'users/addlistschedule';
            $this->load->view('layouts/main', $data);
        }
    }

    function editschedule($emp, $Dt) //p
    {
        $data['get_schedule'] = $this->Listuser_model->get_schedule($emp, $Dt);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('Schedule', 'Schedule', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'WSCode' => $this->input->post('Schedule'),
                'Type' => $this->input->post('Type'),
                'LastUpBy' => "Administrator",
                'LastUpDt' => date("Ymd"),
            );
            $cek = $this->Listuser_model->cek($emp, $Dt);
            $WSCode = $this->Workschedule_model->get_workschedule($this->input->post('Schedule'));
            if (count($cek >= 2)) {
                foreach ($cek as $c) {
                    $TmScheduleLast = $c['aOut1'];
                    $TmScheduleFirst = $WSCode['bIn1'];
                    if ($TmScheduleFirst < $TmScheduleLast) {
                        $this->session->set_flashdata(
                            'msg',
                            '<div class="alert alert-danger">
                        <h6>Gagal </h6>
                        <p>Anda gagal tambah jadwal karena jadwal konflik.</p>
                    </div>'
                        );
                        redirect('listuser/schedule/' . $emp);
                        break;
                    } else {
                        $schedule_id = $this->Listuser_model->edit_schedule($emp, $Dt, $params);
                        if ($schedule_id) {
                            $this->session->set_flashdata(
                                'msg',
                                '<div class="alert alert-success">
                                <h6>Berhasil </h6>
                                <p>Anda berhasil edit jadwal.</p>
                            </div>'
                            );
                            redirect('listuser/schedule/' . $emp);
                        } else {
                            $this->session->set_flashdata(
                                'msg',
                                '<div class="alert alert-danger">
                                <h6>Gagal </h6>
                                <p>Anda gagal edit jadwal.</p>
                            </div>'
                            );
                            redirect('listuser/schedule/' . $emp);
                        }
                    }
                }
            } else {
                $schedule_id = $this->Listuser_model->edit_schedule($emp, $Dt, $params);
                if ($schedule_id) {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-success">
                            <h6>Berhasil </h6>
                            <p>Anda berhasil edit jadwal.</p>
                        </div>'
                    );
                    redirect('listuser/schedule/' . $emp);
                } else {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-danger">
                            <h6>Gagal </h6>
                            <p>Anda gagal edit jadwal.</p>
                        </div>'
                    );
                    redirect('listuser/schedule/' . $emp);
                }
            }
        } else {
            $this->load->model('Workschedule_model');
            $data['Dt'] = $Dt;
            $data['emp'] = $emp;
            $data['type'] = $this->Listuser_model->get_schedule($emp, $Dt);
            $data['workschedule'] = $this->Workschedule_model->get_all_workschedule();
            $data['_view'] = 'users/editlistschedule';
            $this->load->view('layouts/main', $data);
        }
    }

    function removeschedule($emp, $Dt)// p
    {
        $schedule = $this->Listuser_model->get_schedule($emp, $Dt);

        // check if the customer exists before trying to delete it
        if (isset($schedule['WSCode'])) {
            $this->Listuser_model->delete_schedule($emp, $Dt);
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-success">
                    <h6>Berhasil </h6>
                    <p>Anda berhasil hapus jadwal. </p>
                </div>'
            );
            redirect('listuser/schedule/' . $emp);
        } else
            show_error('The customer you are trying to delete does not exist.');
    }

    function add() //p
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('EmpCode', 'EmpCode', 'required|is_unique[tblemployee.EmpCode]');
        $this->form_validation->set_rules('EmpName', 'EmpName', 'required');
        $this->form_validation->set_rules('DisplayName', 'DisplayName', 'required');
        $this->form_validation->set_rules('Gender', 'Gender', 'required');
        $this->form_validation->set_rules('Religion', 'Religion', 'required');
        $this->form_validation->set_rules('Email', 'Email', 'valid_email|is_unique[tblemployee.Email]');

        if ($this->form_validation->run()) {
            $params = array(
                'Gender' => $this->input->post('Gender'),
                'Religion' => $this->input->post('Religion'),
                'EmpName' => $this->input->post('EmpName'),
                'EmpCode' => $this->input->post('EmpCode'),
                'DisplayName' => $this->input->post('DisplayName'),
                'Mobile' => $this->input->post('Mobile'),
                'Email' => $this->input->post('Email'),
                'Address' => $this->input->post('Address'),
                'CreateBy' => $this->session->userdata('email'),
                'CreateDt' => date("Ymd"),
            );

            // $user_id = $this->Listuser_model->add_user($params);
            if ($this->Listuser_model->add_user($params)) {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-success">
                        <h6>Berhasil </h6>
                        <p>Anda berhasil input user dengan kode ' . $this->input->post('EmpCode') . '.</p>
                    </div>'
                );
                redirect('listuser/index');
            } else {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger">
                        <h6>Gagal </h6>
                        <p>Anda gagal input user dengan kode ' . $this->input->post('EmpCode') . '.</p>
                    </div>'
                );
                redirect('listuser/index');
            }
        } else {
            $data['_view'] = 'users/add';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
     * Editing a user
     */
    function edit($EmpCode) //p
    {
        // check if the user exists before trying to edit it
        $data['user'] = $this->Listuser_model->get_user($EmpCode);

        if (isset($data['user']['EmpCode'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('EmpName', 'EmpName', 'required');
            $this->form_validation->set_rules('DisplayName', 'DisplayName', 'required');
            $this->form_validation->set_rules('Gender', 'Gender', 'required');
            $this->form_validation->set_rules('Religion', 'Religion', 'required');
            $this->form_validation->set_rules('Email', 'Email', 'valid_email');

            if ($this->form_validation->run()) {
                $params = array(
                    'Gender' => $this->input->post('Gender'),
                    'Religion' => $this->input->post('Religion'),
                    'EmpName' => $this->input->post('EmpName'),
                    'DisplayName' => $this->input->post('DisplayName'),
                    'Mobile' => $this->input->post('Mobile'),
                    'Email' => $this->input->post('Email'),
                    'Address' => $this->input->post('Address'),
                    'LastUpBy' => $this->session->userdata('email'),
                    'LastUpDt' => date("Ymd"),
                );


                if ($this->Listuser_model->update_user($EmpCode, $params)) {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-success">
                            <h6>Berhasil </h6>
                            <p>Anda berhasil edit user dengan kode ' . $EmpCode . '.</p>
                        </div>'
                    );
                    redirect('listuser/index');
                } else {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-danger">
                            <h6>Gagal </h6>
                            <p>Anda gagal edit user dengan kode ' . $EmpCode . '.</p>
                        </div>'
                    );
                    redirect('listuser/index');
                }
            } else {
                $data['_view'] = 'users/edit';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error('The user you are trying to edit does not exist.');
    }

    /*
     * Deleting user
     */
    function remove($EmpCode) //p
    {
        $user = $this->Listuser_model->get_user($EmpCode);

        // check if the user exists before trying to delete it
        if (isset($user['EmpCode'])) {
            $this->Listuser_model->delete_user($EmpCode);
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-success">
                    <h6>Berhasil </h6>
                    <p>Anda berhasil hapus user dengan kode ' . $EmpCode . '.</p>
                </div>'
            );
            redirect('listuser/index');
        } else
            show_error('The user you are trying to delete does not exist.');
    }
}
