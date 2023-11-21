<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

    public $table = 'transaksi';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id,tgl,no_faktur,harga,kepada_nama,kepada_hp,kepada_alamat');
        $this->datatables->from('transaksi');
        //add this line for join
        //$this->datatables->join('table2', 'transaksi.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('admin/transaksi/read/$1'),'<button class="btn btn-xs btn-success"><i class="ace-icon fa fa-check bigger-120"></i></button>')."&nbsp;&nbsp;".anchor(site_url('admin/transaksi/update/$1'),'<button class="btn btn-xs btn-info"><i class="ace-icon fa fa-pencil bigger-120"></i></button>')."&nbsp;&nbsp;".anchor(site_url('admin/transaksi/delete/$1'),'<button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }

    // datatables
    function json_barang() {
        $this->datatables->select('id,id_transaksi,barang,harga,diskon,jumlah,total');
        $this->datatables->from('transaksi_barang_temp');
        return $this->datatables->generate();
    }

    // datatables
    function json_barang_temp() {
        $this->datatables->select('id,barang,harga,diskon,jumlah,total');
        $this->datatables->from('transaksi_barang_temp');
        return $this->datatables->generate();
    }

    // datatables
    function json_barang_edit($id_transaksi) {
        $this->datatables->select('id,id_transaksi,barang,harga,diskon,jumlah,total');
        $this->datatables->from('transaksi_barang_edit');
        $this->datatables->where('id_transaksi', $id_transaksi);
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
    	$this->db->or_like('no_faktur', $q);
    	$this->db->or_like('harga', $q);
    	$this->db->or_like('kepada_nama', $q);
    	$this->db->or_like('kepada_hp', $q);
    	$this->db->or_like('kepada_alamat', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
    	$this->db->or_like('tgl', $q);
    	$this->db->or_like('no_faktur', $q);
    	$this->db->or_like('harga', $q);
    	$this->db->or_like('kepada_nama', $q);
    	$this->db->or_like('kepada_hp', $q);
    	$this->db->or_like('kepada_alamat', $q);
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

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-02-21 01:51:51 */
/* http://harviacode.com */