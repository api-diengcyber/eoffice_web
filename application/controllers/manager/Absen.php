<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absen extends CI_Controller
{

    public $active = array('active_utilities' => 'active_absen');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Absen_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->Tampilan_model->manager();
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();

        $id_users = 'semua';
        $bulan = date('m');
        $tahun = date('Y');
        if (!empty($this->input->post('id_users', TRUE))) {
            $id_users = $this->input->post('id_users', TRUE);
        }
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }

        $data = array(
            'id_users' => $id_users,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulan_tahun' => $bulan.'-'.$tahun,
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
        );
        $this->Tampilan_model->layar('absen/absen_list', $data, $this->active);
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

    public function absen($month=''){
		$this->load->model('Laporan_model');
		$this->load->model('Tugas_model');
		$data_login = $this->Tampilan_model->cek_login();
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
        
		$this->db->select('*')->from('jam_kerja')->where('id_users', $data_login['users_id']);
		if(!empty($month)){
		$this->db->where('SUBSTRING(tgl,4,7)', str_pad($month, 2, '0', STR_PAD_LEFT).'-'.date('Y'));
		}else{
		$this->db->where('SUBSTRING(tgl,4,7)', date('m-Y'));
		}
		$this->db->order_by('id', 'DESC');
		$data_absen = $this->db->get()->result();
		
		$data = array(
			'status' => $status,
			'tahun' => date('Y'),
			'data_absen' => $data_absen,
			'data_rekap_bulan' => $this->db->select('b.bulan, COUNT(j.id) AS jml , b.id as id_bulan')
										   ->from('jam_kerja AS j')
										   ->join('bulan AS b', 'SUBSTRING(j.tgl,4,2) = b.id')
										   //->where('j.status', '2')
										   ->where('j.id_users', $data_login['users_id'])
										   ->where('SUBSTRING(j.tgl,7,4)', date('Y'))
										   ->group_by('SUBSTRING(j.tgl,4,2)')
										   ->order_by('SUBSTRING(j.tgl,4,2) ASC')
										   ->get()->result(),
			'data_rekap_tahun' => $this->db->select('t.tahun, COUNT(j.id) AS jml')
										   ->from('jam_kerja AS j')
										   ->join('(SELECT tahun FROM hari_kerja GROUP BY tahun) AS t', 'SUBSTRING(j.tgl,7,4) = t.tahun')
										   //->where('j.status', '2')
										   ->where('j.id_users', $data_login['users_id'])
										   ->group_by('SUBSTRING(j.tgl,7,4)')
										   ->order_by('SUBSTRING(j.tgl,7,4) DESC')
										   ->get()->result(),
			'data_tugas' => $this->Tugas_model->get_by_peg($data_login['users_id_pegawai']),
			'status_laporan' => $this->Tugas_model->get_laporan_today($data_login['users_id_pegawai']),
		);
		$this->Tampilan_model->layar('absen/absen_form', $data, $this->active);
    }
    
    public function json($id_users = '', $bulan = '', $tahun = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        echo $this->Absen_model->json($id_users, $bulan, $tahun);
    }

    public function update($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Absen_model->get_by_id($id);
        if ($row) {
            $row_pegawai = $this->db->where('id_users', $row->id_users)->get('pegawai')->row();
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/absen/update_action'),
                'id' => set_value('id', $row->id),
                'tgl' => set_value('tgl', $row->tgl),
                'nama_pegawai' => set_value('nama_pegawai', $row_pegawai->nama_pegawai),
                'jam_masuk' => set_value('jam_masuk', $row->jam_masuk),
                'jam_pulang' => set_value('jam_pulang', $row->jam_pulang),
                'status' => set_value('status', $row->status),
            );
            $this->Tampilan_model->layar('absen/absen_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/absen'));
        }
    }

    public function update_action()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'tgl' => $this->input->post('tgl', TRUE),
                'jam_masuk' => $this->input->post('jam_masuk', TRUE),
                'jam_pulang' => $this->input->post('jam_pulang', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            $this->Absen_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/absen'));
        }
    }
    public function absen_action()
	{
		$data_login = $this->Tampilan_model->cek_login();
		$absen = $this->input->post('absen', TRUE);
		$status = $this->input->post('status', TRUE);
		if ($absen == '1') { // btn masuk
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
				);
				$this->db->insert('jam_kerja', $data_masuk);
			}
		} else if ($absen == '2') { // btn pulang
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
				);
				$this->db->where('id', $row->id);
				$this->db->update('jam_kerja', $data_pulang);
			}
		}
		redirect(site_url('manager/absen'));
	}
    public function cetak()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $active = array('active_report' => 'active_cetak_gaji');
        $data = array(
            'action' => site_url('admin/absen/cetak_action'),
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result()
        );
        $this->Tampilan_model->layar('absen/absen_cetak', $data, $active);
    }

    public function cetak_action()
    {
        $id_pegawai = $this->input->post('id_pegawai', true);
        $tahun = $this->input->post('tahun', true);
        $bulan = $this->input->post('bulan', true);
        $this->db->select('g.*, p.nama_pegawai, p.level, p.tingkat');
        $this->db->from('gaji_perbulan g');
        $this->db->join('pegawai p', 'p.id = g.id_pegawai');
        $this->db->where('g.id_bulan', sprintf('%02d', $bulan).'-'.$tahun);
        if (!empty($id_pegawai) && $id_pegawai!='semua') {
            $this->db->where('p.id', $id_pegawai);
        }
        $res_gaji = $this->db->get()->result();
        $data = array(
            'data_gaji' => $res_gaji
        );
        $this->load->view('admin/absen/cetak_absen', $data, FALSE);
    }

    public function delete($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Absen_model->get_by_id($id);
        if ($row) {
            $this->Absen_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/absen'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/absen'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
        $this->form_validation->set_rules('jam_masuk', 'jam_masuk', 'trim|required');
        $this->form_validation->set_rules('jam_pulang', 'jam_pulang', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function test($bulan_tahun){
         $this->load->model('Absen_model');
         $test = $this->Absen_model->get_by_month($bulan_tahun);
         echo "<pre>";
         print_r($test);
         echo '</pre>';
    }
    public function excel($bulan_tahun = '')
    {
        $this->load->model('Absen_model');
        $this->load->helper('exportexcel');
        $namaFile = "absen_pegawai_".$bulan_tahun.".xls";
        $judul = "absen_pegawai_".$bulan_tahun;
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Pegawai");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
        xlsWriteLabel($tablehead, $kolomhead++, "Jam Masuk");
        xlsWriteLabel($tablehead, $kolomhead++, "Jam Pulang");
        xlsWriteLabel($tablehead, $kolomhead++, "Total Jam");
        xlsWriteLabel($tablehead, $kolomhead++, "Lembur");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");

        foreach ($this->Absen_model->get_by_month($bulan_tahun) as $data) {
            $kolombody = 0;
            $status = '';
            if($data->status == 1){
                $status = 'MASUK';
            }else{
                $status = 'PULANG';
            }
            $start = new \DateTime($data->tgl.' '.$data->jam_masuk);
            $end   = new \DateTime($data->tgl.' '.$data->jam_pulang);

            $interval  = $end->diff($start);
            $jam_masuk =  $interval->format('%h,%i Jam');

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pegawai);
            xlsWriteLabel($tablebody, $kolombody++, $data->tgl);
            xlsWriteLabel($tablebody, $kolombody++, $data->jam_masuk);
            xlsWriteLabel($tablebody, $kolombody++, $data->jam_pulang);
            xlsWriteLabel($tablebody, $kolombody++, $jam_masuk);
            xlsWriteLabel($tablebody, $kolombody++, $data->lembur);
            xlsWriteLabel($tablebody, $kolombody++, $status);

        $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Hari_kerja.php */
/* Location: ./application/controllers/Hari_kerja.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-30 05:50:21 */
/* http://harviacode.com */