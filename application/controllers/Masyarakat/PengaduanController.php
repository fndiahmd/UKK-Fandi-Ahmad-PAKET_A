<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengaduanController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        is_logged_in();
        if (!empty($this->session->userdata('level'))) :
            redirect('Auth/BlockedController');
        endif;
        $this->load->model('M_pengaduan');
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Pengaduan';

        $masyarakat = $this->db->get_where('masyarakat', ['username' => $this->session->userdata('username')])->row_array();
        $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan_masyarakat_nik($masyarakat['nik'])->result_array();
        // $petugas = $this->db->get_where('petugas', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('isi_laporan', 'Isi Laporan Pengaduan', 'trim|required');
        $this->form_validation->set_rules('foto', 'Foto Pengaduan', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/backend_head', $data);
            $this->load->view('layouts/backend_sidebar_v');
            $this->load->view('layouts/backend_topbar_v');
            $this->load->view('masyarakat/pengaduan');
            $this->load->view('layouts/backend_footer_v');
            $this->load->view('layouts/backend_foot');
        } else {
            $upload_foto = $this->upload_foto('foto');

            if ($upload_foto == FALSE) {
                $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
					Upload foto pengaduan gagal, hanya png,jpg dan jpeg yang dapat di upload!
					</div>');

                redirect('Masyarakat/PengaduanController');
            } else {
                $params = [
                    'tgl_pengaduan'      => date('Y-m-d H:i:s'),
                    'nik'                => $masyarakat['nik'],
                    'isi_laporan'        => htmlspecialchars($this->input->post('isi_laporan', true)),
                    'foto'                => $upload_foto,
                    'status'            => '0',
                ];

                $resp = $this->M_pengaduan->create($params);

                if ($resp) {
                    $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-primary" role="alert">
						Laporan berhasil dibuat
						</div>');

                    redirect('Masyarakat/PengaduanController');
                } else {
                    $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
						Laporan gagal dibuat!
						</div>');

                    redirect('Masyarakat/PengaduanController');
                }
            }
        }
    }

    public function pengaduan_detail($id)
    {
        $cek_data = $this->db->get_where('pengaduan', ['id_pengaduan' => htmlspecialchars($id)])->row_array();

        if (!empty($cek_data)) {
            $data['title'] = 'Detail Pengaduan';

            $data['data_pengaduan'] = $this->M_pengaduan->data_pengaduan_tanggapan(htmlspecialchars($id))->row_array();

            if ($data['data_pengaduan']) {
                $this->load->view('layouts/backend_head', $data);
                $this->load->view('layouts/backend_sidebar_v');
                $this->load->view('layouts/backend_topbar_v');
                $this->load->view('masyarakat/pengaduan_detail');
                $this->load->view('layouts/backend_footer_v');
                $this->load->view('layouts/backend_foot');
            } else {
                $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
					Laporan sedang di proses!
					</div>');

                redirect('Masyarakat/PengaduanController');
            }
        } else {
            $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
            Data tidak ada!
            </div>');

            redirect('Masyarakat/PengaduanController');
        }
    }

    public function pengaduan_batal($id)
    {
        $cek_data = $this->db->get_where('pengaduan', ['id_pengaduan' => htmlspecialchars($id)])->row_array();

        if (!empty($cek_data)) {
            if ($cek_data['status'] == '0') {
                $resp = $this->db->delete('pengaduan', ['id_pengaduan' => $id]);

                //hapus foto

                $path = './assets/uploads/' . $cek_data['foto'];
                unlink($path);

                if ($resp) {
                    $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-primary" role="alert">
            Hapus pengaduan berhasil
            </div>');

                    redirect('Masyarakat/PengaduanController');
                } else {
                    $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
            Hapus pengaduan gagal!
            </div>');

                    redirect('Masyarakat/PengaduanController');
                }
            } else {
                $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
					Pengaduan sedang di proses!
					</div>');

                redirect('Masyarakat/PengaduanController');
            }
        } else {
            $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
				data tidak ada
				</div>');

            redirect('Masyarakat/PengaduanController');
        }
    }

    public function edit($id)
    {
        $cek_data = $this->db->get_where('pengaduan', ['id_pengaduan' => htmlspecialchars($id)])->row_array();

        if (!empty($cek_data)) {

            if ($cek_data['status'] == '0') {


                $data['title'] = 'Edit Pengaduan';
                $data['pengaduan'] = $cek_data;

                $this->form_validation->set_rules('isi_laporan', 'Isi Laporan Pengaduan', 'trim|required');
                $this->form_validation->set_rules('foto', 'Foto Pengaduan', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('layouts/backend_head', $data);
                    $this->load->view('layouts/backend_sidebar_v');
                    $this->load->view('layouts/backend_topbar_v');
                    $this->load->view('masyarakat/edit_pengaduan');
                    $this->load->view('layouts/backend_footer_v');
                    $this->load->view('layouts/backend_foot');
                } else {
                    $upload_foto = $this->upload_foto('foto');

                    if ($upload_foto == FALSE) {
                        $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
                        Upload foto pengaduan gagal, hanya png,jpg dan jpeg yang dapat di upload!
                        </div>');

                        redirect('Masyarakat/PengaduanController');
                    } else {
                        $path = './assets/uploads/' . $cek_data['foto'];
                        unlink($path);

                        $params = [
                            'isi_laporan'  => htmlspecialchars($this->input->post('isi_laporan', true)),
                            'foto'         => $upload_foto,
                        ];

                        $resp = $this->db->update('pengaduan', $params, ['id_pengaduan' => $id]);

                        if ($resp) {
                            $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-primary" role="alert">
                            Laporan berhasil diedit
                            </div>');

                            redirect('Masyarakat/PengaduanController');
                        } else {
                            $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
                            Laporan gagal diedit!
                            </div>');

                            redirect('Masyarakat/PengaduanController');
                        }
                    }
                }
            } else {
                $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
                Pengaduan sedang di proses!
                </div>');

                redirect('Masyarakat/PengaduanController');
            }
        } else {
            $this->session->set_flashdata('msg_pengaduan', '<div class="alert alert-danger" role="alert">
            data tidak ada
            </div>');

            redirect('Masyarakat/PengaduanController');
        }
    }


    private function upload_foto($foto)
    {
        $config['upload_path']          = './assets/uploads/';
        $config['allowed_types']        = 'jpeg|jpg|png|JPEG|JPG|PNG';
        $config['max_size']             = 2048;
        $config['remove_spaces']        = TRUE;
        $config['detect_mime']            = TRUE;
        $config['mod_mime_fix']            = TRUE;
        $config['encrypt_name']            = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($foto)) {
            return FALSE;
        } else {
            return $this->upload->data('file_name');
        }
    }
}

/* End of file PengaduanController.php */
/* Location: ./application/controllers/User/PengaduanController.php */
