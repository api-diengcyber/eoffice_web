<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public $load;

    public $api;

    public $form_validation;

    public $input;

    public $db;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
       

		// $namaKantor = $this->db->select('*')
		// 			->from('kantor')
		// 			->where('id',$kantor_id->id_kantor)
		// 			->get()
		// 			->row();
    }

    private function _get_presensi_pegawai_by_date($date, $id_pegawai_mentor = '', $kode_kelas = '')
    {

        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();

        $this->db->select('j.*, p.nama_pegawai, km.kode_kelas, km.nama_kelas');
        $this->db->from('jam_kerja j');
        $this->db->join('users u', 'j.id_users=u.id');
        $this->db->join('pegawai p', 'p.id_users=u.id');
        $this->db->join('kelas_training k', 'p.id=k.id_pegawai_training', 'left');
        $this->db->join('kelas_mentor km', 'k.id_kelas_mentor=km.id', 'left');
        $this->db->where('u.id_kantor', $kantor_id->id_kantor);
        if (!empty($id_pegawai_mentor)) {
            $this->db->where('km.id_pegawai_mentor', $id_pegawai_mentor);
        }
        if (!empty($kode_kelas)) {
            $this->db->where('km.kode_kelas', $kode_kelas);
        }
        $this->db->where('tgl', date('d-m-Y', strtotime($date)));
        $this->db->group_by('j.id');
        return $this->db;
    }


    public function get_presensi_list_by_date()
    {
        $this->api->head('application/json', false);

        $this->form_validation->set_rules('limit', 'Limit', 'trim|required');
        $this->form_validation->set_rules('page', 'Page', 'trim|required');
        $this->form_validation->set_rules('date', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_mentor', 'ID Pegawai Mentor', 'trim');
        $this->form_validation->set_rules('kode_kelas', 'Kode Kelas', 'trim');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $limit = $this->input->post('limit', true);
        $page = $this->input->post('page', true);
        $date = $this->input->post('date', true);
        $id_pegawai_mentor = null;
        if (!empty($this->input->post('id_pegawai_mentor', true))) {
            $id_pegawai_mentor = $this->input->post('id_pegawai_mentor', true);
        }
        $kode_kelas = null;
        if (!empty($this->input->post('kode_kelas', true))) {
            $kode_kelas = $this->input->post('kode_kelas', true);
        }

        $get_p1 = $this->_get_presensi_pegawai_by_date($date, $id_pegawai_mentor, $kode_kelas);
        $total_rows = $get_p1->get()->num_rows();

        $total_page = ceil($total_rows / $limit);
        $offset = ($page == 1) ? 0 : (($page * $limit) - $limit);

        if ($total_rows != 0 && $page > $total_page) {
            $this->api->result('error', [], "Page Over!");
            return;
        }

        $get_p2 = $this->_get_presensi_pegawai_by_date($date, $id_pegawai_mentor, $kode_kelas);
        $get_p2->order_by('j.id', 'asc');
        $get_p2->limit($limit);
        $get_p2->offset($offset);
        $res = $get_p2->get()->result();

        $res = [
            'data' => $res,
            'page' => $page,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
        ];

        $this->api->result('ok', $res, 'Data Presensi ' . $date);
    }

    private function _get_presensi_pegawai($date, $id_pegawai_mentor = '', $kode_kelas = '')
    {
        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();

        $this->db->select('p.*, u.phone, CONCAT("62", SUBSTRING(u.phone,2,15)) AS phone_wa, km.kode_kelas, km.nama_kelas');
        $this->db->from('pegawai p');
        $this->db->join('users u', 'p.id_users=u.id');
        $this->db->join('jam_kerja j', 'p.id_users=j.id_users');
        $this->db->join('kelas_training k', 'p.id=k.id_pegawai_training', 'left');
        $this->db->join('kelas_mentor km', 'k.id_kelas_mentor=km.id', 'left');
        // $this->db->join('users as u', 'u.id=p.id_users');
        $this->db->where('u.id_kantor', $kantor_id->id_kantor);
        if (!empty($id_pegawai_mentor)) {
            $this->db->where('km.id_pegawai_mentor', $id_pegawai_mentor);
        }
        if (!empty($kode_kelas)) {
            $this->db->where('km.kode_kelas', $kode_kelas);
        }
        $this->db->where('RIGHT(j.tgl,4) = "' . date('Y', strtotime($date)) . '"');
        $this->db->where('SUBSTRING(j.tgl,4,2) = "' . date('m', strtotime($date)) . '"');
        $this->db->group_by('p.id');
        return $this->db;
    }

    private function _get_presensi_jam_kerja($date, $whereIdUsersIn = [], $id_pegawai_mentor = '', $kode_kelas = '')
    {

        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();

        $sdate = date('Y-m-01', strtotime($date));
        $edate = date('Y-m-t', strtotime($date));
        $this->db->from('jam_kerja j');
        $this->db->join('pegawai p', 'p.id_users=j.id_users');
        $this->db->join('kelas_training k', 'p.id=k.id_pegawai_training', 'left');
        $this->db->join('kelas_mentor km', 'k.id_kelas_mentor=km.id', 'left');
        $this->db->join('users as u', 'u.id=p.id_users', 'left');
        $this->db->where('u.id_kantor',  $kantor_id->id_kantor);
        if (!empty($id_pegawai_mentor)) {
            $this->db->where('km.id_pegawai_mentor', $id_pegawai_mentor);
        }
        if (!empty($kode_kelas)) {
            $this->db->where('km.kode_kelas', $kode_kelas);
        }
        $this->db->where("DATE(CONCAT(SUBSTRING(j.tgl,7,4),'-',SUBSTRING(j.tgl,4,2),'-',SUBSTRING(j.tgl,1,2))) BETWEEN '" . $sdate . "' AND '" . $edate . "'");
        $this->db->where_in("j.id_users", $whereIdUsersIn);
        $this->db->group_by('j.id');
        $res = $this->db->get()->result();
        $data = [];
        foreach ($res as $key) :
            $data[$key->id_users][$key->tgl] = $key;
        endforeach;
        return $data;
    }


    public function get_presensi()
    {
        $this->api->head('application/json', false);

        $this->form_validation->set_rules('limit', 'Limit', 'trim|required');
        $this->form_validation->set_rules('page', 'Page', 'trim|required');
        $this->form_validation->set_rules('date', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_mentor', 'Id Pegawai Mentor', 'trim');
        $this->form_validation->set_rules('kode_kelas', 'Kode kelas', 'trim');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $limit = $this->input->post('limit', true);
        $page = $this->input->post('page', true);
        $date = $this->input->post('date', true);
        $id_pegawai_mentor = null;
        if (!empty($this->input->post('id_pegawai_mentor', true))) {
            $id_pegawai_mentor = $this->input->post('id_pegawai_mentor', true);
        }
        $kode_kelas = null;
        if (!empty($this->input->post('kode_kelas', true))) {
            $kode_kelas = $this->input->post('kode_kelas', true);
        }

        $get_p1 = $this->_get_presensi_pegawai($date, $id_pegawai_mentor, $kode_kelas);
        $total_rows = $get_p1->get()->num_rows();

        $total_page = ceil($total_rows / $limit);
        $offset = ($page == 1) ? 0 : (($page * $limit) - $limit);

        if ($total_rows != 0 && $page > $total_page) {
            $this->api->result('error', [], "Page Over!");
            return;
        }

        $get_p2 = $this->_get_presensi_pegawai($date, $id_pegawai_mentor, $kode_kelas);
        $get_p2->order_by('p.nama_pegawai', 'asc');
        $get_p2->limit($limit);
        $get_p2->offset($offset);
        $res = $get_p2->get()->result();

        $data_id_users = [];
        foreach ($res as $key) :
            $data_id_users[] = $key->id_users;
        endforeach;

        $data_jam_kerja = $this->_get_presensi_jam_kerja($date, $data_id_users, $id_pegawai_mentor, $kode_kelas);

        $ehdate = date('t', strtotime($date)) * 1;
        $blnthndate = date('m-Y', strtotime($date));
        $dmydate = date('d-m-Y', strtotime($date));

        $data = [];
        foreach ($res as $key) :
            $det = [];
            for ($i = 0; $i < $ehdate; $i++) :
                $tglni = sprintf('%02d', ($i + 1)) . '-' . $blnthndate;
                $today = 0;
                if ($tglni == $dmydate) {
                    $today = 1;
                }
                $dt = [
                    'today' => $today,
                ];
                if (!empty($data_jam_kerja[$key->id_users][$tglni])) {
                    $rd = (object) $data_jam_kerja[$key->id_users][$tglni];
                    $rd->today = $today;
                    $dt = $rd;
                }
                $det[$i] = $dt;
            endfor;
            $key->dates = $det;
            $data[] = $key;
        endforeach;

        $res = [
            'data' => $data,
            'page' => $page,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
        ];

        $this->api->result('ok', $res, 'Data Presensi');
    }

    public function get_presensi_id($id)
    {
        $this->api->head('application/json', false);

        $this->form_validation->set_rules('limit', 'Limit', 'trim|required');
        $this->form_validation->set_rules('page', 'Page', 'trim|required');
        $this->form_validation->set_rules('date', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_mentor', 'Id Pegawai Mentor', 'trim');
        $this->form_validation->set_rules('kode_kelas', 'Kode kelas', 'trim');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $limit = $this->input->post('limit', true);
        $page = $this->input->post('page', true);
        $date = $this->input->post('date', true);
        $id_pegawai_mentor = null;
        if (!empty($this->input->post('id_pegawai_mentor', true))) {
            $id_pegawai_mentor = $this->input->post('id_pegawai_mentor', true);
        }
        $kode_kelas = null;
        if (!empty($this->input->post('kode_kelas', true))) {
            $kode_kelas = $this->input->post('kode_kelas', true);
        }

        $get_p1 = $this->_get_presensi_pegawai($date, $id_pegawai_mentor, $kode_kelas);
        $total_rows = $get_p1->get()->num_rows();

        $total_page = ceil($total_rows / $limit);
        $offset = ($page == 1) ? 0 : (($page * $limit) - $limit);

        if ($total_rows != 0 && $page > $total_page) {
            $this->api->result('error', [], "Page Over!");
            return;
        }

        $get_p2 = $this->_get_presensi_pegawai($date, $id_pegawai_mentor, $kode_kelas);
        $get_p2->order_by('p.nama_pegawai', 'asc');
        $get_p2->limit($limit);
        $get_p2->offset($offset);
        $res = $get_p2->get()->result();

        $data_id_users = [];
        foreach ($res as $key) :
            $data_id_users[] = $key->id_users;
        endforeach;

        $data_jam_kerja = $this->_get_presensi_jam_kerja($date, $data_id_users, $id_pegawai_mentor, $kode_kelas);

        $ehdate = date('t', strtotime($date)) * 1;
        $blnthndate = date('m-Y', strtotime($date));
        $dmydate = date('d-m-Y', strtotime($date));

        $data = [];
        foreach ($res as $key) :
            $det = [];
            for ($i = 0; $i < $ehdate; $i++) :
                $tglni = sprintf('%02d', ($i + 1)) . '-' . $blnthndate;
                $today = 0;
                if ($tglni == $dmydate) {
                    $today = 1;
                }
                $dt = [
                    'today' => $today,
                ];
                if (!empty($data_jam_kerja[$key->id_users][$tglni])) {
                    $rd = (object) $data_jam_kerja[$key->id_users][$tglni];
                    $rd->today = $today;
                    $dt = $rd;
                }
                $det[$i] = $dt;
            endfor;
            $key->dates = $det;
            $data[] = $key;
        endforeach;

        $res = [
            'data' => $data,
            'page' => $page,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
        ];

        $this->api->result('ok', $res, 'Data Presensi');
    }
}
