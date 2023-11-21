<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pil_level extends CI_Controller
{

    public $active = array('active_master' => 'active_pil_level');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Pil_level_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array();
        $this->Tampilan_model->layar('pil_level/pil_level_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Pil_level_model->json();
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_level_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'level' => $row->level,
    	    );
            $this->Tampilan_model->layar('pil_level/pil_level_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_level'));
        }
    }

    public function create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/pil_level/create_action'),
    	    'id' => set_value('id'),
    	    'level' => set_value('level'),
    	);
        $this->Tampilan_model->layar('pil_level/pil_level_form', $data, $this->active);
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
    		'level' => $this->input->post('level',TRUE),
    	    );

            $this->Pil_level_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/pil_level'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_level_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/pil_level/update_action'),
        		'id' => set_value('id', $row->id),
        		'level' => set_value('level', $row->level),
        	    );
            $this->Tampilan_model->layar('pil_level/pil_level_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_level'));
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
    		'level' => $this->input->post('level',TRUE),
    	    );

            $this->Pil_level_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/pil_level'));
        }
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_level_model->get_by_id($id);

        if ($row) {
            $this->Pil_level_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/pil_level'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_level'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('level', 'level', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->helper('exportexcel');
        $namaFile = "pil_level.xls";
        $judul = "pil_level";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Level");

	foreach ($this->Pil_level_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->level);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pil_level.doc");

        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        
        $data = array(
            'pil_level_data' => $this->Pil_level_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pil_level/pil_level_doc',$data);
    }

}

/* End of file Pil_level.php */
/* Location: ./application/controllers/Pil_level.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-03 05:59:01 */
/* http://harviacode.com */