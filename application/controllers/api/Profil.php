<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_model', 'api');
		$this->load->model('ion_auth_model', 'ion_model');
	}

	public function update()
	{
		$this->api->head();

		$this->form_validation->set_rules('id_pegawai', 'Pegawai ID', 'trim|required');
		$this->form_validation->set_rules('id_users', 'User ID', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if ($this->form_validation->run() !== TRUE) {
			$this->api->result('error', $this->form_validation->error_array(), validation_errors());
			return;
		}

		$id_pegawai = $this->input->post('id_pegawai', true);
		$id_users = $this->input->post('id_users', true);
		$email = strtolower($this->input->post('email', true));
		$old_password = $this->input->post("old_password");
		$password = $this->input->post('password');
		$hash_password = '';

		if (!empty($password)) {
			$hash_password = $this->ion_model->hash_password($password, FALSE, FALSE);
		}

		// user
		$row_u = $this->db->where("id", $id_users)->get("users")->row();
		if (!$row_u) {
			$this->api->result('error', [], "Tidak ada user!");
			return;
		}

		// check pegawai
		$row_p = $this->db->where('id', $id_pegawai)->get('pegawai')->row();
		if (!$row_p) {
			$this->api->result('error', [], "Tidak ada pegawai!");
			return;
		}

		// check email exists
		$row_email = $this->db->where('(username = "' . $email . '" OR email = "' . $email . '") AND id!="' . $id_users . '"')->get('users')->row();
		if ($row_email) {
			$this->api->result('error', [], "Email sudah digunakan!");
			return;
		}

		$foto = $row_p->foto;
		$filename = '';
		if (!empty($_FILES['photo']['name'])) {
			// upload foto
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
			$foto = $filename;

			if (!empty($row_p->foto) && file_exists('assets/photos/' . $row_p->foto)) {
				unlink('assets/photos/' . $row_p->foto);
			}
		}

		$data_user = [
			'username' => $email,
			'email' => $email,
		];
		if ($this->ion_model->hash_password_db($id_users, $old_password, FALSE)) {
			if ($hash_password != '') {
				$data_user['password'] = $hash_password;
			}
		}

		$this->db->where('id', $id_users);
		$this->db->update('users', $data_user);

		if (!empty($filename)) {
			$data_pegawai = [
				'foto' => $filename,
			];
			$this->db->where('id', $id_pegawai);
			$this->db->update('pegawai', $data_pegawai);
		}

		$res = [
			'foto' => $foto,
			'foto_url' => site_url('assets/photos/' . $foto),
			'email' => $email,
		];

		$this->api->result('ok', $res, 'Update berhasil');
	}
}
