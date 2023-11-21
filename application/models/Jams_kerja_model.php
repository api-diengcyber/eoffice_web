<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jams_kerja_model extends CI_Model
{

    public $table = 'jam_kerja';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id,id_users,tgl,jam_masuk,jam_pulang,lembur,tidak_masuk,status');
        $this->datatables->from('jam_kerja');
        //add this line for join
        //$this->datatables->join('table2', 'jam_kerja.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('jams_kerja/read/$1'),'Read')." | ".anchor(site_url('jams_kerja/update/$1'),'Update')." | ".anchor(site_url('jams_kerja/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
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
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('id_users', $q);
	$this->db->or_like('tgl', $q);
	$this->db->or_like('jam_masuk', $q);
	$this->db->or_like('jam_pulang', $q);
	$this->db->or_like('lembur', $q);
	$this->db->or_like('tidak_masuk', $q);
	$this->db->or_like('status', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('id_users', $q);
	$this->db->or_like('tgl', $q);
	$this->db->or_like('jam_masuk', $q);
	$this->db->or_like('jam_pulang', $q);
	$this->db->or_like('lembur', $q);
	$this->db->or_like('tidak_masuk', $q);
	$this->db->or_like('status', $q);
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

/* End of file Jams_kerja_model.php */
/* Location: ./application/models/Jams_kerja_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-09-10 10:38:28 */
/* http://harviacode.com */