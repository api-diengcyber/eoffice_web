<div class="row">
    <div class="col-md-12">
        <?php foreach ($data_info as $info): ?>
        <div class="alert alert-primary">
            <strong><?php echo $info['tgl'] ?></strong>
            <ul>
                <?php foreach ($info['info'] as $val): ?>
                    <li><?php echo $val ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php endforeach ?>
    </div>
</div>