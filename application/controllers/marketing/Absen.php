<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen extends CI_Controller {

	public $active = array('active_absen' => 'active');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tampilan_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->model('Laporan_model');
		$this->load->model('Tugas_model');
		$data_login = $this->Tampilan_model->cek_login();
		$this->Tampilan_model->marketing();
		/* 
		status == 0  = belum masuk
		status == 1  = sudah masuk
		status == 2  = pulang
		*/
		$status = '0'; 
		$row = $this->db->select('*')
						->from('jam_kerja')
						->where('id_users', $data_login['users_id'])
						->where('tgl', date('d-m-Y'))
						->order_by('id', 'DESC')
						->get()->row();
		if ($row) {
			if ($row->status == '1') {
				$status = '1';
			} else if ($row->status == '2') {
				$status = '2';
			}
		}
		if($row=='') {
			$jam_pulang = 0;
		}else{
			$jam_pulang = $row->jam_pulang;
		}
		$user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();
        $kantor = $this->db->select('*')
                ->from('kantor')
                ->where('id',$kantor_id->id_kantor)
                ->get()
                ->row();
				$nama_kantor = $kantor->nama_kantor;

			$dateNow=date('Y-m-d');
		$cekIjin =  $this->db->select('t.*,p.ket_tidak_masuk')
							->from('tidak_masuk AS t')
							->join('pil_tidak_masuk AS p','p.id=t.tidak_masuk')
							->where('id_users',$user_id)
							->where('tgl',$dateNow)
							->get()
							->row();
		$lokasi_kantor = $this->db->select('*')
							->from('kantor_lokasi')
							->where('id_kantor',$kantor_id->id_kantor)
							->get()
							->row();
		$lat= $lokasi_kantor->lat;
		$long= $lokasi_kantor->long;
							
		$data = array(
			
			'nama_kantor' => $nama_kantor,
			'lat' => $lat,
			'long' => $long,
			'cekIjin' => $cekIjin,
			'status' => $status,
			'jam_pulang' => $jam_pulang,
			'tahun' => date('Y'),
			'data_absen' => $this->db->select('*')
									->from('jam_kerja')
									->where('id_users', $data_login['users_id'])
									->where('SUBSTRING(tgl,4,7)', date('m-Y'))
									->order_by('id', 'DESC')
									->get()->result(),
			'data_rekap_bulan' => $this->db->select('b.bulan, COUNT(j.id) AS jml')
										   ->from('jam_kerja AS j')
										   ->join('bulan AS b', 'SUBSTRING(j.tgl,6,2) = b.id')
										   //->where('j.status', '2')
										   ->where('j.id_users', $data_login['users_id'])
										   ->where('RIGHT(j.tgl,4)', date('Y'))
										   ->group_by('SUBSTRING(j.tgl,4,2)')
										   ->order_by('SUBSTRING(j.tgl,4,2) ASC')
										   ->get()->result(),
			'data_rekap_tahun' => $this->db->select('t.tahun, COUNT(j.id) AS jml')
										   ->from('jam_kerja AS j')
										   ->join('(SELECT tahun FROM hari_kerja GROUP BY tahun) AS t', 'RIGHT(j.tgl,4) = t.tahun')
										   //->where('j.status', '2')
										   ->where('j.id_users', $data_login['users_id'])
										   ->group_by('RIGHT(j.tgl,4)')
										   ->order_by('RIGHT(j.tgl,4) DESC')
										   ->get()->result(),
			'data_tugas' => $this->Tugas_model->get_by_peg($data_login['users_id']),
			// 'gajian_pegawai' => $this->Laporan_model->get_gajian_pegawai(date('m-Y'))['id_pegawai'][$data_login['users_id']],
			'status_laporan' => $this->Tugas_model->get_laporan_today($data_login['users_id_pegawai']),
		);
		$this->Tampilan_model->layar('absen/absen_form', $data, $this->active);
	}
    public function add_keterangan(){
		$id = $this->input->post('id');
		$keterangan = $this->input->post('keterangan');
		$pulang = $this->input->post('pulang');
		
		$data['keterangan'] = $keterangan;
		if($pulang == 'on'){
		$data['status'] = 2;
		$data['jam_pulang'] = date('H:i:s');
		}
		$this->db->where('id', $id);
		$this->db->update('jam_kerja', $data);
		redirect(site_url('pegawai/absen'),'refresh');
    }

	public function absen_action()
	{
		$data_login = $this->Tampilan_model->cek_login();
		
		$this->Tampilan_model->marketing();
		$absen = $this->input->post('absen', TRUE);
		$status = $this->input->post('status', TRUE);
		if ($absen == '1') { // btn masuk
			$lokasi_masuk = $this->input->post('lokasi');
			$row = $this->db->select('*')
							->from('jam_kerja')
							->where('id_users', $data_login['users_id'])
							->where('tgl', date('d-m-Y'))
							->order_by('id', 'DESC')
							->get()->row();
			if ($row) {
            	$this->session->set_flashdata('message', 'Anda sudah masuk Hari ini!');
			} else {
				$data_masuk = array(
					'tgl' => date('d-m-Y'),
					'id_users' => $data_login['users_id'],
					'jam_masuk' => date('H:i:s'),
					'status' => "1",
					'lokasi_masuk' => $lokasi_masuk,
				);
				$this->db->insert('jam_kerja', $data_masuk);
			}
		} else if ($absen == '2') { // btn pulang
			$lokasi_pulang = $this->input->post('lokasi');
			$row = $this->db->select('*')
							->from('jam_kerja')
							->where('id_users', $data_login['users_id'])
							->where('tgl', date('d-m-Y'))
							//->where('status', '1')
							->order_by('id', 'DESC')
							->get()->row();
			if ($row) {
				$data_pulang = array(
					'tgl' => date('d-m-Y'),
					'jam_pulang' => date('H:i:s'),
					'status' => '2',
					'lokasi_pulang' => $lokasi_pulang,
				);
				$this->db->where('id', $row->id);
				$this->db->update('jam_kerja', $data_pulang);
			}
		}
		redirect(site_url('marketing/absen'));
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */