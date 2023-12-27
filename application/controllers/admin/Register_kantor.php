<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register_kantor extends CI_Controller
{

    public $active = array('active_utilities' => 'active_register_kantor');

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Tampilan_model');
        $this->load->model('Registrasi_kantor_model');
        $this->Tampilan_model->admin();
    }

    public function index()
    {
        $data = [];
        $this->Tampilan_model->layar('registrasi_kantor/registrasi_kantor_list', $data, $this->active);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Registrasi_kantor_model->json();
    }

    public function create()
    {
        $data = [
            'button' => 'Create',
            'action' => site_url('admin/register_kantor/create_action'),
            'id' => set_value('id'),
            'perusahaan' => set_value('perusahaan'),
            'alamat' => set_value('alamat'),
            'no_telp_perusahaan' => set_value('no_telp_perusahaan'),
            'bidang_bisnis' => set_value('bidang_bisnis'),
            'jml_karyawan' => set_value('jml_karyawan'),
            'nama_pemohon' => set_value('nama_pemohon'),
            'no_telp_pemohon' => set_value('no_telp_pemohon'),
            'jabatan_pemohon' => set_value('jabatan_pemohon'),
            'email' => set_value('email'),
        ];
        $this->Tampilan_model->layar('registrasi_kantor/registrasi_kantor_form', $data, $this->active);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = [
                'perusahaan' => $this->input->post('perusahaan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telp_perusahaan' => $this->input->post('no_telp_perusahaan', TRUE),
                'bidang_bisnis' => $this->input->post('bidang_bisnis', TRUE),
                'jml_karyawan' => $this->input->post('jml_karyawan', TRUE),
                'nama_pemohon' => $this->input->post('nama_pemohon', TRUE),
                'no_telp_pemohon' => $this->input->post('no_telp_pemohon', TRUE),
                'jabatan_pemohon' => $this->input->post('jabatan_pemohon', TRUE),
                'email' => $this->input->post('email', TRUE),
                'status' => 1,
            ];
            $this->Registrasi_kantor_model->insert($data);

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/register_kantor'));
        }
    }

    public function update($id)
    {
        $row = $this->Registrasi_kantor_model->get_by_id($id);
        if ($row) {
            $data = [
                'button' => 'Update',
                'action' => site_url('admin/register_kantor/update_action'),
                'id' => set_value('id', $row->id),
                'perusahaan' => set_value('perusahaan', $row->perusahaan),
                'alamat' => set_value('alamat', $row->alamat),
                'no_telp_perusahaan' => set_value('no_telp_perusahaan', $row->no_telp_perusahaan),
                'bidang_bisnis' => set_value('bidang_bisnis', $row->bidang_bisnis),
                'jml_karyawan' => set_value('jml_karyawan', $row->jml_karyawan),
                'nama_pemohon' => set_value('nama_pemohon', $row->nama_pemohon),
                'no_telp_pemohon' => set_value('no_telp_pemohon', $row->no_telp_pemohon),
                'jabatan_pemohon' => set_value('jabatan_pemohon', $row->jabatan_pemohon),
                'email' => set_value('email', $row->email),
            ];
            $this->Tampilan_model->layar('registrasi_kantor/registrasi_kantor_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/register_kantor'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $id = $this->input->post('id', TRUE);
            $data = [
                'perusahaan' => $this->input->post('perusahaan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telp_perusahaan' => $this->input->post('no_telp_perusahaan', TRUE),
                'bidang_bisnis' => $this->input->post('bidang_bisnis', TRUE),
                'jml_karyawan' => $this->input->post('jml_karyawan', TRUE),
                'nama_pemohon' => $this->input->post('nama_pemohon', TRUE),
                'no_telp_pemohon' => $this->input->post('no_telp_pemohon', TRUE),
                'jabatan_pemohon' => $this->input->post('jabatan_pemohon', TRUE),
                'email' => $this->input->post('email', TRUE),
            ];
            $data_lat_long = [
                'lat' => $this->input->post('lat', TRUE),
                'long' => $this->input->post('long', TRUE),
            ];

            $kantor = $this->Kantor_lokasi_model->get_by_id_kantor($id);
            // var_dump($kantor);

            $this->Registrasi_kantor_model->update($id, $data);
            $this->Kantor_lokasi_model->update($kantor->id_kantor, $data_lat_long);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/register_kantor'));
            // var_dump($data);
        }
    }

    public function delete($id)
    {
        $row = $this->Registrasi_kantor_model->get_by_id($id);
        if ($row) {
            $this->Registrasi_kantor_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/register_kantor'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/register_kantor'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('perusahaan', 'perusahaan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat kantor', 'trim|required');
        $this->form_validation->set_rules('no_telp_perusahaan', 'no telp kantor', 'trim|required');
        $this->form_validation->set_rules('bidang_bisnis', 'bidang bisnis', 'trim|required');
        $this->form_validation->set_rules('jml_karyawan', 'jumlah karyawan', 'trim|required');
        $this->form_validation->set_rules('nama_pemohon', 'nama pemohon', 'trim|required');
        $this->form_validation->set_rules('no_telp_pemohon', 'no telp pemohon', 'trim|required');
        $this->form_validation->set_rules('jabatan_pemohon', 'jabatan pemohon', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Kantor.php */
/* Location: ./application/controllers/Kantor.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-10-23 03:57:51 */
/* http://harviacode.com */
