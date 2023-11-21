<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daily_sales_report extends CI_Controller
{

    public $active = array('active_report' => 'active_daily_sales_report');

    function __construct()
    {
        parent::__construct();
		$this->load->model('Tampilan_model');
        $this->load->model('Daily_sales_report_model');
        $this->load->library('form_validation');        
		$this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $pil_tanggal = '1';
        $tanggal = date('d-m-Y');
        $tanggal_periode = date('d-m-Y').' - '.date('t-m-Y');
        $id_marketing = "0";
        if ($this->input->post('pil_tanggal', TRUE) != null) {
            $pil_tanggal = $this->input->post('pil_tanggal', TRUE);
            $this->session->set_userdata(array('pil_tanggal' => $pil_tanggal));
        }
        if (!empty($this->session->userdata('pil_tanggal'))) {
            $pil_tanggal = $this->session->userdata('pil_tanggal');
        }
        if ($this->input->post('tanggal',  TRUE) != null) {
            $tanggal = $this->input->post('tanggal',  TRUE);
            $this->session->set_userdata(array('tanggal' => $tanggal));
        }
        if (!empty($this->session->userdata('tanggal'))) {
            $tanggal = $this->session->userdata('tanggal');
        }
        if ($this->input->post('tanggal_periode',  TRUE) != null) {
            $tanggal_periode = $this->input->post('tanggal_periode',  TRUE);
            $this->session->set_userdata(array('tanggal_periode' => $tanggal_periode));
        }
        if (!empty($this->session->userdata('tanggal_periode'))) {
            $tanggal_periode = $this->session->userdata('tanggal_periode');
        }
        if ($pil_tanggal == '2') { // PERIODE
            $tgl = $tanggal_periode;
        } else if ($pil_tanggal == '1') { // TANGGAL
            $tgl = $tanggal;
        } else {
            $tgl = $tanggal;
        }
        if ($this->input->post('id_marketing',  TRUE) != null) {
            $id_marketing = $this->input->post('id_marketing',  TRUE);
            $this->session->set_userdata(array('id_marketing' => $id_marketing));
        }
        if (!empty($this->session->userdata('id_marketing'))) {
            $id_marketing = $this->session->userdata('id_marketing');
        }
        $data = array(
            'pil_tanggal' => $pil_tanggal,
            'tanggal' => $tgl,
            'id_marketing' => $id_marketing,
            'data_marketing' => $this->db->select('u.*, p.*')
                                         ->from('pegawai p')
                                         ->join('users u', 'p.id_users = u.id')
                                         ->where('u.active', '1')
                                         ->where('p.level', '2')
                                         ->order_by('p.nama_pegawai', 'asc')
                                         ->get()->result(),
        );
        $this->Tampilan_model->layar('daily_sales_report/daily_sales_report_list', $data, $this->active);
    } 
    
    public function json($pil_tanggal = '', $tanggal = '', $id_marketing = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Daily_sales_report_model->json_admin($pil_tanggal, $tanggal, $id_marketing);
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Daily_sales_report_model->get_by_id($id);
        if ($row) {
            $data = array(
                'res' => $this->db->select('d.*, s.status AS nm_status')
                                  ->from('daily_sales_report AS d')
                                  ->join('pil_status AS s', 'd.status = s.id')
                                  ->where('d.nama_instansi', $row->nama_instansi)
                                  ->where('d.alamat_instansi', $row->alamat_instansi)
                                  ->where('d.kelurahan_instansi', $row->kelurahan_instansi)
                                  ->where('d.kecamatan_instansi', $row->kecamatan_instansi)
                                  ->where('d.telp_instansi', $row->telp_instansi)
                                  ->where('d.telp2_instansi', $row->telp2_instansi)
                                  ->where('d.id_marketing', $row->id_marketing)
                                  ->order_by('d.id', 'DESC')
                                  ->get()->result(),
		    );
        	$this->Tampilan_model->layar('daily_sales_report/daily_sales_report_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/daily_sales_report'));
        }
    }
    
    public function update($id) 
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Daily_sales_report_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/daily_sales_report/update_action'),
                'id' => set_value('id', $row->id),
                'tgl' => set_value('tgl', $row->tgl),
                'tgl_kunjungan' => set_value('tgl_kunjungan', $row->tgl_kunjungan),
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
                'status' => set_value('status', $row->status),
                'prioritas' => set_value('prioritas', $row->prioritas),
                'id_marketing' => set_value('id_marketing', $row->id_marketing),
                'data_pil_status' => $this->db->get('pil_status')->result(),
            );
            $this->Tampilan_model->layar('daily_sales_report/daily_sales_report_form_update', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/daily_sales_report'));
        }
    }
    
    public function update_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $row = $this->Daily_sales_report_model->get_by_id($this->input->post('id', TRUE));
            if ($row) {
                $data_update_alamat = array(
                    'nama_instansi' => $this->input->post('nama_instansi', true),
                    'lokasi' => $this->input->post('lokasi', true),
                    'alamat_instansi' => $this->input->post('alamat_instansi', true),
                    'kelurahan_instansi' => $this->input->post('kelurahan_instansi', true),
                    'kecamatan_instansi' => $this->input->post('kecamatan_instansi', true),
                    'telp_instansi' => $this->input->post('telp_instansi', true),
                    'telp2_instansi' => $this->input->post('telp2_instansi', true),
                );
                $this->db->where('nama_instansi', $row->nama_instansi);
                $this->db->where('lokasi', $row->lokasi);
                $this->db->where('alamat_instansi', $row->alamat_instansi);
                $this->db->where('kelurahan_instansi', $row->kelurahan_instansi);
                $this->db->where('kecamatan_instansi', $row->kecamatan_instansi);
                $this->db->where('telp_instansi', $row->telp_instansi);
                $this->db->where('telp2_instansi', $row->telp2_instansi);
                $this->db->update('daily_sales_report', $data_update_alamat);
                $data = array(
                    'tgl_kunjungan' => $this->input->post('tgl_kunjungan', true),
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
                    'status' => $this->input->post('status', true),
                    'prioritas' => $this->input->post('prioritas', true),
                    'id_marketing' => $data_login['users_id'],
                );
                $this->Daily_sales_report_model->update($this->input->post('id', TRUE), $data);
                $this->session->set_flashdata('message', 'Update Record Success');
            } else {
                $this->session->set_flashdata('message', 'Update Record Failed');
            }
            redirect(site_url('admin/daily_sales_report'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('tgl_kunjungan', 'tgl_kunjungan', 'trim|required');
        $this->form_validation->set_rules('tgl', 'tgl', 'trim');
        $this->form_validation->set_rules('tgl_kunjungan', 'tgl_kunjungan', 'trim|required');
        $this->form_validation->set_rules('nama_instansi', 'nama_instansi', 'trim|required');
        $this->form_validation->set_rules('alamat_instansi', 'alamat_instansi', 'trim|required');
        $this->form_validation->set_rules('kelurahan_instansi', 'kelurahan_instansi', 'trim|required');
        $this->form_validation->set_rules('kecamatan_instansi', 'kecamatan_instansi', 'trim|required');
        $this->form_validation->set_rules('telp_instansi', 'telp_instansi', 'trim|required');
        $this->form_validation->set_rules('telp2_instansi', 'telp2_instansi', 'trim');
        $this->form_validation->set_rules('atas_nama', 'atas_nama', 'trim');
        $this->form_validation->set_rules('alamat_atas_nama', 'alamat_atas_nama', 'trim');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_rules('lokasi', 'lokasi', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('prioritas', 'prioritas', 'trim|required');
        $this->form_validation->set_rules('id_marketing', 'id_marketing', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Daily_sales_report_model->get_by_id($id);
        if ($row) {
            $this->db->where('id_marketing', $row->id_marketing);
            $this->db->where('nama_instansi', $row->nama_instansi);
            $this->db->where('alamat_instansi', $row->alamat_instansi);
            $this->db->where('kelurahan_instansi', $row->kelurahan_instansi);
            $this->db->where('kecamatan_instansi', $row->kecamatan_instansi);
            $this->db->where('telp_instansi', $row->telp_instansi);
            $this->db->where('telp2_instansi', $row->telp2_instansi);
            $this->db->delete('daily_sales_report');
            $this->Daily_sales_report_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/daily_sales_report'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/daily_sales_report'));
        }
    }

}

/* End of file Daily_sales_report.php */
/* Location: ./application/controllers/Daily_sales_report.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-23 05:03:03 */
/* http://harviacode.com */