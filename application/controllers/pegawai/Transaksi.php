<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	public $active = array('active_transaksi' => 'active');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tampilan_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->pegawai();
		$data = array();
		$this->Tampilan_model->layar('transaksi/transaksi_list', $data, $this->active);
	}


}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */