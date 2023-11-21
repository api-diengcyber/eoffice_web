<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->load->model('Status_kerja_model');
    }

    public function update()
    {
        $this->api->head();

        $id_user = $this->input->post('id_user');
        $status = $this->input->post('active');

        if (!empty($id_user) && !empty($status)) { 
            $data = [
                'id_user' => $id_user,
                'created_on' => date('Y-m-d H:i:s'),
                'status' => !empty($status) ? $status : 0,
            ];
            $this->Status_kerja_model->insert($data);
        }

        $this->api->result("ok", [], "Update berhasil!");
    }
}
