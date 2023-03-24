<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        is_logged_in();
        if (!$this->session->userdata('level')) :
            redirect('Auth/BlockedController');
        endif;
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Dashboard';

        $data['petugas'] = $this->db->get('petugas')->num_rows();
        $data['pengaduan'] = $this->db->get('pengaduan')->num_rows();
        $data['pengaduan_proses'] = $this->db->get('pengaduan', ['status' => 'proses'])->num_rows();
        $data['pengaduan_selesai'] = $this->db->get('pengaduan', ['status' => 'selesai'])->num_rows();


            $this->load->view('layouts/backend_head', $data);
            $this->load->view('layouts/backend_sidebar_v');
            $this->load->view('layouts/backend_topbar_v');
            $this->load->view('admin/dashboard');
            $this->load->view('layouts/backend_footer_v');
            $this->load->view('layouts/backend_foot');
        
    }

}

