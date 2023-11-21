<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitor_layar extends CI_Controller
{

    public $active = array('active_utilities' => 'active_monitor_layar');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Monitor_layar_model');
        $this->load->model('Status_kerja_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->data_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    }

    public function json()
    {
        header('Content-Type: application/json');
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Monitor_layar_model->json(date('d-m-Y'));
    }

    public function index()
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = [];
        $this->Tampilan_model->layar('monitor_layar/monitor_layar_list', $data, $this->active);
    }

    public function status_kerja_json($id_user, $tgl = NULL)
    {
        header('Content-Type: application/json');
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Status_kerja_model->json($id_user, $tgl);
    }

    public function status_kerja($id_user)
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $tgl = date('d-m-Y');
        if (!empty($this->input->post('tgl'))) {
            $tgl = $this->input->post('tgl');
        }

        $data = [
            'tgl' => $tgl,
            'id_user' => $id_user,
            'data_total_jam' => $this->Status_kerja_model->get_total_active_by_tgl($id_user, $tgl),
            'data_bulan' => $this->data_bulan,
            'action_export' => site_url('admin/monitor_layar/status_kerja_export')
        ];

        $this->Tampilan_model->layar('monitor_layar/status_kerja', $data, $this->active);
    }

    public function status_kerja_export()
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $this->load->helper('exportexcel');

        $id_user = $this->input->post('id_user');
        $bulan = $this->input->post('bulan');
        $nama_bulan = $this->data_bulan[$bulan];
        $tahun = date('Y');

        $row = $this->db->where('id', $id_user)->get('users')->row();
        $row_pegawai = $this->db->where('id_users', $id_user)->get('pegawai')->row();

        $namaFile = "export-status-kerja-" . $nama_bulan . "-" . $tahun . ".xls";
        $tablehead = 0;
        $tablebody = 1;

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead, $row_pegawai->nama_pegawai);
        $tablehead++;
        xlsWriteLabel($tablehead, $kolomhead, $nama_bulan . " " . $tahun);
        $tablehead++;

        $tablehead += 2;

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Tgl");
        xlsWriteLabel($tablehead, $kolomhead++, "Jam Start");
        xlsWriteLabel($tablehead, $kolomhead++, "Jam Stop");
        xlsWriteLabel($tablehead, $kolomhead++, "Durasi");

        $tablebody = $tablehead + 1;

        $data_total_jam = $this->Status_kerja_model->get_total_active_by_bulan($id_user, $bulan, $tahun);
        $nourut = 1;
        foreach ($data_total_jam->data as $row) :
            $kolombody = 0;

            xlsWriteLabel($tablebody, $kolombody++, (string) $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $row['date']);
            xlsWriteLabel($tablebody, $kolombody++, $row['start']);
            xlsWriteLabel($tablebody, $kolombody++, $row['end']);
            xlsWriteLabel($tablebody, $kolombody++, (string) $row['interval']);

            $tablebody++;
            $nourut++;
        endforeach;

        $tablefoot = $tablebody + 3;
        $kolomfoot = 0;

        xlsWriteLabel($tablefoot, $kolomfoot++, "");
        xlsWriteLabel($tablefoot, $kolomfoot++, "");
        xlsWriteLabel($tablefoot, $kolomfoot++, "");
        xlsWriteLabel($tablefoot, $kolomfoot++, "Jumlah");
        xlsWriteLabel($tablefoot, $kolomfoot++, $data_total_jam->total);

        xlsEOF();
        exit();
    }

    public function preview_request_screen()
    {
        header('Content-Type: application/json');
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $id = $this->input->post('id');
        $date = $this->input->post('date');

        $r = $this->Monitor_layar_model->preview_request_screen($id, $date);
        echo json_encode($r);
    }

    public function request_screen()
    {
        header('Content-Type: application/json');
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $id = $this->input->post('id');
        $r = $this->Monitor_layar_model->send_request_screen($id);
        echo json_encode($r);
    }

    public function get_user_files_screenshot()
    {
        header('Content-Type: application/json');
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $id = $this->input->post('id', true);
        $limit = $this->input->post('limit', true);
        $page = $this->input->post('page', true);
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $files = $this->Monitor_layar_model->get_files_db($id, $limit, $page, $start_date, $end_date);
        echo json_encode([
            'dir' => base_url('assets/screensharing'),
            'files' => $files,
        ]);
    }

    public function galeri_user($id)
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $start = date('01-m-Y');
        $end = date('t-m-Y');
        $exstart = explode("-", $start);
        $start_h = $exstart[0];
        $start_m = !empty($exstart[1]) ? $exstart[1] : date('m');
        $start_y = !empty($exstart[2]) ? $exstart[2] : date('Y');
        $zstart = $start_y . "-" . $start_m . "-" . $start_h;
        $exend = explode("-", $end);
        $end_h = $exend[0];
        $end_m = !empty($exend[1]) ? $exend[1] : date('m');
        $end_y = !empty($exend[2]) ? $exend[2] : date('Y');
        $zend = $end_y . "-" . $end_m . "-" . $end_h;

        $pstart = $this->input->post('start');
        $pend = $this->input->post('end');

        $pzstart = $zstart;
        $pzend = $zend;
        if (!empty($pstart)) {
            $pzstart = $pstart;
        }
        if (!empty($pend)) {
            $pzend = $pend;
        }

        $row_pegawai = $this->Monitor_layar_model->get_by_id_user($id);

        $data = [
            'data_pegawai' => $row_pegawai,
            'start' => $pzstart,
            'end' => $pzend,
        ];
        $this->Tampilan_model->layar('monitor_layar/galeri_list', $data, $this->active);
    }
}
