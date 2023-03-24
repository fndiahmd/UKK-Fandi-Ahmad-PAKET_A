<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_petugas extends CI_Model
{

    private $table = 'petugas';
    private $primary_key = 'id_petugas';

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }
}

/* End of file Pengaduan_m.php */
/* Location: ./application/models/Pengaduan_m.php */