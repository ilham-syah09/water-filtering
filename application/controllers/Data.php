<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{
	// fungsi menyimpan data nilai pada sensor
	public function save()
	{
		$sensor = [
			'pH'	=> $this->input->get('pH'),
			'ppm'	=> $this->input->get('ppm'),
			'debit'	=> $this->input->get('debit'),
		];

		if ($sensor) {
			$data = [
				'pH'	=> $sensor['pH'],
				'ppm'	=> $sensor['ppm'],
				'debit'	=> $sensor['debit'],
			];

			$this->db->order_by('id', 'desc');
			$data_sebelumnya = $this->db->get('sensor', 1)->row_array();

			if ($data_sebelumnya) {
				$nilai_sebelumnya = [
					'nilai_pH'		=> $data_sebelumnya['pH'],
					'nilai_ppm'		=> $data_sebelumnya['ppm'],
					'nilai_debit'	=> $data_sebelumnya['debit'],
				];

				if ($nilai_sebelumnya['nilai_pH'] != $sensor['pH'] || $nilai_sebelumnya['nilai_ppm'] != $sensor['ppm'] || $nilai_sebelumnya['nilai_debit'] != $sensor['debit']) {
					$this->db->insert('sensor', $data);
					echo 'nilai sensor berhasil masuk db';
				} else {
					echo 'nilai sensor masih sama';
				}
			} else {
				$this->db->insert('sensor', $data);
				echo 'nilai sensor berhasil masuk db';
			}
		}
	}
}

/* End of file Data.php */
