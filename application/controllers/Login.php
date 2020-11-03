<?php
class Login extends CI_Controller{

  function index(){
    $this->load->view('login_view');

  }

  function auth(){
    $this->load->model('Login_model');
    $email    = $this->input->post('email',TRUE);
    $password = $this->input->post('password',TRUE);
    $validate = $this->Login_model->validate($email,$password);
    if($validate['level'] == '2'){
        $sesdata = array(
            'email'     => $email,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);
        redirect(base_url('dashboard'));
    }else{
        echo $this->session->set_flashdata('msg','Username or Password is Wrong');
        redirect('login');
    }
  }

  function logout(){
      $this->session->sess_destroy();
      redirect('login');
  }

}
