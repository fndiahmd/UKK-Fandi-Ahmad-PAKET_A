<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        is_logged_in();
        if (!$this->session->userdata('level')) {
            redirect('Auth/BlockedController');
        }

        $this->load->model('M_pengaduan');
    }

    public function index()
    {
        $data['title'] = 'Generate Laporan';
        $data['data_pengaduan'] = $this->M_pengaduan->laporan_pengaduan()->result_array();


        $this->load->view('layouts/backend_head', $data);
        $this->load->view('layouts/backend_sidebar_v');
        $this->load->view('layouts/backend_topbar_v');
        $this->load->view('admin/laporan');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }

    public function generate_laporan()
    {

        $data['laporan'] = $this->M_pengaduan->laporan_pengaduan()->result_array();

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'landscape'); // opsional | default A4
        $this->pdf->filename = "laporan-pengaduan.pdf"; // opsional | default is laporan.pdf
        $this->pdf->load_view('laporan_pdf', $data);
    }
}

