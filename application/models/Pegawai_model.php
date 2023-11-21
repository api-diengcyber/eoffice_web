<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{

    public $table = 'pegawai';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($status)
    {

        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();


        $this->datatables->select('p.id, p.id_users, p.nama_pegawai, p.tgl_masuk, p.rekening, p.level, p.gaji_pokok, l.level AS nm_level, t.tingkat, pj.jabatan, p.wfh, p.hybrid');
        $this->datatables->from('pegawai AS p');
        //add this line for join
        $this->datatables->join('pil_level AS l', 'p.level = l.id', 'left');
        $this->datatables->join('pil_jabatan AS pj', 'p.id_jabatan = pj.id', 'left');
        $this->datatables->join('pil_tingkat AS t', 'p.tingkat = t.id', 'left');
        $this->datatables->join('users as u', 'p.id_users = u.id', 'left');
        $this->datatables->where('u.active', $status);
        $this->datatables->where('u.id_kantor', $kantor_id->id_kantor);
        $this->datatables->where('u.id!=', $user_id);
        $this->datatables->add_column('action', anchor(site_url('admin/pegawai/read/$1'), '<button class="btn btn-xs btn-success"><i class="ace-icon fa fa-check bigger-120"></i></button>') . "&nbsp;&nbsp;" . anchor(site_url('admin/pegawai/update/$1'), '<button class="btn btn-xs btn-info"><i class="ace-icon fa fa-pencil bigger-120"></i></button>') . "&nbsp;&nbsp;" . anchor(site_url('admin/pegawai/delete/$1'), '<button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        $this->db->order_by('level ASC, id ASC');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }
    // get data by id
    function get_pegawai()
    {
        $this->db->select('p.id as id , p.* , p.level as id_level , p.tingkat as id_tingkat, pt.tingkat,pt.ket,pj.jabatan,l.level');
        $this->db->from('pegawai as p');
        $this->db->join('pil_tingkat as pt', 'p.tingkat = pt.id', 'left');
        $this->db->join('pil_jabatan as pj', 'p.id_jabatan = pj.id', 'left');
        $this->db->join('pil_level as l', 'p.level = l.id', 'left');
        $this->db->where('p.level > 0');
        return $this->db->get()->row();
    }
    function get_pegawai_aktif()
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

        $this->db->select('p.*,p.id as id');
        $this->db->from('pegawai as p');
        // $this->db->where('p.level != 0');
        $this->db->where('u.active = 1');
        $this->db->join('users as u', 'p.id_users = u.id');
        $this->db->where('u.id_kantor', $kantor_id->id_kantor);
        $this->db->where('u.id!=', $user_id);
        $this->db->order_by('u.id','desc');
        return $this->db->get()->result();
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->select('p.id as id , p.* , p.level as id_level , p.tingkat as id_tingkat, pt.tingkat,pt.ket,pj.jabatan,l.level,u.active as status,u.email as email');
        $this->db->from('pegawai as p');
        $this->db->join('pil_tingkat as pt', 'p.tingkat = pt.id', 'left');
        $this->db->join('pil_jabatan as pj', 'p.id_jabatan = pj.id', 'left');
        $this->db->join('pil_level as l', 'p.level = l.id', 'left');
        $this->db->join('users as u', 'u.id = p.id_users');
        $this->db->where('p.' . $this->id, $id);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id', $q);
        $this->db->or_like('id_users', $q);
        $this->db->or_like('nama_pegawai', $q);
        $this->db->or_like('tgl_masuk', $q);
        $this->db->or_like('rekening', $q);
        $this->db->or_like('level', $q);
        $this->db->or_like('gaji_pokok', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('id_users', $q);
        $this->db->or_like('nama_pegawai', $q);
        $this->db->or_like('tgl_masuk', $q);
        $this->db->or_like('rekening', $q);
        $this->db->or_like('level', $q);
        $this->db->or_like('gaji_pokok', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
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
}

/* End of file Pegawai_model.php */
/* Location: ./application/models/Pegawai_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-29 10:12:33 */
/* http://harviacode.com */
