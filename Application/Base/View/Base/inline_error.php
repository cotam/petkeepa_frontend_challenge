<?php foreach ( $_errors as $er ) : ?>
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo _( 'Close' ); ?></span></button>
    <?php echo $er; ?>
</div>
<?php endforeach; ?>

