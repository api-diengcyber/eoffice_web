<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class KPI_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_pegawai($where_in = NULL)
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

        $this->db->select('p.*, l.level AS nm_level, t.tingkat, pj.jabatan');
        $this->db->from('pegawai p');
        $this->db->join('pil_level l', 'p.level = l.id', 'left');
        $this->db->join('pil_jabatan pj', 'p.id_jabatan = pj.id', 'left');
        $this->db->join('pil_tingkat t', 'p.tingkat = t.id', 'left');
        $this->db->join('users u', 'p.id_users = u.id', 'left');
        $this->db->join('tugas tu', 'tu.id_pegawai=p.id', 'left');
        $this->db->where('u.active', 1);
        $this->db->where('p.level != 0');
        $this->db->where('u.id !=', $user_id);
        $this->db->where('u.id_kantor ', $kantor_id->id_kantor);
        if (!empty($where_in) && is_array($where_in)) {
            $this->db->where_in('p.id', $where_in);
        }
        $this->db->order_by('p.nama_pegawai ASC');
        $this->db->group_by('p.id');
        return $this->db->get()->result();
    }

    function get_tugas_pegawai($params_where = [])
    {
        $this->load->model('Status_kerja_model');

        $id_pegawai = null;
        if (!empty($params_where['id_pegawai'])) {
            $id_pegawai = [$params_where['id_pegawai']];
        }
        $res = $this->get_pegawai($id_pegawai);

        $start = date('Y-m-d');
        $end = date('Y-m-d');
        if (!empty($params_where['start']) && !empty($params_where['end'])) {
            $start = $params_where['start'];
            $end = $params_where['end'];
        }

        $data_tgl = [];
        $dari = $start;
        $sampai = $end;
        while (strtotime($dari) <= strtotime($sampai)) {
            $data_tgl[] = date('d M y', strtotime($dari));
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        $data = [];
        $i = 0;
        foreach ($res as $key) :
            $data[$i] = $key;
            $data[$i]->progress = [];
            $dari = $start;
            $sampai = $end;
            $i2 = 0;
            $total_progress = 0;
            while (strtotime($dari) <= strtotime($sampai)) {
                $this->db->select('t.progress');
                $this->db->from('tugas t');
                $this->db->where('t.id_pegawai', $key->id);
                $this->db->where('t.tgl', date('d-m-Y', strtotime($dari)));
                $row = $this->db->get()->row();
                $progress = 0;
                if ($row) {
                    $i2++;
                    $progress = $row->progress * 1;
                    $total_progress += $progress;
                }
                $data[$i]->progress[] = [
                    'tgl' => $dari,
                    'progress' => $progress,
                ];
                $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
            }
            $data[$i]->average_progress = $i2 > 0 ? round($total_progress / $i2) : 0;
            $status_kerja = $this->Status_kerja_model->get_total_active_by_periode($key->id_users, $start, $end);
            $data[$i]->total_jam_kerja = $status_kerja->total;
            $data[$i]->average_jam_kerja = $status_kerja->average;
            $i++;
        endforeach;
        return (object) [
            'data_tgl' => $data_tgl,
            'data_tugas_pegawai' => $data,
        ];
    }
}
