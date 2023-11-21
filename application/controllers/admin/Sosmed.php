<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sosmed extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Waapi_model');
        $this->Tampilan_model->admin();
    }

    public function check_whatsapp_client()
    {
        header('Content-Type: application/json');
        $is_connected = false;
        $check_client = $this->Waapi_model->check_client();
        if (!empty($check_client)) {
            $decode = (array) json_decode($check_client);
            if (!empty($decode['status'])) {
                if ($decode['status'] == 'CONNECTED') {
                    $is_connected = true;
                }
            }
        }
        echo json_encode([
            'status' => $is_connected
        ]);
    }

    public function whatsapp()
    {
        $auth_token = $this->Waapi_model->gen_auth_token();
        $data = [
            'socket_io' => $this->Waapi_model->get_socket_url(),
            'bearer_wa' => $auth_token,
            'session_name' => $this->Waapi_model->session_name,
            'qr_url' => $this->Waapi_model->get_qr_url(),
            'view_whatsapp' => site_url('android/whatsapp'),
        ];
        $this->Tampilan_model->layar('sosmed/sosmed_whatsapp', $data, ['active_sosmed' => 'active_sosmed_wa']);
    }

    public function instagram()
    {
        $data = [
            'socket_io' => $this->Waapi_model->get_socket_url(),
        ];
        $this->Tampilan_model->layar('sosmed/sosmed_instagram', $data, ['active_sosmed' => 'active_sosmed_ig']);
    }
}
