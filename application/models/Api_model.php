<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Api_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->API_KEY = "3hKnM&pQ#JCs_M";
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    public function head($type = 'application/json', $with_key = true)
    {
        header('Content-Type: ' . $type);
        header("Access-Control-Allow-Origin: *");

        if ($with_key) {
            $api_key = $this->input->post('X-API-KEY');
            if ($api_key != $this->API_KEY) {
                $this->result('failed', [], 'TIDAK ADA API KEY = ' . implode(',', $_POST));
                die();
                exit();
            }
        }
    }

    public function result($status = 'error', $data = [], $msg = '')
    {
        if ($status == 'error') {
            http_response_code(500);
        } else {
            http_response_code(200);
        }
        echo json_encode(array(
            'status' => $status,
            'data' => $data,
            'msg' => $msg,
        ));
    }
    function hariIndo($hariInggris)
    {
        switch ($hariInggris) {
            case 'Sunday':
                return 'Minggu';
            case 'Monday':
                return 'Senin';
            case 'Tuesday':
                return 'Selasa';
            case 'Wednesday':
                return 'Rabu';
            case 'Thursday':
                return 'Kamis';
            case 'Friday':
                return 'Jumat';
            case 'Saturday':
                return 'Sabtu';
            default:
                return 'hari tidak valid';
        }
    }
    function bulanIndo($blnindex)
    {
        $ar = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $ar[$blnindex * 1];
    }
}
