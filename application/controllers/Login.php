<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
      $this->load->library('form_validation');
  }
   
  function index(){ 
      $this->load->view('login_form');
  } //end 

public function actlogin() {
    // Set aturan validasi input
    $this->form_validation->set_rules('username', 'Username', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect(base_url('login'));
    } else {
        // Ambil input dari form
        $username = $this->input->post('username', TRUE); // TRUE untuk xss_clean
        $password = $this->input->post('password', TRUE);

        // Cek login
        $user = $this->data_model->check_login($username, $password);

        if ($user) {
            // Simpan data pengguna ke session
            $this->session->set_userdata('user_id', $user->id_user);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('hak', $user->hak_akses);

            // Redirect ke halaman dashboard
            redirect('beranda');
        } else {
            // Jika login gagal, tampilkan pesan error
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect(base_url('login'));
        }
    }
} ///end

public function logout() {
    // Hapus session
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('username');
    $this->session->sess_destroy();

    // Redirect ke halaman login
    redirect('login');
}

}
?>