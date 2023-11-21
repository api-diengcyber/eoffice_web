<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class KPI extends CI_Controller
{

    public $active = array('active_utilities' => 'active_kpi');

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Tampilan_model');
        $this->load->model('KPI_model');
        $this->Tampilan_model->admin();
    }

    function getColor()
    {
        $hash = md5('color' . rand(1, 10000));
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));
        return "rgb(" . $r . ", " . $g . ", " . $b . ")";
    }

    private function generate_color_pegawai()
    {
        $res = $this->db->where('color IS NULL OR color = ""')->get('pegawai')->result();
        foreach ($res as $key) :
            $this->db->where('id', $key->id);
            $this->db->update('pegawai', [
                'color' => $this->getColor(),
            ]);
        endforeach;
    }

    public function index()
    {
        $this->generate_color_pegawai();
        $id_pegawai = '';
        if (!empty($this->input->post('id_pegawai'))) {
            $id_pegawai = $this->input->post('id_pegawai');
        }
        $start = date('01-m-Y');
        $end = date('d-m-Y');
        if (!empty($this->input->post('start'))) {
            $start = $this->input->post('start');
        }
        if (!empty($this->input->post('end'))) {
            $end = $this->input->post('end');
        }
        $exstart = explode("-", $start);
        $exend = explode("-", $end);
        $params = [
            'id_pegawai' => $id_pegawai,
            'start' => $exstart[2] . '-' . $exstart[1] . '-' . $exstart[0],
            'end' => $exend[2] . '-' . $exend[1] . '-' . $exend[0],
        ];
        $data = [
            'id_pegawai' => $id_pegawai,
            'start' => $start,
            'end' => $end,
            'data_pegawai' => $this->KPI_model->get_pegawai(),
            'tugas_pegawai' => $this->KPI_model->get_tugas_pegawai($params),
        ];
        $this->Tampilan_model->layar('kpi/kpi_page', $data, $this->active);
    }
}
