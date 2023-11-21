<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->hari = array(
            1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );
        $this->bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
    }

    private function _get_libur_periode($startFg, $endFg)
    {
        $this->db->select('CONCAT(tahun, "-", (IF(LENGTH(bulan) = 1, CONCAT("0", bulan), bulan))) AS thn_bln, hari_libur');
        $this->db->from('hari_kerja');
        $this->db->where('hari_libur IS NOT NULL AND hari_libur!=""');
        $this->db->where('DATE(CONCAT(tahun, "-", (IF(LENGTH(bulan) = 1, CONCAT("0", bulan), bulan)), "-01")) BETWEEN "' . $startFg . '" AND "' . $endFg . '"');
        $res = $this->db->get()->result();
        $list_data_libur = [];
        foreach ($res as $key) :
            $exlibur = explode(",", $key->hari_libur);
            foreach ($exlibur as $hari) :
                if (!empty($hari)) {
                    $fgd = $key->thn_bln . '-' . sprintf('%02d', $hari);
                    $list_data_libur[$fgd] = '1';
                }
            endforeach;
        endforeach;
        return $list_data_libur;
    }


    public function get_total_laporan_by_periode()
    {
        $this->api->head();
        $this->load->model('Status_kerja_model');

        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Tanggal mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal selesai', 'trim|required');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id_user = $this->input->post('id_user');
        $id_pegawai = $this->input->post('id_pegawai');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $total_masuk = $this->db->where('id_users', $id_user)->where('(DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) BETWEEN "' . $start_date . '" AND "' . $end_date . '")')->where_in('status', [1, 2])->get('jam_kerja')->num_rows();
        $total_pulang = $this->db->where('id_users', $id_user)->where('(DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) BETWEEN "' . $start_date . '" AND "' . $end_date . '")')->where('status', 2)->get('jam_kerja')->num_rows();
        $total_izin = $this->db->where('id_users', $id_user)->where('(tgl BETWEEN "' . $start_date . '" AND "' . $end_date . '")')->where('tidak_masuk', 1)->get('tidak_masuk')->num_rows();
        $total_sakit = $this->db->where('id_users', $id_user)->where('(tgl BETWEEN "' . $start_date . '" AND "' . $end_date . '")')->where('tidak_masuk', 2)->get('tidak_masuk')->num_rows();
        $total_wfh = $this->db->where('id_users', $id_user)->where('(tgl BETWEEN "' . $start_date . '" AND "' . $end_date . '")')->where('tidak_masuk', 4)->get('tidak_masuk')->num_rows();
        $total_tugas = $this->db->where('id_pegawai', $id_pegawai)->where('(DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) BETWEEN "' . $start_date . '" AND "' . $end_date . '")')->get('upload_tugas')->num_rows();

        $row_total_active = $this->Status_kerja_model->get_total_active_by_periode($id_user, $start_date, $end_date);
        $total_jam_wfh = $row_total_active->total;

        $res = [
            'period_start' => $start_date,
            'period_end' => $end_date,
            'total_masuk' => $total_masuk,
            'total_pulang' => $total_pulang,
            'total_izin' => $total_izin,
            'total_sakit' => $total_sakit,
            'total_wfh' => $total_wfh,
            // 'total_wfh' => $total_jam_wfh,
            'total_tugas' => $total_tugas,
        ];

        $this->api->result("ok", $res, "Total laporan");
    }

    private function _get_list_upload_by_periode($id_pegawai, $fdate_start, $fdate_end)
    {
        $this->db->select('ut.id, ut.tgl, t.judul, t.tugas, t.progress, ut.ket, ut.file, ut.waktu, t.selesai, IF(ut.file IS NOT NULL OR ut.file != "", CONCAT("' . site_url() . 'assets/tugas/upload/",ut.file), "") AS url_file');
        $this->db->from('upload_tugas ut');
        $this->db->join('tugas t', 'ut.id_tugas=t.id');
        $this->db->where('ut.id_pegawai', $id_pegawai);
        $this->db->where('(DATE(CONCAT(SUBSTRING(ut.tgl,7,4),"-",SUBSTRING(ut.tgl,4,2),"-",SUBSTRING(ut.tgl,1,2))) BETWEEN "' . $fdate_start . '" AND "' . $fdate_end . '")');
        return $this->db->get()->result();
    }

    private function _get_list_upload_by_waktu($id_pegawai, $waktu, $sdate)
    {
        $this->db->select('ut.id, t.judul, ut.ket, ut.file, t.tugas, t.selesai, IF(ut.file IS NOT NULL OR ut.file != "", CONCAT("' . site_url() . 'assets/tugas/upload/",ut.file), "") AS url_file');
        $this->db->from('upload_tugas ut');
        $this->db->join('tugas t', 'ut.id_tugas=t.id');
        $this->db->where('ut.id_pegawai', $id_pegawai);
        $this->db->where('ut.waktu', $waktu);
        $this->db->where('ut.tgl', $sdate);
        $this->db->where('t.tanggungan!=', 1);
        return $this->db->get()->result();
    }

    private function _get_list_upload_tanggungan_by_waktu($id_pegawai, $sdate)
    {
        $this->db->select('ut.id, t.judul, ut.ket, ut.file, t.tugas, t.selesai, IF(ut.file IS NOT NULL OR ut.file != "", CONCAT("' . site_url() . 'assets/tugas/upload/",ut.file), "") AS url_file');
        $this->db->from('upload_tugas ut');
        $this->db->join('tugas t', 'ut.id_tugas=t.id');
        $this->db->where('ut.id_pegawai', $id_pegawai);
        $this->db->where('ut.tgl', $sdate);
        $this->db->where('t.tanggungan', 1);
        return $this->db->get()->result();
    }


    public function get_list_by_periode()
    {
        $this->api->head();

        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Tanggal mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal selesai', 'trim|required');
        $this->form_validation->set_rules('page', 'Halaman', 'trim|required');
        $this->form_validation->set_rules('limit', 'Limit', 'trim|required');
        $this->form_validation->set_rules('sort', 'Sort', 'trim|required');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id_user = $this->input->post('id_user');
        $id_pegawai = $this->input->post('id_pegawai');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $page = $this->input->post('page') * 1;
        $limit = $this->input->post('limit') * 1;
        $sort = strtolower($this->input->post('sort'));

        $res = $this->_get_data_main($id_user, $id_pegawai, $start_date, $end_date, $page, $limit, $sort);

        $this->api->result("ok", $res, "List laporan");
    }


    public function sample_list()
    {

        $id_user = 1;
        $id_pegawai = 1;
        $start_date = "2023-05-01";
        $end_date = "2023-05-30";
        $page = 1;
        $limit = 30;
        $sort = 'asc'; // asc | desc

        $res = $this->_get_data_main($id_user, $id_pegawai, $start_date, $end_date, $page, $limit, $sort);

        echo "<pre>";
        print_r(json_encode($res, JSON_PRETTY_PRINT));
        echo "</pre>";
    }

    private function _get_data_main($id_user, $id_pegawai, $start_date, $end_date, $page, $limit, $sort)
    {
        $time_start = microtime(true);

        if (empty($page)) {
            $this->api->result("error", [], "Halaman harus diisi");
            return;
        }

        if (strtotime($start_date) > strtotime($end_date)) {
            $this->api->result("error", [], "Format periode salah");
            return;
        }

        $tgl1 = strtotime($start_date);
        $tgl2 = strtotime($end_date);
        $jarak = $tgl2 - $tgl1;
        $total_hari = ceil($jarak / 60 / 60 / 24) + 1;

        $offset = ($page == 1) ? 0 : (($page * $limit) - $limit);

        if ($total_hari > 1) {
            $total_page = ceil($total_hari / $limit);
        } else {
            $total_page = 1;
        }

        if ($page > $total_page) {
            $this->api->result("error", [], "Halaman tidak ada");
            return;
        }

        if ($sort == 'asc') {
            $strtotime_begin_date = strtotime("+" . $offset . " day", strtotime($start_date));
        } else {
            $strtotime_begin_date = strtotime("-" . $offset . " day", strtotime($end_date));
        }

        $now = date('Y-m-d');
        $strtotime_now = strtotime($now);

        $pstartdate2 = null;
        $penddate2 = null;
        $rdates = [];
        for ($idf = 0; $idf < $limit; $idf++) {
            if ($sort == 'asc') {
                $strtotime_begin2 = strtotime("+" . $idf . " day", $strtotime_begin_date);
                if ($strtotime_begin2 > strtotime($end_date)) {
                    break;
                }
            } else {
                $strtotime_begin2 = strtotime("-" . $idf . " day", $strtotime_begin_date);
                if ($strtotime_begin2 < strtotime($start_date)) {
                    break;
                }
            }
            $rdates[] = $strtotime_begin2;
            if ($idf == 0) {
                $pstartdate2 = date('Y-m-d', $strtotime_begin2);
            }
            $penddate2 = date('Y-m-d', $strtotime_begin2);
        }
        if ($sort == 'desc') {
            $pstartdate = $penddate2;
            $penddate = $pstartdate2;
        } else {
            $pstartdate = $pstartdate2;
            $penddate = $penddate2;
        }

        $list_libur = $this->_get_libur_periode(date('Y-m-01', strtotime($pstartdate)), date('Y-m-01', strtotime($penddate)));

        $list_jam_kerja = [];
        $this->db->select('*, DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) AS rtgl');
        $this->db->where('id_users', $id_user);
        $this->db->where("DATE(CONCAT(SUBSTRING(tgl,7,4),'-',SUBSTRING(tgl,4,2),'-',SUBSTRING(tgl,1,2))) BETWEEN '" . $pstartdate . "' AND '" . $penddate . "'");
        $this->db->order_by('id', 'DESC');
        $res_jam_kerja = $this->db->get('jam_kerja')->result();
        foreach ($res_jam_kerja as $row_jk) :
            $list_jam_kerja[$row_jk->rtgl] = $row_jk;
        endforeach;

        $list_tidak_masuk = [];
        $this->db->where('id_users', $id_user);
        $this->db->where('tgl BETWEEN "' . $pstartdate . '" AND "' . $penddate . '"');
        $res_tidak_masuk = $this->db->get('tidak_masuk')->result();
        foreach ($res_tidak_masuk as $row_tm) :
            $list_tidak_masuk[$row_tm->tgl] = $row_tm;
        endforeach;

        $list_upload_pagi = [];
        $list_upload_siang = [];
        $list_upload_tanggungan = [];
        $list_upload = $this->_get_list_upload_by_periode($id_pegawai, $pstartdate, $penddate);
        foreach ($list_upload as $row_up) :
            // if ($row_up->tanggungan == "1") {
            //     $list_upload_tanggungan[$row_up->tgl][] = $row_up;
            // } else {
            if ($row_up->waktu == "1") {
                $list_upload_pagi[$row_up->tgl][] = $row_up;
            }
            if ($row_up->waktu == "2") {
                $list_upload_siang[$row_up->tgl][] = $row_up;
            }
        // }
        endforeach;

        $data = [];
        foreach ($rdates as $strtotime_begin) :
            $fdate = date('Y-m-d', $strtotime_begin);
            $ddate = date('d-m-Y', $strtotime_begin);

            $is_holiday = 0;
            $holiday_description = "";
            $day_num = date('N', $strtotime_begin);
            if ($day_num == 7) {
                $is_holiday = 1;
            }
            if (!empty($list_libur[$fdate])) {
                $is_holiday = 1;
            }

            $status = 0;
            $jam_masuk = '';
            $jam_pulang = '';
            if (!empty($list_jam_kerja[$fdate])) {
                $row_jam_kerja = $list_jam_kerja[$fdate];
                $status = $row_jam_kerja->status * 1;
                $jam_masuk = substr($row_jam_kerja->jam_masuk, 0, 5);
                $jam_pulang = substr($row_jam_kerja->jam_pulang, 0, 5);
            }

            $is_wfh = 0;
            $status_tidak_masuk = 0;
            if (!empty($list_tidak_masuk[$fdate])) {
                $row_tidak_masuk = $list_tidak_masuk[$fdate];
                if ($row_tidak_masuk->tidak_masuk == "4") {
                    $is_wfh = 1;
                }
                $status_tidak_masuk = $row_tidak_masuk->tidak_masuk * 1;
            }

            $day = date('d', $strtotime_begin);

            $is_divider_first_month = 0;
            $is_divider_last_month = 0;
            if ($day == date('t', $strtotime_begin)) {
                $is_divider_last_month = 1;
            }
            if ($day == '01') {
                $is_divider_first_month = 1;
            }

            $slist_upload_pagi = [];
            if (!empty($list_upload_pagi[$ddate])) {
                sort($list_upload_pagi[$ddate]);
                $slist_upload_pagi = $list_upload_pagi[$ddate];
            }
            $slist_upload_siang = [];
            if (!empty($list_upload_siang[$ddate])) {
                sort($list_upload_siang[$ddate]);
                $slist_upload_siang = $list_upload_siang[$ddate];
            }
            $slist_upload_tanggungan = [];
            if (!empty($list_upload_tanggungan[$ddate])) {
                sort($list_upload_tanggungan[$ddate]);
                $slist_upload_tanggungan = $list_upload_tanggungan[$ddate];
            }

            $data[] = (object) [
                'tgl' => $fdate,
                'day' => $day,
                'month' => date('m', $strtotime_begin),
                'year' => date('Y', $strtotime_begin),
                'text_day' => $this->hari[$day_num],
                'text_month' => $this->bulan[date('m', $strtotime_begin) * 1],
                'is_divider_first_month' => $is_divider_first_month,
                'is_divider_last_month' => $is_divider_last_month,
                'date_is_more' => $strtotime_begin > $strtotime_now ? 1 : 0,
                'date_is_now' => $fdate == $now ? 1 : 0,
                'date_is_less' => $strtotime_begin < $strtotime_now ? 1 : 0,
                'is_holiday' => $is_holiday,
                'holiday_description' => $holiday_description,
                'status' => $status,
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
                'status_tidak_masuk' => $status_tidak_masuk,
                'is_wfh' => $is_wfh,
                'list_upload_pagi' => $slist_upload_pagi,
                'list_upload_siang' => $slist_upload_siang,
                'list_upload_tanggungan' => $slist_upload_tanggungan,
            ];
        endforeach;

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);

        $res = [
            'execution_time' => $execution_time,
            'page' => $page,
            'limit' => $limit,
            'sort' => $sort,
            'period_start' => $start_date,
            'period_end' => $end_date,
            'page_period_start' => $pstartdate,
            'page_period_end' => $penddate,
            'total_page' => $total_page,
            'total_day' => $total_hari,
            'offset' => $offset,
            'now' => date('Y-m-d H:i'),
            'data' => $data,
            'isLast' => $page >= $total_page ? 1 : 0,
        ];

        return $res;
    }


    public function get_tugas_belum_selesai()
    {
        $this->api->head('application/json', false);

        $id_pegawai = $this->input->post("id_pegawai");

        $row = $this->db->where('id_pegawai', $id_pegawai)->where('selesai', 0)->get('tugas')->result();

        if ($row) {
            $this->api->result("ok", $row, "Berhasil mendapatkan tugas.");
        } else {
            print_r($this->db->error());
            $this->api->result("error", [], "Gagal mendapatkan tugas.");
        }
    }
}
