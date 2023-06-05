<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('log_login'))) {
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
            'title' => 'Dashboard',
            'page'  => 'backend/dashboard',
        ];

        $this->load->view('backend/index', $data);
    }

    public function manageUser()
    {
        if ($this->dt_admin->role_id == 2) {
            $this->session->set_flashdata('flash-error', 'Access denied!');
            redirect('dashboard', 'refresh');
        }

        $data = [
            'title' => 'Manage User',
            'page'  => 'backend/manage_user',
            'admin' => $this->admin->getAdmin()
        ];

        $this->load->view('backend/index', $data);
    }

    public function addUser()
    {
        if ($this->dt_admin->role_id == 2) {
            $this->session->set_flashdata('flash-error', 'Access denied!');
            redirect('dashboard', 'refresh');
        }

        $data = [
            'name'  => $this->input->post('name'),
            'username'  => $this->input->post('username'),
            'role_id'  => $this->input->post('role_id'),
            'password'  => password_hash('user123', PASSWORD_BCRYPT),
        ];

        $this->db->insert('admin', $data);
        $this->session->set_flashdata('flash-sukses', 'Berhasil! Password user123');
        redirect('admin/manageUser', 'refresh');
    }

    public function deleteUser($id)
    {
        if ($this->dt_admin->role_id == 2) {
            $this->session->set_flashdata('flash-error', 'Access denied!');
            redirect('dashboard', 'refresh');
        }

        $this->db->where('id', $id);
        $this->db->delete('admin');
        $this->session->set_flashdata('flash-sukses', 'Berhasil dihapus!');
        redirect('admin/manageUser', 'refresh');
    }

    public function resetPassUser($id)
    {
        if ($this->dt_admin->role_id == 2) {
            $this->session->set_flashdata('flash-error', 'Access denied!');
            redirect('dashboard', 'refresh');
        }

        $data = [
            'password'  => password_hash('user123', PASSWORD_BCRYPT),
        ];

        $this->db->where('id', $id);
        $this->db->update('admin', $data);
        $this->session->set_flashdata('flash-sukses', 'Password di reset!');
        redirect('admin/manageUser', 'refresh');
    }

    public function realtime()
    {
        if ($this->dt_admin->role_id == 2) {
            $this->session->set_flashdata('flash-error', 'Access denied!');
            redirect('dashboard', 'refresh');
        }

        $count = $this->db->get('sensor')->num_rows();

        $this->db->order_by('id', 'desc');
        $data = $this->db->get('sensor', 1)->row();

        echo json_encode([
            'data'  => $data,
            'count' => $count
        ]);
    }
}
