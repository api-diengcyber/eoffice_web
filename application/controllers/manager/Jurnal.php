<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jurnal extends CI_Controller
{

    public $active = array('active_utilities' => 'active_jurnal');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Jurnal_model');
        $this->load->model('Akun_model');
        $this->load->model('Pil_transaksi_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array();
        $this->Tampilan_model->layar('jurnal/jurnal_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Jurnal_model->json();
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Jurnal_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'tgl' => $row->tgl,
    		'id_akun' => $row->id_akun,
    		'keterangan' => $row->keterangan,
    		'debet' => $row->debet,
    		'kredit' => $row->kredit,
    	    );
            $this->Tampilan_model->layar('jurnal/jurnal_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/jurnal'));
        }
    }

    public function create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/jurnal/create_action'),
    	    'id' => set_value('id'),
    	    'tgl' => set_value('tgl', date('d-m-Y')),
            'id_transaksi' => set_value('id_transaksi'),
    	    'nominal' => set_value('nominal'),
    	    'keterangan' => set_value('keterangan'),
            'data_pil_transaksi' => $this->Pil_transaksi_model->get_all(),
    	);
        $this->Tampilan_model->layar('jurnal/jurnal_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            /* debet */
            $no = 0;
            $row_gb = $this->db->select('SUBSTRING(kode,2,10) AS no')
                               ->from('jurnal')
                               ->order_by('kode', 'DESC')
                               ->get()->row();
            if ($row_gb) {
                $no = $row_gb->no;
            }
            $no_jurnal = sprintf('%05d', $no+1);
            $kode = 'J'.$no_jurnal;

            $row_pil_transaksi = $this->Pil_transaksi_model->get_by_id($this->input->post('id_transaksi', TRUE));

            /* debet */
            $data = array(
            'kode' => $kode,
    		'tgl' => $this->input->post('tgl',TRUE),
            'id_transaksi' => $this->input->post('id_transaksi', TRUE),
    		'id_akun' => $row_pil_transaksi->id_akun_debet,
    		'keterangan' => $this->input->post('keterangan',TRUE),
    		'debet' => str_replace('.','',$this->input->post('nominal',TRUE)),
    	    );
            $this->Jurnal_model->insert($data);
            /* debet */
            /* kredit */
            $data = array(
            'kode' => $kode,
            'tgl' => $this->input->post('tgl',TRUE),
            'id_transaksi' => $this->input->post('id_transaksi', TRUE),
            'id_akun' => $row_pil_transaksi->id_akun_kredit,
            'keterangan' => $this->input->post('keterangan',TRUE),
            'kredit' => str_replace('.','',$this->input->post('nominal',TRUE)),
            );
            $this->Jurnal_model->insert($data);
            /* kredit */

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/jurnal'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Jurnal_model->get_by_id($id);
        if ($row) {
            $row_debet = $this->db->select('*')
                                  ->from('jurnal')
                                  ->where('kode', $row->kode)
                                  ->where('debet > 0')
                                  ->get()->row();
            $row_kredit = $this->db->select('*')
                                  ->from('jurnal')
                                  ->where('kode', $row->kode)
                                  ->where('kredit > 0')
                                  ->get()->row();
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/jurnal/update_action'),
        		'id' => set_value('id', $row->id),
        		'tgl' => set_value('tgl', $row->tgl),
                'id_transaksi' => set_value('id_transaksi', $row->id_transaksi),
                'nominal' => set_value('nominal', number_format($row->debet,0,',','.')),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'data_pil_transaksi' => $this->Pil_transaksi_model->get_all(),
            );
            $this->Tampilan_model->layar('jurnal/jurnal_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/jurnal'));
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

            $row = $this->Jurnal_model->get_by_id($this->input->post('id', TRUE));
            $row_pil_transaksi = $this->Pil_transaksi_model->get_by_id($this->input->post('id_transaksi', TRUE));

            $data = array(
            'tgl' => $this->input->post('tgl',TRUE),
            'id_akun' => $row_pil_transaksi->id_akun_debet,
            'id_transaksi' => $this->input->post('id_transaksi', TRUE),
            'keterangan' => $this->input->post('keterangan',TRUE),
            'debet' => str_replace('.','',$this->input->post('nominal',TRUE)),
            );
            $this->db->where('debet > 0');
            $this->db->where('kode', $row->kode);
            $this->db->update('jurnal', $data);
            /* debet */
            /* kredit */
            $data = array(
            'tgl' => $this->input->post('tgl',TRUE),
            'id_akun' => $row_pil_transaksi->id_akun_kredit,
            'id_transaksi' => $this->input->post('id_transaksi', TRUE),
            'keterangan' => $this->input->post('keterangan',TRUE),
            'kredit' => str_replace('.','',$this->input->post('nominal',TRUE)),
            );
            $this->db->where('kredit > 0');
            $this->db->where('kode', $row->kode);
            $this->db->update('jurnal', $data);

            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/jurnal'));
        }
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Jurnal_model->get_by_id($id);

        if ($row) {
            $this->db->where('kode', $row->kode);
            $this->db->delete('jurnal');
            $this->Jurnal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/jurnal'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/jurnal'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
        $this->form_validation->set_rules('id_transaksi', 'id_transaksi', 'trim|required');
    	$this->form_validation->set_rules('nominal', 'nominal', 'trim|required');
    	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->helper('exportexcel');
        $namaFile = "jurnal.xls";
        $judul = "jurnal";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Akun");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Debet");
	xlsWriteLabel($tablehead, $kolomhead++, "Kredit");

	foreach ($this->Jurnal_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl);
	    xlsWriteLabel($tablebody, $kolombody++, $data->id_akun);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->debet);
	    xlsWriteNumber($tablebody, $kolombody++, $data->kredit);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=jurnal.doc");

        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $data = array(
            'jurnal_data' => $this->Jurnal_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('jurnal/jurnal_doc',$data);
    }

}

/* End of file Jurnal.php */
/* Location: ./application/controllers/Jurnal.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-03 09:35:36 */
/* http://harviacode.com */