<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kritik_saran_model extends CI_Model
{

    public $table = 'kritik_saran';
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
        $this->datatables->select('id,tgl,isi');
        $this->datatables->from('kritik_saran');
        $this->datatables->where('id_kantor',$kantor_id->id_kantor);
        //add this line for join
        //$this->datatables->join('table2', 'kritik_saran.field = table2.field');
        //$this->datatables->add_column('action', anchor(site_url('kritik_saran/read/$1'),'Read')." | ".anchor(site_url('kritik_saran/update/$1'),'Update')." | ".anchor(site_url('kritik_saran/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
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
	$this->db->or_like('tgl', $q);
	$this->db->or_like('isi', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('tgl', $q);
	$this->db->or_like('isi', $q);
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

/* End of file Kritik_saran_model.php */
/* Location: ./application/models/Kritik_saran_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-09-04 10:57:32 */
/* http://harviacode.com */