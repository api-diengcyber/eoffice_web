<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4">
        <h2 style="margin-top:0px">Materi</h2>
    </div>
    <div class="col-md-4 text-center">
        <div style="margin-top: 4px"  id="message">
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        </div>
    </div>
</div>
<style>
    .mlist > li {
        border: solid 1px chocolate;
        background-color: #fdf59a;
        padding:5px;
        border-radius: 10px;
        margin-bottom:10px;
    }
    .mlist > li > a{
        color:black;
    }
    .mlist > li > a:hover {
        color:chocolate;
        text-decoration: none;
    }
</style>
<ul class="mlist">
    <?php foreach ($data_materi as $dm): ?>
    <li>
        <i class="fa fa-list"></i> <a href="<?php echo base_url('training/materi/read/'.$dm->id) ?>"><?php echo $dm->nama_materi ?></a>
    </li>
    <?php endforeach ?>
</ul>