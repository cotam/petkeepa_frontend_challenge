                                <?php foreach ( $hosts as $host ) : ?>
                                <div id="basiness_id_<?php echo $host['basiness_id']; ?>" class="row ajax-search-result" data-lat="<?php echo $host['lat']; ?>" data-lng="<?php echo $host['lng']; ?>" data-href="<?php echo U( '/Home/Search/detail', array( 'host_id' => $host['usr_login_id'] ) ) ?>" data-href-target="_blank">
                                    <div class="col-md-3 col-sm-3 col-xs-4 text-center">
                                        <img src="<?php echo $host['head_img_url']; ?>" alt="<?php echo $host['title']; ?>" width="100%">
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-xs-8">
                                        <div class="row">
                                            <div class="content">
                                                <h2 class="name-title"><b><?php echo $host['first_name']; ?>&nbsp;&nbsp;<?php echo $host['last_name']; ?></b><!--&nbsp;&nbsp;<small>( <?php echo to_time( $host['latest_date'] ); ?> )</small>--></h2>
                                                <div>
                                                    <div class="star-holder"><div class="ajax-star" data-score="<?php echo $host['score']; ?>"></div></div>
                                                    <b><?php echo $host['comments']; ?> <?php echo _( 'Reviews.' ); ?></b>
                                                </div>
                                                <hr class="margin-top-5 margin-bottom-10">
                                                <h1 class="post-title hidden-sm hidden-xs">
                                                    <b><?php echo $host['title']; ?></b>
                                                </h1>
												
												<div class="content hidden-lg hidden-md">
													<div class="price content">
														<span style="font-family:Tangerine;font-size:35px"><?php echo _( 'from' ); ?></span>
														<span class="highlight emphasize value">$<?php echo $host['minimum_price']; ?></span><span><?php echo _( 'Per Night' ); ?></span>
													</div>
												</div>
                                        
                                                <p class="hidden-xs"><b><?php echo intercept( $host['self_description'], C( 'INTERCEPT_BASE' ) ); ?></b></p>
												<p><span font-size="12px"><b><?php echo intercept( $host['street'], C( 'INTERCEPT_BASE' ) ); ?> , <?php echo intercept( $host['division_level_third'], C( 'INTERCEPT_BASE' ) ); ?></b></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 hidden-sm hidden-xs " align="center" vertical-align="middle">
                                        <div class="row">
                                            <div class="content">
                                                <div class="price content col-lg-12 col-md-12">
													<span style="font-family:Tangerine;font-size:35px"><?php echo _( 'from ' ); ?></span>
													<p><span class="highlight emphasize value">$<?php echo $host['minimum_price']; ?></span><p><span><?php echo _( ' Per Night' ); ?></p></span></p>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 ajax-search-paged">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="margin-top-10"><?php if ( $host_count == 0 ) : echo _( 'No host found.' ); elseif ( $host_count == 1 ) : echo '1 host found.'; else : echo $host_count . _( ' hosts found.' ); endif; ?></h3>
                                    </div>
                                    <div class="pagination-holder right col-md-6 col-sm-6 col-xs-6">
                                        <?php if ( $host_count != 0 ) : ?>
                                        <ul class="pagination search-paged">
                                            <?php 
                                                  if ( $host_paged['paged'] > ( 1 + 3 ) ) {
                                                      $page_start = $host_paged['paged'] - 1;
                                                  } else {
                                                      $page_start = 1;
                                                  }

                                                  if ( $host_paged['paged'] < ( $host_paged['max_paged'] - 3 ) ) {
                                                      $page_end = $host_paged['paged'] + 1;
                                                  } else {
                                                      $page_end = $host_paged['max_paged'];
                                                  }
                                            ?>
                                            <?php if ( $host_paged['paged'] != 1 ) : ?>
                                                <li><a href="javascript:;" data-paged="<?php echo $host_paged['paged'] - 1; ?>">«</a></li>
                                            <?php endif; ?>
                                            <?php if ( $host_paged['paged'] > ( 1 + 3 ) ) : ?>
                                            <?php $start = ''; ?>
                                                <li><a href="javascript:;" data-paged="1">1</a></li>
                                                <li><a href="javascript:;" class="more" >...</a></li>
                                            <?php endif; ?>
                                            <?php while( ( $page_start++ ) <= $page_end ) : ?>
                                                <li><a href="javascript:;" data-paged="<?php echo ( $page_start - 1 ); ?>"><?php echo ( $page_start - 1 ); ?></a></li>
                                            <?php endwhile; ?>
                                            <?php if ( $host_paged['paged'] < ( $host_paged['max_paged'] - 3 ) ) : ?>
                                                <li><a href="javascript:;" class="more" >...</a></li>
                                                <li><a href="javascript:;" data-paged="<?php echo $host_paged['max_paged']; ?>"><?php echo $host_paged['max_paged']; ?></a></li>
                                            <?php endif; ?>
                                            <?php if ( $host_paged['paged'] != $host_paged['max_paged'] ) : ?>
                                                <li><a href="javascript:;" data-paged="<?php echo $host_paged['paged'] + 1; ?>">»</a></li>
                                            <?php endif; ?>
                                        </ul>
                                        <?php endif; ?>
                                    </div>
                                    <script>
        jQuery(window).ready(function($) {
            var _ajax_form = $( '#ajax_form' );
            $( '.search-paged a' ).on( 'click', function () {
                var _this = $( this );
                if ( _this.data( 'paged' ) && $( '#paged' ).length > 0 ) {
                    $( '#paged' ).val( _this.data( 'paged' ) );
                    ajax_form_submit.call( _ajax_form );
                }
            } );

            $( '.ajax-search-result .ajax-star' ).each( function() {
                star_init.call( this );
            } );
            
            /**
             * jump used script
             */
            $( '[data-href]' ).on( 'click', function() {
                var _this = $( this );
                if ( _this.attr( 'data-href-target' ) == '_blank' ) {
                    window.open( _this.attr( 'data-href' ) );
                } else {
                    location.href = _this.attr( 'data-href' );
                }
            } );
			


        });

                                    </script>
                                </div>
