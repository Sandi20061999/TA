<?php
class Workschedule extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Workschedule_model');
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
    }

    /*
     * Listing of workschedule
     */
    function index()
    {
        $data['workschedule'] = $this->Workschedule_model->get_all_workschedule();

        $data['_view'] = 'workschedule/index';
        $this->load->view('layouts/main', $data);
    }

    /*
     * Adding a new workschedule
     */
    function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('WSCode', 'Work Schedule Code', 'required|is_unique[tblworkschedule.WSCode]');
        $this->form_validation->set_rules('WSName', 'Work Schedule Name', 'required');
        $this->form_validation->set_rules('In1', 'In', 'required|callback_is_start_time_valid');
        $this->form_validation->set_rules('bIn1', 'Range In Start', 'required|callback_is_start_time_valid');
        $this->form_validation->set_rules('aIn1', 'Range In End', 'required|callback_is_start_time_valid');
        $this->form_validation->set_rules('Out1', 'Out', 'required|callback_is_start_time_valid');
        $this->form_validation->set_rules('bOut1', 'Range Out Start', 'required|callback_is_start_time_valid');
        $this->form_validation->set_rules('aOut1', 'Range Out End', 'required|callback_is_start_time_valid');
        if ($this->form_validation->run()) {

            $params = array(
                'WSCode' => $this->input->post('WSCode'),
                'WSName' => $this->input->post('WSName'),
                'In1' => str_replace(":", "", $this->input->post('In1')),
                'bIn1' => str_replace(":", "", $this->input->post('bIn1')),
                'aIn1' => str_replace(":", "", $this->input->post('aIn1')),
                'Out1' => str_replace(":", "", $this->input->post('Out1')),
                'bOut1' => str_replace(":", "", $this->input->post('bOut1')),
                'aOut1' => str_replace(":", "", $this->input->post('aOut1')),
                'CreateBy' => "Administrator",
                'CreateDt' => date("Ymd"),
            );

            $workschedule_id = $this->Workschedule_model->add_workschedule($params);
            if ($workschedule_id) {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-success">
                        <h6>Berhasil </h6>
                        <p>Anda berhasil input jadwal dengan kode ' . $this->input->post('WSCode') . '.</p>
                    </div>'
                );
                redirect('workschedule/index');
            } else {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger">
                        <h6>Gagal </h6>
                        <p>Anda gagal input jadwal dengan kode ' . $this->input->post('WSCode') . '.</p>
                    </div>'
                );
                redirect('workschedule/index');
            }
        } else {
            $data['_view'] = 'workschedule/add';
            $this->load->view('layouts/main', $data);
        }
    }
    function is_start_time_valid($time)
    {

        if (date('H:i', strtotime($time)) == $time) {
            return TRUE;
        } else {
            $this->form_validation->set_message('is_start_time_valid', 'The {field} must be in format "HH:MM"');
            return FALSE;
        }
    }
    /*
     * Editing a workschedule
     */
    function edit($WSCode)
    {
        // check if the workschedule exists before trying to edit it
        $data['workschedule'] = $this->Workschedule_model->get_workschedule($WSCode);

        if (isset($data['workschedule']['WSCode'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('WSName', 'Work Schedule Name', 'required');
            $this->form_validation->set_rules('In1', 'In', 'required|callback_is_start_time_valid');
            $this->form_validation->set_rules('bIn1', 'Range In Start', 'required|callback_is_start_time_valid');
            $this->form_validation->set_rules('aIn1', 'Range In End', 'required|callback_is_start_time_valid');
            $this->form_validation->set_rules('Out1', 'Out', 'required|callback_is_start_time_valid');
            $this->form_validation->set_rules('bOut1', 'Range Out Start', 'required|callback_is_start_time_valid');
            $this->form_validation->set_rules('aOut1', 'Range Out End', 'required|callback_is_start_time_valid');

            if ($this->form_validation->run()) {
                $params = array(
                    'WSName' => $this->input->post('WSName'),
                    'In1' => str_replace(":", "", $this->input->post('In1')),
                    'bIn1' => str_replace(":", "", $this->input->post('bIn1')),
                    'aIn1' => str_replace(":", "", $this->input->post('aIn1')),
                    'Out1' => str_replace(":", "", $this->input->post('Out1')),
                    'bOut1' => str_replace(":", "", $this->input->post('bOut1')),
                    'aOut1' => str_replace(":", "", $this->input->post('aOut1')),
                    'LastUpBy' => "Administrator",
                    'LastUpDt' => date("Ymd"),
                );

                if ($this->Workschedule_model->update_workschedule($WSCode, $params)) {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-success">
                            <h6>Berhasil </h6>
                            <p>Anda berhasil edit jadwal dengan kode ' . $this->input->post('WSCode') . '.</p>
                        </div>'
                    );
                    redirect('workschedule/index');
                } else {
                    $this->session->set_flashdata(
                        'msg',
                        '<div class="alert alert-danger">
                            <h6>Gagal </h6>
                            <p>Anda gagal edit jadwal dengan kode ' . $this->input->post('WSCode') . '.</p>
                        </div>'
                    );
                    redirect('workschedule/index');
                }
            } else {
                $data['_view'] = 'workschedule/edit';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error('The workschedule you are trying to edit does not exist.');
    }

    /*
     * Deleting workschedule
     */
    function remove($WSCode)
    {
        $workschedule = $this->Workschedule_model->get_workschedule($WSCode);
        if (isset($workschedule['WSCode'])) {
            if ($this->Workschedule_model->delete_workschedule($WSCode)) {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-success">
                            <h6>Berhasil </h6>
                            <p>Anda berhasil hapus jadwal dengan kode ' . $this->input->post('WSCode') . '.</p>
                        </div>'
                );
                redirect('workschedule/index');
            } else {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger">
                            <h6>Gagal </h6>
                            <p>Anda gagal hapus jadwal dengan kode ' . $this->input->post('WSCode') . '.</p>
                        </div>'
                );
                redirect('workschedule/index');
            }
        } else {
            show_error('The workschedule you are trying to delete does not exist.');
        }
    }
}
