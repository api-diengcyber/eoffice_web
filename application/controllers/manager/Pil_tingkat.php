<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pil_tingkat extends CI_Controller
{

    public $active = array('active_master' => 'active_pil_tingkat');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Pil_tingkat_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->Tampilan_model->admin();
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array();
        $this->Tampilan_model->layar('pil_tingkat/pil_tingkat_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Pil_tingkat_model->json();
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_tingkat_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'tingkat' => $row->tingkat,
    		'ket' => $row->ket,
    	    );
            $this->Tampilan_model->layar('pil_tingkat/pil_tingkat_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_tingkat'));
        }
    }

    public function create() 
    {
        $this->load->model('Pil_jabatan_model');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/pil_tingkat/create_action'),
    	    'id' => set_value('id'),
    	    'tingkat' => set_value('tingkat'),
    	    'ket' => set_value('ket'),
            'jabatan'=> $this->Pil_jabatan_model->get_all(),
            'id_jabatan'=>'',
    	);
        $this->Tampilan_model->layar('pil_tingkat/pil_tingkat_form', $data, $this->active);
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
            'id_jabatan' => $this->input->post('id_jabatan'),
    		'tingkat' => $this->input->post('tingkat',TRUE),
    		'ket' => $this->input->post('ket',TRUE),
    	    );

            $this->Pil_tingkat_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/pil_tingkat'));
        }
    }
    
    public function update($id) 
    {
        $this->load->model('Pil_jabatan_model');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_tingkat_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/pil_tingkat/update_action'),
        		'id' => set_value('id', $row->id),
        		'tingkat' => set_value('tingkat', $row->tingkat),
        		'ket' => set_value('ket', $row->ket),
                'jabatan'=> $this->Pil_jabatan_model->get_all(),
                'id_jabatan' => set_value('id_jabatan',$row->id_jabatan),
        	    );
            $this->Tampilan_model->layar('pil_tingkat/pil_tingkat_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_tingkat'));
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
                'id_jabatan' => $this->input->post('id_jabatan'),
        		'tingkat' => $this->input->post('tingkat',TRUE),
        		'ket' => $this->input->post('ket',TRUE),
	    );

            $this->Pil_tingkat_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/pil_tingkat'));
        }
    }
    public function urutkan(){
        $data_login = $this->Tampilan_model->cek_login();
        $this->load->model('Pil_jabatan_model');
        $this->Tampilan_model->admin();

        $data['id'] = $this->input->post('id_jabatan');
        $data['jabatan'] = $this->Pil_jabatan_model->get_all();
        $data['level']   = $this->Pil_tingkat_model->get_by_jabatan($this->input->post('id_jabatan'));
        $this->Tampilan_model->layar('pil_tingkat/urutkan_pil_tingkat', $data, $this->active);
    }
    public function set_orders()
        {
            $this->load->model('Pil_tingkat_model');
            $sort = $this->input->post('item');
            if(!empty($sort)){
                $i = 0;
                $b = 1;
                $result = $this->Pil_tingkat_model->get_all();
                foreach ($result as $row) {
                   $id = $row->id;
                   $this->db->where('id', $sort[$i]);
                   $data = array('orders'=>$b);
                   $this->db->update('pil_tingkat', $data);
                   //echo $sort[$i];
                   $i++;
                   $b++;
                }
            }
        }
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_tingkat_model->get_by_id($id);

        if ($row) {
            $this->Pil_tingkat_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/pil_tingkat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_tingkat'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tingkat', 'tingkat', 'trim|required');
    	$this->form_validation->set_rules('ket', 'ket', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->helper('exportexcel');
        $namaFile = "pil_tingkat.xls";
        $judul = "pil_tingkat";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tingkat");
	xlsWriteLabel($tablehead, $kolomhead++, "Ket");

	foreach ($this->Pil_tingkat_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tingkat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ket);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pil_tingkat.doc");

        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $data = array(
            'pil_tingkat_data' => $this->Pil_tingkat_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pil_tingkat/pil_tingkat_doc',$data);
    }

}

/* End of file Pil_tingkat.php */
/* Location: ./application/controllers/Pil_tingkat.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-02 01:51:29 */
/* http://harviacode.com */