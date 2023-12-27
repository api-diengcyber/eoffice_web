<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kantor extends CI_Controller
{

    public $active = array('active_utilities' => 'active_kantor');

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Tampilan_model');
        $this->load->model('Kantor_model');
        $this->load->model('Kantor_lokasi_model');
        $this->load->model('Registrasi_kantor_model');
        $this->Tampilan_model->admin();
    }

    public function index()
    {
        $data = [];
        $this->Tampilan_model->layar('kantor/kantor_list', $data, $this->active);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kantor_model->json();
    }

    public function read($id)
    {
        $row = $this->Kantor_model->get_by_id($id);
        if ($row) {
            $data = [
                'id' => $row->id,
                'kode' => $row->kode,
                'nama_kantor' => $row->kantor,
                'kode_wkatsapp' => $row->kode_wkatsapp,
                'lat' => set_value('nama_kantor', $row->lat),
                'long' => set_value('nama_kantor', $row->long),
            ];
            $this->load->view('kantor/kantor_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/kantor'));
        }
    }

    public function create($id_registrasi_kantor = NULL)
    {
        $row_reg_kantor = NULL;
        if (!empty($id_registrasi_kantor)) {
            $row_reg_kantor = $this->Registrasi_kantor_model->get_by_id($id_registrasi_kantor);
        }
        $data = [
            'button' => 'Create',
            'action' => site_url('admin/kantor/create_action'),
            'id' => set_value('id'),
            'id_registrasi_kantor' => set_value('id_registrasi_kantor', $id_registrasi_kantor),
            'kode' => set_value('kode'),
            'nama_kantor' => set_value('nama_kantor', !empty($row_reg_kantor) ? $row_reg_kantor->perusahaan : ""),
            'alamat_kantor' => set_value('alamat_kantor', !empty($row_reg_kantor) ? $row_reg_kantor->alamat : ""),
            'no_telp_kantor' => set_value('no_telp_kantor', !empty($row_reg_kantor) ? $row_reg_kantor->no_telp_perusahaan : ""),
            'bidang_bisnis' => set_value('bidang_bisnis', !empty($row_reg_kantor) ? $row_reg_kantor->bidang_bisnis : ""),
            'jumlah_karyawan' => set_value('jumlah_karyawan', !empty($row_reg_kantor) ? $row_reg_kantor->jml_karyawan : ""),
            'nama_pemohon' => set_value('nama_pemohon', !empty($row_reg_kantor) ? $row_reg_kantor->nama_pemohon : ""),
            'no_telp_pemohon' => set_value('no_telp_pemohon', !empty($row_reg_kantor) ? $row_reg_kantor->no_telp_pemohon : ""),
            'jabatan_pemohon' => set_value('jabatan_pemohon', !empty($row_reg_kantor) ? $row_reg_kantor->jabatan_pemohon : ""),
            'email' => set_value('email', !empty($row_reg_kantor) ? $row_reg_kantor->email : ""),
            'kode_whatsapp' => set_value('kode_whatsapp'),
        ];
        $this->Tampilan_model->layar('kantor/kantor_form', $data, $this->active);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $id_registrasi_kantor = $this->input->post('id_registrasi_kantor');

            $data = [
                'kode' => $this->input->post('kode', TRUE),
                'nama_kantor' => $this->input->post('nama_kantor', TRUE),
                'alamat_kantor' => $this->input->post('alamat_kantor', TRUE),
                'no_telp_kantor' => $this->input->post('no_telp_kantor', TRUE),
                'bidang_bisnis' => $this->input->post('bidang_bisnis', TRUE),
                'jumlah_karyawan' => $this->input->post('jumlah_karyawan', TRUE),
                'nama_pemohon' => $this->input->post('nama_pemohon', TRUE),
                'no_telp_pemohon' => $this->input->post('no_telp_pemohon', TRUE),
                'jabatan_pemohon' => $this->input->post('jabatan_pemohon', TRUE),
                'email' => $this->input->post('email', TRUE),
                'kode_whatsapp' => $this->input->post('kode_whatsapp', TRUE),
            ];
            $this->Kantor_model->insert($data);
            $id = $this->db->insert_id();

            $data_lat_long = [
                'id_kantor' => $id,
                'lat' => $this->input->post('lat', TRUE),
                'long' => $this->input->post('long', TRUE),
            ];
            $this->Kantor_lokasi_model->insert($data_lat_long);

            if (!empty($id_registrasi_kantor)) {
                $this->Registrasi_kantor_model->update($id, [
                    'status' => 2,
                ]);
            }

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/kantor'));
        }
    }

    public function update($id)
    {
        $row = $this->Kantor_model->get_by_id($id);
        if ($row) {
            $data = [
                'button' => 'Update',
                'action' => site_url('admin/kantor/update_action'),
                'id' => set_value('id', $row->id),
                'kode' => set_value('kode', $row->kode),
                'nama_kantor' => set_value('nama_kantor', $row->nama_kantor),
                'alamat_kantor' => set_value('alamat_kantor', $row->alamat_kantor),
                'no_telp_kantor' => set_value('no_telp_kantor', $row->no_telp_kantor),
                'bidang_bisnis' => set_value('bidang_bisnis', $row->bidang_bisnis),
                'jumlah_karyawan' => set_value('jumlah_karyawan', $row->jumlah_karyawan),
                'nama_pemohon' => set_value('nama_pemohon', $row->nama_pemohon),
                'no_telp_pemohon' => set_value('no_telp_pemohon', $row->no_telp_pemohon),
                'jabatan_pemohon' => set_value('jabatan_pemohon', $row->jabatan_pemohon),
                'email' => set_value('email', $row->email),
                'kode_whatsapp' => set_value('kode_whatsapp', $row->kode_whatsapp),
                'lat' => set_value('lat', $row->lat),
                'long' => set_value('long', $row->long),
            ];
            $this->Tampilan_model->layar('kantor/kantor_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/kantor'));
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
                'kode' => $this->input->post('kode', TRUE),
                'nama_kantor' => $this->input->post('nama_kantor', TRUE),
                'alamat_kantor' => $this->input->post('alamat_kantor', TRUE),
                'no_telp_kantor' => $this->input->post('no_telp_kantor', TRUE),
                'bidang_bisnis' => $this->input->post('bidang_bisnis', TRUE),
                'jumlah_karyawan' => $this->input->post('jumlah_karyawan', TRUE),
                'nama_pemohon' => $this->input->post('nama_pemohon', TRUE),
                'no_telp_pemohon' => $this->input->post('no_telp_pemohon', TRUE),
                'jabatan_pemohon' => $this->input->post('jabatan_pemohon', TRUE),
                'email' => $this->input->post('email', TRUE),
                'kode_whatsapp' => $this->input->post('kode_whatsapp', TRUE),
            ];
            $data_lat_long = [
                'lat' => $this->input->post('lat', TRUE),
                'long' => $this->input->post('long', TRUE),
            ];

            $kantor = $this->Kantor_lokasi_model->get_by_id_kantor($id);
            // var_dump($kantor);

            $this->Kantor_model->update($id, $data);
            $this->Kantor_lokasi_model->update($kantor->id_kantor, $data_lat_long);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/kantor'));
            // var_dump($data);
        }
    }

    public function delete($id)
    {
        $row = $this->Kantor_model->get_by_id($id);
        if ($row) {
            $this->Kantor_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/kantor'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/kantor'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('kode', 'kode', 'trim|required');
        $this->form_validation->set_rules('nama_kantor', 'nama kantor', 'trim|required');
        $this->form_validation->set_rules('alamat_kantor', 'alamat kantor', 'trim|required');
        $this->form_validation->set_rules('no_telp_kantor', 'no telp kantor', 'trim|required');
        $this->form_validation->set_rules('bidang_bisnis', 'bidang bisnis', 'trim|required');
        $this->form_validation->set_rules('jumlah_karyawan', 'jumlah karyawan', 'trim|required');
        $this->form_validation->set_rules('nama_pemohon', 'nama pemohon', 'trim|required');
        $this->form_validation->set_rules('no_telp_pemohon', 'no telp pemohon', 'trim|required');
        $this->form_validation->set_rules('jabatan_pemohon', 'jabatan pemohon', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('kode_whatsapp', 'kode whatsapp', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Kantor.php */
/* Location: ./application/controllers/Kantor.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-10-23 03:57:51 */
/* http://harviacode.com */
