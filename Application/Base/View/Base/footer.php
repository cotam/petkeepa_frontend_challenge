            <footer id="footer-black" class="widefat">
                <div class="container">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="footer-logo">
                            <h1 class="site-title">
                                <a href="#"><img src="<?php echo PET_PUBLIC_URL; ?>images/logo-petkeepa-200.png" alt="<?php echo _( 'Traveline' ); ?>" /></a>
                            </h1>
                            <ul class="footer-social-icons">
                                <li><a href="#" class="fa fa-facebook"></a></li>
                                <li><a href="#" class="fa fa-twitter"></a></li>
                                <!--<li><a href="#" class="fa fa-pinterest"></a></li>-->
                                <!--<li><a href="#" class="fa fa-tumblr"></a></li>-->
                                <!--<li><a href="#" class="fa fa-vimeo-square"></a></li>-->
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="newsletter-holder">
                            <h3>
                                <?php echo _( 'Help Guide' ); ?>
                            </h3>
                            <p>
                                <a href="<?php echo U( '/Home/Index/FAQ_user' ); ?>" ><?php echo _( 'FAQ for Users' ); ?></a>
                                <br/>
                                <a href="<?php echo U( '/Home/Index/FAQ_host' ); ?>" ><?php echo _( 'FAQ for Host' ); ?></a>
                                <br/>
                                <a href="<?php echo U( '/Home/Index/how_it_works' ); ?>"><?php echo _( 'How it works' ); ?></a>
                                <br/>
                                <a href="<?php echo U( '/Home/Index/privacy_policy' ); ?>" ><?php echo _( 'Privacy Policy' ); ?></a>
                                <br/>
                                <a href="<?php echo U( '/Home/Index/terms_conditions' ); ?>" ><?php echo _( 'Terms and Conditions' ); ?></a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="newsletter-holder">
                            <h3>
                                <?php echo _( 'Country' ); ?>
                            </h3>
                            <p>
                                <a href="http://www.petkeepa.com/" ><?php echo _( 'Singapore' ); ?></a>
                            </p>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="newsletter-holder">
                            <h3>
                                <?php echo _( 'Contact us' ); ?>
                            </h3>
                            <p>
                                <b><?php echo _( 'Email:' ); ?></b> contact@petkeepa.com<br>
                                <b><?php echo _( 'Address:' ); ?></b> 10 Anson Road #26-04 International Plaza, Singapore 079903
                            </p>
                            
                        </div>
                    </div>
                </div>
                </footer><!-- /#footer -->
                
                <!--<div id="copyright" class="text-center"><?php echo _( '&copy; 2014 - 2015 Pet Keepa. Designed by ' ); ?><a href="http://www.madaboutdesign.com">MadAboutDesign</a></div>-->
        </div><!-- /#site -->

        <?php echo $_footer_js; ?>
    </body>
</html>

