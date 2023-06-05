<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('log_admin'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('notif-error', 'Anda sudah login !');
                redirect('admin');
            }
        } else if (!empty($this->session->userdata('log_user'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('notif-error', 'Anda sudah login !');
                redirect('user');
            }
        }
        $this->load->model('M_Login', 'login');
    }

    public function index()
    {
        $data = [
            'title' => 'Halaman Login',
            'page'  => 'auth/login'
        ];

        $this->load->view('auth/index', $data);
    }

    public function proses()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $a = $this->login->cek_login($username, $password);

        if ($a == 'admin') {
            $this->session->set_flashdata('flash-sukses', 'Login Sukses');
            redirect('admin', 'refresh');
        } else if ($a == 'user') {
            $this->session->set_flashdata('flash-sukses', 'Login Sukses');
            redirect('user', 'refresh');
        } else {
            $this->session->set_flashdata('flash-error', 'Login Gagal');
            redirect('auth', 'refresh');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth', 'refresh');
    }
}
