<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_masyarakat extends CI_Model
{

    private $table = 'masyarakat';
    private $primary_key = 'nik';

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }
}
