<style>
    table {
        border-collapse: collapse;
    }

    td,
    th {
        padding: 10px;
    }

    .mlist {
        list-style: none !important;
        padding-left: 0px;
    }

    .mlist>li {
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: dotted 1px silver;
    }

    .mlist>li:last-child {
        border-bottom: 0px;
    }

    .capitalize {
        text-transform: capitalize !important;
    }

    .table-bordered {
        border: 1px solid #b6b6b6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #b6b6b6;
    }
</style>
<table class="table table-bordered table-striped capitalize" id="myTable" border="1">
    <thead class="table-dark" style="border:solid 1px #212529">
        <tr>
            <th width="150px" rowspan="3" style="vertical-align:middle">Nama</th>
        </tr>
        <tr>
            <th style="text-align:center" colspan="2">Laporan</th>
        </tr>
        <tr>
            <th style="text-align:center;background-color:#CDDC39" width="50%">Pagi</th>
            <th style="text-align:center;background-color:#897b14;" width="50%">Siang</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laporan as $l) : ?>
            <tr>
                <td style="vertical-align:middle"><?php echo $l->nama ?></td>
                <td>
                    <ul class="mlist">
                        <?php if (!empty($l->laporan_pagi[0]->tgl)) { ?>
                            <?php foreach ($l->laporan_pagi as $lp) : ?>
                                <li style="border-bottom:solid 1px black">
                                    <span>Keterangan : </span> <br>
                                    <?php echo ($lp->ket) ? $lp->ket : 'Tidak ada keterangan'; ?> <br>
                                </li>
                            <?php endforeach ?>
                        <?php } else { ?>
                            Belum upload tugas
                        <?php } ?>
                    </ul>
                </td>
                <td style="vertical-align:middle">
                    <ul class="mlist">
                        <?php if (!empty($l->laporan_siang[0]->tgl)) { ?>
                            <?php foreach ($l->laporan_siang as $ls) : ?>
                                <li style="border-bottom:solid 1px black">
                                    <span>Keterangan : </span> <br>
                                    <?php echo ($ls->ket) ? $ls->ket : 'Tidak ada keterangan'; ?> <br>
                                </li>
                            <?php endforeach ?>
                        <?php } else { ?>
                            Belum upload tugas
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>