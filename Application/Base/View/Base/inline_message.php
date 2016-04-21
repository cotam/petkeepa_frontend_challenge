<?php foreach ( $_messages as $ms ) : ?>
<div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo _( 'Close' ); ?></span></button>
    <?php echo $ms; ?>
</div>
<?php endforeach; ?>

