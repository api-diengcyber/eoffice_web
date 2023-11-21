<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Status_kerja extends CI_Controller
{

    public $active = array('active_status_kerja' => 'active_status_kerja');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Monitor_layar_model');
        $this->load->model('Status_kerja_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function json($tgl = NULL)
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->pegawai();
        echo $this->Status_kerja_model->json($data_login['users_id'], $tgl);
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->pegawai();

        $tgl = date('d-m-Y');
        if (!empty($this->input->post('tgl'))) {
            $tgl = $this->input->post('tgl');
        }

        $data = [
            'tgl' => $tgl,
            'id_user' => $data_login['users_id'],
            'data_total_jam' => $this->Status_kerja_model->get_total_active_by_tgl($data_login['users_id'], $tgl),
        ];

        $this->Tampilan_model->layar('status_kerja/status_kerja', $data, $this->active);
    }
}
