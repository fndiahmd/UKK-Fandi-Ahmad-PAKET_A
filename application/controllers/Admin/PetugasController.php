<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PetugasController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        is_logged_in();
        if (!$this->session->userdata('level')) {
            redirect('Auth/BlockedController');
        }
        $this->load->model('M_petugas');
    }

    public function index()
    {
        $data['title'] = 'Tambah Petugas';
        $data['data_petugas'] = $this->db->get('petugas')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric_spaces|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric_spaces|min_length[6]|max_length[15]');
        $this->form_validation->set_rules('telp', 'Telp', 'trim|required|numeric');
        $this->form_validation->set_rules('level', 'Level', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/backend_head', $data);
            $this->load->view('layouts/backend_sidebar_v');
            $this->load->view('layouts/backend_topbar_v');
            $this->load->view('admin/petugas');
            $this->load->view('layouts/backend_footer_v');
            $this->load->view('layouts/backend_foot');
        } else {
            // $upload_foto = $this->upload_foto('foto');
            $params = [
                'nama_petugas'      => htmlspecialchars($this->input->post('nama', true)),
                'username'          => htmlspecialchars($this->input->post('username', true)),
                'password'          => password_hash(htmlspecialchars($this->input->post('password', true)), PASSWORD_DEFAULT),
                'telp'              => htmlspecialchars($this->input->post('telp', true)),
                'level'             => htmlspecialchars($this->input->post('level', true)),
                'foto_profile'      => 'user.png',
            ];

            $resp = $this->M_petugas->create($params);

            if ($resp) {
                $this->session->set_userdata($session);

                $this->session->set_flashdata('msg_petugas', '<div class="alert alert-primary" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            			Akun petugas berhasil dibuat
            			</div>');

                redirect('Admin/PetugasController');
            } else {
                $this->session->set_flashdata('msg_petugas', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            			Akun petugas gagal dibuat!
            			</div>');

                redirect('Admin/PetugasController');
            }
        }
    }

    public function delete($id)
    {
        $id_petugas = htmlspecialchars($id); // id petugas

        $cek_data = $this->db->get_where('petugas',['id_petugas' => $id_petugas])->row_array();
        
        if ( ! empty($cek_data)) :
            $resp = $this->db->delete('petugas',['id_petugas' => $id_petugas]);

            if ($resp) :
                $this->session->set_userdata($session);

                $this->session->set_flashdata('msg_petugas','<div class="alert alert-primary" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Akun berhasil dihapus
                    </div>');

                redirect('Admin/PetugasController');
            else :
                $this->session->set_flashdata('msg_petugas','<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Akun gagal dihapus!
                    </div>');

                redirect('Admin/PetugasController');
            endif;
        else :
            $this->session->set_flashdata('msg_petugas','<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data tidak ada
                </div>');

            redirect('Admin/PetugasController');
        endif;
    }

    public function edit($id)
{
		$id_petugas = htmlspecialchars($id); // id petugas

		$cek_data = $this->db->get_where('petugas',['id_petugas' => $id_petugas])->row_array();

		if ( ! empty($cek_data)) :

			$data['title'] = 'Edit Petugas';
			$data['petugas'] = $cek_data;

			$this->form_validation->set_rules('nama','Nama','trim|required|alpha_numeric_spaces');
			$this->form_validation->set_rules('telp','Telp','trim|required|numeric');
			$this->form_validation->set_rules('level','Level','trim|required');

			if ($this->form_validation->run() == FALSE) :
				$this->load->view('layouts/backend_head', $data);
				$this->load->view('layouts/backend_sidebar_v');
				$this->load->view('layouts/backend_topbar_v');
				$this->load->view('admin/edit_petugas');
				$this->load->view('layouts/backend_footer_v');
				$this->load->view('layouts/backend_foot');
			else :

			$params = [
				'nama_petugas'			=> htmlspecialchars($this->input->post('nama',TRUE)),
				'telp'					=> htmlspecialchars($this->input->post('telp',TRUE)),
				'level'					=> htmlspecialchars($this->input->post('level',TRUE)),
			];

			$resp = $this->db->update('petugas',$params, ['id_petugas' => $id_petugas]);

			if ($resp) :
                $this->session->set_userdata($session);

				$this->session->set_flashdata('msg_petugas','<div class="alert alert-primary" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Akun petugas berhasil di edit
					</div>');

				redirect('Admin/PetugasController');
			else :
				$this->session->set_flashdata('msg_petugas','<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Akun petugas gagal di edit!
					</div>');

				redirect('Admin/PetugasController');
			endif;

			endif;

		else :
			$this->session->set_flashdata('msg_petugas','<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data tidak ada
				</div>');

			redirect('Admin/PetugasController');
		endif;
	}

    public function username_check($str = NULL)
    {
        if (!empty($str)) {
            $masyarakat = $this->db->get_where('masyarakat', ['username' => $str])->row_array();
            $petugas = $this->db->get_where('petugas', ['username' => $str])->row_array();

            if ($masyarakat == TRUE or $petugas == TRUE) {
                $this->form_validation->set_message('username_check', 'Username ini sudah ada');

                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('username_check', 'Inputan kosong');

            return FALSE;
        }
    }
}

