<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Materi extends CI_Controller
{
    public $active = array('active_utilities'=>'active_materi');
    function __construct()
    {
        parent::__construct();
        $this->load->model('Materi_model');
        $this->load->model('Tampilan_model');
        $this->load->model('Upload_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->Tampilan_model->admin();
    }

    public function index()
    {
        $this->Tampilan_model->layar('materi/materi_list','',$this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Materi_model->json();
    }

    public function read($id) 
    {
        $row = $this->Materi_model->get_by_id($id);
        if ($row) {
            $data = array(
        		'id' => $row->id,
        		'tgl' => $row->tgl,
        		'nama_materi' => $row->nama_materi,
        		'isi' => $row->isi,
        		'lampiran' => $row->lampiran,
	    );
            $this->Tampilan_model->layar('materi/materi_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/materi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/materi/create_action'),
    	    'id' => set_value('id'),
    	    'tgl' => set_value('tgl'),
    	    'nama_materi' => set_value('nama_materi'),
    	    'isi' => set_value('isi'),
    	    'lampiran' => set_value('lampiran'),
    	);
        $this->Tampilan_model->layar('materi/materi_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $lampiran = 'test';
            if(isset($_FILES['lampiran'])) {
                $lampiran = $this->Upload_model->files('assets/materi','',$_FILES['lampiran']);
            }
            $data = array(
        		'nama_materi' => $this->input->post('nama_materi',TRUE),
        		'isi' => $this->input->post('isi',TRUE),
        		'lampiran' => $lampiran,
    	    );

            $this->Materi_model->insert($data, $this->active);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/materi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Materi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/materi/update_action'),
        		'id' => set_value('id', $row->id),
        		'tgl' => set_value('tgl', $row->tgl),
        		'nama_materi' => set_value('nama_materi', $row->nama_materi),
        		'isi' => set_value('isi', $row->isi),
        		'lampiran' => set_value('lampiran', $row->lampiran),
    	    );
            $this->Tampilan_model->layar('materi/materi_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/materi'));
        }
    }
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $lampiran = $this->input->post('old');
            if(isset($_FILES['lampiran'])){
                @unlink('assets/materi/'.$lampiran);
                $lampiran = $this->Upload_model->files('assets/materi','',$_FILES['lampiran']);
            }
            $data = array(
        		'nama_materi' => $this->input->post('nama_materi',TRUE),
        		'isi' => $this->input->post('isi',TRUE),
        		'lampiran' => $lampiran,
    	    );

            $this->Materi_model->update($this->input->post('id', TRUE), $data, $this->active);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/materi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Materi_model->get_by_id($id);

        if ($row) {
            $this->Materi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/materi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/materi'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tgl', 'tgl', 'trim');
    	$this->form_validation->set_rules('nama_materi', 'nama materi', 'trim');
    	$this->form_validation->set_rules('isi', 'isi', 'trim');
    	$this->form_validation->set_rules('lampiran', 'lampiran', 'trim');

    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Materi.php */
/* Location: ./application/controllers/Materi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-12-20 09:57:39 */
/* http://harviacode.com */