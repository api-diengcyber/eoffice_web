<!DOCTYPE html>TANGAN ANGIE OFFICE

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>

    <style>
        * {

            word-wrap: break-word;

        }

        li {

            white-space: normal;

            max-width: 400px;

        }

        table {

            border-collapse: collapse;

        }

        th {

            padding: 2px;

        }

        td {

            padding: 2px;

        }

        /*

    table:first-child th {

        border: 1px solid black;

    }

    table:first-child td {

        border: 1px solid black;

    }*/

        @media print {

            .navbar {

                display: none !important;

            }

            .sidebar {

                display: none !important;

            }

            .footer {

                display: none;

            }

            * {

                background-color: white !important;

                color: black !important;

            }

            .no-print {

                display: none;

            }

            * {

                padding: 0px;

            }

            .card-body {

                padding: 0px !important;

            }

            .page-body-wrapper:not(.auth-page) {

                padding-top: 0px !important;

            }

        }
    </style>

</head>

<body>

    <?php

    $dayList = array(

        'Sun' => 'Minggu',

        'Mon' => 'Senin',

        'Tue' => 'Selasa',

        'Wed' => 'Rabu',

        'Thu' => 'Kamis',

        'Fri' => 'Jumat',

        'Sat' => 'Sabtu'

    );

    $monthList = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    $array1 = array();

    $array2 = array();

    $row_hari_libur_1 = $this->db->select('hari_libur')

        ->from('hari_kerja')

        ->where('tahun', $start_y)

        ->where('bulan', $start_m * 1)

        ->get()->row();

    if ($row_hari_libur_1) {

        $exlibur1 = explode(",", $row_hari_libur_1->hari_libur);

        foreach ($exlibur1 as $key) {

            if (!empty($key)) {
                $array1[$start_m * 1][$key * 1] = "libur";
            }
        }
    }

    $row_hari_libur_2 = $this->db->select('hari_libur')

        ->from('hari_kerja')

        ->where('tahun', $end_y)

        ->where('bulan', $end_m * 1)

        ->get()->row();

    if ($row_hari_libur_2) {

        $exlibur2 = explode(",", $row_hari_libur_2->hari_libur);

        foreach ($exlibur2 as $key) {

            if (!empty($key)) {
                $array2[$end_m * 1][$key * 1] = "libur";
            }
        }
    }

    $array_libur = array_replace_recursive($array1, $array2);

    foreach ($laporan as $l) :

        ?>

        <div style="float:left;">

            <table style="width:100%;">

                <thead>

                    <tr>

                        <td align="left" colspan="2" height="85" width="250" style="border:0px solid white;padding:10px;"><img src="<?php echo base_url() . 'assets/images/dc.png' ?>" style="width: 250px;"><br></td>

                        <td align="left" style="vertical-align:middle;padding-left:10px;border:0px solid white;"><b><?php echo $office_alamat ?></b></td>

                    </tr>

                    <tr>

                        <th width="100" align="left">Nama</th>

                        <td align="left"><?php echo $l->nama ?></td>

                        <td></td>

                    </tr>

                    <tr>

                        <th width="100" align="left">Periode</th>

                        <td align="left"><?php echo $start ?> - <?php echo $end ?></td>

                        <td></td>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td colspan="3">

                            <table border="1" style="width:100%;">

                                <thead>

                                    <tr style="font-weight: bold;background-color: green;color:white">

                                        <td width="30" align="center">NO</td>

                                        <td width="100" align="center">HARI, TGL</td>

                                        <td width="100" align="center">STATUS</td>

                                        <td width="150" align="center">MASUK</td>

                                        <td width="150" align="center">PULANG</td>

                                        <td width="100" align="center">KERJA</td>

                                        <td width="200" align="center">KETERANGAN</td>

                                        <td width="200" align="center">TUGAS 1</td>

                                        <td width="200" align="center">TUGAS 2</td>

                                        <td align="center">VERIFIKASI</td>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                        $no = 1;

                                        $total_hari = 0;

                                        $jml_masuk = 0;

                                        $jml_libur = 0;

                                        $tidak_sesuai_jam = 0;

                                        $tidak_laporan = 0;

                                        $terlambat = 0;

                                        $date = $start;

                                        $end_date = $end;

                                        $total_menit_telat = 0;

                                        $total_alpha = 0;

                                        $total_jam_kerja = 0;

                                        $rjam_kerja = $this->db->get('jam_kerja_aktif')->row();

                                        while (strtotime($date) <= strtotime($end_date)) :

                                            $str_date = strtotime($date);

                                            $day = date('D', $str_date);

                                            $dday = date('d', $str_date);

                                            $month = date('m', $str_date);

                                            $row_jam_kerja = $this->db->select('*')

                                                ->from('jam_kerja')

                                                ->where('id_users', $l->id_users)

                                                ->where('tgl', $date)

                                                ->get()->row();

                                            $ip = "";

                                            $jam_masuk = "";

                                            $jam_pulang = "";

                                            $lokasi_masuk = "";

                                            $lokasi_pulang = "";

                                            $keterangan = "Tidak masuk / Alpha";

                                            $tr_style = "background-color:red;color:black;";

                                            $hitung_masuk = 0;

                                            $status_new = '';

                                            if ($row_jam_kerja) {

                                                $tr_style = "";

                                                $keterangan = "Masuk";

                                                $ip = $row_jam_kerja->ip_address;

                                                $jam_masuk = $row_jam_kerja->jam_masuk;

                                                $jam_pulang = $row_jam_kerja->jam_pulang;

                                                $lokasi_masuk = $row_jam_kerja->lokasi_masuk;

                                                $lokasi_pulang = $row_jam_kerja->lokasi_pulang;

                                                if (empty($jam_pulang)) {

                                                    $tidak_laporan++;
                                                }

                                                $ket = "";

                                                if (!empty($row_jam_kerja->keterangan)) {

                                                    $ket = ", " . $row_jam_kerja->keterangan;
                                                }

                                                $keterangan .= $ket;

                                                $hitung_masuk = 1;
                                            }


                                            $row_wfh = $this->db->select('tm.*, ptm.ket_tidak_masuk')
                                                ->from('tidak_masuk tm')
                                                ->join('pil_tidak_masuk ptm', 'tm.tidak_masuk=ptm.id')
                                                ->where('tm.id_users', $l->id_users)
                                                ->where('tm.tidak_masuk', 4)
                                                ->where('tm.tgl', date('Y-m-d', strtotime($date)))
                                                ->get()->row();

                                            if ($row_wfh) {
                                                $status_new = 'WFH';
                                            } else {
                                                $status_new = 'OFFICE';
                                            }

                                            $row_tidak_masuk = $this->db->select('tm.*, ptm.ket_tidak_masuk')

                                                ->from('tidak_masuk tm')

                                                ->join('pil_tidak_masuk ptm', 'tm.tidak_masuk=ptm.id')

                                                ->where('tm.id_users', $l->id_users)
                                                ->where('tm.tidak_masuk !=', 4)

                                                ->where('tm.tgl', date('Y-m-d', strtotime($date)))

                                                ->get()->row();

                                            if ($row_tidak_masuk) {

                                                $ket = "";

                                                if (!empty($row_tidak_masuk->keterangan)) {

                                                    $ket = ", " . $row_tidak_masuk->keterangan;
                                                }

                                                $status_new = $row_tidak_masuk->ket_tidak_masuk;

                                                $keterangan = $row_tidak_masuk->ket_tidak_masuk . $ket;

                                                $tr_style = "background-color:yellow;";

                                                $hitung_masuk = 0;
                                            }

                                            if ($hitung_masuk == 1) {

                                                $jml_masuk++;
                                            }

                                            $res_upload_tugas_pagi = $this->db->select('ut.*, t.judul, t.tugas')

                                                ->from('upload_tugas ut')

                                                ->join('tugas t', 't.id=ut.id_tugas AND t.id_pegawai=ut.id_pegawai')

                                                ->where('ut.id_pegawai', $l->id)

                                                ->where('ut.tgl', $date)

                                                ->where('ut.waktu', 1)

                                                ->get()->result();

                                            $tugas_1 = "";

                                            foreach ($res_upload_tugas_pagi as $key_pagi) {

                                                $ket = "";

                                                if (!empty($key_pagi->ket)) {

                                                    $ket = " (" . $key_pagi->ket . ")";
                                                }

                                                //$tugas_1 = '<b>'.$key_pagi->judul.'</b>, '.substr($key_pagi->tugas,0,100).$ket."<br>";

                                                $tugas_1 .= '<b>' . $key_pagi->judul . '</b>, ' . $ket . "<br>";
                                            }

                                            $res_upload_tugas_siang = $this->db->select('ut.*, t.judul, t.tugas')

                                                ->from('upload_tugas ut')

                                                ->join('tugas t', 't.id=ut.id_tugas AND t.id_pegawai=ut.id_pegawai')

                                                ->where('ut.id_pegawai', $l->id)

                                                ->where('ut.tgl', $date)

                                                ->where('ut.waktu', 2)

                                                ->get()->result();

                                            $tugas_2 = "";

                                            foreach ($res_upload_tugas_siang as $key_siang) {

                                                $ket = "";

                                                if (!empty($key_siang->ket)) {

                                                    $ket = " (" . $key_siang->ket . ")";
                                                }

                                                //$tugas_2 = '<b>'.$key_siang->judul.'</b>, '.substr($key_siang->tugas,0,100).$ket."<br>";

                                                $tugas_2 .= '<b>' . $key_siang->judul . '</b>, ' . $ket . "<br>";
                                            }

                                            if (empty($tidak_libur)) {
                                                //sabtu tidak libur
                                                //     if ($l->id_jabatan=="4") {

                                                //         if ($day=="Sat") {

                                                //             $keterangan = "Libur";

                                                //             $tr_style = "background-color:black;color:white";

                                                //             $jml_libur++;

                                                //         }

                                                //     }

                                                if ($day == "Sun" || !empty($array_libur[$month * 1][$dday * 1])) {

                                                    $keterangan = "Libur";

                                                    $tr_style = "background-color:black;color:white";

                                                    $jml_libur++;
                                                }
                                            }

                                            $total_hari++;

                                            if ($jml_masuk < 0) {

                                                $jml_masuk = 0;
                                            }

                                            $jam_kerja = 0;

                                            if (!empty($jam_masuk) && !empty($jam_pulang)) {

                                                $start_dt = new \DateTime(date('d-m-Y', $str_date) . ' ' . $jam_masuk);

                                                $end_dt   = new \DateTime(date('d-m-Y', $str_date) . ' ' . $jam_pulang);

                                                $interval  = $end_dt->diff($start_dt);

                                                // if($interval->h>5){

                                                //     $interval->h = $interval->h-1;

                                                // }

                                                $jam_kerja = $interval->format('%h');

                                                $menit_kerja = $interval->format('%i');

                                                $dec_jam_kerja = (100 / 60) * $menit_kerja * 1;

                                                $jam_kerja = $jam_kerja;

                                                if ($dec_jam_kerja > 0) {

                                                    $jam_kerja .= "." . round($dec_jam_kerja);
                                                }

                                                $total_jam_kerja += floatval($jam_kerja);
                                            }

                                            ?>

                                        <tr style="<?php echo $tr_style ?>">

                                            <td align="center" style="vertical-align:middle;"><?php echo $no; ?></td>

                                            <td align="center" style="vertical-align:middle;"><?php echo $dayList[$day] . ", " . date('d-m-Y', $str_date) ?></td>

                                            <td align="center" style="vertical-align:middle;"><?php echo $status_new ?></td>

                                            <td align="center" style="vertical-align:middle;">

                                                <?php

                                                        echo $jam_masuk . '<br>(' . $lokasi_masuk . ')';

                                                        $start_dt = new \DateTime(date('d-m-Y') . ' ' . $jam_masuk);

                                                        $end_dt   = new \DateTime(date('d-m-Y') . ' ' . $rjam_kerja->jam_masuk);

                                                        $interval  = $end_dt->diff($start_dt);



                                                        $jms_kerja = $interval->format('%r%h');

                                                        $menit_kerja = $interval->format('%r%i');



                                                        if ($jms_kerja > 0 && $menit_kerja > 0) {

                                                            echo '<p class="mb-2" style="color:orange"><i class="fa fa-clock-o"></i> Terlambat: ' . $jms_kerja . ' Jam, ' . $menit_kerja . ' Menit</p>';
                                                        } else if ($jms_kerja <= 0 && $menit_kerja > 0) {

                                                            echo '<p class="mb-2" style="color:orange"><i class="fa fa-clock-o"></i> Terlambat: ' . $menit_kerja . ' Menit</p>';
                                                        } else if ($jms_kerja > 0 && $menit_kerja <= 0) {

                                                            echo '<p class="mb-2" style="color:orange"><i class="fa fa-clock-o"></i> Terlambat: ' . $jms_kerja . ' Jam</p>';
                                                        }



                                                        if ($jms_kerja > 0 || $menit_kerja > 0) {

                                                            $menit_jam = floor(($jms_kerja * 60 + $menit_kerja) / 5);

                                                            $total_menit_telat += $menit_jam;

                                                            $terlambat++;
                                                        }

                                                        ?>

                                            </td>

                                            <td align="center" style="vertical-align:middle;"><?php echo $jam_pulang . '<br>(' . $lokasi_pulang . ')' ?></td>

                                            <td align="center" style="vertical-align:middle;">

                                                <?php

                                                        $color = "";

                                                        if ($l->id_jabatan == "4") {

                                                            if ($jam_kerja * 1 < 6.5 && $jam_kerja != 0) {

                                                                $color = "red";

                                                                $tidak_sesuai_jam++;
                                                            }
                                                        } else {

                                                            if ($jam_kerja * 1 < 7.5 && $jam_kerja != 0) {

                                                                $color = "red";

                                                                $tidak_sesuai_jam++;
                                                            }
                                                        }

                                                        ?>

                                                <?php if ($jam_pulang != '' || $jam_pulang != 0) { ?>

                                                    <span style="color:<?php echo $color ?>;"><?php echo str_replace(".", ",", $jam_kerja) ?> Jam</span></td>

                                        <?php } ?>

                                        <td align="center" style="vertical-align:top;"><?php echo $keterangan ?></td>

                                        <td style="vertical-align:top;"><?php echo $tugas_1 ?></td>

                                        <td style="vertical-align:top;"><?php echo $tugas_2 ?></td>

                                        <td></td>

                                        </tr>

                                    <?php

                                            $date = date("d-m-Y", strtotime("+1 day", strtotime($date)));

                                            if ($keterangan == "Tidak masuk / Alpha") {

                                                $total_alpha++;
                                            }
                                            $no++;
                                        endwhile;

                                        $row_jam_kerja = $this->db->select('jam_kerja')

                                            ->from('hari_kerja')

                                            ->where('tahun', $start_y)

                                            ->where('bulan', $start_m * 1)

                                            ->get()->row();
                                        ?>

                                    <tr>
                                        <th align="right" colspan="5">TOTAL JAM KERJA</th>
                                        <th><?= str_replace(".", ",", $total_jam_kerja) ?> Jam</th>

                                        <th align="right" colspan="3">TOTAL HARI</th>

                                        <th><?php echo $total_hari ?></th>

                                    </tr>

                                    <tr>
                                        <th align="right" colspan="5">JAM KERJA BULAN INI</th>
                                        <th><?= $row_jam_kerja->jam_kerja ?> Jam</th>
                                        <th align="right" colspan="3">JUMLAH MASUK</th>

                                        <th><?php echo $jml_masuk ?></th>

                                    </tr>

                                    <tr>
                                        <th align="right" colspan="5">HASIL</th>
                                        <th><?= $total_jam_kerja - floatval($row_jam_kerja->jam_kerja) ?> Jam</th>
                                        <th align="right" colspan="3">JUMLAH HARI MINGGU / LIBUR </th>

                                        <th><?php echo $jml_libur ?></th>

                                    </tr>

                                    <tr>
                                        <th align="right" colspan="9">HARI AKTIF </th>

                                        <th><?php echo $total_hari - $jml_libur ?></th>

                                    </tr>

                                    <tr>

                                        <th align="right" colspan="9">TOTAL TIDAK MASUK / ALPHA</th>

                                        <th><?php echo $total_hari - $jml_libur - $jml_masuk . ' / ' . $total_alpha ?></th>

                                    </tr>

                                    <tr>

                                        <th align="right" colspan="9">TIDAK SESUAI JAM </th>

                                        <th><?php echo $tidak_sesuai_jam ?></th>

                                    </tr>

                                    <tr>

                                        <th align="right" colspan="9">TIDAK LAPORAN </th>

                                        <th><?php echo $tidak_laporan ?></th>

                                    </tr>

                                    <tr>

                                        <th align="right" colspan="9">TERLAMBAT / TOTAL</th>

                                        <th><?php echo $terlambat . ' / ' . $total_menit_telat ?></th>

                                    </tr>

                                </tbody>

                            </table>

                        </td>

                    </tr>

                </tbody>

                <tfoot>

                    <tr>

                        <td colspan="3" style="border:none;">

                            <table style="margin-top:10px;margin-bottom:10px;float:right;">

                                <tr>

                                    <td colspan="10">DICETAK, <?php echo date('d-m-Y') ?></td>

                                </tr>

                                <tr>

                                    <td colspan="10"><br><br>TANGAN ANGIE OFFICE SYSTEM</td>

                                </tr>

                            </table>

                        </td>

                    </tr>

                </tfoot>

            </table>

        <?php endforeach ?>

        </div>

</body>

</html>