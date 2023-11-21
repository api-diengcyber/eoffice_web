<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presensi extends CI_Controller {

    public $active = array('active_utilities' => 'active_presensi');

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
	}

	public function index()
	{
		$user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();


        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        if (!empty($this->input->post('proses', TRUE)) && $this->input->post('proses', TRUE) == '1') {
        	$this->_proses_action();
        } else {
	        $tahun = date('Y');
	        $bulan = date('m');
	        if (!empty($this->input->post('tahun', TRUE))) {
	        	$tahun = $this->input->post('tahun', TRUE);
	        }
	        if (!empty($this->input->post('bulan', TRUE))) {
	        	$bulan = $this->input->post('bulan', TRUE);
	        }

	        $data = array(
				'data_bulan_ini' => $this->db->where('id', $bulan)->get('bulan')->row(),
				'hari' => date('d'),
				'bulan' => $bulan,
				'tahun' => $tahun,
				'batas_hari_bulan' => date('t'),
				'data_pegawai_kerja' => $this->db->select('j.*, RIGHT(j.tgl,2) AS hari, p.nama_pegawai')
												 ->from('jam_kerja AS j')
												 ->join('pegawai AS p', 'j.id_users = p.id_users')
												 ->join('users as u','u.id=j.id_users')
												 ->where('u.id_kantor',$kantor_id->id_kantor)
												 ->where('RIGHT(j.tgl,4) = "'.$tahun.'"')
												 ->where('SUBSTRING(j.tgl,4,2) = "'.sprintf('%02d', $bulan).'"')
												 ->group_by('u.id')
												 ->order_by('p.nama_pegawai', 'ASC')
												 ->get()->result(),
	            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
	            'data_bulan' => $this->db->get('bulan')->result(),
			);
	        $this->Tampilan_model->layar('presensi/presensi_list', $data, $this->active);
			// var_dump($data);
        }

	}

	public function _proses_action()
	{

		

	    $tahun = $this->input->post('tahun', TRUE);
	    $bulan = $this->input->post('bulan', TRUE);
	    $id_bulan = sprintf('%02d', $bulan).'-'.$tahun;
	    $row_hk = $this->db->select('*')
	    				   ->from('hari_kerja')
	    				   ->where('tahun', $tahun)
	    				   ->where('bulan', $bulan)
	    				   ->get()->row();
	    $res_pegawai = $this->db->where('level!=0')->get('pegawai')->result();
	    foreach ($res_pegawai as $key) {
	    	$res_jam_kerja = $this->db->select('*')
	    							  ->from('jam_kerja')
	    							  ->where('id_users', $key->id_users)
	    							  ->where('SUBSTRING(tgl,6,2) = "'.sprintf('%02d', $bulan).'"')
	    							  ->where('SUBSTRING(tgl,1,4) = "'.$tahun.'"')
	    							  ->get()->result();
	    	$masuk = count($res_jam_kerja);

	    	$row_gaji = $this->db->select('g.*')
	    						 ->from('gaji_perbulan AS g')
	    						 ->where('id_bulan', $id_bulan)
	    						 ->where('id_pegawai', $key->id)
	    						 ->get()->row();
	    	$data = array(
	    		'id_bulan' => $id_bulan,
	    		'id_pegawai' => $key->id,
	    		'rek' => $key->rekening,
	    		'gaji_pokok' => $key->gaji_pokok,
	    		'hk' => $row_hk->jam_kerja,
	    		'masuk' => $masuk,
				// 'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
	    	);
	    	if ($row_gaji) {
	    		// update //
	    		$this->db->where('id', $row_gaji->id);
	    		$this->db->update('gaji_perbulan', $data);
	    	} else {
	    		// insert //
	    		$this->db->insert('gaji_perbulan', $data);
	    	}
	    }

        $this->session->set_flashdata('message', 'Proses Success');
        redirect(site_url('admin/laporan'));
	}

}

/* End of file Presensi.php */
/* Location: ./application/controllers/Presensi.php */