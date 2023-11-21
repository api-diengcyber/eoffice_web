<h2 style="margin-top:0px">Materi Read</h2>

<div class="card p-2">    
    <table class="table">
        <tr><td>Tanggal</td><td><?php echo $tgl; ?></td></tr>
        <tr><td>Nama Materi</td><td><?php echo $nama_materi; ?></td></tr>
        <tr><td>Isi</td><td><?php echo $isi; ?></td></tr>
        <tr><td>Lampiran</td><td>
            <!-- <?php echo $lampiran; ?> -->
            <?php
            if($lampiran!=null){?>
                <a href="<?=base_url('assets/materi/'.$lampiran)?>" target="_blank">File</a>
            <?php }else{ ?>
                -
            <?php
                }
            ?>
        </td></tr>
        <tr><td></td><td><a href="<?php echo site_url('admin/materi') ?>" class="btn btn-default">Cancel</a></td></tr>
    </table>
</div>