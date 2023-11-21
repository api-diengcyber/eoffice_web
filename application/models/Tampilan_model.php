<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tampilan_model extends CI_Model
{

	public $db;
	public $view_admin = 'admin/';
	public $view_pegawai = 'pegawai/';
	public $view_marketing = 'marketing/';
	public $view_training = 'training/';
	public $view_manager = 'manager/';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->lang->load('auth');
	}

	public function cek_login()
	{
		
		$data = array();
		if (!empty($this->session->userdata('users_id_office'))) {
			
			
			
			$data = array(
				'users_id' => $this->session->userdata('users_id_office'),
				'users_id_pegawai' => $this->session->userdata('users_id_pegawai_office'),
				'users_foto_pegawai' => $this->session->userdata('users_foto_pegawai_office'),
				'users_username' => $this->session->userdata('users_username_office'),
				'users_level' => $this->session->userdata('users_level_office'),
				'users_id_kantor' => $this->session->userdata(),
				
			);
		} else {
			redirect(site_url('auth/login'));
		}
		return $data;
		// var_dump($data);
	}

	public function layar($hal, $data = array(), $active = array())
	{
		$data_login = $this->cek_login();
		$this->load->model('Laporan_model');
		if (empty($this->session->userdata('users_id_office'))) {
		    redirect(site_url('auth/login'));
		    return;
		}
		if ($data_login['users_level'] == '0') { // ADMIN
			$fview = $this->view_admin;
// 		} else if ($data_login['users_level'] == '1') { // PEGAWAI
// 			$fview = $this->view_pegawai;
// 			// $data_login['gajian_pegawai'] = $this->Laporan_model->get_gajian_pegawai(date('m-Y'))['id_pegawai'][$data_login['users_id']];

// 		} else if ($data_login['users_level'] == '2') { // MARKETING
// 			$fview = $this->view_marketing;
// 			// $data_login['gajian_pegawai'] = $this->Laporan_model->get_gajian_pegawai(date('m-Y'))['id_pegawai'][$data_login['users_id']];
// 		} else if ($data_login['users_level'] == '5') {
// 			$fview = $this->view_training;
// 		} else if ($data_login['users_level'] == '6') {
// 			$fview = $this->view_manager;
		} else {
            $fview = $this->view_pegawai;
// 			redirect(site_url('auth/login'));
		}
		$this->load->view($fview . 'element/_header', $data_login);
		$this->load->view($fview . 'element/_sidebar', $active);
		$this->load->view($fview . $hal, $data);
		$this->load->view($fview . 'element/_footer');
	}

	public function admin()
	{
		$data_login = $this->cek_login();
		if ($data_login['users_level'] == '0') { // ADMIN
		} else {
			redirect(site_url());
		}
	}

	public function pegawai()
	{
		$data_login = $this->cek_login();
		if ($data_login['users_level'] != '0') { // BUKAN ADMIN
		} else {
			redirect(site_url());
		}
	}

	public function marketing()
	{
// 		$data_login = $this->cek_login();
// 		if ($data_login['users_level'] == '2') { // MARKETING
// 		} else {
// 			redirect(site_url());
// 		}
        $this->pegawai();
	}

	public function training()
	{
// 		$data_login = $this->cek_login();
// 		if ($data_login['users_level'] == '5') { // TRAINING
// 		} else {
// 			redirect(site_url());
// 		}
        $this->pegawai();
	}

	public function manager()
	{
// 		$data_login = $this->cek_login();
// 		if ($data_login['users_level'] == '6') { // TRAINING
// 		} else {
// 			redirect(site_url());
// 		}
        $this->pegawai();
	}
}

/* End of file Tampilan_model.php */
/* Location: ./application/models/Tampilan_model.php */
