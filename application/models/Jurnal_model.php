<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jurnal_model extends CI_Model
{

    public $table = 'jurnal';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('j1.id, j1.kode, j1.tgl, j1.id_akun AS id_akun_debet, ak_debet.akun AS akun_debet, j2.id_akun AS id_akun_kredit, ak_kredit.akun AS akun_kredit, j1.debet AS nominal, j1.keterangan');
        $this->datatables->from('jurnal AS j1');
        //add this line for join
        $this->datatables->join('jurnal AS j2', 'j1.kode = j2.kode');
        $this->datatables->join('akun AS ak_debet', 'j1.id_akun = ak_debet.id');
        $this->datatables->join('akun AS ak_kredit', 'j2.id_akun = ak_kredit.id');
        $this->datatables->where('j1.debet > 0 AND j2.kredit > 0');
        $this->datatables->add_column('action', anchor(site_url('admin/jurnal/read/$1'),'<button class="btn btn-xs btn-success"><i class="ace-icon fa fa-check bigger-120"></i></button>')."&nbsp;&nbsp;".anchor(site_url('admin/jurnal/update/$1'),'<button class="btn btn-xs btn-info"><i class="ace-icon fa fa-pencil bigger-120"></i></button>')."&nbsp;&nbsp;".anchor(site_url('admin/jurnal/delete/$1'),'<button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
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
	$this->db->or_like('id_akun', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('debet', $q);
	$this->db->or_like('kredit', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('tgl', $q);
	$this->db->or_like('id_akun', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('debet', $q);
	$this->db->or_like('kredit', $q);
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

/* End of file Jurnal_model.php */
/* Location: ./application/models/Jurnal_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-03 09:35:36 */
/* http://harviacode.com */