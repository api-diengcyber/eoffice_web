<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hari_kerja extends CI_Controller
{

    public $active = array('active_master' => 'active_hari_kerja');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Hari_kerja_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        if ($this->input->get('lihat', TRUE) == 'semua') {
            $tahun = '';
            $bulan = '';
        } else {
            $tahun = date('Y');
            $bulan = date('m');
        }

        $data = array(
            'tahun' => $tahun,
            'bulan' => $bulan,
        );
        $this->Tampilan_model->layar('hari_kerja/hari_kerja_list', $data, $this->active);
    } 
    
    public function json($tahun = '', $bulan = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Hari_kerja_model->json($tahun, $bulan);
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Hari_kerja_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'tahun' => $row->tahun,
    		'bulan' => $row->bulan,
    		'hari_kerja' => $row->hari_kerja,
    		'hari_masuk' => $row->hari_masuk,
    	    );
            $this->Tampilan_model->layar('hari_kerja/hari_kerja_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/hari_kerja'));
        }
    }

    public function create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/hari_kerja/create_action'),
    	    'id' => set_value('id'),
    	    'tahun' => set_value('tahun'),
    	    'bulan' => set_value('bulan'),
    	    'hari_kerja' => set_value('hari_kerja'),
    	    'hari_masuk' => set_value('hari_masuk'),
            'data_bulan' => $this->db->get('bulan')->result(),
    	);
        $this->Tampilan_model->layar('hari_kerja/hari_kerja_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
    		'tahun' => $this->input->post('tahun',TRUE),
    		'bulan' => $this->input->post('bulan',TRUE),
    		'hari_kerja' => $this->input->post('hari_kerja',TRUE),
    		'hari_masuk' => $this->input->post('hari_masuk',TRUE),
    	    );

            $this->Hari_kerja_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/hari_kerja'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Hari_kerja_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/hari_kerja/update_action'),
        		'id' => set_value('id', $row->id),
        		'tahun' => set_value('tahun', $row->tahun),
        		'bulan' => set_value('bulan', $row->bulan),
        		'hari_kerja' => set_value('hari_kerja', $row->hari_kerja),
        		'hari_masuk' => set_value('hari_masuk', $row->hari_masuk),
                'data_bulan' => $this->db->get('bulan')->result(),
        	    );
            $this->Tampilan_model->layar('hari_kerja/hari_kerja_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/hari_kerja'));
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
            $data = array(
    		'tahun' => $this->input->post('tahun',TRUE),
    		'bulan' => $this->input->post('bulan',TRUE),
    		'hari_kerja' => $this->input->post('hari_kerja',TRUE),
    		'hari_masuk' => $this->input->post('hari_masuk',TRUE),
    	    );

            $this->Hari_kerja_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/hari_kerja'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Hari_kerja_model->get_by_id($id);

        if ($row) {
            $this->Hari_kerja_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/hari_kerja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/hari_kerja'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tahun', 'tahun', 'trim|required');
    	$this->form_validation->set_rules('bulan', 'bulan', 'trim|required');
    	$this->form_validation->set_rules('hari_kerja', 'hari kerja', 'trim|required');
    	$this->form_validation->set_rules('hari_masuk', 'hari masuk', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->helper('exportexcel');
        $namaFile = "hari_kerja.xls";
        $judul = "hari_kerja";
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
    	xlsWriteLabel($tablehead, $kolomhead++, "Tahun");
    	xlsWriteLabel($tablehead, $kolomhead++, "Bulan");
    	xlsWriteLabel($tablehead, $kolomhead++, "Hari Kerja");
    	xlsWriteLabel($tablehead, $kolomhead++, "Hari Masuk");

	foreach ($this->Hari_kerja_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->tahun);
	    xlsWriteNumber($tablebody, $kolombody++, $data->bulan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->hari_kerja);
	    xlsWriteNumber($tablebody, $kolombody++, $data->hari_masuk);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=hari_kerja.doc");

        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $data = array(
            'hari_kerja_data' => $this->Hari_kerja_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('hari_kerja/hari_kerja_doc',$data);
    }

}

/* End of file Hari_kerja.php */
/* Location: ./application/controllers/Hari_kerja.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-30 05:50:21 */
/* http://harviacode.com */