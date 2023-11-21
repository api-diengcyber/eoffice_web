<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Whatsapp extends CI_Controller
{

    private $xapi = 'habs7d576asf67d5as6da546sfdf6a5sd';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Waapi_model');
    }

    public function api_access()
    {
        $r = false;
        if (!empty($this->session->userdata('users_id_office'))) {
            $r = true;
        }
        if ($this->input->get('x-api-key') == $this->xapi) {
            $r = true;
        }
        if (!$r) {
            show_404();
            exit();
        }
    }

    public function index()
    {
        $this->api_access();
        $raw_user = $this->Waapi_model->get_user();
        $row_user = null;
        if (!empty($raw_user)) {
            $row_user = (object) json_decode($raw_user);
        }
        $auth_token = $this->Waapi_model->gen_auth_token();
        $this->load->view('android/whatsapp', [
            'data_user' => $row_user,
            'api_url' => $this->Waapi_model->get_api_url(),
            'bearer_wa' => $auth_token,
            'session_name' => $this->Waapi_model->session_name,
        ]);
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

    public function get_contacts()
    {
        header('Content-Type: application/json');
        $r = $this->Waapi_model->get_all_chat();
        if (!empty($r)) {
            $decode = (array) json_decode($r);
            $res = [];
            if (!empty($decode['data'])) {
                $data = $decode['data'];
                foreach ($data as $row) :
                    $row = (array) $row;
                    $res[] = $row['contact'];
                endforeach;
            }
            echo json_encode($res, JSON_PRETTY_PRINT);
        } else {
            echo json_encode([]);
        }
    }

    public function get_messages()
    {
        header('Content-Type: application/json');
        $chat_id = $this->input->post('chat_id');
        $r = $this->Waapi_model->get_messages($chat_id);
        if (!empty($r)) {
            $decode = (array) json_decode($r);
            echo json_encode($decode, JSON_PRETTY_PRINT);
        } else {
            echo json_encode([]);
        }
    }

    public function send_msg()
    {
        header('Content-Type: application/json');
        $no = $this->input->post('no');
        $msg = $this->input->post('msg');
        $r = $this->Waapi_model->send($no, $msg);
        if (!empty($r)) {
            $decode = (array) json_decode($r);
            echo json_encode($decode, JSON_PRETTY_PRINT);
        } else {
            echo json_encode([]);
        }
    }
}
