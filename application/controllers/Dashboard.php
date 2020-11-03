<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
          redirect('login');
        }
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
        $this->load->model('Key_model');

    } 
	public function index()
	{
        $ambil = $this->Key_model->getloc();
        $data['d'] = $ambil['data'];
        $data['totaluser'] = $this->Dashboard_model->totaluser();
        $data['totallog'] = $this->Dashboard_model->totallog();
        $data['totalkey'] = $this->Dashboard_model->totalkey();
        $data['_view'] = 'dashboard';
        $this->load->view('layouts/main',$data);
    }
    
    public function setcenter(){
        $this->form_validation->set_rules('lat','Latitude','required');
		$this->form_validation->set_rules('lng','Longitude','required');

        if($this->form_validation->run())     
        {               
            // $params = array(
            //     'latcenter' => $this->input->post('lat'),
            //     'longcenter' => $this->input->post('lng'),
            // );

            $aktif = $this->Key_model->update_loc('latcenter', 'longcenter', $this->input->post('lat'), $this->input->post('lng'));
            if($aktif){
                redirect('dashboard');
            }else{
                echo "gagal memerbarui";
            }
            redirect('dashboard');
        }
        else
        {
            $dataloc = $this->Key_model->getloc();
            $data['d'] = $dataloc['data'];
            
            $data['_view'] = 'location/setloccenter';
            $this->load->view('layouts/main',$data);
        }
    }

    public function setkiriatas(){
        $this->form_validation->set_rules('lat','Latitude','required');
		$this->form_validation->set_rules('lng','Longitude','required');

        if($this->form_validation->run())     
        {               
            // $params = array(
            //     'latkiriatas' => $this->input->post('lat'),
            //     'longkiriatas' => $this->input->post('lng'),
            // );
            $this->Key_model->update_loc('latkiriatas', 'longkiriatas', $this->input->post('lat'), $this->input->post('lng'));
            // $this->Key_model->update_loc($params);
            redirect('dashboard');
        }
        else
        {
            $dataloc = $this->Key_model->getloc();
            $data['d'] = $dataloc['data'];
            
            $data['_view'] = 'location/setlockiriatas';
            $this->load->view('layouts/main',$data);
        }
    }

    public function setkananatas(){
        $this->form_validation->set_rules('lat','Latitude','required');
		$this->form_validation->set_rules('lng','Longitude','required');

        if($this->form_validation->run())     
        {               
            // $params = array(
            //     'latkananatas' => $this->input->post('lat'),
            //     'longkananatas' => $this->input->post('lng'),
            // );
            $this->Key_model->update_loc('latkananatas', 'longkananatas', $this->input->post('lat'), $this->input->post('lng'));
            // $this->Key_model->update_loc($params);
            redirect('dashboard');
        }
        else
        {
            $dataloc = $this->Key_model->getloc();
            $data['d'] = $dataloc['data'];
            
            $data['_view'] = 'location/setlockananatas';
            $this->load->view('layouts/main',$data);
        }
    }

    public function setkananbawah(){
        $this->form_validation->set_rules('lat','Latitude','required');
		$this->form_validation->set_rules('lng','Longitude','required');

        if($this->form_validation->run())     
        {               
            // $params = array(
            //     'latkananbawah' => $this->input->post('lat'),
            //     'longkananbawah' => $this->input->post('lng'),
            // );
            $this->Key_model->update_loc('latkananbawah', 'longkananbawah', $this->input->post('lat'), $this->input->post('lng'));
            // $this->Key_model->update_loc($params);
            redirect('dashboard');
        }
        else
        {
            $dataloc = $this->Key_model->getloc();
            $data['d'] = $dataloc['data'];
            
            $data['_view'] = 'location/setlockananbawah';
            $this->load->view('layouts/main',$data);
        }
    }

    public function setkiribawah(){
        $this->form_validation->set_rules('lat','Latitude','required');
		$this->form_validation->set_rules('lng','Longitude','required');

        if($this->form_validation->run())     
        {               
            // $params = array(
            //     'latkiribawah' => $this->input->post('lat'),
            //     'longkiribawah' => $this->input->post('lng'),
            // );
            $this->Key_model->update_loc('latkiribawah', 'longkiribawah', $this->input->post('lat'), $this->input->post('lng'));
            // $this->Key_model->update_loc($params);
            redirect('dashboard');
        }
        else
        {
            $dataloc = $this->Key_model->getloc();
            $data['d'] = $dataloc['data'];
            
            $data['_view'] = 'location/setlockiribawah';
            $this->load->view('layouts/main',$data);
        }
    }
    
}
