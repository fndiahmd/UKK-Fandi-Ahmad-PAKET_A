<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProfileController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        is_logged_in();
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Profile';

        $masyarakat = $this->db->get_where('masyarakat', ['username' => $this->session->userdata('username')])->row_array();
        $petugas = $this->db->get_where('petugas', ['username' => $this->session->userdata('username')])->row_array();

        if ($masyarakat == TRUE) {
            $data['user'] = $masyarakat;
        }elseif ($petugas == TRUE) {
            $data['user'] = $petugas;
        }

        $this->load->view('layouts/backend_head', $data);
        $this->load->view('layouts/backend_sidebar_v');
        $this->load->view('layouts/backend_topbar_v');
        $this->load->view('user/profile');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }
}

/* End of file ProfileController.php */
/* Location: ./application/controllers/User/ProfileController.php */
