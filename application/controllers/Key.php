<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Key extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
        $this->load->model('Key_model');
        $this->load->model('Listuser_model');
    }

    public function index()
    {
        $data['key'] = $this->Key_model->listkey();
        $data['_view'] = 'keys/key';
        $this->load->view('layouts/main', $data);
    }

    function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_id', 'Karyawan', 'required');
        $this->form_validation->set_rules('key', 'Key', 'required|max_length[25]|is_unique[tblkey.key]');
        $this->form_validation->set_rules('level', 'Level/Divisi', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'empCode' => $this->input->post('user_id'),
                'key' => $this->input->post('key'),
                'level' => $this->input->post('level'),
                'CreateBy' => $this->session->userdata('email'),
                'CreateDt' => date("Ymd"),
            );
            
            $key_id = $this->Key_model->add_key($params);
            if($key_id){
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-success">
                        <h6>Berhasil </h6>
                        <p>Anda berhasil input key ' . $this->input->post('key') . '.</p>
                    </div>'
                );
                redirect('key/index');
            }else{
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger">
                        <h6>Gagal </h6>
                        <p>Anda gagal input key ' . $this->input->post('key') . '.</p>
                    </div>'
                );
                redirect('key/index');
            }
        } else {
            $data['all_tblemployee'] = $this->Listuser_model->dropdownaddkey();
            $data['_view'] = 'keys/addkey';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
     * Editing a key
     */
    // function edit($id)
    // {   
    //     // check if the key exists before trying to edit it
    //     $data['key'] = $this->Key_model->get_key($id);

    //     if(isset($data['key']['id']))
    //     {
    //         $this->load->library('form_validation');

    // 		$this->form_validation->set_rules('user_id','User Id','required');
    // 		$this->form_validation->set_rules('key','Key','required|max_length[25]');
    // 		$this->form_validation->set_rules('level','Level','required');

    // 		if($this->form_validation->run())     
    //         {   
    //             $params = array(
    // 				'user_id' => $this->input->post('user_id'),
    // 				'key' => $this->input->post('key'),
    // 				'level' => $this->input->post('level'),
    //             );
    //             $this->session->set_flashdata('msg', 
    //             '<div class="alert alert-success">
    //                 <h6>Berhasil </h6>
    //                 <p>Anda berhasil edit key '.$this->input->post('key').'.</p>
    //             </div>'); 
    //             $this->Key_model->update_key($id,$params);            
    //             redirect('key/index');
    //         }
    //         else
    //         {
    // 		    $data['all_tblemployee'] = $this->Listuser_model->dropdownaddkey();
    //             $data['_view'] = 'keys/editkey';
    //             $this->load->view('layouts/main',$data);
    //         }
    //     }
    //     else
    //         show_error('The key you are trying to edit does not exist.');
    // } 

    /*
     * Deleting key
     */
    function remove($id)
    {
        $key = $this->Key_model->get_key($id);

        // check if the key exists before trying to delete it
        if (isset($key['key'])) {

            $this->Key_model->delete_key($id);
            $this->Key_model->delete_userlog($id);
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-success">
                    <h6>Berhasil </h6>
                    <p>Anda berhasil hapus key ' . $key['key'] . '.</p>
                </div>'
            );
            redirect('key/index');
        } else
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">
            <h6>Gagal </h6>
            <p>Anda gagal menghapus key ' . $key['key'] . '.</p>
        </div>'
            );
        redirect('key/index');
    }

    function reset_login($id)
    {
        $key = $this->Key_model->get_key($id);

        // check if the key exists before trying to delete it
        if (isset($key['key'])) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-success">
                    <h6>Berhasil </h6>
                    <p>Anda berhasil reset token dengan key ' . $key['key'] . '.</p>
                </div>'
            );
            $this->Key_model->delete_userlog($id);
            redirect('key/index');
        } else
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">
                <h6>Gagal </h6>
                <p>Anda gagal reset token dengan key ' . $key['key'] . '.</p>
            </div>'
            );
        redirect('key/index');
    }
}
