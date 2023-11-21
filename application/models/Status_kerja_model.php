<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Status_kerja_model extends CI_Model
{

    public $table = 'status_kerja';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_total_active_by_bulan($id_user, $bulan, $tahun)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('SUBSTRING(created_on,6,2)=', sprintf('%02d', $bulan));
        $this->db->where('LEFT(created_on,4)=', $tahun);
        $this->db->order_by('created_on', 'ASC');
        $res = $this->db->get($this->table)->result();

        return $this->_get_total_active($res);
    }

    function get_total_active_by_periode($id_user, $start_date, $end_date)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('DATE(LEFT(created_on,10)) BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
        $this->db->order_by('created_on', 'ASC');
        $res = $this->db->get($this->table)->result();

        return $this->_get_total_active($res);
    }

    function get_total_active_by_tgl($id_user, $tgl)
    {
        $extgl = explode("-", $tgl);
        $tgl = $extgl[2] . '-' . $extgl[1] . '-' . $extgl[0];
        $this->db->where('id_user', $id_user);
        $this->db->where('LEFT(created_on,10)=', $tgl);
        $this->db->order_by('created_on', 'ASC');
        $res = $this->db->get($this->table)->result();

        return $this->_get_total_active($res);
    }

    function _get_total_active($res)
    {
        $data = [];
        $total_jam_kerja = 0;
        $start_hitung = false;
        $date_start = null;
        $date_end = null;
        $array_days = [];
        foreach ($res as $row) :
            if ($row->status == "1") {
                $start_hitung = true;
                $date_start = new \DateTime($row->created_on);
            }
            if ($row->status == "2") {
                if ($start_hitung) {
                    $date_end = new \DateTime($row->created_on);
                    $interval  = $date_end->diff($date_start);
                    $jam_kerja = $interval->format('%h');
                    $menit_kerja = $interval->format('%i');
                    $dec_jam_kerja = (100 / 60) * $menit_kerja * 1;
                    $jam_kerja = $jam_kerja;
                    if ($dec_jam_kerja > 0) {
                        $jam_kerja .= "." . round($dec_jam_kerja);
                    }
                    $data[] = [
                        'date' => $date_start->format('Y-m-d'),
                        'start' => $date_start->format('Y-m-d H:i:s'),
                        'end' => $date_end->format('Y-m-d H:i:s'),
                        'interval' => floatval($jam_kerja),
                    ];
                    $array_days[$date_start->format('Y-m-d')] = true;
                    $total_jam_kerja += floatval($jam_kerja);
                    $start_hitung = false;
                }
            }
        endforeach;

        return (object) [
            'total' => $total_jam_kerja,
            'average' => count($array_days) > 0 ? round($total_jam_kerja / count($array_days), 2) : 0,
            'data' => $data,
        ];
    }

    function json($id_user, $tgl = NULL)
    {
        $this->datatables->select('sk.id, sk.id_user, sk.created_on, sk.status, p.nama_pegawai');
        $this->datatables->from($this->table . ' sk');
        $this->datatables->join('users u', 'sk.id_user=u.id');
        $this->datatables->join('pegawai p', 'p.id_users=u.id');
        $this->datatables->where('sk.id_user', $id_user);
        if (!empty($tgl)) {
            $extgl = explode("-", $tgl);
            $tgl = $extgl[2] . '-' . $extgl[1] . '-' . $extgl[0];
            $this->datatables->where('LEFT(sk.created_on,10)=', $tgl);
        }
        return $this->datatables->generate();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}
