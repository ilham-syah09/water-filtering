<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Login extends CI_Model
{
	function cek_login($u, $p)
	{
		$this->db->where('username', $u);
		$data = $this->db->get('admin')->row();

		if ($data) {
			if (password_verify($p, $data->password)) {
				if ($data->role_id == 1) {
					$role_id = 'admin';
				} else {
					$role_id = 'user';
				}

				$login		=	array(
					'is_logged_in'	=> 	true,
					'id'			=>	$data->id,
					'role_id'		=>	$role_id
				);
				if ($login) {
					$this->session->set_userdata('log_' . $role_id, $login);
					$this->session->set_userdata($login);
					return $role_id;
				}
			} else {
				return 'Password Salah';
			}
		} else {
			return 'Username tidak terdaftar';
		}
	}
}
/* End of file M_Login.php */
/* Location: ./application/models/M_Login.php */