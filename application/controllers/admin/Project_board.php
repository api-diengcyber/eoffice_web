<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project_board extends CI_Controller
{

    public $active = array('active_absen' => 'active');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->library('form_validation');
    }


    public function index()
    {
        $this->Tampilan_model->layar("project_board/board"); 
    }
}
/* End of file Project_board.php */
