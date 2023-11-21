<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spk_report_model extends CI_Model
{

    public $table = 'spk_report';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json_marketing($id_users) {
        $this->datatables->select('s.id,s.tgl,s.tgl_spk,s.no_spk,s.nama_instansi,s.alamat_instansi,s.kelurahan_instansi,s.kecamatan_instansi,s.telp_instansi,s.telp2_instansi,s.atas_nama,s.alamat_atas_nama,s.keterangan,s.lokasi,s.pembayaran,s.diskon,s.status,s.prioritas,s.id_marketing,(SELECT id FROM do_report WHERE nama_instansi=s.nama_instansi AND alamat_instansi=s.alamat_instansi AND kelurahan_instansi=s.kelurahan_instansi AND kecamatan_instansi=s.kecamatan_instansi AND telp_instansi=s.telp_instansi AND telp2_instansi=s.telp2_instansi) AS id_do,(SELECT tgl_do FROM do_report WHERE nama_instansi=s.nama_instansi AND alamat_instansi=s.alamat_instansi AND kelurahan_instansi=s.kelurahan_instansi AND kecamatan_instansi=s.kecamatan_instansi AND telp_instansi=s.telp_instansi AND telp2_instansi=s.telp2_instansi) AS tgl_do, d.do');
        $this->datatables->from('spk_report AS s');
        $this->datatables->join('(SELECT MAX(id) AS id,nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi,do FROM daily_sales_report GROUP BY nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi) AS d', 'd.nama_instansi=s.nama_instansi AND d.alamat_instansi=s.alamat_instansi AND d.kelurahan_instansi=s.kelurahan_instansi AND d.kecamatan_instansi=s.kecamatan_instansi AND d.telp_instansi=s.telp_instansi AND d.telp2_instansi=s.telp2_instansi');
        $this->datatables->where('id_marketing', $id_users);
        $this->datatables->add_column('action', anchor(site_url('marketing/spk_report/read/$1'),'<button type="button" class="btn btn-minier btn-success"><i class="ace-icon fa fa-check icon-only bigger-110"></i></button>')."&nbsp;".anchor(site_url('marketing/spk_report/update/$1'),'<button type="button" class="btn btn-minier btn-info"><i class="ace-icon fa fa-pencil icon-only bigger-110"></i></button>'), 'id');
        $this->db->order_by('id_do', 'desc');
        $this->db->order_by('id', 'desc');
        $this->db->group_by('s.id');
        return $this->datatables->generate();
    }
    function json_training($id_users) {
        $this->datatables->select('s.id,s.tgl,s.tgl_spk,s.no_spk,s.nama_instansi,s.alamat_instansi,s.kelurahan_instansi,s.kecamatan_instansi,s.telp_instansi,s.telp2_instansi,s.atas_nama,s.alamat_atas_nama,s.keterangan,s.lokasi,s.pembayaran,s.diskon,s.status,s.prioritas,s.id_marketing,(SELECT id FROM do_report WHERE nama_instansi=s.nama_instansi AND alamat_instansi=s.alamat_instansi AND kelurahan_instansi=s.kelurahan_instansi AND kecamatan_instansi=s.kecamatan_instansi AND telp_instansi=s.telp_instansi AND telp2_instansi=s.telp2_instansi) AS id_do,(SELECT tgl_do FROM do_report WHERE nama_instansi=s.nama_instansi AND alamat_instansi=s.alamat_instansi AND kelurahan_instansi=s.kelurahan_instansi AND kecamatan_instansi=s.kecamatan_instansi AND telp_instansi=s.telp_instansi AND telp2_instansi=s.telp2_instansi) AS tgl_do, d.do');
        $this->datatables->from('spk_report AS s');
        $this->datatables->join('(SELECT MAX(id) AS id,nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi,do FROM daily_sales_report GROUP BY nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi) AS d', 'd.nama_instansi=s.nama_instansi AND d.alamat_instansi=s.alamat_instansi AND d.kelurahan_instansi=s.kelurahan_instansi AND d.kecamatan_instansi=s.kecamatan_instansi AND d.telp_instansi=s.telp_instansi AND d.telp2_instansi=s.telp2_instansi');
        $this->datatables->where('id_marketing', $id_users);
        $this->datatables->add_column('action', anchor(site_url('marketing/spk_report/read/$1'),'<button type="button" class="btn btn-minier btn-success"><i class="ace-icon fa fa-check icon-only bigger-110"></i></button>')."&nbsp;".anchor(site_url('marketing/spk_report/update/$1'),'<button type="button" class="btn btn-minier btn-info"><i class="ace-icon fa fa-pencil icon-only bigger-110"></i></button>'), 'id');
        $this->db->order_by('id_do', 'desc');
        $this->db->order_by('id', 'desc');
        $this->db->group_by('s.id');
        return $this->datatables->generate();
    }

    // datatables
    function json_admin($pil_tanggal = '', $tanggal = '', $id_marketing='') {
        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();
        // var_dump($pil_tanggal, $tanggal, $id_marketing);
        $this->datatables->select('s.id,s.tgl,s.tgl_spk,s.no_spk,s.nama_instansi,s.alamat_instansi,s.kelurahan_instansi,s.kecamatan_instansi,s.telp_instansi,s.telp2_instansi,s.atas_nama,s.alamat_atas_nama,s.keterangan,s.lokasi,s.pembayaran,s.diskon,s.status,s.prioritas,s.id_marketing');
        $this->datatables->from('spk_report s');
        if($tanggal != '') {
            $this->datatables->where('s.tgl_spk', $tanggal);
        }
        if($id_marketing != '') {
            $this->datatables->where('s.id_marketing', $id_marketing);
        }
        $this->datatables->where('s.id_kantor', $kantor_id->id_kantor);
        $this->datatables->add_column('action', anchor(site_url('admin/spk_report/read/$1'),'<button type="button" class="btn btn-minier btn-success"><i class="ace-icon fa fa-check icon-only bigger-110"></i></button>')."&nbsp;".anchor(site_url('admin/spk_report/update/$1'),'<button type="button" class="btn btn-minier btn-info"><i class="ace-icon fa fa-pencil icon-only bigger-110"></i></button>')."&nbsp;".anchor(site_url('admin/spk_report/delete/$1'),'<button type="button" class="btn btn-minier btn-danger"><i class="ace-icon fa fa-trash icon-only bigger-110"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
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
    	$this->db->or_like('tgl_spk', $q);
    	$this->db->or_like('nama', $q);
    	$this->db->or_like('alamat', $q);
    	$this->db->or_like('no_spk', $q);
    	$this->db->or_like('telp', $q);
    	$this->db->or_like('type', $q);
    	$this->db->or_like('warna', $q);
    	$this->db->or_like('nama_stnk', $q);
    	$this->db->or_like('pembayaran', $q);
    	$this->db->or_like('ket_pembayaran', $q);
    	$this->db->or_like('diskon', $q);
    	$this->db->or_like('pekerjaan', $q);
    	$this->db->or_like('keterangan', $q);
    	$this->db->or_like('status', $q);
    	$this->db->or_like('id_marketing', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
    	$this->db->or_like('tgl_spk', $q);
    	$this->db->or_like('nama', $q);
    	$this->db->or_like('alamat', $q);
    	$this->db->or_like('no_spk', $q);
    	$this->db->or_like('telp', $q);
    	$this->db->or_like('type', $q);
    	$this->db->or_like('warna', $q);
    	$this->db->or_like('nama_stnk', $q);
    	$this->db->or_like('pembayaran', $q);
    	$this->db->or_like('ket_pembayaran', $q);
    	$this->db->or_like('diskon', $q);
    	$this->db->or_like('pekerjaan', $q);
    	$this->db->or_like('keterangan', $q);
    	$this->db->or_like('status', $q);
    	$this->db->or_like('id_marketing', $q);
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

/* End of file Spk_report_model.php */
/* Location: ./application/models/Spk_report_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-23 05:03:28 */
/* http://harviacode.com */