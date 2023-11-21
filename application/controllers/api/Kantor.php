<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kantor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->load->model('Kantor_model');
        $this->load->model('Global_model');
        // echo $kantor = $this->Kantor_model->getGlobalVariable();
        $this->load->library('session');
        
    }

    public function index()
    {
        var_dump('sasas');
    }
    public function cek_kantor($id)
    {
        $this->api->head('application/json', false);
        $user_id = $this->session->userdata('user_id');
        $kantor = $this->Kantor_model->get_by_id($id);
    
        // echo $kantor = $this->Kantor_model->getGlobalVariable();
        
        $this->session->set_userdata('id_kantors', $id);
        //  echo  
        $this->api->result('ok', $kantor, 'Data Kantor');
       
    }
    
   
}
