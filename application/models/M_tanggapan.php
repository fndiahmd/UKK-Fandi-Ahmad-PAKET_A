<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tanggapan extends CI_Model
{

    private $table = 'tanggapan';
    private $primary_key = 'id_tanggapan';

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }
}
