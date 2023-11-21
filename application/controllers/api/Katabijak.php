<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Katabijak extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->load->library('form_validation');
    }


    public function index()
    {
        $this->api->head('application/json', false);
        $row = $this->db->query("SELECT * FROM kata_bijak ORDER BY RAND() LIMIT 1;")->row();
        $this->api->result(
            'ok',
            [
                'kalimat' => $row->kata_bijak,
            ],
            "Get berhasil"
        );
    }
}