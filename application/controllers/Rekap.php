<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('data_login'))) {
            $this->session->set_flashdata('flash-error', 'Anda Belum Login');
            redirect('auth', 'refresh');
        }

        $this->db->where('id', $this->session->userdata('id'));
        $this->dt_admin = $this->db->get('admin')->row();

        $this->load->model('M_Admin', 'admin');
    }

    // fungsi menampilkan halaman rekap dan menampilkan data sensor
    public function index()
    {
        $data = [
            'title' => 'Rekap',
            'page'  => 'backend/rekap',
            'rekap' => $this->admin->getDataSensor(),
        ];

        $this->load->view('backend/index', $data);
    }

    // fungsi hapus data pada halaman rekap
    public function delete($id)
    {
        $this->db->delete('sensor', ['id' => $id]);
        $this->session->set_flashdata('flash-sukses', 'data berhasil dihapus');
        redirect('rekap', 'refresh');
    }
}
