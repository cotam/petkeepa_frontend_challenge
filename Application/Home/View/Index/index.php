<?php echo $_header; ?>
<?php echo $_navigation; ?>
			<!--<h1 id="header-welcome" class="welcome">Welcome to Petkeepa</h1>-->
            <section id="featured" class="wide-fat">
                <div class="flexslider">
                    <ul class="slides">
                        <!--<li>
                            <img src="<?php echo PET_PUBLIC_URL; ?>images/content/slider-img6.jpg" />
                        </li> -->
                        <li>
                            <img src="<?php echo PET_PUBLIC_URL; ?>images/content/slider-img1.jpg" />
                        </li>
                        <!--<li>
                            <img src="<?php echo PET_PUBLIC_URL; ?>images/content/slider-img5.jpg" />
                        </li> -->
                    </ul><!-- /.slides -->

                    <div class="featured-overlay">
                        <div class="featured-overlay-inner">
                            <form class="location-search" action="<?php echo U( '/Home/Search/index' ); ?>" method="get">
                                <h1><?php echo _( 'Welcome to Petkeepa' ); ?></h1>
                                <div class="search-field">
                                    <input class="text stop-auto-submit" id="places_input" name="keywords" type="text" data-lat-input=".lat-input" data-lng-input=".lng-input" placeholder="<?php echo _( 'Choose Your City' ); ?>" autofocus="autofocus" />
                                </div>
                                <div class="search-field">
                                    <div class="col-field-left">
                                        <input id="check-in-date" name="checkin" class="text traveline_date_input hasDatepicker datetimepicker" data-out-selector="#check-out-date" type="text" placeholder="<?php echo _( 'Check in date' ); ?>" readonly="readonly">
                                    </div>
                                    <div class="col-field-right">
                                        <input id="check-out-date" name="checkout" class="text traveline_date_input hasDatepicker datetimepicker" data-in-selector="#check-in-date" type="text" placeholder="<?php echo _( 'Check out date' ); ?>" readonly="readonly">
                                    </div>									
                                </div>
                                <div class="search-field">
                                    <input type="hidden" class="button wide-fat lat-input" name="lat" value="0"/>
                                    <input type="hidden" class="button wide-fat lng-input" name="lng" value="0"/>
                                    <input type="submit" class="button wide-fat" value="<?php echo _( 'Find a host for your pet' ); ?>"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>					
            </section><!-- /#featured -->
			
			<!--<section id="petkeepa-home-search" class="section wide-fat">
                <form action="<?php echo U( '/Home/Search/index' ); ?>" method="get">
					<div class="container">
						<div class="col-md-3">
							<div class="search-field">
								<input class="home-search-text stop-auto-submit" id="places_input" name="keywords" type="text" data-lat-input=".lat-input" data-lng-input=".lng-input" placeholder="<?php echo _( 'City' ); ?>" autofocus="autofocus" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="search-field">
								<div class="col-field-left">
									<input id="check-in-date" name="checkin" class="home-search-text traveline_date_input hasDatepicker datetimepicker" data-out-selector="#check-out-date" type="text" placeholder="<?php echo _( 'Check In' ); ?>" readonly="readonly">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="search-field">
								<div class="col-field-right">
									<input id="check-out-date" name="checkout" class="home-search-text traveline_date_input hasDatepicker datetimepicker" data-in-selector="#check-in-date" type="text" placeholder="<?php echo _( 'Check Out' ); ?>" readonly="readonly">
								</div>									
							</div>
						</div>
						<div class="col-md-3">
							<div class="search-field">
								<input type="hidden" class="button wide-fat lat-input" name="lat" value="0"/>
								<input type="hidden" class="button wide-fat lng-input" name="lng" value="0"/>
								<input type="submit" class="home-search-button wide-fat fa fa-2x" value="<?php echo _( '&#xf002;' ); ?>"/>
							</div>
						</div>
					</div>
				</form>
            </section>
			<hr class="style-home"> -->
            <!--<section id="why-use-petkeepa" class="section wide-fat hidden-xs">
                <div class="container text-center">	
                    <h1 class="page-title"><?php echo _( 'Why Use PetKeepa' ); ?></h1>
                    <div class="about-details grid col-3">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 about-detail-1 step-input">
                                <h2><?php echo _( 'Awesome TLC & Convenient' ); ?></h2>
                                <p><?php echo _( 'Search multiple personalized care and home stays from your local community' ); ?></p>
                            </div>
                            <div class="col-md-4 col-sm-4 about-detail-2 step-search">
                                <h2><?php echo _( 'Verification & Trust' ); ?></h2>
                                <p><?php echo _( 'Verified Profiles, open dialogue and fellow pet owner\'s reviews for your choice' ); ?></p>
                            </div>
                            <div class="col-md-4 col-sm-4 about-detail-3 step-book">
                                <h2><?php echo _( 'Peace of mind' ); ?></h2>
                                <p><?php echo _( 'Daily updates of your pet\'s holiday while you are away' ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- /#why-use-petkeepa.section -->
            
            <section id="how-it-works" class="section wide-fat">
                <div class="container text-center">
                    <h1 class="page-title"><?php echo _( 'How it Works' ); ?></h1>
                    <div class="about-details grid col-3">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 about-detail-1 step-input">
                                <i class="fa fa-calendar fa-4x"></i>
                                <h2><?php echo _( 'Input & Discover' ); ?></h2>
                                <p><?php echo _( 'Input your required dates and browse awesome hosts near you' ); ?></p>
                            </div>
                            <div class="col-md-4 col-sm-4 about-detail-2 step-search">
                                <i class="fa fa-search fa-4x"></i>
                                <h2><?php echo _( 'Search & Connect' ); ?></h2>
                                <p><?php echo _( 'Read what others say. Communicate online or simply meet up to arrange a personalized TLC for your best friend' ); ?></p>
                            </div>
                            <div class="col-md-4 col-sm-4 about-detail-3 step-book">
                                <i class="fa fa-check fa-4x"></i>
                                <h2><?php echo _( 'Book & Relax' ); ?></h2>
                                <p><?php echo _( 'Make payment online. Relax and Enjoy daily updates on your pets while you are away' ); ?></p>
                            </div>
                        </div><!-- /.row -->
 
                        <!--<div class="margin-top-40">
                           <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-offset-4 about-detail-2 step-search">
                               <a href="<?php echo U( '/Home/Search' ); ?>" class="button wide-fat" style="padding:15px;"><?php echo _( 'Start Search' ); ?></a>
                           </div>
                           <div class="clearfix"></div>
                           <p><a href="javascript:;" data-toggle="modal" data-target="#howitworks" class="higlight">Learn More</a> <?php echo _( 'on how you can be part of the service provider community on PetKeepa' ); ?></p>
                        </div> -->
                        
                    </div>
                </div>
            </section><!-- /#how-it-works.section -->
            
            <section id="who-we-are" class="section wide-fat hidden-xs">
                <div class="container text-center">	
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-title"><?php echo _( 'About Us' ); ?></h1>
                            <p><?php echo _( 'PetKeepa was founded to establish an online community of pet lovers and pet professional that would be readily available to assist pet owners when they are busy.' ); ?></p>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-6 pull-left">
							<a href="<?php echo U( 'Index/about' ); ?>" class="higlight button"><?php echo _( 'SUBSCRIBE' ); ?></a>
						</div>
						<div class="col-md-6 pull-right">
							<a href="<?php echo U( 'Index/about' ); ?>" class="button white"><?php echo _( 'SEE MORE' ); ?></a>
						</div>
					</div>
                </div>
            </section><!-- /#about-us.section -->

            <!--<section id="out-mission" class="section wide-fat hidden-xs">
                <div class="container">	
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 pull-right">
                            <h1 class="page-title"><?php echo _( 'Our Mission' ); ?></h1>
                            <p style="color:#51575b;"><?php echo _( 'We believe that happy pets require constant care and attention. Pets also have different needs like if they mingle well with large groups of pets or require special medical care.' ); ?></p>
                            <a href="<?php echo U( 'Index/about' ); ?>" class="higlight button"><?php echo _( 'Read More' ); ?></a>
                        </div>
                    </div>
                </div>		
            </section><!-- /#out-mission.section -->

            <!--<section id="subscribe" class="section wide-fat hidden-xs">
                <div class="container">	
                    <div class="row">
						<div class="col-xs-12 col-sm-6 col-md-offset-1">
                            <form method="post">
                                <div class="col-md-12">
                                    <h3><?php echo _( 'Subscribe to PetKeepa for latest information and promotion' ); ?></h3>
                                </div>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="name" placeholder="<?php echo _( 'Email Address' ); ?>" />
                                </div>
                                <div class="col-md-4 margin-top-10">
                                    <input class="button" type="submit" value="<?php echo _( 'Subscribe' ); ?>" />
                                </div>
                            </form>
						</div>
                    </div>
                </div>
            </section><!-- /#subscribe.section -->			
<?php echo $_footer; ?>
