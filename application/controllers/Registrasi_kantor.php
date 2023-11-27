<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Registrasi_kantor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Registrasi_kantor_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data = [
            'no_nav' => true,
        ];
        $this->Tampilan_model->layar2('registrasi_kantor/registrasi_kantor_list', $data);
    }

    public function create_done()
    {
        $data = [
            'no_nav' => true,
        ];
        $this->Tampilan_model->layar2('registrasi_kantor/registrasi_kantor_done', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Registrasi_kantor_model->json();
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('registrasi_kantor/create_action'),
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
            'no_nav' => true,
        );
        $this->Tampilan_model->layar2('registrasi_kantor/registrasi_kantor_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'perusahaan' => $this->input->post('perusahaan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telp_perusahaan' => $this->input->post('no_telp_perusahaan', TRUE),
                'bidang_bisnis' => $this->input->post('bidang_bisnis', TRUE),
                'jml_karyawan' => $this->input->post('jml_karyawan', TRUE),
                'nama_pemohon' => $this->input->post('nama_pemohon', TRUE),
                'no_telp_pemohon' => $this->input->post('no_telp_pemohon', TRUE),
                'jabatan_pemohon' => $this->input->post('jabatan_pemohon', TRUE),
                'email' => $this->input->post('email', TRUE),
            );

            $this->Registrasi_kantor_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('registrasi_kantor/create_done'));
        }
    }

    public function update($id)
    {
        $row = $this->Registrasi_kantor_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('registrasi_kantor/update_action'),
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
                'no_nav' => true,
            );
            $this->Tampilan_model->layar2('registrasi_kantor/registrasi_kantor_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('registrasi_kantor'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'perusahaan' => $this->input->post('perusahaan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telp_perusahaan' => $this->input->post('no_telp_perusahaan', TRUE),
                'bidang_bisnis' => $this->input->post('bidang_bisnis', TRUE),
                'jml_karyawan' => $this->input->post('jml_karyawan', TRUE),
                'nama_pemohon' => $this->input->post('nama_pemohon', TRUE),
                'no_telp_pemohon' => $this->input->post('no_telp_pemohon', TRUE),
                'jabatan_pemohon' => $this->input->post('jabatan_pemohon', TRUE),
                'email' => $this->input->post('email', TRUE),
            );

            $this->Registrasi_kantor_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('registrasi_kantor'));
        }
    }

    public function delete($id)
    {
        $row = $this->Registrasi_kantor_model->get_by_id($id);

        if ($row) {
            $this->Registrasi_kantor_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('registrasi_kantor'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('registrasi_kantor'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('perusahaan', 'perusahaan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp_perusahaan', 'no telp perusahaan', 'trim|required');
        $this->form_validation->set_rules('bidang_bisnis', 'bidang bisnis', 'trim|required');
        $this->form_validation->set_rules('jml_karyawan', 'jml karyawan', 'trim|required');
        $this->form_validation->set_rules('nama_pemohon', 'nama pemohon', 'trim|required');
        $this->form_validation->set_rules('no_telp_pemohon', 'no telp pemohon', 'trim|required');
        $this->form_validation->set_rules('jabatan_pemohon', 'jabatan pemohon', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Registrasi_kantor.php */
/* Location: ./application/controllers/Registrasi_kantor.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-11-27 08:57:13 */
/* http://harviacode.com */
