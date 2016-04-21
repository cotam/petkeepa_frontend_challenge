<?php echo $_header; ?>
<?php if ( empty( $preview ) ) : echo $_navigation_alt; endif; ?>

            <section id="search-detail" class="section wide-fat host-detail">
                <div class="container">
                    <div class="row">
                        <div id="detail-post" class="col-xs-12">
                            <!--<h3 class="post-title color-main"><?php echo $host['title']; ?></h3> -->
                            <div id="wrapper" class="hidden-xs hidden-sm">
                                <div id="carousel">
									<?php foreach ( $host['pics'] as $pic ) : ?>
                                    <div id="slide_<?php echo $pic['id']; ?>" class="imageWrapper">
                                        <a class="next-btn" href="#next"><img class="overlayImage" alt="<?php echo $pic['info']; ?>" src="<?php echo $pic['url']; ?>"/>
                                            <?php if ( !empty( $preview ) ) : echo _('<img id="previewImg" class="overlayImage" src="/Application/Uploads/preview.png"/>'); endif; ?>    
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
								</div>
								<div id="pager"></div>
							</div>
							
                            <div class="single-slider-holder hidden-md hidden-lg">
                                <!--<div class="main-slide-nav">
                                    <a class="fa fa-angle-left prev-btn" href="#prev"></a>
                                    <a class="fa fa-angle-right next-btn" href="#next"></a>
                                </div>-->
								<div class="main-slide-nav">
								<a class="next-btn" href="#next">
                                <div class="single-slider">
                                    <?php foreach ( $host['pics'] as $pic ) : ?>
                                        <?php if ( !empty( $preview ) ) : ?>
                                            <div id="host_detail_gallery_item" style="width:100%" class="imageWrapper" id="slide_<?php echo $pic['id']; ?>">
                                                <img style="width:100%" class="overlayImage" alt="<?php echo $pic['info']; ?>" src="<?php echo $pic['url']; ?>"/>
                                                <img class="overlayImage" src="/Application/Uploads/previewxs.png"/>
                                            </div>
                                        <?php else : ?>
                                            <div class="host-detail-gallery-item" id="slide_<?php echo $pic['id']; ?>">
                                                <img alt="<?php echo $pic['info']; ?>" src="<?php echo $pic['url']; ?>"/>
                                            </div>
                                        <?php endif; ?>
                                    
                                    <?php endforeach; ?>
                                </div>
								</a>
								</div>
                                <!--<div class="single-slider-thumb-gallery">
                                    <ul>
                                        <?php foreach ( $host['pics'] as $pic ) : ?>
                                        <li>
                                            <a class="horizontal-gallery-item" href="#slide_<?php echo $pic['id']; ?>">
                                                <img alt="<?php echo $pic['info']; ?>" src="<?php echo $pic['url']; ?>" width="69" height="50" />
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>-->
                            </div> 

                            <hr>

                        </div>
						 <div id="detail-post" class="col-md-7 col-sm-6 col-xs-12">
                            <div id="detail-info-box" class="tab-holder">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" >
                                    <li class="active"><a href="#detail" data-toggle="tab"><i class="fa fa-info fa-2x text-center"></i></a></li>
                                    <li><a href="#map" data-toggle="tab"><i class="fa fa-map-marker fa-2x"></i></a></li>
                                    <li><a href="#comment" data-toggle="tab"><i class="fa fa-comments fa-2x"></i></a></li>
                                </ul>
                                <!-- /# Nav tabs -->

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="detail">
									    <div class="row">
											<div class="col-md-4">
												<img src="<?php echo $host['head_img_url']; ?>" width="140" height="140" alt="" class="img-circle" />
											<!--<h3 class="block-title text-center margin-top-5"><strong><?php echo $host['first_name']; ?></strong></h3>-->
											</div>
											<div class="col-md-8">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-6"><b><h3 class="margin-top-5"><strong><?php echo $host['first_name']; ?></strong></h3></b></td>
															<td class="col-md-6"><div class="star-holder">
																<div class="star big" data-score="<?php echo ceil($host['score']); ?>"></div>
                                            </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Response Rate' ); ?></b></td>
                                                            <td><?php echo $response_rate; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Response Time' ); ?></b></td>
                                                            <td><?php echo ( empty( $host['response_time'] ) ? "Prompt" : to_response_time( $host['response_time'], '' ) ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Last Activity' ); ?></b></td>
                                                            <td><?php echo to_time( $host['latest_date'] ); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
										</div>
										<p></p>
										<div class="row">
											<div class="col-md-6"
												<!-- Greet & Meet -->
											   <?php $user_id = get_session_id();
												if ( empty( $user_id ) ) : ?>
												   <a class="button wide-fat capital logo_blue" href="<?php echo U( 'User/login' ) . '?redirect_to=' . $_self; ?>" >Login to send a Greet & Meet message</a>
												<?php else : ?>
                                                    <button id="greet-meet-btn" type="button" class="button wide-fat white capital" data-toggle="collapse" data-target="#greet-meet" aria-expanded="true" aria-controls="greet-meet"><?php echo _( 'Meet & Greet' ); ?></button>
												<?php endif; ?>
											</div>
											<div id="online-chat-div" class="col-md-6">
												<?php $user_id = get_session_id();
												if ( empty( $user_id ) ) : ?>
												    <a class="button wide-fat capital logo_blue" href="<?php echo U( 'User/login' ) . '?redirect_to=' . $_self; ?>" >Login to send message</a>
												<?php else : ?>
                                                    <button id="online-chat-btn" type="button" class="button wide-fat white capital" data-toggle="collapse" data-target="#online-chat" aria-expanded="true" aria-controls="online-chat"><?php echo _( 'Message Me' ); ?></button>
												<?php endif; ?>
											</div>

                                            <div class="col-md-12" style="margin-top: 1%">
                                                <div id="greet-meet" class="collapse">
                                                    <form method="post" action="#" name="comments-form" id="comments-form">
                                                        <div class="form-group" style="display:none">
                                                            <input type="text" value="Meet & Greet Request" class="form-control" title="comments-form-title" name="title" disabled>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <textarea placeholder="Your Meet & Greet Message ..." class="form-control" title="comments-form-comments" name="letter" rows="6"></textarea>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="agree" required />                                     
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-11">
                                                            <div class="form-group">
                                                                <label><?php echo _( 'I agree to pay for any service with the Host only through the Petkeepa platform, I understand that the fees are needed to continue to continuously expand Petkeepa features and build a trusted community in Petkeepa.' ); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12 col-md-4 col-md-offset-8">
                                                                <input type="hidden" name="opt" value="meet" />
                                                                <button type="submit" class="button wide-fat"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<?php echo _( 'SEND' ); ?></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- END Greet & Meet -->
                                            </div>

                                            <div class="col-md-12" style="margin-top: 1%">
                                                <div id="online-chat" class="collapse">
                                                    <form method="post" action="#" name="comments-form" id="comments-form">
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Title" class="form-control" name="title" required>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <textarea placeholder="Your Message ..." class="form-control" name="letter" rows="6" required></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-xs-12 col-md-4 col-md-offset-8">
                                                                <input type="hidden" name="opt" value="chat" />
                                                                <button type="submit" class="button wide-fat"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<?php echo _( 'SEND' ); ?></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- END Online chat -->
                                                <a href="javascript:;" class="button wide-fat white margin-top-10 margin-bottom-10 collection_button <?php if ( ! $is_collected ) : echo 'add_collection'; else : echo 'remove_collection'; endif; ?>" data-add-url="<?php echo U( 'User/Booking/add_saved' ); ?>" data-remove-url="<?php echo U( 'User/Booking/remove_saved' ); ?>" data-collection="<?php echo $host['usr_login_id']; ?>" ><?php if( ! $is_collected ) : echo _( 'Add To Favourite List' ); else : echo _( 'Remove Favourite From List' ); endif; ?></a>
                                            </div>
										
                                            
                                        </div>
										<hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Host Information' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-6"><b><?php echo _( 'Residence Type' ); ?></b></td>
                                                            <td class="col-md-6"><?php echo ( $host['property_type'] != '4' ? $GLOBALS['pet_property_type_enum'][ $host['property_type'] ] : $host['property_other'] ) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'With yard' ); ?></b></td>
                                                            <td><?php echo ( $host['yard_type'] != '0' ? 'Yes' : 'No' ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Own pets' ); ?></b></td>
                                                            <td><?php echo ( $host['resident_pets'] != '0' ? 'Yes' : 'No' ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Experience' ); ?></b></td>
                                                            <td><?php echo $host['expreience'] ; ?> Years</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Cancellation Policy' ); ?></b></td>
                                                            <td><?php echo $GLOBALS['pet_service_cancellation_enum'][ $host['service_cancellation'] ]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Accepted Pet Type' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-6"><b><?php echo sprintf( _( 'Large Dogs ( %s )' ), $GLOBALS['pet_dog_size_accepted_enum'][4] ); ?></b></td>
                                                            <td class="col-md-6"><?php echo ( is_set( $host['service_provided'], 1 ) && is_set( $host['service_size_accepted'], 4 ) ? 'Yes' : 'No' ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo sprintf( _( 'Medium Dogs ( %s )' ), $GLOBALS['pet_dog_size_accepted_enum'][2] ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_provided'], 1 ) && is_set( $host['service_size_accepted'], 2 ) ? 'Yes' : 'No' ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo sprintf( _( 'Small Dogs ( %s )' ), $GLOBALS['pet_dog_size_accepted_enum'][1] ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_provided'], 1 ) && is_set( $host['service_size_accepted'], 1 ) ? 'Yes' : 'No' ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Cats' ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_provided'], 2 ) ? 'Yes' : 'No' ); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Service Details' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-6"><b><?php echo _( 'Boarding Service' ); ?></b></td>
                                                            <td class="col-md-6"><?php echo ( is_set( $host['service_types'], 1 ) ? _( 'Yes' ) : _( 'No' ) ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Sitting Service (Nightly)' ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_types'], 2 ) ? _( 'Yes' ) : _( 'No' ) ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Walking' ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_types'], 8 ) ? _( 'Yes' ) : _( 'No' ) ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Grooming' ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_types'], 16 ) ? _( 'Yes' ) : _( 'No' ) ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Bathing' ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_types'], 32 ) ? _( 'Yes' ) : _( 'No' ) ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo _( 'Pick-up' ); ?></b></td>
                                                            <td><?php echo ( is_set( $host['service_types'], 64 ) ? _( 'Yes' ) : _( 'No' ) ); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Profile Description' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <p><?php echo nl2br( $host['self_description'] ); ?></p>
                                            </div>
                                        </div>

                                        <hr>

                                        <?php if ( ! empty( $host['additional'] ) ) : ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Additional Information' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <p><?php echo nl2br( $host['additional'] ); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <hr class="hidden-lg hidden-md hidden-sm">

                                        <div class="row hidden-lg hidden-md hidden-sm">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Address' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo address_short( $host ); ?>
                                            </div>
                                        </div>

                                        <?php if ( 0 == $host['service_breeds'] ) : ?>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3 class="no-margin"><?php echo _( 'Restrictions' ); ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <p><?php echo nl2br( $host['service_not_restrictions'] ); ?></p>
                                            </div>
                                        </div>
                                        
                                        <?php endif; ?>

                                    </div>

                                    <div class="tab-pane" id="map">
                                        <div id="map_canvas" data-lat="<?php echo $host['lat']; ?>" data-lng="<?php echo $host['lng']; ?>" data-zoom="<?php echo C( 'MAP_DEFAULT_HOME_ZOOM' ); ?>" data-autoshow="true"></div>
                                    </div>

                                    <div class="tab-pane" id="comment">
                                        <div class="notice no-margin" >
                                            <?php echo $_error; ?>
                                            <?php echo $_message; ?>
                                        </div>
                                        <?php if ( ! empty( $comments ) ) : ?>
										<?php $review_count = 0;?>
										<?php foreach ( $comments as $comment ) : ?>
                                            <?php
                                            if ( $comment['usr_login_id_from'] == 0 || $comment['reply'] != null ) {
                                                continue;
                                            }
                                            else {
                                                $review_count++;
                                            } ?>
										<?php endforeach; ?>
                                        <h2><span><?php echo $review_count; ?></span> <?php echo _( 'Review(s)' ); ?></h2>

                                        <hr>

                                        <?php $comment_count = 0; $user_id = get_session_id(); ?>
                                        <div class="comments-holder">
                                            <?php foreach ( $comments as $comment ) : ?>
                                            <?php
                                            if ( $comment['usr_login_id_from'] == 0 ) {
                                                continue;
                                            }
                                            if ( $comment['usr_login_id_from'] == $user_id ) {
                                                $comment_count++;
                                            } ?>
                                            <div class="comment-item row">
                                                <div class="col-md-3 col-sm-4 col-xs-4">
                                                    <div class="avatar">
                                                        <img src="<?php echo $comment['from_head_img_url']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-9 col-sm-8 col-xs-8">
                                                    <div class="comment-body">
                                                        <span class="author">
                                                            <?php echo $comment['from_first_name']; ?>
                                                        </span>
                                                        <span class="date-time">
                                                            <?php echo ( $comment['submit_time'] ); ?>
                                                        </span>
                                                        <?php if ( get_session_id() == I( 'get.host_id' ) ) : ?>
														<?php $replied = 0; ?>
														<?php foreach ( $comments as $reply ) : ?>
															<?php if ( $comment['id'] == $reply['reply'] ) : ?>
																<?php $replied = 1; break;?>
															<?php endif; ?>
														<?php endforeach; ?>
														<?php if ( $replied == 0 ) : ?>
                                                        <span class="reply">
                                                            <a href="#comment-form" class="comment-reply hash-move" data-from="<?php echo $comment['id']; ?>"><i class="fa fa-reply fa-fw"></i>Reply</a>
                                                        </span>
														<?php endif; ?>
                                                        <?php endif; ?>
                                                        <p>
                                                            <?php echo nl2br( $comment['comment'] ); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php foreach ( $comments as $reply ) : ?>
                                            <?php if ( $comment['id'] == $reply['reply'] ) : ?>
                                            <div class="comment-item row">
                                                <div class="col-md-3 col-sm-4 col-xs-4 col-md-offset-2 col-sm-offset-1 col-xs-offset-1">
                                                    <div class="avatar">
                                                        <img src="<?php echo $reply['to_head_img_url']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-sm-6 col-xs-6">
                                                    <div class="comment-body">
                                                        <span class="author">
                                                            <?php echo $reply['to_first_name']; ?>
                                                        </span>
                                                        <span class="date-time">
                                                            <?php echo ( $reply['submit_time'] ); ?>
                                                        </span>
                                                        <p>
                                                            <?php echo $reply['comment']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php else : ?>
                                        <div>
                                            <h4><?php echo _( 'No reviews yet.' ); ?></h4>
                                        </div>
                                        <?php endif; ?>
                                         
                                        <?php if ( ( $success_service_counts != 0 && $success_service_counts > $comment_count ) || get_session_id() == I( 'get.host_id' ) ) : ?>
                                        <div id="comment-form" class="comment-form-holder">
                                            <h3><?php echo _( 'Write A Review' ); ?></h3>

                                            <hr>

                                            <form class="submit-comment-form" method="post">
                                                <?php if ( get_session_id() !== I( 'get.host_id' ) ) : ?>
                                                <div class="star-holder">
                                                    <span><?php echo _( 'How do you want to rate your host?' ); ?></span>
                                                    <div class="star big" data-score="" data-readonly="false"></div>
                                                </div>
                                                <?php endif; ?>

                                                <textarea class="col-xs-12 textarea" name="comments" <?php if ( get_session_id() == I( 'get.host_id' ) ) : ?>disabled="disabled"<?php endif; ?> placeholder="<?php echo _( 'Give your review here...' ); ?>" rows="7"></textarea>

                                                <button type="submit" <?php if ( get_session_id() == I( 'get.host_id' ) ) : ?>disabled="disabled"<?php endif; ?>  class="button green narrow"><?php echo _( 'Submit Now' ); ?></button>
                                                <input type="hidden" name="opt" value="comments" />
                                                <input type="hidden" name="reply" value="0" />
                                            </form>
                                        </div>
                                        <?php endif; ?>
                                    </div>
									<div class="tab-pane hidden-xs" id="book">
										
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-5 col-sm-6 pull-right">
                            <div class="sidebar-holder">

									<div class="notice">
										<?php echo $_error; ?>
									</div>
									<div id="bill-box">
										<h3><strong><?php echo $host['first_name'] . '\'s Services'; ?></strong></h3>
									
										<ul>
											<?php if ( is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 ) || is_set( $host['service_types'], 8 ) || is_set( $host['service_types'], 16 ) || is_set( $host['service_types'], 32 ) || is_set( $host['service_types'], 64 ) ) : ?>
											<select class="chosen-select hidden-xs hidden-sm" name="booking_type" id="booking_type_select">
											<?php if ( is_set( $host['service_types'], 1 ) && is_set( $host['service_types'], 2 ) && (is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) ) : ?>
												<option value="Pet_Boarding" selected="selected">Pet Boarding</option>
												<option value="Pet_Sitting" <?php if ( $booking_type == "Pet_Sitting" ) : echo 'selected="selected"'; endif; ?>>Pet Sitting</option>
												<option value="Other_Services" <?php if ( $booking_type == "Other_Services" ) : echo 'selected="selected"'; endif; ?>>Other Services</option>
											<?php elseif ( is_set( $host['service_types'], 1 ) && !is_set( $host['service_types'], 2 ) && (is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) ) : ?>
												<option value="Pet_Boarding" selected="selected">Pet Boarding</option>
												<option value="Other_Services" <?php if ( $booking_type == "Other_Services" ) : echo 'selected="selected"'; endif; ?>>Other Services</option>
											<?php elseif ( !is_set( $host['service_types'], 1 ) && is_set( $host['service_types'], 2 ) && (is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) ) : ?>
												<option value="Pet_Sitting" selected="selected">Pet Sitting</option>
												<option value="Other_Services" <?php if ( $booking_type == "Other_Services" ) : echo 'selected="selected"'; endif; ?>>Other Services</option>
											<?php elseif ( is_set( $host['service_types'], 4 ) || is_set( $host['service_types'], 512 ) || is_set( $host['service_types'], 8 ) || is_set( $host['service_types'], 16 ) || is_set( $host['service_types'], 32 ) || is_set( $host['service_types'], 64 ) ) : ?>
												<option value="Other_Services" selected="selected">Other Services</option>
											<?php endif; ?>
											</select>
											
											<select class="select hidden-md hidden-lg" name="booking_type" id="booking_type_select_mob">
											<?php if ( is_set( $host['service_types'], 1 ) && is_set( $host['service_types'], 2 ) && (is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) ) : ?>
												<option value="Pet_Boarding" selected="selected">Pet Boarding</option>
												<option value="Pet_Sitting" <?php if ( $booking_type == "Pet_Sitting" ) : echo 'selected="selected"'; endif; ?>>Pet Sitting</option>
												<option value="Other_Services" <?php if ( $booking_type == "Other_Services" ) : echo 'selected="selected"'; endif; ?>>Other Services</option>
											<?php elseif ( is_set( $host['service_types'], 1 ) && !is_set( $host['service_types'], 2 ) && (is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) ) : ?>
												<option value="Pet_Boarding" selected="selected">Pet Boarding</option>
												<option value="Other_Services" <?php if ( $booking_type == "Other_Services" ) : echo 'selected="selected"'; endif; ?>>Other Services</option>
											<?php elseif ( !is_set( $host['service_types'], 1 ) && is_set( $host['service_types'], 2 ) && (is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) ) : ?>
												<option value="Pet_Sitting" selected="selected">Pet Sitting</option>
												<option value="Other_Services" <?php if ( $booking_type == "Other_Services" ) : echo 'selected="selected"'; endif; ?>>Other Services</option>
											<?php elseif ( is_set( $host['service_types'], 4 ) || is_set( $host['service_types'], 512 ) || is_set( $host['service_types'], 8 ) || is_set( $host['service_types'], 16 ) || is_set( $host['service_types'], 32 ) || is_set( $host['service_types'], 64 ) ) : ?>
												<option value="Other_Services" selected="selected">Other Services</option>
											<?php endif; ?>
											</select>
											
											
											<hr>
											<?php if ( is_set( $host['service_provided'], 1 ) || is_set( $host['service_provided'], 2 )) : ?>
											<div class="pet-boarding">
											<aside class="pet-sidebar">
												<section class="pet-payment js-gig-payment">
												<form method="post" action="#">
													<div class="mp-box mp-box-white nobot">
														
														<ul class="pet-extras-list js-pet-boarding">
															
															<li class="sel-boarding" id="quantity">
																<input id="check-in-date" required name="checkin" class="hasDatepicker datetimepicker text" data-out-selector="#check-out-date" value="<?php if ( isset( $search_info['checkin'] ) ) : echo $search_info['checkin']; else : echo _($checkin); endif; ?>" type="text" placeholder="<?php echo _( 'Check-in' ); ?>" data-input="#date-check-in-input" readonly="readonly">
															

																<input id="check-out-date" name="checkout" class="hasDatepicker datetimepicker text" data-in-selector="#check-in-date" value="<?php if ( isset( $search_info['checkout'] ) ) : echo $search_info['checkout']; else : echo _( $checkout ); endif; ?>" type="text" placeholder="<?php echo _( 'Check-out' ); ?>" data-input="#date-check-out-input" readonly="readonly">
																<input type="hidden" name="boarding_nights" id="boarding_nights" value="<?php if (isset( $boarding_nights)) : echo _($boarding_nights); else: echo '0'; endif; ?>" />
															</li>
															<?php if ( is_set( $host['service_provided'], 1 ) && is_set( 4 , $host['service_size_accepted'] ) && $rates[1][1][4] > 0 ) : ?>
															<li class="sel-boarding" id="quantity">
																	<span class="extra-text"><?php echo _( 'Big Dog' ); ?></span>
																	<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Weight greater than 20kg."'); ?>></span>
																	<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][1][4]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																	<input type="hidden" id="big_dog_boarding_rate" value="<?php echo $rates[1][1][4]; ?>" />
																	<div class="fake-dropdown fake-dropdown-real 1st-dog">
																	<select class="select" name="big_dog_boarding_qty" id="big_dog_boarding_qty">
																		<option value="1" selected="selected">1</option>
																		<option value="2" <?php if ( $big_dog_boarding_qty == "2" ) : echo 'selected="selected"'; endif; ?>>2</option>
																		<option value="3" <?php if ( $big_dog_boarding_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																		</select>
																	</div>
																	
																<input type="checkbox" name="big_dog_boarding" id="big_dog_boarding" <?php if ( $big_dog_boarding ) : echo 'checked="checked"'; endif; ?> value="true">
																
																<ul class="tabled-ul hidden-md hidden-lg">
																	<li>
																		<div class="row no-margin">
																		<div class="col-xs-12 no-margin">
																			<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][1][4]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																		</div>
																	</div>
																	</li>
																</ul>


																<!--<?php //if ( is_set( $host['service_types'], 128) ) : ?>
																<ul class="tabled-ul">
																	<li>
																		<div class="row no-margin">
																			<div class="col-xs-12 no-margin">
																				<input type="checkbox" id= "big_dog_boarding_meal" name="big_dog_boarding_meal" <?php //if ( $big_dog_boarding_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																				<input type="hidden" id="big_dog_boarding_meal_rate" value="<?php //echo $rates[128][1]; ?>" />
																				<small><?php //echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[128][1] ); ?></small>
																			</div>
																		</div>
																	</li>
																</ul>
																<?php //endif; ?> -->
																
															</li>
															<?php endif; ?>
															
															<?php if ( is_set( $host['service_provided'], 1 ) && is_set( 2 , $host['service_size_accepted'] ) && $rates[1][1][2] > 0 ) : ?>
															<li class="sel-boarding" id="quantity">
																	<span class="extra-text"><?php echo _( 'Medium Dog' ); ?></span>
																	<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Weight between 10 and 20kg."'); ?>></span>
																	<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][1][2]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																	<input type="hidden" id="medium_dog_boarding_rate" value="<?php echo $rates[1][1][2]; ?>" />
																	<div class="fake-dropdown fake-dropdown-real 1st-dog">
																	<select class="select" id="medium_dog_boarding_qty" name="medium_dog_boarding_qty">
																		<option value="1" selected="selected">1</option>
																		<option value="2" <?php if ( $medium_dog_boarding_qty == "2" ) : echo 'selected="selected"'; endif; ?>>2</option>
																		<option value="3" <?php if ( $medium_dog_boarding_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																	</select>
																	</div>
																	<input type="checkbox" id="medium_dog_boarding" name="medium_dog_boarding" <?php if ( $medium_dog_boarding ) : echo 'checked="checked"'; endif; ?> value="true">
																	
																	<ul class="tabled-ul hidden-md hidden-lg">
																		<li>
																			<div class="row no-margin">
																			<div class="col-xs-12 no-margin">
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][1][2]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																			</div>
																		</div>
																		</li>
																	</ul>


																<!--<?php if ( is_set( $host['service_types'], 128) ) : ?>
																<ul class="tabled-ul">
																	<li>
																		<div class="row no-margin">
																			<div class="col-xs-12 no-margin">
																				<input type="checkbox" id="medium_dog_boarding_meal" name="medium_dog_boarding_meal" <?php if ( $medium_dog_boarding_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																				<input type="hidden" id="medium_dog_boarding_meal_rate" value="<?php echo $rates[128][1]; ?>" />
																				<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[128][1] ); ?></small>
																			</div>
																		</div>
																	</li>
																</ul>
																<?php endif; ?>-->
																
															</li>
															<?php endif; ?>
															
															<?php if ( is_set( $host['service_provided'], 1 ) && is_set( 1, $host['service_size_accepted'] ) && $rates[1][1][1] > 0 ) : ?>
															<li class="sel-boarding" id="quantity">
																	<span class="extra-text"><?php echo _( 'Small Dog' ); ?></span>
																	<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Weight less than 10kg."'); ?>></span>
																	<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][1][1]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																	<input type="hidden" id="small_dog_boarding_rate" value="<?php echo $rates[1][1][1]; ?>" />
																	<div class="fake-dropdown fake-dropdown-real 1st-dog">
																	<select class="select" id="small_dog_boarding_qty" name="small_dog_boarding_qty">
																		<option value="1" selected="selected">1</option>
																		<option value="2" <?php if ( $small_dog_boarding_qty == "2" ) : echo 'selected="selected"'; endif; ?>>2</option>
																		<option value="3" <?php if ( $small_dog_boarding_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																	</select>
																	</div>
																	<input type="checkbox" id="small_dog_boarding" name="small_dog_boarding" <?php if ( $small_dog_boarding ) : echo 'checked="checked"'; endif; ?> value="true">
																	
																	<ul class="tabled-ul hidden-md hidden-lg">
																		<li>
																			<div class="row no-margin">
																			<div class="col-xs-12 no-margin">
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][1][1]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																			</div>
																		</div>
																		</li>
																	</ul>


																<!--<?php if ( is_set( $host['service_types'], 128) ) : ?>
																<ul class="tabled-ul">
																	<li>
																		<div class="row no-margin">
																			<div class="col-xs-12 no-margin">
																				<input type="checkbox" id= "small_dog_boarding_meal" name="small_dog_boarding_meal" <?php if ( $small_dog_boarding_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																				<input type="hidden" id="small_dog_boarding_meal_rate" value="<?php echo $rates[128][1]; ?>" />
																				<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[128][1] ); ?></small>
																			</div>
																		</div>
																	</li>
																</ul>
																<?php endif; ?>-->
																
															</li>
															<?php endif; ?>
															
															<?php if ( is_set( $host['service_provided'], 2 ) && $rates[1][2][0] > 0 ) : ?>
																<li class="sel-boarding" id="quantity">
																	<span class="extra-text"><?php echo _( 'Cat' ); ?></span>
																	<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[1][2][0]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																	<input type="hidden" id="cat_boarding_rate" value="<?php echo $rates[1][2][0]; ?>" />
																	<div class="fake-dropdown fake-dropdown-real 1st-dog">
																	<select class="select" id= "cat_boarding_qty" name="cat_boarding_qty">
																		<option value="1" selected="selected">1</option>
																		<option value="2" <?php if ( $cat_boarding_qty == "2" ) : echo 'selected="selected"'; endif; ?>>2</option>
																		<option value="3" <?php if ( $cat_boarding_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																	</select>
																	</div>
																	<input type="checkbox" id = "cat_boarding" name="cat_boarding" <?php if ( $cat_boarding) : echo 'checked="checked"'; endif; ?> value="true">


																	<!--<?php if ( is_set( $host['service_types'], 256) ) : ?>
																	<ul class="tabled-ul">
																		<li>
																			<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<input type="checkbox" id="cat_boarding_meal" name="cat_boarding_meal" <?php if ( $cat_boarding_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																					<input type="hidden" id="cat_boarding_meal_rate" value="<?php echo $rates[256][2]; ?>" />
																					<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[256][2] ); ?></small>
																				</div>
																			</div>
																		</li>
																	</ul>
																	<?php endif; ?>-->
																</li>
															<?php endif; ?>
															
														</ul>
														
														<div class="pet-order-button order-multi js-order-multi">
															<div class="shopping-cart cf">
																<input type="hidden" name="total_pets_boarding" id="total_pets_boarding" value="<?php if (isset( $total_pets_boarding)) : echo _($total_pets_boarding); else: echo ''; endif; ?>" />
																<input type="hidden" name="opt" value="pet_boarding_booking" />
																<input type="submit" id="pet-boarding-book-now" class="btn-standard-lrg btn-grad js-btn-boarding" value="<?php echo _( 'Book Now' ); ?>"/>
															</div>
														</div>
												</div>
												</form>
											</section>

																			
											</aside>
											</div>
											<?php endif; ?>
											
											<div class="pet-sitting" style="display:none">
												<aside class="pet-sidebar">
													<section class="pet-payment js-gig-payment">
														<form method="post" action="#">
														<div class="mp-box mp-box-white nobot">
															
															<ul class="pet-extras-list js-pet-boarding">
																
																<li class="sel-boarding" id="quantity">
																	<input id="check-in-date-sitting" name="checkinsit" class="hasDatepicker datetimepicker text" data-out-selector="#check-out-date-sitting" value="<?php if ( isset( $search_info['checkin'] ) ) : echo $search_info['checkin']; else : echo _($checkinsit); endif; ?>" type="text" placeholder="<?php echo _( 'Check-in' ); ?>" data-input="#date-check-in-input" readonly="readonly">
																

																	<input id="check-out-date-sitting" name="checkoutsit" class="hasDatepicker datetimepicker text" data-in-selector="#check-in-date-sitting" value="<?php if ( isset( $search_info['checkout'] ) ) : echo $search_info['checkout']; else : echo _( $checkoutsit); endif; ?>" type="text" placeholder="<?php echo _( 'Check-out' ); ?>" data-input="#date-check-out-input" readonly="readonly">
																	<input type="hidden" name="sitting_nights" id="sitting_nights" value="<?php if (isset( $sitting_nights)) : echo _($sitting_nights); else: echo '0'; endif; ?>" />
																</li>
																<?php if ( is_set( $host['service_provided'], 1 ) && is_set( 4, $host['service_size_accepted'] ) && $rates[2][1][4] > 0 ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Big Dog' ); ?></span>
																		<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Weight greater than 20kg."'); ?>></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][1][4]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="big_dog_sitting_rate" value="<?php echo $rates[2][1][4]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																		<select class="select" id="big_dog_sitting_qty" name="big_dog_sitting_qty">
																			<option value="1" selected="selected">1</option>
																			<option value="2" <?php if ( $big_dog_sitting_qty == "2" ) : echo 'selected="selected"'; endif; ?>>2</option>
																			<option value="3" <?php if ( $big_dog_sitting_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																		</select>
																		</div>
																		
																		<input type="checkbox" id="big_dog_sitting" name="big_dog_sitting" <?php if ( $big_dog_sitting ) : echo 'checked="checked"'; endif; ?> value="true">
																		
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][1][4]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																				</div>
																			</div>
																			</li>
																		</ul>


																	<!--<?php if ( is_set( $host['service_types'], 128) ) : ?>
																	<ul class="tabled-ul">
																		<li>
																			<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<input type="checkbox" id="big_dog_sitting_meal" name="big_dog_sitting_meal" <?php if ( $big_dog_sitting_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																					<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[128][1] ); ?></small>
																					<input type="hidden" id="big_dog_sitting_meal_rate" value="<?php echo $rates[128][1]; ?>" />
																				</div>
																			</div>
																		</li>
																	</ul>
																	<?php endif; ?>-->
																	
																</li>
																<?php endif; ?>
																
																<?php if ( is_set( $host['service_provided'], 1 ) && is_set( 2, $host['service_size_accepted'] ) && $rates[2][1][2] > 0 ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Medium Dog' ); ?></span>
																		<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Weight between 10 and 20kg."'); ?>></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][1][2]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="medium_dog_sitting_rate" value="<?php echo $rates[2][1][2]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																		<select id="medium_dog_sitting_qty" name="medium_dog_sitting_qty" class="select">
																			<option value="1" selected="selected">1</option>
																			<option value="2" <?php if ( $medium_dog_sitting_qty == "2" ) : echo 'selected="selected"'; endif; ?> >2</option>
																			<option value="3" <?php if ( $medium_dog_sitting_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																		</select>
																		</div>
																		<input type="checkbox" name="medium_dog_sitting" id="medium_dog_sitting" <?php if ( $medium_dog_sitting ) : echo 'checked="checked"'; endif; ?> value="true">
																		
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][1][2]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																				</div>
																			</div>
																			</li>
																		</ul>


																	<!--<?php if ( is_set( $host['service_types'], 128) ) : ?>
																	<ul class="tabled-ul">
																		<li>
																			<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<input type="checkbox" name="medium_dog_sitting_meal" id="medium_dog_sitting_meal" <?php if ( $medium_dog_sitting_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																					<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[128][1] ); ?></small>
																					<input type="hidden" id="medium_dog_sitting_meal_rate" value="<?php echo $rates[128][1]; ?>" />
																				</div>
																			</div>
																		</li>
																	</ul>
																	<?php endif; ?>-->
																	
																</li>
																<?php endif; ?>
																
																<?php if ( is_set( $host['service_provided'], 1 ) && is_set( 1, $host['service_size_accepted'] ) && $rates[2][1][1] > 0 ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Small Dog' ); ?></span>
																		<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Weight less than 10kg."'); ?>></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][1][1]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="small_dog_sitting_rate" value="<?php echo $rates[2][1][1]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																		<select id="small_dog_sitting_qty" name="small_dog_sitting_qty" class="select">
																			<option value="1" selected="selected">1</option>
																			<option value="2" <?php if ( $small_dog_sitting_qty == "2" ) : echo 'selected="selected"'; endif; ?> >2</option>
																			<option value="3" <?php if ( $small_dog_sitting_qty == "3" ) : echo 'selected="selected"'; endif; ?> >3</option>
																		</select>
																		</div>
																		<input type="checkbox" id="small_dog_sitting" name="small_dog_sitting" <?php if ( $small_dog_sitting ) : echo 'checked="checked"'; endif; ?> value="true">
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][1][1]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																				</div>
																			</div>
																			</li>
																		</ul>


																	<!--<?php if ( is_set( $host['service_types'], 128) ) : ?>
																	<ul class="tabled-ul">
																		<li>
																			<div class="row no-margin">
																				<div class="col-xs-12 no-margin">
																					<input type="checkbox" name="small_dog_sitting_meal" id="small_dog_sitting_meal" <?php if ( $small_dog_sitting_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																					<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[128][1] ); ?></small>
																					<input type="hidden" id="small_dog_sitting_meal_rate" value="<?php echo $rates[128][1]; ?>" />
																				</div>
																			</div>
																		</li>
																	</ul>
																	<?php endif; ?>-->
																	
																</li>
																<?php endif; ?>
																
																<?php if ( is_set( $host['service_provided'], 2 ) && $rates[2][2][0] > 0 ) : ?>
																	<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Cat' ); ?></span>
																		<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[2][2][0]; ?> / <?php echo _( 'night' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="cat_sitting_rate" value="<?php echo $rates[2][2][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																		<select id="cat_sitting_qty" name="cat_sitting_qty" class="select" name="pet_less_than_ten_1">
																			<option value="1" selected="selected">1</option>
																			<option value="2" <?php if ( $cat_sitting_qty == "2" ) : echo 'selected="selected"'; endif; ?> >2</option>
																			<option value="3" <?php if ( $cat_sitting_qty == "3" ) : echo 'selected="selected"'; endif; ?>>3</option>
																		</select>
																		</div>
																		<input type="checkbox" name="cat_sitting" id="cat_sitting" <?php if ( $cat_sitting ) : echo 'checked="checked"'; endif; ?> value="true">


																		<!--<?php if ( is_set( $host['service_types'], 256) ) : ?>
																		<ul class="tabled-ul">
																			<li>
																				<div class="row no-margin">
																					<div class="col-xs-12 no-margin">
																						<input type="checkbox" name="cat_sitting_meal" id="cat_sitting_meal" <?php if ( $cat_sitting_meal ) : echo 'checked="checked"'; endif; ?> value="true">
																						<small><?php echo sprintf( _( 'Include meals( + %s )' ), C( 'PET_CURRENCY' ) . ' ' . $rates[256][2] ); ?></small>
																						<input type="hidden" id="cat_sitting_meal_rate" value="<?php echo $rates[256][2]; ?>" />
																					</div>
																				</div>
																			</li>
																		</ul>
																		<?php endif; ?>-->
																	</li>
																<?php endif; ?>
																
															</ul>
															
															<div class="pet-order-button order-multi js-order-multi">
																<div class="shopping-cart cf">
																	<input type="hidden" name="total_pets_sitting" id="total_pets_sitting" value="<?php if (isset( $total_pets_sitting)) : echo _($total_pets_sitting); else: echo ''; endif; ?>" />
																	<input type="hidden" name="opt" value="pet_sitting_booking" />
																	<input type="submit" id="pet_sitting_book_now" class="btn-standard-lrg btn-grad js-btn-boarding" value="<?php echo _( 'Book Now' ); ?>"/>
																</div>
															</div>
													</div>
													</form>
												</section>

																			
											</aside>
											</div>
											
											<div class="other-services" style="display:none">
											<aside class="pet-sidebar">
													<section class="pet-payment js-gig-payment">
														<form method="post" action="#">
														<div class="mp-box mp-box-white nobot">
															
															<ul class="pet-extras-list js-other-services">

																<?php if ( is_set( $host['service_types'], 4 ) || is_set( $host['service_types'], 512 ) || is_set( $host['service_types'], 8 ) || is_set( $host['service_types'], 16 ) || is_set( $host['service_types'], 32 ) || is_set( $host['service_types'], 64 ) ) : ?>
																<li class="sel-boarding" id="quantity">
																	<input id="check-in-date-other" name="checkinot" class="hasDatepicker datetimepicker text" value="<?php if ( isset( $search_info['checkin'] ) ) : echo $search_info['checkin']; else : echo _( $checkinot ); endif; ?>" type="text" placeholder="<?php echo _( 'Check-in' ); ?>" data-input="#date-check-in-input" readonly="readonly">
																	<input type="hidden" id="other_nights" name="other_nights" value="<?php if (isset( $other_nights)) : echo _($other_nights); else: echo ''; endif; ?>" />
																</li>
																<?php endif; ?>
																<?php if ( is_set( $host['service_types'], 4 ) && $rates[4][0] > 0 ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Day Care ' ); ?></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[4][0]; ?> / <?php echo _( 'day' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="day_care_rate" value="<?php echo $rates[4][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																			<select id="day_care_qty" name="day_care_qty" class="form-group" name="service_type_4">
																				<?php for( $i = 0; $i <= 10; $i++ ) : ?>
																					<option value="<?php echo $i; ?>" <?php if ( $day_care_qty  == $i ) : echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		<span class="input-group-addon"><?php echo _( 'days' ); ?></span>	
																		</div>
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[4][0]; ?> / <?php echo _( 'day' ); ?></span><?php echo _( ' )' ); ?></span>
																			</li>
																		</ul>
																		
																</li>
																<?php endif; ?>
																<?php if ( is_set( $host['service_types'], 512 ) && $rates[512][0]) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Home Visit ' ); ?></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[512][0]; ?> / <?php echo _( 'visit' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="home_visit_rate" value="<?php echo $rates[512][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																			<select id="home_visit_qty" name="home_visit_qty" class="form-group" name="service_type_512">
																				<?php for( $i = 0; $i <= 10; $i++ ) : ?>
																					<option value="<?php echo $i; ?>" <?php if ( $home_visit_qty  == $i ) : echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		<span class="input-group-addon"><?php echo _( 'visits' ); ?></span>	
																		</div>
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[512][0]; ?> / <?php echo _( 'visit' ); ?></span><?php echo _( ' )' ); ?></span>
																			</li>
																		</ul>
																		
																</li>
																<?php endif; ?>
																<?php if ( is_set( $host['service_types'], 8 ) && $rates[8][0] ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Pet Walking ' ); ?></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[8][0]; ?> / <?php echo _( 'time' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="pet_walking_rate" value="<?php echo $rates[8][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																			<select id="pet_walking_qty" name="pet_walking_qty" class="form-group" name="service_type_8">
																				<?php for( $i = 0; $i <= 10; $i++ ) : ?>
																					<option value="<?php echo $i; ?>" <?php if ( $pet_walking_qty  == $i ) : echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		<span class="input-group-addon"><?php echo _( 'hours' ); ?></span>	
																		</div>
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[8][0]; ?> / <?php echo _( 'time' ); ?></span><?php echo _( ' )' ); ?></span>
																			</li>
																		</ul>
																		
																</li>
																<?php endif; ?>
																
																<?php if ( is_set( $host['service_types'], 16 ) && $rates[16][0] ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Pet Grooming' ); ?></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[16][0]; ?> / <?php echo _( 'time' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="pet_grooming_rate" value="<?php echo $rates[16][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																			<select id="pet_grooming_qty" name="pet_grooming_qty" class="form-group" name="service_type_16">
																				<?php for( $i = 0; $i <= 10; $i++ ) : ?>
																					<option value="<?php echo $i; ?>" <?php if ( $pet_grooming_qty == $i ) : echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		<span class="input-group-addon"><?php echo _( 'times' ); ?></span>	
																		</div>
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[16][0]; ?> / <?php echo _( 'time' ); ?></span><?php echo _( ' )' ); ?></span>
																			</li>
																		</ul>
																		
																</li>
																<?php endif; ?>
																
																<?php if ( is_set( $host['service_types'], 32 ) && $rates[32][0] ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text"><?php echo _( 'Pet Bathing' ); ?></span>
																		<span class="extra-text hidden-xs hidden-sm"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[32][0]; ?> / <?php echo _( 'Hour' ); ?></span><?php echo _( ' )' ); ?></span>
																		<input type="hidden" id="pet_bathing_rate" value="<?php echo $rates[32][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																			<select id="pet_bathing_qty" name="pet_bathing_qty" class="form-group" name="service_type_32">
																				<?php for( $i = 0; $i <= 10; $i++ ) : ?>
																					<option value="<?php echo $i; ?>" <?php if ( $pet_bathing_qty == $i ) : echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		<span class="input-group-addon"><?php echo _( 'times' ); ?></span>	
																		</div>
																		<ul class="tabled-ul hidden-md hidden-lg">
																			<li>
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[32][0]; ?> / <?php echo _( 'Hour' ); ?></span><?php echo _( ' )' ); ?></span>
																			</li>
																		</ul>
																		
																</li>
																<?php endif; ?>
																
																<?php if ( is_set( $host['service_types'], 64 ) && $rates[64][0] ) : ?>
																<li class="sel-boarding" id="quantity">
																		<span class="extra-text hidden-xs hidden-sm"><?php echo sprintf( _( 'Pick-up Service Within %s km' ), "<span class='higlight'>{$rates[64][1]}</span>" ); ?></span>
																		<span class="extra-text hidden-md hidden-lg"><?php echo _( 'Pick-ups' ); ?></span>
																		<span class="glyphicon glyphicon-info-sign hidden-lg hidden-md" aria-hidden="true" data-toggle="tooltip" <?php echo _('title="Within ' . $rates[64][1] . ' km"'); ?>></span>
																		<input type="hidden" id="pickup_service_rate" value="<?php echo $rates[64][0]; ?>" />
																		<div class="fake-dropdown fake-dropdown-real 1st-dog">
																			<select id="pickup_service_qty" name="pickup_service_qty" class="form-group" name="service_type_64">
																				<?php for( $i = 0; $i <= 10; $i++ ) : ?>
																					<option value="<?php echo $i; ?>" <?php if ( $pickup_service_qty == $i ) : echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		<span class="input-group-addon"><?php echo _( 'trips' ); ?></span>	
																		</div>
																		<ul class="tabled-ul">
																			<li>
																				<span class="extra-text"><?php echo _( ' ( ' ); ?><span class="highlight emphasize value" style="font-size:large">$<?php echo $rates[64][0]; ?> / <?php echo _( 'Trip' ); ?></span><?php echo _( ' )' ); ?></span>
																			</li>
																		</ul>
																		
																</li>
																<?php endif; ?>

															</ul>
															<div class="pet-order-button order-multi js-order-multi">
																<div class="shopping-cart cf">
																	<input type="hidden" name="opt" value="other_services_booking" />
																	<input type="submit" id="other_services_book_now" class="btn-standard-lrg btn-grad js-btn-boarding" value="<?php echo _( 'Book Now' ); ?>"/>
																</div>
															</div>
													</div>
													</form>
												</section>

																			
											</aside> 
											</div>
										</ul>
									</div>
									<hr>

								<?php endif; ?> 
                                <div id="detail-calendar-box" class="row no-margin">
                                    <div class="calendar" data-url="<?php echo U( 'Search/calendar?host_id=' . I( 'get.host_id' ) ); ?>" data-id="<?php echo $host['usr_login_id']; ?>" ></div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 margin-top-10">
                                        <div class="explain explain-blue pull-left"></div>
                                        <div class="pull-left"><?php echo _( 'Available' ); ?></div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 margin-top-10">
                                        <div class="explain explain-red pull-left"></div>
                                        <div class="pull-left"><?php echo _( 'Occupied' ); ?></div>
                                    </div>
                                </div>
								
								<hr>

                                <div id="host-info-box" class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
										<?php if ( !empty( $host['pet_head_img_url']) ): ?> 
                                        <img src="<?php echo $host['pet_head_img_url']; ?>" width="140" height="140" alt="" class="img-circle" />
										<?php endif; ?>
										<?php if ( !empty( $host['pet_name']) ): ?> 
                                        <h3 class="block-title text-center margin-top-5"><strong><?php echo $host['pet_name']; ?></strong></h3>
										<?php endif; ?>
                                    </div>
                                    
									<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <div class="info-badge">
										<?php if ( !empty( $host['pet_age']) ): ?> 
                                            <h3><?php echo to_age( $host['pet_age'] ); ?></h3>
										<?php endif; ?>
                                        </div>
                                        <div class="info-badge">
										<?php if ( !empty( $host['pet_gender']) ): ?> 
											<?php foreach( $GLOBALS['pet_gender_enum'] as $key => $enum ) : ?>
												<?php if ( $key == $host['pet_gender'] ) : ?>
													<h3><?php echo _( $enum ); ?></h3>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
                                        </div>
                                        <div class="info-badge">
										<?php if ( !empty( $host['pet_is_neutered']) ): ?> 
											<?php foreach( $GLOBALS['pet_is_neutered'] as $key => $enum ) : ?>
												<?php if ( $key == $host['pet_is_neutered'] ) : ?>
													<h3><?php echo _( $enum ); ?></h3>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
                                        </div>
                                    </div>
									
                               </div>

                                <!--<hr>

                                <div id="host-info-box" class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <img src="<?php echo $host['head_img_url']; ?>" width="140" height="140" alt="" class="img-circle" />
                                        <h3 class="block-title text-center margin-top-5"><strong><?php echo $host['first_name']; ?></strong></h3>
                                    </div>
                                    <!--
									<div class="col-md-5 col-sm-5 col-xs-5 text-center">
                                        <img src="<?php echo $host['head_img_url']; ?>" width="140" height="140" alt="" class="img-circle" />
                                        <h3 class="block-title text-center margin-top-5"><strong><?php echo $host['first_name']; ?></strong></h3>
                                    </div>
									<div class="col-md-7 col-sm-7 col-xs-7">
                                        <div class="info-badge">
                                            <img src="<?php echo PET_PUBLIC_URL;?>images/badge1.png">
                                            <h3><?php echo _( 'To much better.' ); ?></h3>
                                        </div>
                                        <div class="info-badge">
                                            <img src="<?php echo PET_PUBLIC_URL;?>images/badge2.png">
                                            <h3><?php echo _( 'Very well.' ); ?></h3>
                                        </div>
                                        <div class="info-badge">
                                            <img src="<?php echo PET_PUBLIC_URL;?>images/badge3.png">
                                            <h3><?php echo _( '2 Repeat Guests.' ); ?></h3>
                                        </div>
                                    </div>
									-->
                               <!-- </div>

                                <hr>

                                <div id="host-info-well" class="row no-margin">
                                    <div class="col-md-4 col-sm-4 col-xs-4 well text-center">
                                        <h3 class="block-title"><strong><?php echo _( 'Response Rate' ); ?></strong></h3>
                                        <p><?php echo $response_rate; ?>%</p>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 well text-center">
                                        <h3 class="block-title"><strong><?php echo _( 'Response Time' ); ?></strong></h3>
                                        <p><?php echo ( empty( $host['response_time'] ) ? "Prompt" : to_response_time( $host['response_time'], '' ) ); ?></p>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 well text-center">
                                        <h3 class="block-title"><strong><?php echo _( 'Last Activity' ); ?></strong></h3>
                                        <p><?php echo to_time( $host['latest_date'] ); ?></p>
                                    </div>
                                </div>
                                  
								<div class="row no-margin">
                                    
                                    <!-- Greet & Meet -->

                                   <!-- <?php $user_id = get_session_id();
                                    if ( empty( $user_id ) ) : ?>

                                    <a class="button wide-fat capital logo_blue" href="<?php echo U( 'User/login' ) . '?redirect_to=' . $_self; ?>" >Login to send a Greet & Meet message</a>

                                    <?php else : ?>

                                    <div id="greet-meet" class="collapse">
                                        <form method="post" action="#" name="comments-form" id="comments-form">
                                            <div class="form-group">
                                                <input type="text" value="Meet & Greet Request" class="form-control" title="comments-form-title" name="title" disabled>
                                            </div>
                                            
                                            <div class="form-group">
                                                <textarea placeholder="Your Message ..." class="form-control" title="comments-form-comments" name="letter" rows="6"></textarea>
                                            </div>
											<div class="col-xs-1">
												<div class="form-group">
													<input type="checkbox" name="agree" required />										
												</div>
											</div>
											<div class="col-xs-11">
												<div class="form-group">
													<label><?php echo _( 'I agree to pay for any service with the Host only through the Petkeepa platform, I understand that the fees are needed to continue to continuously expand Petkeepa features and build a trusted community in Petkeepa.' ); ?></label>
												</div>
											</div>
                                            <div class="form-group">
                                                <div class="col-xs-12 no-margin">
                                                    <input type="hidden" name="opt" value="meet" />
                                                    <button type="submit" class="button wide-fat"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<?php echo _( 'SEND' ); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- END Greet & Meet -->

                                   <!-- <button type="button" class="button wide-fat capital logo_blue" data-toggle="collapse" data-target="#greet-meet" aria-expanded="true" aria-controls="greet-meet"><?php echo _( 'Meet & Greet Request' ); ?></button>

                                    <?php endif; ?>
                                </div>
								  
                                <div class="row no-margin">
                                    
                                    <!-- Online chat -->

                                  <!--  <?php $user_id = get_session_id();
                                    if ( empty( $user_id ) ) : ?>

                                    <a class="button wide-fat capital logo_blue" href="<?php echo U( 'User/login' ) . '?redirect_to=' . $_self; ?>" >Login to send message</a>

                                    <?php else : ?>

                                    <div id="online-chat" class="collapse">
                                        <form method="post" action="#" name="comments-form" id="comments-form">
                                            <div class="form-group">
                                                <input type="text" placeholder="Title" class="form-control" name="title" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <textarea placeholder="Your Message ..." class="form-control" name="letter" rows="6" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-xs-12 no-margin">
                                                    <input type="hidden" name="opt" value="chat" />
                                                    <button type="submit" class="button wide-fat"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<?php echo _( 'SEND' ); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- END Online chat -->

                                   <!-- <button type="button" class="button wide-fat capital logo_blue" data-toggle="collapse" data-target="#online-chat" aria-expanded="true" aria-controls="online-chat"><?php echo _( 'Message Me' ); ?></button>

                                    <?php endif; ?>
                                    <a href="javascript:;" class="button wide-fat white margin-top-10 margin-bottom-10 collection_button <?php if ( ! $is_collected ) : echo 'add_collection'; else : echo 'remove_collection'; endif; ?>" data-add-url="<?php echo U( 'User/Booking/add_saved' ); ?>" data-remove-url="<?php echo U( 'User/Booking/remove_saved' ); ?>" data-collection="<?php echo $host['usr_login_id']; ?>" ><?php if( ! $is_collected ) : echo _( 'Add To Favourite List' ); else : echo _( 'Remove Favourite From List' ); endif; ?></a>
                                </div>
                            </div>
                        </div> -->

                       
                    </div>
                </div>
            </section>
<?php echo $_footer; ?>
