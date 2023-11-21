<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    public $table = 'gaji_perbulan';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->model('Default_tp_model');
        $this->jam_kerja = 7;
        $this->min_jam_kerja = 5;
    }

    // datatables
    function json($id_pegawai = '', $bulan = '', $tahun = '')
    {

        
        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();


        $this->datatables->select('g.id, g.bonus_gaji , g.keterangan_bonus, g.id_bulan, g.id_pegawai, g.gaji_pokok, g.hk, g.masuk, g.transport, g.gaji_kotor, g.pot_absen, g.gaji_bersih, p.nama_pegawai');
        $this->datatables->from('gaji_perbulan AS g');
        //add this line for join
        $this->datatables->join('pegawai AS p', 'g.id_pegawai = p.id');
        $this->datatables->join('users AS u', 'u.id = p.id_users');
        $this->datatables->where('u.id_kantor', $kantor_id->id_kantor);
        // where
        if ($id_pegawai != 'semua') {
            $this->datatables->where('g.id_pegawai', $id_pegawai);
        }
        if (!empty($bulan)) {
            $this->datatables->where('SUBSTRING(g.id_bulan,1,2)', sprintf('%02d', $bulan));
        }
        if (!empty($tahun)) {
            $this->datatables->where('RIGHT(g.id_bulan,4)', $tahun);
        }
        $this->db->order_by('g.id_pegawai', 'asc');
        // column
        return $this->datatables->generate();
    }
    function get_laporan_periode($id_pegawai = '', $start = '', $end = '')
    {
        $exstart = explode("-", $start);
        $start_h = $exstart[0];
        $start_m = !empty($exstart[1]) ? $exstart[1] : date('m');
        $start_y = !empty($exstart[2]) ? $exstart[2] : date('Y');
        $zstart = $start_y . "-" . $start_m . "-" . $start_h;
        $exend = explode("-", $end);
        $end_h = $exend[0];
        $end_m = !empty($exend[1]) ? $exend[1] : date('m');
        $end_y = !empty($exend[2]) ? $exend[2] : date('Y');
        $zend = $end_y . "-" . $end_m . "-" . $end_h;
        $this->load->model('Pegawai_model');
        $output = array();
        if (!empty($id_pegawai) && $id_pegawai != 'SEMUA') {
            $data = $this->Pegawai_model->get_by_id($id_pegawai);
            $output[] = (object) array(
                'id' => $data->id,
                'id_users' => $data->id_users,
                'nama' => $data->nama_pegawai,
                'id_jabatan' => $data->id_jabatan,
                'laporan' => $this->_get_wrap_upload_tugas_periode($id_pegawai, $zstart, $zend),
            );
        } else {
            $data = $this->Pegawai_model->get_pegawai_aktif();
            foreach ($data as $d) {
                $output[] = (object) array(
                    'id' => $d->id,
                    'id_users' => $d->id_users,
                    'nama' => $d->nama_pegawai,
                    'id_jabatan' => $d->id_jabatan,
                    'laporan' => $this->_get_wrap_upload_tugas_periode($d->id, $zstart, $zend),
                );
            }
        }
        return $output;
    }
    function _get_wrap_upload_tugas_periode($id_pegawai, $zstart, $zend)
    {
        $this->db->select('');
        $this->db->from('upload_tugas');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) BETWEEN "' . $zstart . '" AND "' . $zend . '"');
        $this->db->group_by('tgl');
        $data = $this->db->get()->result();
        $output  = array();
        foreach ($data as $dt) {
            $tahun = substr($dt->tgl, -4);
            $bulan = substr($dt->tgl, 3, 2);
            $hari = substr($dt->tgl, 0, 2);
            $output[]  = (object) array(
                'tgl' => $dt->tgl,
                'pagi' => $this->_get_upload_tugas($tahun, $bulan, $hari, $id_pegawai, 1),
                'siang' => $this->_get_upload_tugas($tahun, $bulan, $hari, $id_pegawai, 2)
            );
        }
        return $output;
    }

    /*
    function get_all_gajian($bulan_tahun)
    {
        $this->db->select('gp.id as id,gp.bonus_gaji,gp.keterangan_bonus,gp.masuk,gp.id_pegawai,gp.id_bulan,gp.gaji_pokok as gaji_pokok,p.jabatan,p.nama_pegawai');
        $this->db->from('gaji_perbulan as gp');
        $this->db->join('pegawai as p', 'p.id = gp.id_pegawai');
        $this->db->where('gp.id_bulan', $bulan_tahun);
        $this->db->group_by('gp.id_pegawai');
        $gp = $this->db->get('gaji_perbulan')->result();
        $hari_masuk = $this->db->where('bulan = left("'.$bulan_tahun.'",2)')->where('tahun = right("'.$bulan_tahun.'",4)')->get('hari_kerja')->row()->hari_masuk;

        $detail = array();
        $exp = explode('-', $bulan_tahun);
        $tahun_bulan = $exp[1].'-'.$exp[0];
        foreach ($gp as $g) {
            //$tidak_masuk = $hari_masuk - $g->masuk;
            $tidak_masuk = $this->_tidak_masuk($tahun_bulan,$g->id_pegawai);
            $pot_absen   = $g->gaji_pokok / $hari_masuk * $tidak_masuk;
            $detail[] = (object) array(
                        'bonus_gaji'=>$g->bonus_gaji,
                        'keterangan_bonus'=>$g->keterangan_bonus,
                        'bulan_tahun'=>$bulan_tahun,
                        'nama_pegawai'=>$g->nama_pegawai,
                        'gaji_pokok'=>$g->gaji_pokok,
                        'jabatan'=>$g->jabatan,
                        'hari_aktif'=>$hari_masuk,
                        'masuk'=>$g->masuk,
                        'tidak_masuk'=>$tidak_masuk,
                        'pot_absen'=>$pot_absen,
                        'potongan'=>$this->get_potongan($g->id_pegawai,$g->id_bulan),
                        'tunjangan'=>$this->get_tunjangan($g->id_pegawai,$g->id_bulan)
                    );
        }
        return $detail;
    }
    */
    function get_laporan_harian($tahun = '', $bulan = '', $hari = '', $id_pegawai = '', $waktu = '')
    {
        $this->load->model('Pegawai_model');
        $output = array();
        if (!empty($id_pegawai) && $id_pegawai != 'SEMUA') {
            $data = $this->Pegawai_model->get_by_id($id_pegawai);
            $output[] = (object) array(
                'id' => $data->id,
                'id_users' => $data->id_users,
                'nama' => $data->nama_pegawai,
                'laporan_pagi' => $this->_get_upload_tugas($tahun, $bulan, $hari, $id_pegawai, 1),
                'laporan_siang' => $this->_get_upload_tugas($tahun, $bulan, $hari, $id_pegawai, 2)
            );
        } else {
            $data = $this->Pegawai_model->get_pegawai_aktif();
            foreach ($data as $d) {
                $output[] = (object) array(
                    'id' => $d->id,
                    'id_users' => $d->id_users,
                    'nama' => $d->nama_pegawai,
                    'laporan_pagi' => $this->_get_upload_tugas($tahun, $bulan, $hari, $d->id, 1),
                    'laporan_siang' => $this->_get_upload_tugas($tahun, $bulan, $hari, $d->id, 2)
                );
            }
        }
        return $output;
    }
    function _get_upload_tugas($tahun, $bulan, $hari, $id_pegawai = '', $waktu = '')
    {
        $this->db->select('ut.*,t.judul,t.tugas');
        $this->db->from('upload_tugas ut');
        if (!empty($bulan)) {
            $this->db->where('SUBSTRING(ut.tgl,4,2) = ' . $bulan);
        }
        if (!empty($tahun)) {
            $this->db->where('RIGHT(ut.tgl,4) =' . $tahun);
        }
        if ($hari != 'SEMUA' && $hari != 'semua') {
            $this->db->where('LEFT(ut.tgl,2) = ' . $hari);
        }
        if (!empty($waktu)) {
            $this->db->where('ut.waktu', $waktu);
        }
        $this->db->where('ut.id_pegawai', $id_pegawai);
        $this->db->join('tugas t', 't.id = ut.id_tugas');
        return $this->db->get()->result();
    }
    function get_gajian_pegawai($bulan_tahun)
    {
        // $this->load->model('Pegawai_model');
        // //$pegawai = $this->Pegawai_model->get_pegawai();
        // $pegawai = $this->db->where('level > 0')->get('pegawai')->result();
        // $arr = [];
        // foreach ($pegawai as $p) {
        //     $arr['id_pegawai'][$p->id] = $this->get_gaji_by_id($p,$bulan_tahun);
        // }
        // return $arr;   
    }
    function get_gaji_by_id($data_pegawai, $bulan_tahun)
    {
        // loading model
        $this->load->model('Pil_jabatan_model');


        //data pegawai
        $id = $data_pegawai->id;
        $nama_pegawai = $data_pegawai->nama_pegawai;
        $data_jabatan = $this->Pil_jabatan_model->get_by_id($data_pegawai->id_jabatan);
        $jabatan = (!empty($data_jabatan)) ? $data_jabatan->jabatan : 'Belum ada jabatan';

        $this->load->model('Pegawai_model');
        $this->load->model('Default_tp_model');
        $exp = explode('-', $bulan_tahun);
        $tahun = $exp[1];
        $bulan = $exp[0];

        //get hari aktif
        //$this->db->where('bulan', $bulan);
        //$this->db->where('tahun', $tahun);
        $hari_aktif = 25; //$this->db->get('hari_kerja')->row()->hari_masuk;

        $data_pegawai = $this->Pegawai_model->get_by_id($id);

        $gaji_pokok   = $data_pegawai->gaji_pokok;
        $gaji_perhari = $gaji_pokok / $hari_aktif;


        $tunjangan   = $this->_tunjangan($id, $bulan_tahun, $data_pegawai->id_level);
        $tidak_masuk = $this->_tidak_masuk($bulan . '-' . $tahun, $id);
        $masuk       = $hari_aktif - $tidak_masuk;

        //potongan
        $potongan    = $this->_potongan($id, $bulan_tahun, $data_pegawai->id_level);
        $potongan_tidak_masuk = $gaji_perhari * $tidak_masuk;
        $potongan_absen  = $this->_potongan_absen($bulan_tahun, $id, $gaji_pokok);
        $potongan_absen_total = $potongan_tidak_masuk + $potongan_absen;
        $total_potongan  = $potongan + $potongan_absen + $potongan_tidak_masuk;
        //

        $default_tunjangan = $this->Default_tp_model->_total_def_tunjangan($data_pegawai->id_level); //default total tunjangan
        $default_potongan  = $this->Default_tp_model->_total_def_potongan($data_pegawai->id_level);  //default total potongan
        $data_potongan  = $this->get_potongan($id, $bulan_tahun);
        $data_tunjangan = $this->get_tunjangan($id, $bulan_tahun);

        //bonus
        $ggp = $this->get_gaji_perbulan($id, $bulan_tahun);
        if (!empty($get_gaji_perbulan)) {
            $bonus_gaji = $ggp->bonus_gaji;
            $keterangan_bonus = $ggp->keterangan_bonus;
        } else {
            $bonus_gaji = 0;
            $keterangan_bonus = '';
        }

        //data gaji
        $gaji_kotor  = $gaji_pokok + $tunjangan;
        $gaji_bersih = $gaji_kotor - $total_potongan;
        //data
        $data = array(
            'bulan_tahun' => $bulan_tahun,
            'hari_aktif' => $hari_aktif,
            'nama_pegawai' => $nama_pegawai,
            'jabatan' => $jabatan,
            'gaji_pokok' => $gaji_pokok,
            'gaji_kotor' => $gaji_kotor,
            'gaji_bersih' => $gaji_bersih,
            'bonus_gaji' => $bonus_gaji,
            'keterangan_bonus' => $keterangan_bonus,
            'masuk' => $masuk,
            'potongan' => $potongan,
            'potongan_absen' => $potongan_absen_total,
            'potongan_absen_telat' => $potongan_absen,
            'potongan_tidak_masuk' => $potongan_tidak_masuk,
            'tunjangan' => $tunjangan,
            'tidak_masuk' => $tidak_masuk,
            'data_potongan' => $data_potongan,
            'data_tunjangan' => $data_tunjangan,
            'default_tunjangan' => $default_tunjangan,
            'default_potongan' => $default_potongan,
            'level' => $data_pegawai->id_level,
        );
        return $data;
    }
    function get_gaji_perbulan($id, $bulan)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->where('id_bulan', $bulan);
        return $this->db->get('gaji_perbulan')->row();
    }
    function get_potongan($id, $bulan)
    {
        $this->db->select('p.*,pp.nama_potongan');
        $this->db->from('potongan as p');
        $this->db->join('pil_potongan as pp', 'pp.id = p.id_potongan');
        $this->db->where('id_pegawai', $id);
        $this->db->where('bulan_tahun', $bulan);
        return $this->db->get()->result();
    }
    function get_tunjangan($id, $bulan)
    {
        $this->db->select('t.*,pt.nama_tunjangan');
        $this->db->from('tunjangan as t');
        $this->db->join('pil_tunjangan as pt', 'pt.id = t.id_tunjangan');
        $this->db->where('id_pegawai', $id);
        $this->db->where('bulan_tahun', $bulan);
        return $this->db->get()->result();
    }

    function get_potongan_bulan($bulan)
    {
        $pegawai = $this->db->where('level > 0')->get('pegawai')->result();
        $arr = array();
        foreach ($pegawai as $p) {
            $arr[] = $this->_potongan($p->id, $bulan, $p->level);
        }
        return $arr;
    }
    function _potongan($id, $bulan, $level)
    {
        $pot = $this->db->where('id_pegawai', $id)->where('bulan_tahun', $bulan)->get('potongan')->result();
        if (!empty($pot)) {
            $arr = $this->Default_tp_model->_total_def_potongan($level);
            foreach ($pot as $p) {
                $arr += $p->nominal;
            }
            return $arr;
        } else {
            return $this->Default_tp_model->_total_def_potongan($level);
        }
    }
    function get_tunjangan_bulan($bulan)
    {
        $pegawai = $this->db->where('level > 0')->get('pegawai')->result();
        $arr = array();
        foreach ($pegawai as $p) {
            $arr[] = $this->_tunjangan($p->id, $bulan, $p->level);
        }
        return $arr;
    }
    function _tunjangan($id, $bulan, $level)
    {
        $tunj = $this->db->where('id_pegawai', $id)->where('bulan_tahun', $bulan)->get('tunjangan')->result();
        if (!empty($tunj)) {
            $arr = $this->Default_tp_model->_total_def_tunjangan($level);
            foreach ($tunj as $p) {
                $arr += $p->nominal;
            }
            return $arr;
        } else {
            return $this->Default_tp_model->_total_def_tunjangan($level);
        }
    }
    function get_tidak_masuk($bulan_tahun)
    {
        $pegawai = $this->db->where('level > 0')->get('pegawai')->result();
        $arr = array();
        foreach ($pegawai as $p) {
            $arr[] = $this->_tidak_masuk($bulan_tahun, $p->id);
        }
        return $arr;
    }
    function _tidak_masuk($bulan_tahun, $id)
    {
        $this->db->where('"' . $bulan_tahun . '" = right(tgl,7)');
        $this->db->where('id_users', $id);
        $tm = $this->db->get('tidak_masuk')->result();
        if (!empty($tm)) {
            return count($tm);
        } else {
            return 0;
        }
    }
    function get_potongan_absen($bulan_tahun)
    {
        $pegawai = $this->db->where('level > 0')->get('pegawai')->result();
        $arr = array();
        foreach ($pegawai as $p) {
            $arr[] = $this->_potongan_absen($bulan_tahun, $p->id, $p->gaji_pokok);
        }
        return $arr;
    }
    function _potongan_absen($bulan_tahun, $id, $gaji_pokok)
    {
        // reusabble variable
        $exp   = explode('-', $bulan_tahun);
        $tahun = $exp[1];
        $bulan = $exp[0];
        $tahun_bulan = $tahun . '-' . $bulan;
        $potongan_absen = 0;

        //get hari aktif
        /*$this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $hari_aktif = $this->db->get('hari_kerja')->row()->hari_masuk;
            */
        $hari_aktif = 25;

        //data gaji
        $gaji_perhari = $gaji_pokok / $hari_aktif;
        $gaji_perjam  = $gaji_perhari / $this->jam_kerja; //jam minimal masuk

        $this->db->where('"' . $bulan_tahun . '" = right(tgl,7)');
        $this->db->where('id_users', $id);
        $result = $this->db->get('jam_kerja')->result();
        foreach ($result as $dt) {
            $start = new \DateTime($dt->tgl . ' ' . $dt->jam_masuk);
            $end   = new \DateTime($dt->tgl . ' ' . $dt->jam_pulang);

            $interval  = $end->diff($start);
            $jam_masuk = $interval->h;

            $pot_absen = $gaji_perhari - ($jam_masuk * $gaji_perjam);

            if ($jam_masuk < $this->jam_kerja and $jam_masuk > ($this->min_jam_kerja - 1)) {
                $potongan_absen += $pot_absen;
            } else if ($jam_masuk < $this->min_jam_kerja) {
                $potongan_absen += $gaji_perhari; // jika jam masuk kurang dari minimal jam kerja;
            } else if ($jam_masuk > $this->jam_kerja || $jam_masuk == $this->jam_kerja) {
                $potongan_absen += 0;
            }
        }
        return $potongan_absen;
    }
}

/* End of file Hari_kerja_model.php */
/* Location: ./application/models/Hari_kerja_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-30 05:50:21 */
/* http://harviacode.com */
