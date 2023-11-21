<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spk_report extends CI_Controller
{
    
    public $active = array('active_spk_report' => 'active');

    function __construct()
    {
        parent::__construct();
		$this->load->model('Tampilan_model');
        $this->load->model('Spk_report_model');
        $this->load->model('Daily_sales_report_model');
        $this->load->library('form_validation');        
		$this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        $data = array();
        $this->Tampilan_model->layar('spk_report/spk_report_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        echo $this->Spk_report_model->json_marketing($data_login['users_id']);
    }
    
    public function update($id) 
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        $row = $this->Spk_report_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('marketing/spk_report/update_action'),
                'id' => set_value('id', $row->id),
                'tgl' => set_value('tgl', $row->tgl),
                'tgl_spk' => set_value('tgl_spk', $row->tgl_spk),
                'no_spk' => set_value('no_spk', $row->no_spk),
                'nama_instansi' => set_value('nama_instansi', $row->nama_instansi),
                'alamat_instansi' => set_value('alamat_instansi', $row->alamat_instansi),
                'kelurahan_instansi' => set_value('kelurahan_instansi', $row->kelurahan_instansi),
                'kecamatan_instansi' => set_value('kecamatan_instansi', $row->kecamatan_instansi),
                'telp_instansi' => set_value('telp_instansi', $row->telp_instansi),
                'telp2_instansi' => set_value('telp2_instansi', $row->telp2_instansi),
                'atas_nama' => set_value('atas_nama', $row->atas_nama),
                'alamat_atas_nama' => set_value('alamat_atas_nama', $row->alamat_atas_nama),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'lokasi' => set_value('lokasi', $row->lokasi),
                'pembayaran' => set_value('pembayaran', $row->pembayaran),
                'diskon' => set_value('diskon', $row->diskon),
                'status' => set_value('status', $row->status),
                'prioritas' => set_value('prioritas', $row->prioritas),
                'id_marketing' => set_value('id_marketing', $row->id_marketing),
		    	'data_pil_status' => $this->db->get('pil_status')->result(),
			);
        	$this->Tampilan_model->layar('spk_report/spk_report_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('marketing/spk_report'));
        }
    }
    
    public function update_action() 
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
    			'tgl_spk' => $this->input->post('tgl_spk', true),
                'no_spk' => $this->input->post('no_spk', true),
                'nama_instansi' => $this->input->post('nama_instansi', true),
                'alamat_instansi' => $this->input->post('alamat_instansi', true),
                'kelurahan_instansi' => $this->input->post('kelurahan_instansi', true),
                'kecamatan_instansi' => $this->input->post('kecamatan_instansi', true),
                'telp_instansi' => $this->input->post('telp_instansi', true),
                'telp2_instansi' => $this->input->post('telp2_instansi', true),
                'atas_nama' => $this->input->post('atas_nama', true),
                'alamat_atas_nama' => $this->input->post('alamat_atas_nama', true),
                'keterangan' => $this->input->post('keterangan', true),
                'lokasi' => $this->input->post('lokasi', true),
                'pembayaran' => $this->input->post('pembayaran', true),
                'diskon' => $this->input->post('diskon', true),
                'status' => $this->input->post('status', true),
                'prioritas' => $this->input->post('prioritas', true)
		    );
            $this->Spk_report_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('marketing/spk_report'));
        }
    }

    public function lihat($id) 
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        $row = $this->Daily_sales_report_model->get_by_id($id);
        $row_spk = $this->db->select('*')
                            ->from('spk_report')
                            ->where('nama_instansi', $row->nama_instansi)
                            ->where('alamat_instansi', $row->alamat_instansi)
                            ->where('kelurahan_instansi', $row->kelurahan_instansi)
                            ->where('kecamatan_instansi', $row->kecamatan_instansi)
                            ->where('telp_instansi', $row->telp_instansi)
                            ->where('telp2_instansi', $row->telp2_instansi)
                            ->get()->row();
        if ($row_spk) {
            $data = array(
                'data' => $row_spk,
                'data_status' => $this->db->where('id', $row_spk->status)->get('pil_status')->row(),
            );
            $this->Tampilan_model->layar('spk_report/spk_report_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('marketing/spk_report'));
        }
    }

    public function insert($id) 
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        $row = $this->Daily_sales_report_model->get_by_id($id);
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('marketing/spk_report/insert_action'),
            'id' => set_value('id', $row->id),
            'tgl' => set_value('tgl', $row->tgl),
            'tgl_spk' => set_value('tgl_spk', date('d-m-Y')),
            'no_spk' => set_value('no_spk'),
            'nama_instansi' => set_value('nama_instansi', $row->nama_instansi),
            'alamat_instansi' => set_value('alamat_instansi', $row->alamat_instansi),
            'kelurahan_instansi' => set_value('kelurahan_instansi', $row->kelurahan_instansi),
            'kecamatan_instansi' => set_value('kecamatan_instansi', $row->kecamatan_instansi),
            'telp_instansi' => set_value('telp_instansi', $row->telp_instansi),
            'telp2_instansi' => set_value('telp2_instansi', $row->telp2_instansi),
            'atas_nama' => set_value('atas_nama', $row->atas_nama),
            'alamat_atas_nama' => set_value('alamat_atas_nama', $row->alamat_atas_nama),
            'keterangan' => set_value('keterangan', $row->keterangan),
            'lokasi' => set_value('lokasi', $row->lokasi),
            'pembayaran' => set_value('pembayaran'),
            'diskon' => set_value('diskon'),
            'status' => set_value('status', $row->status),
            'prioritas' => set_value('prioritas', $row->prioritas),
            'data_pil_status' => $this->db->get('pil_status')->result(),
        );
        $this->Tampilan_model->layar('spk_report/spk_report_form', $data, $this->active);
    }

    public function insert_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->insert($this->input->post('id', TRUE));
        } else {
            $data = array(
                'tgl' => date('d-m-Y'),
                'tgl_spk' => $this->input->post('tgl_spk'),
                'no_spk' => $this->input->post('no_spk'),
                'nama_instansi' => $this->input->post('nama_instansi'),
                'alamat_instansi' => $this->input->post('alamat_instansi'),
                'kelurahan_instansi' => $this->input->post('kelurahan_instansi'),
                'kecamatan_instansi' => $this->input->post('kecamatan_instansi'),
                'telp_instansi' => $this->input->post('telp_instansi'),
                'telp2_instansi' => $this->input->post('telp2_instansi'),
                'atas_nama' => $this->input->post('atas_nama'),
                'alamat_atas_nama' => $this->input->post('alamat_atas_nama'),
                'keterangan' => $this->input->post('keterangan'),
                'lokasi' => $this->input->post('lokasi'),
                'pembayaran' => $this->input->post('pembayaran'),
                'diskon' => $this->input->post('diskon'),
                'status' => $this->input->post('status'),
                'prioritas' => $this->input->post('prioritas'),
                'id_marketing' => $data_login['users_id']
            );
            $this->Spk_report_model->insert($data);
            $this->session->set_flashdata('message', 'Insert Record Success');
            redirect(site_url('marketing/spk_report'));
        }
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('tgl_spk', 'tgl spk', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_rules('tgl', 'tgl', 'trim');
        $this->form_validation->set_rules('tgl_spk', 'tgl_spk', 'trim|required');
        $this->form_validation->set_rules('no_spk', 'no_spk', 'trim|required');
        $this->form_validation->set_rules('nama_instansi', 'nama_instansi', 'trim|required');
        $this->form_validation->set_rules('alamat_instansi', 'alamat_instansi', 'trim');
        $this->form_validation->set_rules('kelurahan_instansi', 'kelurahan_instansi', 'trim');
        $this->form_validation->set_rules('kecamatan_instansi', 'kecamatan_instansi', 'trim');
        $this->form_validation->set_rules('telp_instansi', 'telp_instansi', 'trim');
        $this->form_validation->set_rules('telp2_instansi', 'telp2_instansi', 'trim');
        $this->form_validation->set_rules('atas_nama', 'atas_nama', 'trim');
        $this->form_validation->set_rules('alamat_atas_nama', 'alamat_atas_nama', 'trim');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_rules('lokasi', 'lokasi', 'trim');
        $this->form_validation->set_rules('pembayaran', 'pembayaran', 'trim|required');
        $this->form_validation->set_rules('diskon', 'diskon', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim');
        $this->form_validation->set_rules('prioritas', 'prioritas', 'trim');
        $this->form_validation->set_rules('id_marketing', 'id_marketing', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function report()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();

        $pil_tanggal = '1';
        $tanggal = date('d-m-Y');
        $tanggal_periode = date('d-m-Y').' - '.date('t-m-Y');
        $id_merk = '0';

        if (!empty($this->input->post('pil_tanggal', TRUE))) {
            $pil_tanggal = $this->input->post('pil_tanggal', TRUE);
        }
        if (!empty($this->input->post('id_merk', TRUE))) {
            $id_merk = $this->input->post('id_merk', TRUE);
        }

        if ($this->input->post('tanggal',  TRUE)) {
            $tanggal = $this->input->post('tanggal', TRUE);
        }
        if ($this->input->post('tanggal_periode',  TRUE)) {
            $tanggal_periode = $this->input->post('tanggal_periode', TRUE);
        }
        if ($pil_tanggal == '2') { // PERIODE
            $tgl = $tanggal_periode;
        } else if ($pil_tanggal == '1') { // TANGGAL
            $tgl = $tanggal;
        } else {
            $tgl = $tanggal;
        }

        $data = array(
            'pil_tanggal' => $pil_tanggal,
            'tanggal' => $tgl,
            'id_merk' => $id_merk,
            'data_pil_merk' => $this->db->get('pil_merk')->result(),
        );
        $active = array('active_spk_report_report' => 'active');
        $this->Tampilan_model->layar('spk_report/spk_report_report', $data, $active);
    }
    
    public function json_report($pil_tanggal = '', $tanggal = '', $id_merk = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->marketing();
        echo $this->Spk_report_model->json_marketing_report($pil_tanggal, $tanggal, $data_login['users_id_cabang'], $data_login['users_id'], $id_merk);
    }

}

/* End of file Spk_report.php */
/* Location: ./application/controllers/Spk_report.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-23 05:03:28 */
/* http://harviacode.com */