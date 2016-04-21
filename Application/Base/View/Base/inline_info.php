<?php foreach ( $_infos as $inf ) : ?>
<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo _( 'Close' ); ?></span></button>
    <?php echo $inf; ?>
</div>
<?php endforeach; ?>


