<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kantor_model extends CI_Model
{

    public $table = 'kantor';
    public $id = 'id';
    public $order = 'DESC';

    // private $globalVariable = 'Nilai Variabel Global';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row();
        $this->datatables->select(' k.id,k.nama_kantor,k.kode,k.alamat_kantor,k.no_telp_kantor,k.bidang_bisnis,k.jumlah_karyawan,k.nama_pemohon,k.no_telp_pemohon,k.jabatan_pemohon,k.email,k.kode_whatsapp,k.created_date,l.long,COUNT(u.id) AS total_users');
        $this->datatables->from('kantor k');
        $this->datatables->join('kantor_lokasi l', 'l.id_kantor=k.id', 'left');
        $this->datatables->join('users u', 'u.id_kantor = k.id', 'left');
        $this->datatables->where('k.id', $kantor_id->id_kantor);
        $this->datatables->group_by('k.id');
        $this->datatables->add_column('action', anchor(
            site_url('admin/kantor/update/$1'),
            '<button class="btn btn-xs btn-info">
        <i class="ace-icon fa fa-pencil bigger-120"></i>
        </button>'
        ) . "&nbsp;&nbsp;", $kantor_id->id_kantor);
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        // $this->globalVariable = $id;

        $this->db->select('k.*,l.lat,l.long');
        $this->db->from('kantor as k');
        $this->db->join('kantor_lokasi as l', 'l.id_kantor=k.id');
        $this->db->where('k.id', $id);
        // $this->db->where($this->id, $id);
        return $this->db->get()->row();
    }

    // insert data
    function insert($data)
    {
        $data['created_date'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // public function getGlobalVariable() {
    //     return $this->globalVariable;
    // }
}

/* End of file Kantor_model.php */
/* Location: ./application/models/Kantor_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-10-23 03:57:51 */
/* http://harviacode.com */
