<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daily_sales_report_model extends CI_Model
{

    public $table = 'daily_sales_report';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json_marketing($id_users) { 
        $this->datatables->select('d.id,d.tgl,d.tgl_kunjungan,d.nama_instansi,d.alamat_instansi,d.kelurahan_instansi,d.kecamatan_instansi,d.telp_instansi,d.telp2_instansi,d.atas_nama,d.alamat_atas_nama,d.keterangan,d.lokasi,d.status,d.prioritas,d.id_marketing, IF((SELECT id FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing) > 0, (SELECT id FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing), 0) AS id_spk, IF((SELECT tgl FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing) != "", (SELECT tgl_spk FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing), "-") AS tgl_spk');
        $this->datatables->from('daily_sales_report AS d');
        $this->datatables->join('(SELECT MAX(id) AS id FROM daily_sales_report GROUP BY nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi) md', 'd.id = md.id');
        $this->datatables->where('id_marketing', $id_users);
        $this->datatables->add_column('action', anchor(site_url('marketing/daily_sales_report/read/$1'),'<button type="button" class="btn btn-minier btn-success">LIHAT DATA</button>'), 'id');
        $this->db->group_by('d.telp_instansi, d.telp2_instansi, d.nama_instansi, d.id_marketing');
        $this->db->order_by('d.id', 'DESC');
        return $this->datatables->generate();
    }
    function json_training($id_users) { 
        $this->datatables->select('d.id,d.tgl,d.tgl_kunjungan,d.nama_instansi,d.alamat_instansi,d.kelurahan_instansi,d.kecamatan_instansi,d.telp_instansi,d.telp2_instansi,d.atas_nama,d.alamat_atas_nama,d.keterangan,d.lokasi,d.status,d.prioritas,d.id_marketing, IF((SELECT id FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing) > 0, (SELECT id FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing), 0) AS id_spk, IF((SELECT tgl FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing) != "", (SELECT tgl_spk FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing), "-") AS tgl_spk');
        $this->datatables->from('daily_sales_report AS d');
        $this->datatables->join('(SELECT MAX(id) AS id FROM daily_sales_report GROUP BY nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi) md', 'd.id = md.id');
        $this->datatables->where('id_marketing', $id_users);
        $this->datatables->add_column('action', anchor(site_url('training/daily_sales_report/read/$1'),'<button type="button" class="btn btn-minier btn-success">LIHAT DATA</button>'), 'id');
        $this->db->group_by('d.telp_instansi, d.telp2_instansi, d.nama_instansi, d.id_marketing');
        $this->db->order_by('d.id', 'DESC');
        return $this->datatables->generate();
    }

    // datatables
    function json_admin($pil_tanggal = '', $tanggal = '', $id_marketing = '') {
        $this->datatables->select('d.id,d.tgl,d.tgl_kunjungan,d.nama_instansi,d.alamat_instansi,d.kelurahan_instansi,d.kecamatan_instansi,d.telp_instansi,d.telp2_instansi,d.atas_nama,d.alamat_atas_nama,d.keterangan,d.lokasi,d.status,d.prioritas,d.id_marketing, IF((SELECT id FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing) > 0, (SELECT id FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing), 0) AS id_spk, IF((SELECT tgl FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing) != "", (SELECT tgl_spk FROM spk_report WHERE nama_instansi=d.nama_instansi AND alamat_instansi=d.alamat_instansi AND kelurahan_instansi=d.kelurahan_instansi AND kecamatan_instansi=d.kecamatan_instansi AND telp_instansi=d.telp_instansi AND telp2_instansi=d.telp2_instansi AND id_marketing=d.id_marketing), "-") AS tgl_spk');
        $this->datatables->from('daily_sales_report AS d');
        $this->datatables->join('(SELECT MAX(id) AS id FROM daily_sales_report GROUP BY nama_instansi,alamat_instansi,kelurahan_instansi,kecamatan_instansi,telp_instansi,telp2_instansi) md', 'd.id = md.id');
        if ($pil_tanggal == '1') {
            $this->datatables->where('d.tgl_kunjungan', $tanggal);
        } else if ($pil_tanggal == '2') {
            $extanggal = explode("%20-%20", $tanggal);
            $extanggal_awal = explode("-", $extanggal[0]);
            $extanggal_akhir = explode("-", $extanggal[1]);
            $stgl_awal = $extanggal_awal[2].'-'.$extanggal_awal[1].'-'.$extanggal_awal[0];
            $stgl_akhir = $extanggal_akhir[2].'-'.$extanggal_akhir[1].'-'.$extanggal_akhir[0];
            $this->datatables->where("DATE(CONCAT(SUBSTRING(d.tgl_kunjungan,7,4),'-',SUBSTRING(d.tgl_kunjungan,4,2),'-',SUBSTRING(d.tgl_kunjungan,1,2))) BETWEEN '".$stgl_awal."' AND '".$stgl_akhir."'");
        }
        if (!empty($id_marketing)) {
            $this->datatables->where('id_marketing', $id_marketing);
        }
        $this->datatables->add_column('action', anchor(site_url('admin/daily_sales_report/read/$1'),'<button type="button" class="btn btn-minier btn-success"><i class="ace-icon fa fa-check icon-only bigger-110"></i></button>')."&nbsp;".anchor(site_url('admin/daily_sales_report/delete/$1'),'<button type="button" class="btn btn-minier btn-danger"><i class="ace-icon fa fa-trash icon-only bigger-110"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        $this->db->group_by('d.telp_instansi, d.telp2_instansi, d.nama_instansi, d.id_marketing');
        $this->db->order_by('d.id', 'DESC');
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

/* End of file Daily_sales_report_model.php */
/* Location: ./application/models/Daily_sales_report_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-23 05:03:03 */
/* http://harviacode.com */