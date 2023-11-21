<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Akun extends CI_Controller
{

    public $active = array('active_master' => 'active_akun');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Akun_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array();
        $this->Tampilan_model->layar('akun/akun_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Akun_model->json();
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Akun_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'kode' => $row->kode,
    		'akun' => $row->akun,
    	    );
            $this->Tampilan_model->layar('akun/akun_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/akun'));
        }
    }

    public function create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/akun/create_action'),
    	    'id' => set_value('id'),
    	    'kode' => set_value('kode'),
    	    'akun' => set_value('akun'),
    	);
        $this->Tampilan_model->layar('akun/akun_form', $data, $this->active);
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
    		'kode' => $this->input->post('kode',TRUE),
    		'akun' => $this->input->post('akun',TRUE),
    	    );

            $this->Akun_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/akun'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Akun_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/akun/update_action'),
        		'id' => set_value('id', $row->id),
        		'kode' => set_value('kode', $row->kode),
        		'akun' => set_value('akun', $row->akun),
        	    );
            $this->Tampilan_model->layar('akun/akun_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/akun'));
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
    		'kode' => $this->input->post('kode',TRUE),
    		'akun' => $this->input->post('akun',TRUE),
    	    );

            $this->Akun_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/akun'));
        }
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Akun_model->get_by_id($id);

        if ($row) {
            $this->Akun_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/akun'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/akun'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('kode', 'kode', 'trim|required');
    	$this->form_validation->set_rules('akun', 'akun', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->helper('exportexcel');
        $namaFile = "akun.xls";
        $judul = "akun";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Kode");
	xlsWriteLabel($tablehead, $kolomhead++, "Akun");

	foreach ($this->Akun_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->akun);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=akun.doc");

        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $data = array(
            'akun_data' => $this->Akun_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('akun/akun_doc',$data);
    }

}

/* End of file Akun.php */
/* Location: ./application/controllers/Akun.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-03 07:49:45 */
/* http://harviacode.com */