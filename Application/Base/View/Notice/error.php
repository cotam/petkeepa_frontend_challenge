<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Keepa</title>
    <?php global $pet_plugin_files; ?>
    <link rel="stylesheet" href="<?php echo PET_PUBLIC_URL . $pet_plugin_files['_before']['css'][0]; ?>">
    <link rel="stylesheet" href="<?php echo PET_PUBLIC_URL . $pet_plugin_files['fontawesome']['css'][0]; ?>">
    <link rel="stylesheet" href="<?php echo PET_PUBLIC_URL . $pet_plugin_files['_after']['css'][0]; ?>">
    <link rel="stylesheet" href="<?php echo $pet_plugin_files['google_fonts']['domain'] . $pet_plugin_files['google_fonts']['css'][0]; ?>">
    <link rel="stylesheet" href="<?php echo $pet_plugin_files['google_fonts']['domain'] . $pet_plugin_files['google_fonts']['css'][1]; ?>">
</head>
	
<body>
    <section class="section wide-fat notices">
        <div class="content-holder text-center">
            <div class="branding">
                <h1 class="site-title">
                    <a href="<?php echo U( '/Home/' ); ?>"><img src="<?php echo PET_PUBLIC_URL; ?>images/logo-petkeepa-142.png" alt="PETKEEPA" /></a>
                </h1>
            </div>

            <h1><?php echo($error); ?></h1>

            <h3><?php printf( _( 'This page will automatically <a id="href" href="%s">skip</a> in: <b id="wait">%s</b>' ), $jumpUrl, $waitSecond ); ?></h3>

            <p class="margin-top-30"><a class="button mini" href="<?php echo U( '/Home/' ); ?>"><?php echo _( 'Go back to home' ); ?></a></p>

        </div>

        <script type="text/javascript">
        (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
        })();
        </script>
    </section>

</body>
</html>
