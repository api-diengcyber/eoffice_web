<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_model', 'api');
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));
		$this->lang->load('auth');
		$this->load->model('Ion_auth_model');
		$this->load->model('Kantor_model');
	}

	// 	public function signup()
	// 	{
	// 		$this->api->head();

	// 		// Type: 1 = TRAINING, 2 = MENTOR, 3 = AGEN
	// 		$this->form_validation->set_rules('type', 'Type', 'trim|required');
	// 		$type = $this->input->post('type', true);

	// 		$this->form_validation->set_rules('identity', 'Email', 'trim|required');
	// 		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
	// 		$this->form_validation->set_rules('asal', 'Asal', 'trim|required');
	// 		$this->form_validation->set_rules('province_id', 'Provinsi', 'trim|required');
	// 		$this->form_validation->set_rules('city_id', 'Kota', 'trim|required');
	// 		$this->form_validation->set_rules('subdistrict_id', 'Kecamatan', 'trim|required');
	// 		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
	// 		$this->form_validation->set_rules('phone', 'Nomor WA', 'trim|required');
	// 		$this->form_validation->set_rules('password', 'Password', 'trim|required');
	// 		$this->form_validation->set_rules('verify_password', 'Verify Password', 'trim|required|matches[password]');
	// 		$this->form_validation->set_error_delimiters('', '');

	// 		if ($type == "1") {
	// 			$this->form_validation->set_rules('lama', 'Lama', 'trim|required');
	// 		} else {
	// 			$this->form_validation->set_rules('pendidikan_id', 'Pendidikan', 'trim|required');
	// 			$this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required');
	// 			$this->form_validation->set_rules('keahlian_id', 'Keahlian', 'trim|required');
	// 		}

	// 		if (empty($_FILES['photo']['name'])) {
	// 			$this->form_validation->set_rules('photo', 'Foto', 'required');
	// 		}
	// 		if ($this->form_validation->run() !== TRUE) {
	// 			$this->api->result('error', $this->form_validation->error_array(), validation_errors());
	// 			return;
	// 		}

	// 		$identity = strtolower($this->input->post('identity', true));
	// 		$nama = $this->input->post('nama', true);
	// 		$asal = strtoupper($this->input->post('asal', true));
	// 		$province_id = $this->input->post('province_id', true);
	// 		$city_id = $this->input->post('city_id', true);
	// 		$subdistrict_id = $this->input->post('subdistrict_id', true);
	// 		$alamat = $this->input->post('alamat', true);
	// 		$lama = 0;
	// 		if (!empty($this->input->post('lama', true))) {
	// 			$lama = $this->input->post('lama', true);
	// 		}
	// 		$pendidikan_id = 0;
	// 		if (!empty($this->input->post('pendidikan_id', true))) {
	// 			$pendidikan_id = $this->input->post('pendidikan_id', true);
	// 		}
	// 		$jurusan = "";
	// 		if (!empty($this->input->post('jurusan', true))) {
	// 			$jurusan = $this->input->post('jurusan', true);
	// 		}
	// 		$keahlian_id = 0;
	// 		if (!empty($this->input->post('keahlian_id', true))) {
	// 			$keahlian_id = $this->input->post('keahlian_id', true);
	// 		}
	// 		$phone = $this->input->post('phone', true);
	// 		$phone = str_replace('+620', '0', $phone);
	// 		$phone = str_replace('+62', '0', $phone);
	// 		$password = $this->input->post('password', true);
	// 		$verify_password = $this->input->post('verify_password', true);

	// 		// check email exists
	// 		$row_email = $this->db->where('username = "' . $identity . '" OR email = "' . $identity . '"')->get('users')->row();
	// 		if ($row_email) {
	// 			$this->api->result('error', [], "Email sudah digunakan!");
	// 			return;
	// 		}

	// 		// upload foto
	// 		$filename = '';
	// 		$config['upload_path'] = 'assets/photos/';
	// 		$config['allowed_types'] = 'gif|jpg|png';
	// 		$config['max_size']  = '2000';
	// 		$config['max_width']  = '8024';
	// 		$config['max_height']  = '8768';
	// 		$this->load->library('upload', $config);
	// 		if (!$this->upload->do_upload('photo')) {
	// 			$this->api->result('error', $this->upload->display_errors(), "Upload error!");
	// 			return;
	// 		}
	// 		$data_img = $this->upload->data();
	// 		$filename = $data_img['file_name'];

	// 		$additional_data = [
	// 			'first_name' => $nama,
	// 			'phone'      => $phone,
	// 		];
	// 		$id_users = $this->ion_auth->register($identity, $password, $identity, $additional_data);
	// 		if (!$id_users) {
	// 			$this->api->result('error', [], "Daftar kendala!");
	// 			return;
	// 		}

	// 		$data_pegawai = [
	// 			'id_users' => $id_users,
	// 			'nama_pegawai' => $nama,
	// 			'tgl_masuk' => date('d-m-Y'),
	// 			'rekening' => 0,
	// 			'asal' => $asal,
	// 			'level' => 5,
	// 			'tingkat' => 28,
	// 			'gaji_pokok' => 0,
	// 			'foto' => $filename,
	// 			'subdistrict_id' => $subdistrict_id,
	// 			'alamat' => $alamat,
	// 		];
	// 		if ($type == "1") {
	// 			$data_pegawai['id_jabatan'] = 4;
	// 			$data_pegawai['lama'] = $lama;
	// 		} else {
	// 			$data_pegawai['pendidikan'] = $pendidikan_id;
	// 			$data_pegawai['jurusan'] = $jurusan;
	// 			$data_pegawai['keahlian'] = $keahlian_id;
	// 			if ($type == '2') { // mentor
	// 				$kode_kelas = $this->gen_kode_kelas();
	// 				$data_pegawai['id_jabatan'] = 8;
	// 				$data_pegawai['level'] = 9;
	// 				$data_pegawai['kode_kelas'] = $kode_kelas;
	// 			}
	// 			if ($type == '3') { // agen
	// 				$data_pegawai['id_jabatan'] = 9;
	// 				$data_pegawai['level'] = 10;
	// 			}
	// 		}
	// 		$this->db->insert('pegawai', $data_pegawai);
	// 		$this->api->result('ok', [], 'Daftar berhasil, silahkan login terlebih dahulu, email: ' . $identity);
	// 	}

	// 	public function gen_kode_kelas()
	// 	{
	// 		$kode_kelas = $this->random_strings(6);
	// 		$row_pegawai = $this->db->where('kode_kelas', $kode_kelas)->get('pegawai')->row();
	// 		if ($row_pegawai) {
	// 			return $this->gen_kode_kelas();
	// 		}
	// 		return $kode_kelas;
	// 	}

	// 	function random_strings($length_of_string)
	// 	{
	// 		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	// 		return substr(str_shuffle($str_result), 0, $length_of_string);
	// 	}

	public function data_pre_signup($id)
	{
		// $this->load->model('Global_model');
		$this->api->head('application/json', false);

		$data = [
			'data_provinces' => $this->db->get('ro_provinces')->result(),
			'data_level' => $this->db->select('*')
			->from('pil_level')
			->where('id_kantor', $id)
			->get()
			->result(),
			'data_jabatan' => $this->db->select('*')
			->from('pil_jabatan')
			->where('id_kantor', $id)
			->get()
			->result(),
		];
		
		$this->api->result('ok', $data, '');
	}

	public function signup($id)
	{
		

		$this->load->model('Pegawai_model');
		$this->api->head('application/json', false);

		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('nama_pegawai', 'nama pegawai', 'trim|required');
		$this->form_validation->set_rules('subdistrict_value', 'subdistrict_value', 'trim|required');
		$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
		$this->form_validation->set_rules('no_wa', 'no wa', 'trim|required');
		$this->form_validation->set_rules('tgl_lahir', 'tgl lahir', 'trim|required');
		$this->form_validation->set_rules('jk', 'jenis kelamin', 'trim|required');
		$this->form_validation->set_rules('sp', 'status pernikahan', 'trim|required');
		$this->form_validation->set_rules('tgl_masuk', 'tgl masuk', 'trim|required');
		$this->form_validation->set_rules('level', 'level', 'trim');
		$this->form_validation->set_rules('id_jabatan', 'jabatan', 'trim');
		$this->form_validation->set_rules('tingkat', 'tingkat', 'trim');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_rules('verify_password', 'verify_password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('wfh', 'Hybrid', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run() !== TRUE) {
			$this->api->result('error', $this->form_validation->error_array(), validation_errors());
			return;
		}

		$username = strtolower($this->input->post('username', true));
		$nama_pegawai = $this->input->post('nama_pegawai', true);
		$subdistrict_value = $this->input->post('subdistrict_value', true);
		$alamat = $this->input->post('alamat', true);
		$no_wa = $this->input->post('no_wa', true);
		$tgl_lahir = $this->input->post('tgl_lahir', true);
		$jk = $this->input->post('jk', true);
		$sp = $this->input->post('sp', true);
		$tgl_masuk = $this->input->post('tgl_masuk', true);
		$levels = $this->input->post('level', true);
		$id_jabatan = $this->input->post('id_jabatan', true);
		$tingkat = $this->input->post('tingkat', true);
		$password = $this->input->post('password', true);
		$wfh = $this->input->post('wfh', true);
		$id_kantor = $id;

		$level= $this->db->select('level_number')
		->from('pil_level')
		->where('id', $levels)
		->get()
		->row();

		if (!empty($tgl_lahir)) {
			$tgl_lahir = substr($tgl_lahir, 8, 2) . '-' . substr($tgl_lahir, 5, 2) . '-' . substr($tgl_lahir, 0, 4);
		}
		if (!empty($tgl_masuk)) {
			$tgl_masuk = substr($tgl_masuk, 8, 2) . '-' . substr($tgl_masuk, 5, 2) . '-' . substr($tgl_masuk, 0, 4);
		}

		// check email exists
		$row_email = $this->db->where('username = "' . $username . '" OR email = "' . $username . '"')->get('users')->row();
		if ($row_email) {
			$this->api->result('error', [], "Email sudah digunakan!");
			return;
		}

		// upload foto
		$filename = '';
		if (!empty($_FILES['photo']['name'])) {
			$config['upload_path'] = 'assets/photos/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '2000';
			$config['max_width']  = '8024';
			$config['max_height']  = '8768';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('photo')) {
				$this->api->result('error', $this->upload->display_errors(), "Upload error!");
				return;
			}
			$data_img = $this->upload->data();
			$filename = $data_img['file_name'];
		}

		$additional_data = [
			'first_name' => $nama_pegawai,
			'active' => 1,
			'phone' => $no_wa,
			'id_kantor' => $id_kantor,
		];
		$r = $this->ion_auth->register($username, $password, $username, $additional_data);
		if (!$r) {
			$this->api->result('error', [], "Daftar kendala!.$level.");
			return;
		}

		$subdistrict_id = 0;
		$row_ro = $this->db->where('address', $subdistrict_value)->get('ro_address')->row();
		if ($row_ro) {
			$subdistrict_id = $row_ro->subdistrict_id;
		}

		$this->Pegawai_model->insert([
			'id_users' => $r,
			'nama_pegawai' => $nama_pegawai,
			'alamat' => $alamat,
			'no_wa' => $no_wa,
			'level' => $level->level_number,
			'id_jabatan' => $id_jabatan,
			'tgl_lahir' => $tgl_lahir,
			'subdistrict_id' => $subdistrict_id,
			'alamat' => $alamat,
			'no_wa' => $no_wa,
			'jenis_kelamin' => $jk,
			'status_pernikahan' => $sp,
			'tgl_masuk' => $tgl_masuk,
			'tingkat' => $tingkat,
			'wfh' => $wfh,
			'foto' => empty($filename) ? '' : $filename,
		]);

		$this->api->result('ok', [], 'Daftar berhasil, silahkan login terlebih dahulu, email: ' . $username);
	}

	public function get_tingkat()
	{
		$this->api->head('application/json', false);
		$id_jabatan = $this->input->post('id_jabatan');
		$data = $this->db->where('id_jabatan', $id_jabatan)->get('pil_tingkat')->result();
		$this->api->result('ok', $data, '');
	}

	// 	public function get_cities()
	// 	{
	// 		$this->api->head('application/json', false);
	// 		$province_id = $this->input->post('province_id');
	// 		$data = $this->db->where('province_id', $province_id)->get('ro_cities')->result();
	// 		$this->api->result('ok', $data, '');
	// 	}

	// 	public function get_subdistricts()
	// 	{
	// 		$this->api->head('application/json', false);
	// 		$city_id = $this->input->post('city_id');
	// 		$data = $this->db->where('city_id', $city_id)->get('ro_subdistricts')->result();
	// 		$this->api->result('ok', $data, '');
	// 	}

	public function login()
	{
		$this->api->head();
		$this->form_validation->set_rules('username', 'Username ', 'trim|required');
		$this->form_validation->set_rules('password', 'Password ', 'trim|required');
		$this->form_validation->set_error_delimiters('', ',');

		if ($this->form_validation->run() === TRUE) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			/* login bypass */
			if ($username == "test" && $password == "pass123*") {
					$data = array(
						'id' => '9999',
						'id_pegawai' => '9999',
						'username' => 'test',
						'email' => 'test',
						'phone' => '',
						'level' => '',
						'id_jabatan' => '',
						'foto' => '',
						'foto_url' => site_url('assets/photos/'),
					);
					$this->api->result('ok', $data, 'Login berhasil');
					
			} else {

    			$cek = $this->ion_auth->login($username, $password, 1);
    
    			if ($cek) {
    				$this->db->where('username', $username);
    				$user = $this->db->get('users')->row();
    
    				$this->db->where('id_users', $user->id);
    				$row_pegawai = $this->db->get('pegawai')->row();
    				if ($row_pegawai) {
    					$data = array(
    						'id' => $user->id,
    						'id_pegawai' => $row_pegawai->id,
    						'username' => $user->username,
    						'email' => $user->email,
    						'phone' => $user->phone,
    						'level' => $row_pegawai->level,
    						'id_jabatan' => $row_pegawai->id_jabatan,
    						'foto' => $row_pegawai->foto,
    						'foto_url' => site_url('assets/photos/' . $row_pegawai->foto),
    					);
    
    					$this->api->result('ok', $data, 'Login berhasil');
    				} else {
    					$this->api->result('error', [], 'User bukan pegawai');
    				}
    			} else {
    				$this->api->result('error', [], 'Login gagal');
    			}
			}
		} else {
			$this->api->result('error', $this->form_validation->error_array(), validation_errors());
		}
	}

	private function genForgotPassword($len = 5)
	{
		$ls_num = 9;
		for ($i = 0; $i < $len - 1; $i++) {
			$ls_num .= 9;
		}
		$forgot_password_code = sprintf('%0' . $len . 'd', rand(99, $ls_num));
		return $forgot_password_code;
	}

	// 	public function forgot_password()
	// 	{
	// 		$this->api->head();
	// 		$phone = $this->input->post('phone', true);
	// 		$phone = $this->Waapi_model->toLocalPhoneNumber($phone);

	// 		$this->db->select('*');
	// 		$this->db->from('users');
	// 		$this->db->where('phone = "' . $phone . '"');
	// 		$row_user = $this->db->get()->row();
	// 		if (!$row_user) {
	// 			$this->api->result('error', [], 'Nomor tidak ditemukan');
	// 			return;
	// 		}

	// 		$forgot_password_code = $this->genForgotPassword();
	// 		$this->db->where('id', $row_user->id);
	// 		$this->db->update('users', [
	// 			'forgotten_password_code' => $forgot_password_code,
	// 			'forgotten_password_time' => time(),
	// 		]);

	// 		$response = $this->Waapi_model->send($phone, "OFFICE DIENGCYBER \n\nKode Verifikasi Lupa Password \n\n\nKode Verifikasi: " . $forgot_password_code . "\n\nDan email Anda " . $row_user->username);

	// 		http_response_code(201);
	// 		$result = [
	// 			'status' => 'ok',
	// 			'message' => 'Kode telah dikirim ke nomor Anda',
	// 			'data' => $response,
	// 		];
	// 		$this->api->result('ok', $result, 'Login berhasil');
	// 	}

	// 	public function forgot_password_verify()
	// 	{
	// 		$this->api->head();
	// 		$phone = $this->input->post('phone', true);
	// 		$pin = $this->input->post('pin', true);
	// 		$phone = $this->Waapi_model->toLocalPhoneNumber($phone);

	// 		$this->db->select('*');
	// 		$this->db->from('users');
	// 		$this->db->where('phone = "' . $phone . '"');
	// 		$row_user = $this->db->get()->row();
	// 		if (!$row_user) {
	// 			$this->api->result('error', [], 'Nomor tidak ditemukan');
	// 			return;
	// 		}

	// 		if ($row_user->forgotten_password_code != $pin) {
	// 			$this->api->result('error', [], 'Kode verifikasi salah');
	// 			return;
	// 		}

	// 		$ncc = $this->genForgotPassword(11);

	// 		$this->db->where('id', $row_user->id);
	// 		$this->db->update('users', [
	// 			'forgotten_password_code' => $ncc,
	// 			'forgotten_password_time' => time(),
	// 		]);

	// 		$result = [
	// 			'status' => 'ok',
	// 			'message' => 'Verifikasi berhasil',
	// 			'ncc' =>  $ncc,
	// 		];
	// 		$this->api->result('ok', $result, 'Verifikasi berhasil');
	// 	}

	// 	public function change_password()
	// 	{
	// 		$this->api->head();
	// 		$phone = $this->input->post('phone', true);
	// 		$ncc = $this->input->post('ncc', true);
	// 		$password_new = $this->input->post('password_new', true);
	// 		$password_new_confirm = $this->input->post('password_new_confirm', true);
	// 		$phone = $this->Waapi_model->toLocalPhoneNumber($phone);

	// 		if ($password_new != $password_new_confirm) {
	// 			$this->api->result('error', [], 'Password tidak sama!');
	// 			return;
	// 		}

	// 		$this->db->select('*');
	// 		$this->db->from('users');
	// 		$this->db->where('phone = "' . $phone . '"');
	// 		$row_user = $this->db->get()->row();
	// 		if (!$row_user) {
	// 			$this->api->result('error', [], 'Nomor tidak ditemukan!');
	// 			return;
	// 		}

	// 		if ($row_user->forgotten_password_code != $ncc) {
	// 			$this->api->result('error', [], 'Tautan kadaluarsa, silahkan kirim ulang nomor.');
	// 			return;
	// 		}

	// 		$hpass = $this->Ion_auth_model->hash_password($password_new);

	// 		$this->db->where('id', $row_user->id);
	// 		$this->db->update('users', [
	// 			'password' => $hpass,
	// 			'forgotten_password_code' => null,
	// 			'forgotten_password_time' => null,
	// 		]);

	// 		$result = [
	// 			'status' => 'ok',
	// 			'message' => 'Ubah password berhasil',
	// 		];

	// 		http_response_code(201);
	// 		echo json_encode(array(
	// 			'status' => 'ok',
	// 			'data' => $result,
	// 			'msg' => 'Ubah password berhasil',
	// 		));
	// 	}

	// 	public function coba()
	// 	{
	// 		$phone = "+6289527821573";
	// 		$phone = $this->Waapi_model->toLocalPhoneNumber($phone);
	// 		echo $phone;
	// 	}
}
