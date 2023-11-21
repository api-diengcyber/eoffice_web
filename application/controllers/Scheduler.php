<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scheduler extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_monitor_model');
        $this->load->model('Monitor_layar_model');
    }

    public function jadwal_monitor()
    {
        sleep(1);
        $jam = date('H:i');
        $row = $this->Jadwal_monitor_model->get_by_jam_aktif($jam);
        if (!$row) {
            return;
        }
        $this->db->from('users');
        $this->db->where('active', 1);
        $this->db->where('(fcm_token IS NOT NULL OR fcm_token != "")');
        $res = $this->db->get()->result();
        $success = 0;
        foreach ($res as $data) :
            $t = $this->Monitor_layar_model->send_request_screen($data->id, true, $row->indeks);
            if (!empty($t)) {
                $success++;
            }
        endforeach;
        $this->Jadwal_monitor_model->update($row->id, [
            'success' => $success,
        ]);
        echo "ok";
        return true;
    }
}
