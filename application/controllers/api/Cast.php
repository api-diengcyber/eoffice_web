<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cast extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->load->model('Monitor_layar_model');
    }

    public function update_token()
    {
        $this->api->head();

        $id_user = $this->input->post('id_user');
        $token = $this->input->post('token');

        if (!empty($id_user) && !empty($token)) {
            $this->db->where('id', $id_user);
            $this->db->update('users', [
                'fcm_token' => $token,
            ]);
            $this->api->result('ok', [], "Update berhasil");
        } else {
            $this->api->result('error', [], "Update gagal");
        }
    }

    public function share()
    {
        $this->api->head();

        $id = $this->input->post('id_user', true);
        $date = $this->input->post('date', true);

        $prefix = '';
        if (!empty($this->input->post('auto'))) {
            if ($this->input->post('auto') == 'auto') {
                $prefix = 'AUTO_';
            }
        }

        // $r = $this->Monitor_layar_model->save_base64_image($id, $date, $screen_base);
        $r = $this->Monitor_layar_model->save_image($id, $date, 'screen_image', $prefix);

        if ($r) {
            $this->api->result('error', [], "Layar berhasil diupload");
        } else {
            $this->api->result('error', [], "Layar gagal diupload");
        }
    }
}
