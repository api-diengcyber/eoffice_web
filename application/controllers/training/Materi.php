<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

	public $active = array('active_utilities'=>'active_materi');
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tampilan_model');
		$this->load->model('Materi_model');
		$this->load->library('Datatables');
		$this->Tampilan_model->training();
	}
	public function index()
    {
    	$data['data_materi'] = $this->Materi_model->get_all();
        $this->Tampilan_model->layar('materi/materi_list',$data,$this->active);
    }
	public function json() {
        header('Content-Type: application/json');
        echo $this->Materi_model->json_training();
    }
    public function read($id) {
    	$data['data_materi'] = $this->Materi_model->get_by_id($id);
    	$this->Tampilan_model->layar('materi/materi_read',$data,$this->active);
    }

}

/* End of file Materi.php */
/* Location: ./application/controllers/training/Materi.php */