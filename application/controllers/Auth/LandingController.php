<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LandingController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies

        $this->load->model('M_pengaduan');
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Pengaduan Masyarakat';
        $data['pengaduan'] = $this->db->get('pengaduan')->num_rows();
        $data['tanggapan'] = $this->db->get('tanggapan')->num_rows();
        $data['laporan'] = $this->M_pengaduan->laporan_pengaduan()->result_array();
        $laporan = $this->M_pengaduan->laporan_pengaduan()->num_rows();
        // $data['laporan'] = $this->M_pengaduan->laporan_pengaduan()->result_array();


        $this->load->library('pagination');

        // $config['base_url'] = 'Auth/LandingController';
        // $config['total_rows'] = $laporan;
        // $config['per_page'] = 2;
        
        
        // $config['full_tag_open'] = '<div class="pagination">';
        // $config['full_tag_close'] = '</div>';
        // $from = $this->uri->segment(3);
        // $data['laporan'] = $this->M_pengaduan->data($config['per_page'],$from);
                
        // $this->pagination->initialize($config);
       
        $this->load->view('landing_page', $data);
    }

}

/* End of file LoginController.php */
/* Location: ./application/controllers/Auth/LoginController.php */
