<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BlockedController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies

    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Blocked';
        $this->load->view('layouts/backend_head', $data);
        $this->load->view('blocked');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }
}

