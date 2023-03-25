<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
{

    public function getDataSensor()
    {
        return $this->db->get('sensor')->result();
    }
}

/* End of file M_Admin.php */
