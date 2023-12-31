<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Materi_model extends CI_Model
{

    public $table = 'materi';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {

        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();
        $this->datatables->select('id,tgl,nama_materi,isi,lampiran');
        $this->datatables->from('materi');
        $this->datatables->where('materi.id_kantor',$kantor_id->id_kantor);
        //add this line for join
        //$this->datatables->join('table2', 'materi.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('admin/materi/read/$1'),'<button class="btn btn-xs btn-primary">Read</button>')." ".anchor(site_url('admin/materi/update/$1'),'<button class="btn btn-success btn-xs">Update</button>')." ".anchor(site_url('admin/materi/delete/$1'),'<button class="btn btn-danger btn-xs">Delete</button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }
    // datatables
    function json_training() {
        $this->datatables->select('id,tgl,nama_materi,isi,lampiran');
        $this->datatables->from('materi');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

        $this->db->where('id_kantor', $kantor_id->id_kantor);
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
    	$this->db->or_like('tgl', $q);
    	$this->db->or_like('nama_materi', $q);
    	$this->db->or_like('isi', $q);
    	$this->db->or_like('lampiran', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
    	$this->db->or_like('tgl', $q);
    	$this->db->or_like('nama_materi', $q);
    	$this->db->or_like('isi', $q);
    	$this->db->or_like('lampiran', $q);
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

/* End of file Materi_model.php */
/* Location: ./application/models/Materi_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-12-20 09:57:39 */
/* http://harviacode.com */