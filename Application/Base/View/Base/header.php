<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pet Keepa</title>
        <?php echo $_baser; ?>
        <?php echo $_header_css; ?>
        <!--[if IE]>
            <link rel='stylesheet' type='text/css' href='<?php echo PET_PUBLIC_URL . 'styles/stylesheet-ie.css'; ?>'>
        <![endif]-->
        <script>
        //<![DATA[
            var _public_url = "<?php echo PET_PUBLIC_URL; ?>";
            var _facebook_id = "<?php echo C( 'FACEBOOK_APP_ID' ); ?>";
        //]]>
        </script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-65375224-1', 'auto');
		  ga('send', 'pageview');

		</script>
    </head>
    <body>
        <div id="preloader">
            <div id="status">&nbsp;</div>
            <noscript><?php echo _( 'JavaScript is off. Please enable to view full site.' ); ?></noscript>
        </div>
        <div id="site">
