<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Instagram extends CI_Controller
{

    private $xapi = 'habs7d576asf67d5as6da546sfdf6a5sd';

    public function __construct()
    {
        parent::__construct();
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
        $this->load->view('android/instagram');
    }
}
