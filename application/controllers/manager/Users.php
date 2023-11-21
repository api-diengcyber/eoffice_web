<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tampilan_model');
        $this->load->model('Ion_auth_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
	}

	public function ganti_password()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->admin();
		$data = array(
			'action' => site_url('admin/users/ganti_password_action'),
		);
		$this->Tampilan_model->layar('users/ganti_password', $data);
	}

	public function ganti_password_action()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->admin();
		$this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->ganti_password();
        } else {
        	$password_baru = $this->input->post('password_baru', TRUE);
            $hash_password = $this->Ion_auth_model->hash_password($password_baru);
            $data = array(
            	'password' => $hash_password,
            );
            $this->db->where('id', $data_login['users_id']);
            $this->db->update('users', $data);
            $this->session->set_flashdata('message', 'Ganti Password Berhasil');
            redirect(site_url('admin/users/ganti_password'));
        }
	}

	public function _rules()
	{
        $this->form_validation->set_rules('password_baru', 'password baru', 'trim|required');
        $this->form_validation->set_rules('ulangi_password_baru', 'ulangi password baru', 'trim|required');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */