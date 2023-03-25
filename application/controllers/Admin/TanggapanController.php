<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class TanggapanController extends CI_Controller
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
        $this->load->model('M_tanggapan');
        $this->load->model('M_petugas');
    }

    public function index()
    {
        $data['title'] = 'Pengaduan';
        $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan()->result_array();

        $this->load->view('layouts/backend_head', $data);
        $this->load->view('layouts/backend_sidebar_v');
        $this->load->view('layouts/backend_topbar_v');
        $this->load->view('admin/tanggapan');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }

    public function tanggapan_detail()
    {
        $id = htmlspecialchars($this->input->post('id', TRUE));

        $cek_data = $this->db->get_where('pengaduan', ['id_pengaduan' => $id])->row_array();

        if (!empty($cek_data)) {
            $data['title'] = 'Beri Tanggapan';
            $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_id(htmlspecialchars($id))->row_array();

            $this->load->view('layouts/backend_head', $data);
            $this->load->view('layouts/backend_sidebar_v');
            $this->load->view('layouts/backend_topbar_v');
            $this->load->view('admin/tanggapan_detail');
            $this->load->view('layouts/backend_footer_v');
            $this->load->view('layouts/backend_foot');
        } else {
            $this->session->set_userdata($session);

            $this->session->set_flashdata('msg_tanggapan', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            data tidak ada
            </div>');

            redirect('Admin/TanggapanController');
        }
    }

    public function tanggapan_proses()
    {
        $data['title'] = 'Pengaduan Proses';
        $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_proses()->result_array();

        $this->load->view('layouts/backend_head', $data);
        $this->load->view('layouts/backend_sidebar_v');
        $this->load->view('layouts/backend_topbar_v');
        $this->load->view('admin/tanggapan_proses');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }

    public function tanggapan_selesai()
    {
        $data['title'] = 'Pengaduan Selesai';
        $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_selesai()->result_array();

        $this->load->view('layouts/backend_head', $data);
        $this->load->view('layouts/backend_sidebar_v');
        $this->load->view('layouts/backend_topbar_v');
        $this->load->view('admin/tanggapan_selesai');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }

    public function tanggapan_tolak()
    {
        $data['title'] = 'Pengaduan Ditolak';
        $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_tolak()->result_array();

        $this->load->view('layouts/backend_head', $data);
        $this->load->view('layouts/backend_sidebar_v');
        $this->load->view('layouts/backend_topbar_v');
        $this->load->view('admin/tanggapan_tolak');
        $this->load->view('layouts/backend_footer_v');
        $this->load->view('layouts/backend_foot');
    }

    public function tanggapan_pengaduan_selesai()
    {
        $id_pengaduan = htmlspecialchars($this->input->post('id', TRUE));
        $cek_data = $this->db->get_where('pengaduan', ['id_pengaduan' => $id_pengaduan])->row_array();

        if (!empty($cek_data)) {
            $this->form_validation->set_rules('id', 'id', 'trim|required');

            if ($this->form_validation->run() == FALSE) {

                $data['title'] = 'Pengaduan proses';
                $data['pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_proses()->result_array();

                $this->load->view('layouts/backend_head', $data);
                $this->load->view('layouts/backend_sidebar_v');
                $this->load->view('layouts/backend_topbar_v');
                $this->load->view('admin/tanggapan_proses');
                $this->load->view('layouts/backend_footer_v');
                $this->load->view('layouts/backend_foot');
            } else {
                $params = [
                    'status' => 'selesai',
                ];

                $update_status_pengaduan = $this->db->update('pengaduan', $params, ['id_pengaduan' => $id_pengaduan]);

                if ($update_status_pengaduan) {
                $this->session->set_userdata($session);

                    $this->session->set_flashdata('msg_tanggapan_proses', '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Pengaduan berhasil diselesaikan !
						</div>');

                    redirect('Admin/TanggapanController/tanggapan_proses');
                } else {
                    $this->session->set_flashdata('msg_tanggapan_proses', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Pengaduan gagal diselesaikan !
						</div>');

                    redirect('Admin/TanggapanController/tanggapan_proses');
                }
            }
        } else {
            $this->session->set_flashdata('msg_tanggapan_proses', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				data tidak ada
				</div>');

            redirect('Admin/TanggapanController/tanggapan_proses');
        }
    }

    public function tambah_tanggapan()
    {
        $id_pengaduan = htmlspecialchars($this->input->post('id', TRUE));
        $cek_data = $this->db->get_where('pengaduan', ['id_pengaduan' => $id_pengaduan])->row_array();

        if (!empty($cek_data)) {
            $this->form_validation->set_rules('id', 'id', 'trim|required');
            $this->form_validation->set_rules('status', 'Status Pengaduan', 'trim|required');
            $this->form_validation->set_rules('tanggapan', 'Tanggapan', 'trim|required');

            if ($this->form_validation->run() == FALSE) {

                $data['title'] = 'Beri Tanggapan';
                $data['pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_id(htmlspecialchars($id_pengaduan))->result_array();

                $this->load->view('layouts/backend_head', $data);
                $this->load->view('layouts/backend_sidebar_v');
                $this->load->view('layouts/backend_topbar_v');
                $this->load->view('admin/tanggapan_detail');
                $this->load->view('layouts/backend_footer_v');
                $this->load->view('layouts/backend_foot');
            } else {
                $petugas = $this->db->get_where('petugas', ['username' => $this->session->userdata('username')])->row_array();

                $params = [
                    'id_pengaduan'      => $id_pengaduan,
                    'tgl_tanggapan'     => date('Y-m-d H:i:s'),
                    'tanggapan'         => htmlspecialchars($this->input->post('tanggapan', true)),
                    'id_petugas'        => $petugas['id_petugas'],
                ];

                $menanggapi = $this->db->insert('tanggapan', $params);

                if ($menanggapi) {
                    $params = [
                        'status' => $this->input->post('status', true),
                    ];

                    $update_status_pengaduan = $this->db->update('pengaduan', $params, ['id_pengaduan' =>  $id_pengaduan]);

                    if ($update_status_pengaduan) {
                        $this->session->set_userdata($session);

                        $this->session->set_flashdata('msg_tanggapan', '<div class="alert alert-primary" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Menanggapi berhasil
							</div>');

                        redirect('Admin/TanggapanController');
                    } else {
                        $this->session->set_flashdata('msg_tanggapan', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Gagal Update Pengaduan
							</div>');

                        redirect('Admin/TanggapanController');
                    }
                } else {
                    $this->session->set_flashdata('msg_tanggapan', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Menanggapi gagal
							</div>');

                    redirect('Admin/TanggapanController');
                }
            }
        } else {
            $this->session->set_flashdata('msg_tanggapan', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							data tidak ada
							</div>');

            redirect('Admin/TanggapanController');
        }
    }
}

