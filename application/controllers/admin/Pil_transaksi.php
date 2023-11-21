<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pil_transaksi extends CI_Controller
{

    public $active = array('active_master' => 'active_pil_transaksi');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Pil_transaksi_model');
        $this->load->model('Akun_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array();
        $this->Tampilan_model->layar('pil_transaksi/pil_transaksi_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Pil_transaksi_model->json();
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'nm_transaksi' => $row->nm_transaksi,
    		'id_akun_debet' => $row->id_akun_debet,
    		'id_akun_kredit' => $row->id_akun_kredit,
    	    );
            $this->Tampilan_model->layar('pil_transaksi/pil_transaksi_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_transaksi'));
        }
    }

    public function create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/pil_transaksi/create_action'),
    	    'id' => set_value('id'),
    	    'nm_transaksi' => set_value('nm_transaksi'),
    	    'id_akun_debet' => set_value('id_akun_debet'),
    	    'id_akun_kredit' => set_value('id_akun_kredit'),
            'data_akun' => $this->Akun_model->get_all(),
    	);
        $this->Tampilan_model->layar('pil_transaksi/pil_transaksi_form', $data, $this->active);
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
    		'nm_transaksi' => $this->input->post('nm_transaksi',TRUE),
    		'id_akun_debet' => $this->input->post('id_akun_debet',TRUE),
    		'id_akun_kredit' => $this->input->post('id_akun_kredit',TRUE),
    	    );

            $this->Pil_transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/pil_transaksi'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/pil_transaksi/update_action'),
        		'id' => set_value('id', $row->id),
        		'nm_transaksi' => set_value('nm_transaksi', $row->nm_transaksi),
        		'id_akun_debet' => set_value('id_akun_debet', $row->id_akun_debet),
        		'id_akun_kredit' => set_value('id_akun_kredit', $row->id_akun_kredit),
                'data_akun' => $this->Akun_model->get_all(),
        	    );
            $this->Tampilan_model->layar('pil_transaksi/pil_transaksi_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_transaksi'));
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
    		'nm_transaksi' => $this->input->post('nm_transaksi',TRUE),
    		'id_akun_debet' => $this->input->post('id_akun_debet',TRUE),
    		'id_akun_kredit' => $this->input->post('id_akun_kredit',TRUE),
    	    );

            $this->Pil_transaksi_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/pil_transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pil_transaksi_model->get_by_id($id);

        if ($row) {
            $this->Pil_transaksi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/pil_transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pil_transaksi'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('nm_transaksi', 'nm transaksi', 'trim|required');
    	$this->form_validation->set_rules('id_akun_debet', 'id akun debet', 'trim|required');
    	$this->form_validation->set_rules('id_akun_kredit', 'id akun kredit', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pil_transaksi.php */
/* Location: ./application/controllers/Pil_transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-04 02:18:07 */
/* http://harviacode.com */