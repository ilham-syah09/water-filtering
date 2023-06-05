<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('log_user'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('auth', 'refresh');
        }

        $this->load->model('M_Admin', 'admin');


        $this->db->where('id', $this->session->userdata('id'));
        $this->dt_admin = $this->db->get('admin')->row();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard User',
            'page'  => 'backend/user',
        ];

        $this->load->view('backend/index', $data);
    }

    public function realtime()
    {
        $count = $this->db->get('sensor')->num_rows();

        $this->db->order_by('id', 'desc');
        $data = $this->db->get('sensor', 1)->row();

        echo json_encode([
            'data'  => $data,
            'count' => $count
        ]);
    }
}
