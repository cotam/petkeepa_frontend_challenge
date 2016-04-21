            <header id="header-alt" class="wide-fat">
                <div class="container">
                    <div class="col-xs-5 col-md-3 no-margin">
                        <div class="branding">
                            <h1 class="site-title">
                                <a href="<?php echo U( '/Home/' ); ?>"><img src="<?php echo PET_PUBLIC_URL; ?>images/logo-petkeepa-142.png" alt="Traveline" /></a>
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-9 hidden-xs hidden-sm no-margin">
                        <div id="main-menu">
                            <nav class="navigation">
                                <ul>
                                    <!--<li class="menu-item about-us">
                                        <a href="<?php echo U( '/Home/' ); ?>"><i class="fa fa-home"></i><span> <?php echo _( 'Home' ); ?></span></a>
                                    </li> -->
                                    <li class="menu-item our-travel">
                                        <a href="<?php echo U( '/Home/Search' ); ?>"><?php echo _( 'Host Listing' ); ?></span></a>
                                    </li>
                                    <li class="menu-item destinations">
                                        <a href="<?php if ( A( 'User/Widget' )->host_exist() ) : echo U( '/User/Profile/index' ); else : echo U( '/User/Host/register' ); endif; ?>"><?php echo _( 'Become a Host' ); ?></a>
                                    </li>
                                </ul>
                            </nav>
                        </div><!-- /#main-menu -->
                    </div>
					<div class="col-xs-7 hidden-md hidden-lg">
						<nav class="navbar navbar-default" role="navigation">
							<div class="navbar-header">
								<?php if ( empty( $login_user ) ) : ?>
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
										  <span class="sr-only">Toggle navigation</span>
										  <span class="icon-bar"></span>
										  <span class="icon-bar"></span>
										  <span class="icon-bar"></span>
									</button>
								<?php else : ?>
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
										<b><?php echo ( empty( $login_user_info ) || empty( $login_user_info['first_name'] ) ? $login_user['email'] : $login_user_info['first_name'] ); ?></b>&nbsp;<i class="fa fa-caret-down"></i>
										<?php if ( $total_unread_letters > 0 ) : ?>
											&nbsp;<a href="<?php echo U( '/User/Letter/letter_box' ); ?>"><span class="badge"><?php echo $total_unread_letters; ?></span></a>
										<?php endif; ?>
									</button>
								<?php endif; ?>
								<a class="navbar-brand" href="#"></a>
							</div>
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<?php if ( empty( $login_user ) ) : ?>
									<ul class="nav navbar-nav">
										<li>
											<a href="<?php echo U( '/Home/Search' ); ?>"><?php echo _( 'Host Listing' ); ?></span></a>
										</li>
										<li>
											<a href="<?php if ( A( 'User/Widget' )->host_exist() ) : echo U( '/User/Profile/index' ); else : echo U( '/User/Host/register' ); endif; ?>"><?php echo _( 'Become a Host' ); ?></a>
										</li>
										<li>
											<a href="<?php echo U( '/Home/User/login' ) . '?redirect_to=' . $_self; ?> "><?php echo _( 'Sign Up' ); ?></a>
										</li>
									</ul>
								<?php else : ?>
									<ul class="nav navbar-nav">
										<li>
											<a href="<?php echo U( '/Home/Search' ); ?>"><?php echo _( 'Host Listing' ); ?></span></a>
										</li>
										<li>
											<a href="<?php if ( A( 'User/Widget' )->host_exist() ) : echo U( '/User/Profile/index' ); else : echo U( '/User/Host/register' ); endif; ?>"><?php echo _( 'Become a Host' ); ?></a>
										</li>
										<li><a href="<?php echo U( '/User/Home/index' ); ?>"><i class="fa fa-home fa-fw"></i> <?php echo _( 'Dashboard' ); ?></a></li>
										<li><a href="<?php echo U( '/User/Letter/letter_box' ); ?>"><i class="fa fa-envelope-o fa-fw"></i> <?php echo _( 'Messages' ); ?></a></li>
										<li><a href="<?php echo U( '/User/Booking/booking' ); ?>"><i class="fa fa-search fa-fw"></i> <?php echo _( 'Booking' ); ?><?php if( $newbooking_count > 0 ) : ?>&nbsp;<label class="badge"><?php echo $newbooking_count;?></label><?php endif; ?></a></li>
										<li><a href="<?php echo U( '/User/Account/account_records' ); ?>"><i class="fa fa-credit-card fa-fw"></i> <?php echo _( 'Account' ); ?></a></li>
										<li><a href="<?php echo U( '/User/Profile/index' ); ?>"><i class="fa fa-user fa-fw"></i> <?php echo _( 'Profile' ); ?></a></li>
										<li><a href="<?php echo U( '/User/Booking/calendar' ); ?>"><i class="fa fa-calendar fa-fw"></i> <?php echo _( 'My Calendar' ); ?></a></li>
										<li role="presentation" class="divider"></li>
										<li><a href="<?php echo U( '/Home/User/logout' ); ?>"><i class="fa fa-reply fa-fw"></i> <?php echo _( 'Log out' ); ?></a></li>
									</ul>								
								<?php endif; ?>
							</div>
						</nav>
					</div>
                </div>
                <div class="toggle-menu-holder hidden-xs hidden-sm">

                    <?php if ( empty( $login_user ) ) : ?>

					<div id="login_before">
						<ul class="pull-right">
                            <li class="pull-left margin-right-20 signup">
                                <a href="<?php echo U( '/Home/User/login' ) . '?redirect_to=' . $_self; ?> "><?php echo _( 'SIGN UP' ); ?></a>
                            </li>
						</ul>
					</div>

                    <?php else : ?>

					<div id="logined">
						<ul class="pull-right">
						    <li class="pull-left margin-right-20 text-welcome"><b><?php echo _( 'Welcome!' ); ?></b></li>
                            <li class="user-menu-box pull-left margin-right-10">
                                <a id="user-menu" href="<?php echo U( '/User/Home/index' ); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b><?php echo ( empty( $login_user_info ) || empty( $login_user_info['first_name'] ) ? $login_user['email'] : $login_user_info['first_name'] ); ?></b>&nbsp;<i class="fa fa-caret-down"></i></a>
                                <span class="top-angle"></span>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="user-menu">
                                    <li><a href="<?php echo U( '/User/Home/index' ); ?>"><i class="fa fa-home fa-fw"></i> <?php echo _( 'Dashboard' ); ?></a></li>
                                    <li><a href="<?php echo U( '/User/Letter/letter_box' ); ?>"><i class="fa fa-envelope-o fa-fw"></i> <?php echo _( 'Messages' ); ?></a></li>
                                    <li><a href="<?php echo U( '/User/Booking/booking' ); ?>"><i class="fa fa-search fa-fw"></i> <?php echo _( 'Booking' ); ?></a></li>
                                    <li><a href="<?php echo U( '/User/Account/account_records' ); ?>"><i class="fa fa-credit-card fa-fw"></i> <?php echo _( 'Account' ); ?></a></li>
                                    <li><a href="<?php echo U( '/User/Profile/index' ); ?>"><i class="fa fa-user fa-fw"></i> <?php echo _( 'Profile' ); ?></a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li><a href="<?php echo U( '/Home/User/logout' ); ?>"><i class="fa fa-reply fa-fw"></i> <?php echo _( 'Log out' ); ?></a></li>
                                </ul>
                            </li>
                            <?php if ( $total_unread_letters > 0 ) : ?>
                            <li class="pull-left">
                                <a href="<?php echo U( '/User/Letter/letter_box' ); ?>"><span class="badge"><?php echo $total_unread_letters; ?></span></a>
                            </li>
                            <?php endif; ?>
						</ul>
					</div>

                    <?php endif; ?>
                </div>
				<div class="col-xs-12">
				</div>
            </header><!-- /#header --> 
