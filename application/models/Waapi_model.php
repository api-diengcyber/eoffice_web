<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Waapi_model extends CI_Model
{

    public $session_name = 'asdf65dd';

    function __construct()
    {
        parent::__construct();
        $this->load->library('curl_waapi');
        $this->load->library('session');
    }

    function toGenericPhoneNumber($phone = '')
    {
        if (substr($phone, 0, 2) == "08") {
            $phone = '628' . substr($phone, 2);
        } else if (substr($phone, 0, 1) == "8") {
            $phone = '62' . $phone;
        } else if (substr($phone, 0, 2) == "62") {
            if (substr($phone, 0, 3) == "620") {
                $phone = '628' . substr($phone, 3);
            } else {
                $phone = '' . $phone;
            }
        } else if (substr($phone, 0, 4) == "+620") {
            $phone = '628' . substr($phone, 4);
        }
        return $phone;
    }

    function toLocalPhoneNumber($phone = '')
    {
        if (substr($phone, 0, 1) == "8") {
            $phone = '0' . $phone;
        } else if (substr($phone, 0, 2) == "62") {
            if (substr($phone, 0, 3) == "620") {
                $phone = '0' . substr($phone, 0, 3);
            } else {
                $phone = '0' . substr($phone, 0, 2);
            }
        } else if (substr($phone, 0, 3) == "+62") {
            if (substr($phone, 0, 4) == "+620") {
                $phone = '0' . substr($phone, 4);
            } else {
                $phone = '0' . substr($phone, 3);
            }
        }
        return $phone;
    }

    function gen_auth_token()
    {
        $response = $this->curl_waapi->genAccessToken();
        return $response;
    }

    function get_api_url()
    {
        return $this->curl_waapi->apiurl;
    }

    function get_socket_url()
    {
        return $this->curl_waapi->socketurl;
    }

    function get_qr_url()
    {
        return $this->curl_waapi->apiurl . 'qr/' . $this->session_name;
    }

    function check_client()
    {
        $response = $this->curl_waapi->get('api/whatsapp/checkClient/' . $this->session_name);
        return $response;
    }

    function get_host()
    {
        $response = $this->curl_waapi->get('api/whatsapp/get_host');
        return $response;
    }

    function get_user()
    {
        $response = $this->curl_waapi->get('api/users/findUser');
        return $response;
    }

    function get_all_chat()
    {
        $response = $this->curl_waapi->get('api/whatsapp/get_all_chat');
        return $response;
    }

    function get_messages($chat_id)
    {
        $response = $this->curl_waapi->post('api/whatsapp/get_messages', [
            'chatId' => $chat_id,
        ]);
        return $response;
    }

    function send($no, $msg)
    {
        $response = $this->curl_waapi->post('api/whatsapp/sendMessage/' . $this->session_name, [
            'tujuan' => $this->toGenericPhoneNumber($no),
            'message' => $msg,
        ]);
        return $response;
    }

    function send_files($chatId, $msg, $files)
    {
        $response = $this->curl_waapi->post('api/whatsapp/send_file_message/' . $this->session_name, [
            'tujuan' => $chatId,
            'caption' => $msg,
        ]);
        return $response;
    }
}
