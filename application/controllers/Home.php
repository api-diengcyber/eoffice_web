<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public $active = array('active_utilities' => 'active_home');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tampilan_model');
		$this->load->library('form_validation');
	}

	public function privacy()
	{
		$this->load->view('privacy_policy');
	}

	public function privacy_policy_channel()
	{
		$this->load->view('privacy_policy_channel');
	}

	public function index()
	{
		$data_login = $this->Tampilan_model->cek_login();
		// var_dump($data_login);
		if ($data_login['users_level'] == '0' || $data_login['users_level'] == '3') { // ADMIN
			$this->admin();
			// 		} else if ($data_login['users_level'] == '3') { // PEGAWAI
			// 			$this->pegawai();
			// 		} else if ($data_login['users_level'] == '2') { // MARKETING
			// 			$this->marketing();
			// 		} else if ($data_login['users_level'] == '5') {
			// 			$this->training();
			// 		} else if ($data_login['users_level'] == '6') {
			// 			$this->manager();
		} else {
			$this->pegawai();
			//echo "Tidak Ada Halaman Level";
		}
	}

	public function admin()
	{
		$this->load->model('Absen_model');
		$data_login = $this->Tampilan_model->cek_login();
		$user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
			->from('users')
			->where('id', $user_id)
			->get()
			->row();

		$namaKantor = $this->db->select('*')
			->from('kantor')
			->where('id', $kantor_id->id_kantor)
			->get()
			->row();

		// var_dump($user_id,$namaKantor);
		$this->Tampilan_model->admin();
		$bulan = date('m');
		$tahun = date('Y');
		$blthn = date('m-Y');

		$jumlah_pegawai = $this->db->select('u.*')
			->from('users AS u')
			->join('users_groups AS g', 'g.user_id = u.id')
			->where('u.id_kantor=', $kantor_id->id_kantor)
			->where('g.group_id!=', 1)
			->get()->num_rows();
		// $jumlah_pegawai = $this->db->select('j.*, RIGHT(j.tgl,2) AS hari, p.asal, u.phone, p.nama_pegawai')
		// 	->from('jam_kerja AS j')
		//
		// 	->join('users AS u', 'p.id_users = u.id')
		// 	->where('RIGHT(j.tgl,4) = "' . $tahun . '"')
		// 	->where('SUBSTRING(j.tgl,4,2) = "' . $bulan . '"')
		// 	->where('u.id_kantor=',$kantor_id->id_kantor )
		// 	->group_by('j.id_users')
		// 	->order_by('p.nama_pegawai', 'ASC')
		// 	->get()->num_rows();



		$jumlah_masuk = $this->db->select('j.*')
			->from('jam_kerja j')
			->join('users as u', 'j.id_users=u.id')
			->where('u.id_kantor=', $kantor_id->id_kantor)
			->where('tgl', date('d-m-Y'))
			->where('(status = 1 OR status = 2)')
			->where('tgl', date('d-m-Y'))
			->get()->num_rows();



		$jumlah_izin = $this->db->select('*')
			->from('tidak_masuk')
			->join('users as u', 'tidak_masuk.id_users=u.id')
			->where('u.id_kantor=', $kantor_id->id_kantor)
			->where('tidak_masuk!=4')
			->where('tgl', date('Y-m-d'))
			->get()->num_rows();

		$jumlah_wfh = $this->db->select('*')
			->from('tidak_masuk')
			->join('users as u', 'tidak_masuk.id_users=u.id')
			->where('u.id_kantor=', $kantor_id->id_kantor)
			->where('tidak_masuk=4')
			->where('tgl', date('Y-m-d'))
			->get()->num_rows();


		$jumlah_tugas_pending =

			$this->db->select('t.*')
			->from('tugas as t')
			->join('pegawai as p', 'p.id=t.id_pegawai')
			->join('users as u', 'u.id=p.id_users')
			->where('u.id_kantor=', $kantor_id->id_kantor)
			->where('t.selesai', 0)
			->get()
			->num_rows();


		$data = [
			'data_bulan_ini' 		=> $this->db->where('id', $bulan)->get('bulan')->row(),
			'hari' 					=> date('d'),
			'bulan' 				=> $bulan,
			'tahun' 				=> $tahun,
			'batas_hari_bulan' 		=> date('t'),
			'jumlah_pegawai' 		=> $jumlah_pegawai,
			'jumlah_masuk' 			=> $jumlah_masuk,
			'jumlah_izin' 			=> $jumlah_izin,
			'jumlah_wfh' 			=> $jumlah_wfh,
			'jumlah_tugas_pending' 	=> $jumlah_tugas_pending,
			'nama_kantor'			=> $namaKantor,
			'id_kantor'				=> $kantor_id->id_kantor,
		];

		// $this->load->model('Status_kerja_model');
		// $row_total_active = $this->Status_kerja_model->get_total_active_by_periode("74", "2023-01-01", "2023-12-12");


		// echo "<pre>";
		// print_r($row_total_active);
		// echo "</pre>";


		$this->Tampilan_model->layar('home', $data, $this->active);
		// var_dump($data);
	}

	public function pegawai()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->pegawai();

		$this->load->model('Pegawai_model');
		$this->load->model('Tugas_model');

		$row = $this->db->where('id_users', $data_login['users_id'])->get('pegawai')->row();
		$pegawai = $this->Pegawai_model->get_by_id($data_login['users_id_pegawai']);

		$user = $this->db->select('*')
			->from('users')
			->where('id', $pegawai->id_users)
			->get()
			->row();
		$kantor = $this->db->select('*')
			->from('kantor')
			->where('id', $user->id_kantor)
			->get()
			->row();
		$namaKantor = $kantor->nama_kantor;

		$data = array(
			'tingkat' 			=> $row->tingkat,
			'data_pil_tingkat' 	=> $this->db->where('id_jabatan', $row->id_jabatan)->get('pil_tingkat')->result(),
			'data_tugas' 		=> $this->Tugas_model->get_by_id_peg($data_login['users_id_pegawai']),
			'jabatan' 			=> (object) $pegawai,
			'kantor' 			=> $namaKantor,
		);
		// var_dump($pegawai,$kantor);
		$this->Tampilan_model->layar('home', $data, $this->active);
	}

	public function marketing()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->marketing();

		$this->load->model('Pegawai_model');
		$this->load->model('Tugas_model');

		$row = $this->db->where('id_users', $data_login['users_id'])->get('pegawai')->row();
		$pegawai = $this->Pegawai_model->get_by_id($data_login['users_id_pegawai']);
		$data = array(
			'tingkat' => $row->tingkat,
			'data_pil_tingkat' => $this->db->where('id_jabatan', $row->id_jabatan)->get('pil_tingkat')->result(),
			'data_tugas' => $this->Tugas_model->get_by_id_peg($data_login['users_id_pegawai']),
			'jabatan' => (object) $pegawai,
		);
		$this->Tampilan_model->layar('home', $data, $this->active);
	}

	public function training()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->training();

		$this->load->model('Pegawai_model');
		$this->load->model('Tugas_model');

		$row = $this->db->where('id_users', $data_login['users_id'])->get('pegawai')->row();
		$pegawai = $this->Pegawai_model->get_by_id($data_login['users_id_pegawai']);
		$data = array(
			'tingkat' => $row->tingkat,
			'data_pil_tingkat' => $this->db->where('id_jabatan', $row->id_jabatan)->get('pil_tingkat')->result(),
			'data_tugas' => $this->Tugas_model->get_by_id_peg($data_login['users_id_pegawai']),
			'jabatan' => (object) $pegawai,
		);
		$this->Tampilan_model->layar('home', $data, $this->active);
	}

	public function manager()
	{
		$this->load->model('Absen_model');
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->manager();

		$bulan = date('m');
		$tahun = date('Y');
		$data = array(
			'data_bulan_ini' => $this->db->where('id', $bulan)->get('bulan')->row(),
			'hari' => date('d'),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'batas_hari_bulan' => date('t'),
			'data_pegawai_kerja' => $this->db->select('j.*, RIGHT(j.tgl,2) AS hari, p.nama_pegawai')
				->from('jam_kerja AS j')
				->join('pegawai AS p', 'j.id_users = p.id_users')
				->where('RIGHT(j.tgl,4) = "' . $tahun . '"')
				->where('SUBSTRING(j.tgl,4,2) = "' . $bulan . '"')
				->group_by('j.id_users')
				->order_by('p.nama_pegawai', 'ASC')
				->get()->result(),
			'data_pegawai' => $this->db->select('*')
				->from('users as u')
				->join('pegawai as p', 'p.id_users = u.id')
				->where('p.level != 0')
				->where('u.active != 0')
				->get()->result(),
			'data_masuk' => $this->db->select('*')
				->from('jam_kerja')
				->where('tgl', date('d-m-Y'))
				->where('status', '1')
				->or_where('status', '2')
				->where('tgl', date('d-m-Y'))
				->get()->result(),
			'data_pulang' => $this->db->select('*')
				->from('jam_kerja')
				->where('tgl', date('d-m-Y'))
				->where('status', '2')
				->get()->result(),
			'tugas_pending' => $this->db->where('progress', 100)->where('selesai', 0)->get('tugas')->result(),
			'absen_hari_ini' => $this->Absen_model->get_today()
		);
		$this->Tampilan_model->layar('home', $data, $this->active);
	}

	public function sse_pegawai()
	{
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->pegawai();
		$data = array(
			'tugas' => $this->_get_tugas(),
		);
		$json = json_encode($data);
		echo "data: " . $json . "\n\n";
		flush();
	}

	public function _get_tugas()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->pegawai();
		$res = $this->db->select('*')
			->from('tugas')
			->where('id_pegawai', $data_login['users_id_pegawai'])
			->where('selesai', '0')
			->get()->result();
		return count($res);
	}

	public function delete_account()
	{
		$this->load->library('form_validation');

		$data_login = $this->Tampilan_model->cek_login();
		$user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
			->from('users')
			->where('id', $user_id)
			->get()
			->row();

		$this->form_validation->set_rules('alasan', 'Alasan', 'trim|required');

		if ($this->form_validation->run() == true) {
			$this->db->insert('request_delete', [
				'id_kantor' => $kantor_id->id_kantor,
				'id_user' => $user_id,
				'alasan' => $this->input->post('alasan', true),
				'status' => 1,
				'waktu' => date('Y-m-d H:i:s'),
			]);
			redirect('deleteaccount', 'refresh');
		} else {
			$data = [
				'action' => site_url('deleteaccount'),
				'alasan' => set_value('alasan'),
				'data' => $this->db->where('id_user', $user_id)->get('request_delete')->row(),
			];
			$this->Tampilan_model->layar2('delete_account', $data, $this->active);
		}
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
