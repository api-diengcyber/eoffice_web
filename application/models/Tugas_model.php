<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tugas_model extends CI_Model
{

    public $table = 'tugas';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($id_pegawai = '', $bulan = '', $tahun = '' , $status = '') {


        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();


        $this->datatables->select('t.id, t.judul,t.progress as progress, t.id_pegawai,t.is_update, t.tgl, t.tugas, t.upload, t.tgl_selesai, t.selesai, p.nama_pegawai , pj.project as project');
        $this->datatables->from('tugas AS t');
        //add this line for join
        $this->datatables->join('project AS pj', 't.id_project = pj.id' , 'left');
        $this->datatables->join('pegawai AS p', 't.id_pegawai = p.id');
        $this->datatables->join('users AS u', 'u.id=p.id_users');
        $this->datatables->where('u.id!=',  $user_id);
        $this->datatables->where('u.id_kantor',  $kantor_id->id_kantor);
        // where
        if ($id_pegawai!='semua') {
            $this->datatables->where('t.id_pegawai', $id_pegawai);
        }
        if ($bulan!='semua') {
            $this->datatables->where('SUBSTRING(t.tgl,4,2) = "'.sprintf('%02d', $bulan).'"');
        }
        if ($tahun!='semua') {
            $this->datatables->where('SUBSTRING(t.tgl,7,4) = "'.$tahun.'"');
        }
        if ($status!='semua') {
            if($status == 1){
                $this->datatables->where('t.selesai', 1);
            }else if($status == 2){
                $this->datatables->where('t.selesai', 0);
            }else if($status == 3){
                $this->datatables->where('t.progress',100);
                $this->datatables->where('t.selesai', 0);
            }
        }
        // column
        $this->db->order_by('is_update','desc');
        $this->datatables->add_column('action', anchor(site_url('admin/tugas/read/$1'),'<button class="btn btn-xs btn-success"><i class="ace-icon fa fa-check bigger-120"></i></button>')."&nbsp;&nbsp;".anchor(site_url('admin/tugas/update/$1'),'<button class="btn btn-xs btn-info"><i class="ace-icon fa fa-pencil bigger-120"></i></button>')."&nbsp;&nbsp;".anchor(site_url('admin/tugas/delete/$1'),'<button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }
    function get_by_peg($id)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->where('selesai', 0);
        $this->db->order_by('priority', 'desc');
        return $this->db->get('tugas')->result();
    }
    function get_upload_by_id($id_pegawai = '', $ba = '', $bulan = ''){
        
        $this->db->select('*');
        $this->db->from('upload_tugas as ut');
        $this->db->join('tugas as t', 'ut.id_tugas = t.id');
        
        $this->db->where('ut.id_pegawai', $id_pegawai);
        if (!empty($bulan)) {
            $this->db->where('SUBSTRING(ut.tgl,4,2) = ' . $bulan);
        }else{
            $this->db->where('ut.tgl', date('d-m-Y'));
            
        }
        $this->db->where('ut.waktu', $ba);
        $this->db->limit(5);
        $this->db->order_by('ut.id', 'desc');

        $result = $this->db->get()->result();

        
        return $result;
    }
    function get_by_id_peg($id,$tgl='',$status='')
    {
        $this->db->where('id_pegawai', $id);
        $this->db->order_by('priority', 'desc');

        if(!empty($waktu)){
            $this->db->where('waktu', $waktu);
        }
        if(!empty($tgl)){
            $this->db->where('tgl', $tgl);
        }
        if($status == 0){
            $this->db->where('selesai', 0);
            //$this->db->where('progress < 100');
        }

        $result = $this->db->get('tugas', 5, 0)->result();
        $data = array();
        foreach ($result as $v) {
            $data[] = (object)array('id'=>$v->id,
                                    'tanggal'=>$v->tgl,
                                    'judul'=>$v->judul,
                                    'selesai'=>$v->selesai,
                                    'upload'=>$v->upload,
                                    'progress'=>$v->progress,
                                    'tgl'=>$v->tgl,
                                    'tgl_selesai'=>$v->tgl_selesai,
                                    'tugas'=>$v->tugas,
                                    'detail'=>$this->get_upload_tugas($v->id),
                                    );
        }
        return $data;
    }
        function get_upload_tugas($id)
        {   
            $this->db->where('id_tugas', $id);
            $result = $this->db->get('upload_tugas')->result();
            $data = 0;
            foreach ($result as $r) {
                $data += $this->get_message_tugas($r->id);
            }
            return $data;
        }
        function get_message_tugas($id)
        {
            $this->db->where('id_upload_tugas', $id);
            $this->db->where('id_user', null);
            $this->db->where('status', 0); // not read yet
            $result = $this->db->get('message_tugas')->result();

            $total = 0;
            foreach ($result as $r) {
                if($r->status == 0){
                    $total += 1;
                }
            }
            return $total;
        }
        /*
    function get_tugas_pagi($tgl,$waktu){
        $this->db->where('tgl', $tgl);
        $this->db->where('waktu', $waktu);
        return $this->db->get('tugas')->result();
    }
    */
    function get_laporan_today($id){
        $this->db->where('id_pegawai', $id);
        $this->db->where('tgl',date('d-m-Y'));
        $data = $this->db->get('upload_tugas')->result();

        $pagi  = 0; //laporan pagi
        $siang = 0; //laporan siang
        foreach ($data as $lap) {
            if($lap->waktu == 1){
                $pagi  = 1;
            }else if($lap->waktu == 2){
                $siang = 1;
            }
        }
        if($pagi == 1 && $siang == 1){
            return 2; //pagi dan siang sudah upload laporan
        }else if($pagi == 1 && $siang == 0){
            return 1; //baru upload laporan pagi
        }else{
            return 0; //belum upload laporan
        }
    }
    
    function get_rekap_tugas($tahun='',$bulan='',$hari='',$id_pegawai=''){
        $this->load->model('Pegawai_model');
        $output = array();
        if(!empty($id_pegawai)){
            $data_pegawai = $this->Pegawai_model->get_by_id($id_pegawai);
            $data_tugas = $this->get_data_rekap($data_pegawai->id,$tahun,$bulan,$hari);
            $output[] = (object)array(
                            'nama_pegawai'=>$data_pegawai->nama_pegawai,
                            'data_tugas'=>$data_tugas,
                        );
        }else{
            $data_pegawai = $this->Pegawai_model->get_pegawai_aktif();
            $output = array();
            foreach ($data_pegawai as $dp) {
                $data_tugas = $this->get_data_rekap($dp->id,$tahun,$bulan,$hari);
                $output[] = (object)array(
                            'nama_pegawai'=>$dp->nama_pegawai,
                            'data_tugas'=>$data_tugas,
                        );
            }
        }

        return $output;
    }
        function get_data_rekap($id,$tahun,$bulan,$hari){
            $this->db->select('*');
            $this->db->from('tugas as t');
            $this->db->where('t.id_pegawai', $id);
            if(!empty($bulan)){
            $this->db->where('SUBSTRING(tgl,4,2) = '.$bulan);
            }
            if(!empty($tahun)){
            $this->db->where('RIGHT(tgl,4) ='.$tahun);
            }
            if($hari != 'semua'){
            $this->db->where('LEFT(tgl,2) = '.$hari);
            }
            $this->db->group_by('tgl');
            $this->db->order_by('tgl', 'desc');
            $result = $this->db->get('')->result();
            $output = array();
            foreach ($result as $r) {
                $output[] = (object)array(
                            'tgl'=>$r->tgl,
                            'data_tugas'=>$this->_get_by_tgl($r->tgl,$r->id_pegawai),
                        );
            }
            return $output;
        }
            function _get_by_tgl($tgl,$id){
                $this->db->select('*,t.id as id');
                $this->db->from('tugas as t');
                $this->db->join('project as p', 't.id_project = p.id', 'left');
                $this->db->where('t.tgl', $tgl);
                $this->db->where('t.id_pegawai', $id);
                return $this->db->get('')->result();
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
    	$this->db->or_like('tugas', $q);
    	$this->db->or_like('tgl_selesai', $q);
    	$this->db->or_like('selesai', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
    	$this->db->or_like('tgl', $q);
    	$this->db->or_like('tugas', $q);
    	$this->db->or_like('tgl_selesai', $q);
    	$this->db->or_like('selesai', $q);
    	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
    function get_upload_tugas_today($id, $waktu)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->where('tgl', date('d-m-Y'));
        $this->db->where('waktu', $waktu);
        $data = $this->db->get('upload_tugas')->row();
        if (!$data) {
            return 0;
        }
        return 1;
    }

    function get_count_upload_tugas_today($id, $waktu)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->where('tgl', date('d-m-Y'));
        $this->db->where('waktu', $waktu);
        $data = $this->db->get('upload_tugas')->num_rows();
        return $data;
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

/* End of file Tugas_model.php */
/* Location: ./application/models/Tugas_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-04 03:39:43 */
/* http://harviacode.com */