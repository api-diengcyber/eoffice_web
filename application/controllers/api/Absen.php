<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{
    private $kantors_id;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->load->model('Tugas_model');
        $this->load->model('Tidak_masuk_model');
        $this->kantors_id = 'Nilai Variabel Global';
    }

    public function in()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
        $this->form_validation->set_rules('ip_address', 'IP Address ', 'trim|required');
        $this->form_validation->set_rules('lokasi_masuk', 'Lokasi ', 'trim|required');
        $tgl = date('d-m-Y');

        if ($this->form_validation->run() === TRUE) {

            $id_user = $this->input->post('id_user');
            $id_pegawai = $this->input->post('id_pegawai');
            $ip_address = $this->input->post('ip_address');
            $lokasi_masuk = $this->input->post("lokasi_masuk");
            $is_foto = !empty($_FILES['foto_masuk']['name']);

            $hybrid_wfh = 0;
            $row_pegawai = $this->db->where('id', $id_pegawai)->get('pegawai')->row();
            if ($row_pegawai) {
                $hybrid_wfh = $row_pegawai->wfh * 1;
            }

            // cek monitor work service transmisions screen
            if ($row_pegawai->monitor == "1") {
                $row_status_kerja = $this->db->where('LEFT(created_on,10)=', date('Y-m-d'))->where('id_user', $id_user)->order_by('id', 'desc')->get('status_kerja')->row();
                if ($row_status_kerja) {
                    if ($row_status_kerja->status != "1") {
                        $this->api->result('error', [], "KETERANGAN\n\nSilahkan start work terlebih dahulu untuk mulai bekerja.");
                        return;
                    }
                } else {
                    $this->api->result('error', [], "KETERANGAN\n\nSilahkan start work terlebih dahulu untuk mulai bekerja.");
                    return;
                }
            }

            // cek wfh
            $this->db->where('tgl', date('Y-m-d'));
            $this->db->where('id_users', $id_user);
            $this->db->where('tidak_masuk', 4);
            $row = $this->db->get('tidak_masuk')->row();
            if (!$row) {
                // jika bukan wfh
                if ($hybrid_wfh == 1) {
                    if ($lokasi_masuk == "Tidak dapat mengetahui Lokasi") {
                        $this->api->result('error', [], "Tidak dapat mengetahui Lokasi");
                        return;
                    }
                } else {
                    if (strpos($lokasi_masuk, "Tangan angie") > -1) { } else {
                        $this->api->result('error', [], "Lokasi tidak diketahui, silahkan update aplikasi :)");
                        return;
                    }
                }
            } else {
                if ($lokasi_masuk == "Tidak dapat mengetahui Lokasi") {
                    $this->api->result('error', [], "Tidak dapat mengetahui Lokasi");
                    return;
                }
            }

            $nama_foto = '';

            if (!$is_foto) {
                $this->api->result('error', [], "Tidak ada foto");
                return;
            }
            $config['upload_path'] = 'assets/absen/upload';
            $config['allowed_types'] = 'png|gif|jpg';
            $config['max_size'] = '1500';
            $this->load->library("upload", $config);

            if ($this->upload->do_upload('foto_masuk')) {
                $nama_foto = $this->upload->data()['file_name'];
            } else {
                $this->api->result('error', $this->upload->display_errors(), "Foto gagal diupload");
                return;
            }

            $row = $this->db->select('*')
                ->from('jam_kerja')
                ->where('id_users', $id_user)
                ->where('tgl', $tgl)
                ->order_by('id', 'DESC')
                ->get()->row();
            if ($row) {
                $this->api->result('error', [], "Anda sudah masuk hari ini!");
            } else {
                $jam_masuk = date('H:i:s');

                $data_masuk = array(
                    'tgl' => date('d-m-Y'),
                    'id_users' => $id_user,
                    'jam_masuk' => $jam_masuk,
                    'ip_address' => $ip_address,
                    'lokasi_masuk' => $lokasi_masuk,
                    'foto_masuk' => $nama_foto,
                    'status' => "1",
                );
                $q = $this->db->insert('jam_kerja', $data_masuk);

                if ($q) {
                    $row_jam_kerja = $this->db->get('jam_kerja_aktif')->row();
                    $start_dt = new \DateTime(date('d-m-Y') . ' ' . $jam_masuk);
                    $end_dt   = new \DateTime(date('d-m-Y') . ' ' . $row_jam_kerja->jam_masuk);
                    $interval  = $end_dt->diff($start_dt);
                    $jam_kerja = $interval->format('%r%h');
                    $menit_kerja = $interval->format('%r%i');

                    $late = false;
                    $info = "";
                    if ($jam_kerja > 0 && $menit_kerja > 0) {
                        $late = true;
                        $info = 'Terlambat: ' . $jam_kerja . ' Jam, ' . $menit_kerja . ' Menit';
                    } else if ($jam_kerja <= 0 && $menit_kerja > 0) {
                        $late = true;
                        $info = 'Terlambat: ' . $menit_kerja . ' Menit';
                    } else if ($jam_kerja > 0 && $menit_kerja <= 0) {
                        $late = true;
                        $info = 'Terlambat: ' . $jam_kerja . ' Jam';
                    }

                    $this->api->result(
                        'ok',
                        array(
                            'insert_id' => $this->db->insert_id(),
                            'info' => $info,
                            'late' => $late,
                        ),
                        "Berhasil masuk hari ini"
                    );
                    return;
                } else {
                    $this->api->result(
                        'error',
                        $this->db->error(),
                        "Gagal masuk hari ini"
                    );
                    return;
                }
            }
        } else {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
        }
    }


    public function out()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
        $this->form_validation->set_rules('ip_address', 'IP Address ', 'trim|required');
        $this->form_validation->set_rules('lokasi_keluar', 'Lokasi ', 'trim|required');
        $tgl = date('d-m-Y');

        if ($this->form_validation->run() === TRUE) {
            $id_user = $this->input->post('id_user');
            $id_pegawai = $this->input->post('id_pegawai');
            $ip_address = $this->input->post('ip_address');
            $lokasi_pulang = $this->input->post("lokasi_keluar");
            $is_foto = !empty($_FILES['foto_keluar']['name']);

            $hybrid_wfh = 0;
            $row_pegawai = $this->db->where('id', $id_pegawai)->get('pegawai')->row();
            if ($row_pegawai) {
                $hybrid_wfh = $row_pegawai->wfh * 1;
            }

            // cek monitor work service transmisions screen
            if ($row_pegawai->monitor == "1") {
                $row_status_kerja = $this->db->where('LEFT(created_on,10)=', date('Y-m-d'))->where('id_user', $id_user)->order_by('id', 'desc')->get('status_kerja')->row();
                if ($row_status_kerja) {
                    if ($row_status_kerja->status != "1") {
                        $this->api->result('error', [], "KETERANGAN\n\nSilahkan start work terlebih dahulu untuk mulai bekerja.");
                        return;
                    }
                } else {
                    $this->api->result('error', [], "KETERANGAN\n\nSilahkan start work terlebih dahulu untuk mulai bekerja.");
                    return;
                }
            }

            // cek wfh
            $this->db->where('tgl', date('Y-m-d'));
            $this->db->where('id_users', $id_user);
            $this->db->where('tidak_masuk', 4);
            $row = $this->db->get('tidak_masuk')->row();
            if (!$row) {
                // jika bukan wfh
                if ($hybrid_wfh == 1) {
                    if ($lokasi_pulang == "Tidak dapat mengetahui Lokasi") {
                        $this->api->result('error', [], "Tidak dapat mengetahui Lokasi");
                        return;
                    }
                } else {
                    if (strpos($lokasi_pulang, "Tangan angie") > -1) { } else {
                        $this->api->result('error', [], "Lokasi tidak diketahui, silahkan update aplikasi :)");
                        return;
                    }
                }
            } else {
                if ($lokasi_pulang == "Tidak dapat mengetahui Lokasi") {
                    $this->api->result('error', [], "Tidak dapat mengetahui Lokasi");
                    return;
                }
            }

            $tugas = $this->Tugas_model->get_laporan_today($id_pegawai);
            if ($tugas != 1 && $tugas != 2) {
                $this->api->result('error', [], "Harap Upload Laporan Pagi & Siang!");
                return;
            }

            $nama_foto = '';

            if (!$is_foto) {
                $this->api->result('error', [], "Tidak ada foto");
                return;
            }
            $config['upload_path'] = 'assets/absen/upload';
            $config['allowed_types'] = 'png|gif|jpg';
            $config['max_size'] = '1500';
            $this->load->library("upload", $config);

            if ($this->upload->do_upload('foto_keluar')) {
                $nama_foto = $this->upload->data()['file_name'];
            } else {
                $this->api->result('error', $this->upload->display_errors(), "Foto gagal diupload");
                return;
            }

            $row = $this->db->select('*')
                ->from('jam_kerja')
                ->where('id_users', $id_user)
                ->where('tgl', date('d-m-Y'))
                //->where('status', '1')
                ->order_by('id', 'DESC')
                ->get()->row();
            if ($row) {
                $data_pulang = array(
                    'tgl' => $tgl,
                    'jam_pulang' => date('H:i:s'),
                    'lokasi_pulang' => $lokasi_pulang,
                    'foto_pulang' => $nama_foto,
                    'status' => '2',
                );
                $this->db->where('id', $row->id);
                $q = $this->db->update('jam_kerja', $data_pulang);

                if ($q) {
                    $this->api->result(
                        'ok',
                        array(
                            'insert_id' => $this->db->insert_id(),
                            'info' => '',
                            'late' => false,
                        ),
                        "Berhasil Absen Pulang"
                    );
                    return;
                } else {
                    $this->api->result(
                        'error',
                        [],
                        "Gagal Absen Pulang"
                    );
                }
            } else {
                $this->api->result('error', [], "Anda belum masuk hari ini!");
            }
        } else {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
        }
    }


    public function get_status()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal ', 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $id_user = $this->input->post('id_user');
            $id_pegawai = $this->input->post('id_pegawai');
            $tgl = $this->input->post('tgl');

            $this->db->where('id_users', $id_user);
            $this->db->where('tgl', $tgl);
            $this->db->order_by('id', 'DESC');
            $res = $this->db->get('jam_kerja')->row();

            $tugas = $this->Tugas_model->get_laporan_today($id_pegawai);

            if ($res) {
                $this->api->result("ok", [
                    'status' => $res->status,
                    'tugas' => $tugas,
                ], '');
            } else {
                $this->api->result("ok", [
                    'status' => 0,
                    'tugas' => $tugas,
                ], '');
            }
        } else {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
        }
    }


    public function list_by_tgl()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal ', 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $id_user = $this->input->post('id_user');
            $id_pegawai = $this->input->post('id_pegawai');
            $tgl = $this->input->post('tgl');

            $this->db->where('id_users', $id_user);
            $this->db->where('tgl', $tgl);
            $res = $this->db->get('jam_kerja')->result();

            $this->api->result('ok', $res, "GET DATA HARI");
        } else {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
        }
    }

    //     public function list_by_bulan()
    //     {
    //         $this->api->head();
    // 		$this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
    // 		$this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
    // 		$this->form_validation->set_rules('tgl', 'Tanggal ', 'trim|required');

    //         if ($this->form_validation->run() === TRUE){

    //             $id_user = $this->input->post('id_user');
    //             $id_pegawai = $this->input->post('id_pegawai');
    //             $tgl = $this->input->post('tgl');

    //             $this->db->where('id_users', $id_user);
    //             $this->db->where('RIGHT(tgl,7)=', substr($tgl,3,7));
    //             $res = $this->db->get('jam_kerja')->result();

    //             $this->api->result('ok', $res, "GET DATA BULAN");

    // 		} else {
    //             $this->api->result('error', $this->form_validation->error_array(), validation_errors());
    //         }
    //     }


    public function list_by_bulan()
    {
        $this->api->head('text/html', false);


        $id_user = $this->input->post('id_user');
        $id_pegawai = $this->input->post('id_pegawai');
        $tgl = $this->input->post('tgl', true);

        $this->db->where('id_users', $id_user);
        $this->db->where('RIGHT(tgl,7)=', substr($tgl, 3, 7));
        $res = $this->db->get('jam_kerja')->result();

        $data_ar = array(
            'data' => $res,
        );
        $this->load->view('absen_harian', $data_ar);
    }


    public function submit_wfh()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
        $this->form_validation->set_rules('lokasi', 'Lokasi ', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal ', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan ', 'trim|required');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        if (empty($_FILES['foto']['name'])) {
            $this->api->result('error', [], "Tidak ada foto");
            return;
        }

        $tanggal = $this->input->post("tanggal");
        $id_user = $this->input->post('id_user');

        $tgl1 = strtotime(date("Y-m-d"));
        $tgl2 = strtotime($tanggal);
        $jarak = $tgl2 - $tgl1;
        $hari = $jarak / 60 / 60 / 24;
        if ($hari < 0) {
            $this->api->result("error", [], "Tanggal tidak sesuai");
            return;
        }

        $this->db->where('tgl', $tanggal);
        $this->db->where('id_users', $id_user);
        $this->db->where('tidak_masuk', 4);
        $row = $this->db->get('tidak_masuk')->row();
        if ($row) {
            $this->api->result("error", [], "Anda sudah WFH hari ini");
            return;
        }

        $rTanggal = date('d-m-Y', strtotime($tanggal));

        $row_absen = $this->db->select('*')
            ->from('jam_kerja')
            ->where('tgl', $rTanggal)
            ->where('id_users', $id_user)
            ->where_in('status', [1, 2])
            ->get()->row();
        if ($row_absen) {
            // $this->api->result("error", [], "Permohonan WFH dibatalkan, Anda sudah melakukan presensi bukan WFH");
            // return;
        }

        $config['upload_path'] = 'assets/tidak_masuk';
        $config['allowed_types'] = 'png|gif|jpg|jpeg';
        $config['max_size'] = '1500';
        $this->load->library("upload", $config);
        if (!$this->upload->do_upload('foto')) {
            $this->api->result('error', $this->upload->display_errors(), "Foto gagal diupload");
            return;
        }

        $id_pegawai = $this->input->post('id_pegawai');
        $lokasi = $this->input->post("lokasi");
        $keterangan = $this->input->post('keterangan');
        $nama_foto = $this->upload->data()['file_name'];

        $this->db->where('tgl', $tanggal);
        $this->db->where('id_users', $id_user);
        $row_t = $this->db->get('tidak_masuk')->row();
        if ($row_t) {
            $data_up = array(
                'tidak_masuk' => 4,
                'keterangan' => $lokasi . '#' . $keterangan,
                'surat_ijin' => $nama_foto,
            );
            $this->db->where('id', $row_t->id);
            $this->db->update('tidak_masuk', $data_up);
        } else {
            $data_insert = array(
                'tgl' => $tanggal,
                'id_users' => $id_user,
                'tidak_masuk' => 4,
                'keterangan' => $lokasi . '#' . $keterangan,
                'surat_ijin' => $nama_foto,
            );
            $this->db->insert('tidak_masuk', $data_insert);
        }

        $this->api->result("ok", [], "Berhasil izin");
        return;
    }


    public function cek_tgl()
    {
        $tgl1 = strtotime(date("Y-m-d"));
        $tgl2 = strtotime("2023-04-12");
        $jarak = $tgl2 - $tgl1;
        $hari = $jarak / 60 / 60 / 24;
        echo $hari;
    }


    public function tidak_masuk()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'trim|required');
        $this->form_validation->set_rules('status', 'Status ', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan ', 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $id_user = $this->input->post('id_user');
            $id_pegawai = $this->input->post('id_pegawai');
            $status = $this->input->post('status');
            $keterangan = $this->input->post('keterangan');
            $tgl = $this->input->post("tgl");

            $tgl1 = strtotime(date("Y-m-d"));
            $tgl2 = strtotime($tgl);
            $jarak = $tgl2 - $tgl1;
            $hari = $jarak / 60 / 60 / 24;
            if ($hari < 0) {
                $this->api->result("error", [], "Tanggal tidak sesuai");
                return;
            }

            $row = $this->db->select("*")->from("tidak_masuk")->where("tgl", $tgl)->where('id_users', $id_user)->get()->row();

            $is_foto = !empty($_FILES['surat_ijin']['name']);

            $nama_foto = '';

            if (!$is_foto) {
                $this->api->result('error', [], "Tidak ada surat ijin");
                return;
            }
            $config['upload_path'] = 'assets/tidak_masuk';
            $config['allowed_types'] = 'png|gif|jpg|jpeg';
            $config['max_size'] = '1500';
            $this->load->library("upload", $config);

            if ($this->upload->do_upload('surat_ijin')) {
                $nama_foto = $this->upload->data()['file_name'];
            } else {
                $this->api->result('error', $this->upload->display_errors(), "Foto gagal diupload");
                return;
            }

            if ($row) {
                $this->api->result("error", [], "Anda sudah izin hari ini");
                return;
            }

            $tglAbsen = date('d-m-Y', strtotime($tgl));

            $row_absen = $this->db->select('*')
                ->from('jam_kerja')
                ->where('tgl', $tglAbsen)
                ->where('id_users', $id_user)
                ->get()->row();

            if ($row_absen) {
                $is_foto = !empty($_FILES['foto_keluar']['name']);
                $lokasi_pulang = $this->input->post("lokasi_keluar");

                $nama_foto = '';

                if (!$is_foto) {
                    $this->api->result('error', [], "Tidak ada foto");
                    return;
                }
                $config['upload_path'] = 'assets/absen/upload';
                $config['allowed_types'] = 'png|gif|jpg';
                $config['max_size'] = '1500';
                $this->load->library("upload", $config);

                if ($this->upload->do_upload('foto_keluar')) {
                    $nama_foto = $this->upload->data()['file_name'];
                } else {
                    $this->api->result('error', $this->upload->display_errors(), "Foto gagal diupload");
                    return;
                }
                $data_pulang = array(
                    'tgl' => $tglAbsen,
                    'jam_pulang' => date('H:i:s'),
                    'lokasi_pulang' => $lokasi_pulang,
                    'foto_pulang' => $nama_foto,
                    'status' => '2',
                );
                $this->db->where('id', $row_absen->id);
                $qPulang = $this->db->update('jam_kerja', $data_pulang);
                if (!$qPulang) {
                    $this->api->result("error", [], "Gagal Izin");
                    return;
                }
            }

            $this->db->where('tgl', $tgl);
            $this->db->where('id_users', $id_user);
            $row_t = $this->db->get('tidak_masuk')->row();
            if ($row_t) {
                $data_up = array(
                    'tidak_masuk' => $status,
                    'keterangan' => $keterangan,
                    'surat_ijin' => $nama_foto,
                );
                $this->db->where('id', $row_t->id);
                $this->db->update('tidak_masuk', $data_up);

                $this->api->result("ok", [], "Berhasil izin");
                return;
            } else {
                $data_insert = array(
                    'tgl' => $tgl,
                    'id_users' => $id_user,
                    'tidak_masuk' => $status,
                    'keterangan' => $keterangan,
                    'surat_ijin' => $nama_foto,
                );
                $q = $this->db->insert('tidak_masuk', $data_insert);
                if ($q) {
                    $this->api->result("ok", [], "Berhasil izin");
                    return;
                } else {
                    $this->api->result("error", [], "Gagal izin");
                    return;
                }
            }
        } else {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
        }
    }


    public function info()
    {
        $this->api->head();

        $id_user = $this->input->post('id_user');

        $row_user = $this->db->where('id', $id_user)->get('users')->row();

        $row = $this->db->where("id_kantor", $row_user->id_kantor)->get("info")->row();
        if ($row) {
            $this->api->result("ok", $row, "");
        } else {
            $this->api->result("error", [], "");
        }
    }

    function tanggal_indo($tanggal, $cetak_hari = false)
    {
        $hari = array(
            1 =>    'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );

        $bulan = array(
            1 =>   'Januari',
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
        $split       = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }


    public function info_user()
    {
        $this->api->head();


        $this->form_validation->set_rules('id_user', 'ID User', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result("error", [], "");
            return;
        }

        $id_user = $this->input->post('id_user', true);
        $id_pegawai = $this->input->post('id_pegawai');
        $row = $this->db->where('id', $id_user)->get('users')->row();
        $row_pegawai = $this->db->where('id', $id_pegawai)->get('pegawai')->row();
        $this->kantors_id = $row->id_kantor;


        $kt = $this->db->select("lat,long")
            ->from("kantor_lokasi")
            ->where("id_kantor", $row->id_kantor)
            ->get()
            ->row();

        // $certificate = 1;
        // $certificate_url = 'https://www.diengcyber.com';
        // $row_pegawai = $this->db->where('id', $id_pegawai)->get('pegawai')->row();
        // if ($row_pegawai) {
        //     $certificate = $row_pegawai->id_sertifikat * 1;
        // }

        $tugas_pagi = $this->Tugas_model->get_count_upload_tugas_today($id_pegawai, 1);
        $tugas_siang = $this->Tugas_model->get_count_upload_tugas_today($id_pegawai, 2);

        $this->db->where('id_users', $id_user);
        $this->db->where('tgl', date('d-m-Y'));
        $this->db->order_by('id', 'DESC');
        $row_jam_kerja = $this->db->get('jam_kerja')->row();
        $status = 0;
        if ($row_jam_kerja) {
            $status = $row_jam_kerja->status * 1;
        }

        $info_false_gps = "";
        $row_inf = $this->db->where("tujuan", 0)->where('id_kantor', $row->id_kantor)->get("info")->row();
        if ($row_inf) {
            $info_false_gps = $row_inf->info;
        }

        $jam = date('H') * 1;
        if ($jam < 12) {
            $greeting = 'Selamat pagi';
        } else if ($jam < 16) {
            $greeting = 'Selamat siang';
        } else if ($jam < 19) {
            $greeting = 'Selamat sore';
        } else if ($jam >= 19) {
            $greeting = 'Selamat malam';
        } else {
            $greeting = 'Selamat';
        }

        $is_wfh = 0;
        $status_tidak_masuk = 0;
        $this->db->where('id_users', $id_user);
        $this->db->where('tgl', date('Y-m-d'));
        $row_tidak_masuk = $this->db->get('tidak_masuk')->row();
        if ($row_tidak_masuk) {
            if ($row_tidak_masuk->tidak_masuk == "4") {
                $is_wfh = 1;
            }
            $status_tidak_masuk = $row_tidak_masuk->tidak_masuk * 1;
        }

        // $this->db->where('id_pegawai', $id_pegawai);
        // $this->db->where('tanggungan', 1);
        // $this->db->where('selesai!=', 1);
        // $count_tanggungan = $this->db->get('tugas')->num_rows();

        // $penilaian = 0;
        // $this->db->select('*');
        // $this->db->from('penilaian_training');
        // $this->db->where('id_users', $id_user);
        // $row_penilaian = $this->db->get()->row();
        // if ($row_penilaian) {
        //     $penilaian = 1;
        // }
        $this->load->model('Status_kerja_model');

        $row_total_active = $this->Status_kerja_model->get_total_active_by_tgl($id_user, date('d-m-Y'));
        $total_jam_wfh = $row_total_active->is_active ? $row_total_active->running_total : $row_total_active->total;
        $jam_aktif = $row_total_active->start_jam_kerja_aktif;

        if ($row) {
            // $latCek = -7.358130895877216;
            // $longCek = 109.90312842967987;
            $data = [
                'greeting' => $greeting . ", \n" . $row->username,
                'is_monitor' => $row_pegawai->monitor == "1",
                'text_status_wfh' => 'Status kerja: ' . ($row_total_active->is_active ? "Aktif" : "Tidak aktif") . ' ' . (!empty($jam_aktif) ? "(" . $jam_aktif . ")" : ""),
                'text_total_jam_kerja' => 'Total jam kerja hari ini: ' . $total_jam_wfh . ' jam',
                'str_time' => $this->tanggal_indo(date('Y-m-d'), true),
                'str_date_ymd' => date('Y-m-d'),
                'tugas_pagi' => $tugas_pagi > 0 ? 1 : 0,
                'tugas_siang' => $tugas_siang > 0 ? 1 : 0,
                'total_tugas_pagi' => $tugas_pagi,
                'total_tugas_siang' => $tugas_siang,
                'status' => $status,
                'info_false_gps' => $info_false_gps,
                'is_wfh' => $is_wfh,
                'hybrid' => $row_pegawai->hybrid,
                'wfh' => $row_pegawai->wfh,
                'status_tidak_masuk' => $status_tidak_masuk,
                // 'total_tanggungan' => $count_tanggungan * 1,
                // 'is_saturday' => date("D") == "Sat" ? 1 : 0,
                // 'certificate' => $certificate,
                // 'certificate_url' => $certificate_url,
                // 'penilaian' => $penilaian,
                'office_latitude' => (float) $kt->lat,
                'office_longitude' => (float) $kt->long,

                'office_max_distance' => 100,
            ];
            $this->api->result("ok", $data, "");
        } else {
            $this->api->result("error", [], "");
        }
    }
}
