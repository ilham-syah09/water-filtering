<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{
	// fungsi menyimpan data nilai pada sensor
	public function save()
	{
		if ($this->input->get('pH') < 6) {
			$statuspH = "KURANG BAIK";
		} else if ($this->input->get('pH') >= 6 && $this->input->get('pH') <= 9) {
			$statuspH = "AMAN";
		} else {
			$statuspH = "BURUK";
		}

		if ($this->input->get('ppm') < 300) {
			$statusTds = "SANGAT BAIK";
		} else if ($this->input->get('ppm') >= 300 && $this->input->get('ppm') <= 600) {
			$statusTds = "BAIK";
		} else if ($this->input->get('ppm') > 600 && $this->input->get('ppm') <= 900) {
			$statusTds = "BURUK";
		} else {
			$statusTds = "SANGAT BURUK";
		}

		$data = [
			'pH'	=> $this->input->get('pH'),
			'ppm'	=> $this->input->get('ppm'),
			'debit'	=> $this->input->get('debit'),
			'statusTds'	=> $statusTds,
			'statuspH'	=> $statuspH,
		];

		$this->db->order_by('id', 'desc');
		$data_sebelumnya = $this->db->get('sensor', 1)->row_array();

		if ($data_sebelumnya) {
			$nilai_sebelumnya = [
				'nilai_pH'		=> $data_sebelumnya['pH'],
				'nilai_ppm'		=> $data_sebelumnya['ppm'],
				'nilai_debit'	=> $data_sebelumnya['debit'],
			];

			if ($nilai_sebelumnya['nilai_pH'] != $data['pH'] || $nilai_sebelumnya['nilai_ppm'] != $data['ppm'] || $nilai_sebelumnya['nilai_debit'] != $data['debit']) {
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

/* End of file Data.php */
