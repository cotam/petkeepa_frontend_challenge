                        <div id="hosts_box" class="hotels-filter search-box">
							<section id="js-search-summary-bar" class="search-summary-bar clearfix hidden-md hidden-lg">
								<button type="button" id="btnSearchIcon" class="search-summary-button">
								  <span class="visually-hidden"><i class="fa fa-search fa-1x"></i></span>
								</button>

								<div class="search-summary-places ">
								  <h2>
									<span id="country_chosen"><?php if ( $search_info['keywords'] == '' ) echo _( 'Enter a location' ); else echo $search_info['keywords']; ?></span>
								  </h2>
								</div>
								<p class="search-summary-info">
								  
								  <span class="travellers">
									<?php if ( $search_info['checkin'] == '' ) echo _( 'Check-in' ); else echo $search_info['checkin']; ?>
								</span>
								  <span id="checkout"><?php if ( $search_info['checkout'] == '' ) echo _( 'Check-out' ); else echo $search_info['checkout']; ?></span>
								</p>
							</section>
                            <form id="filter-search" class="location-search ajax-form margin-top-10" method="get">
                                <div class="row no-margin">
                                    <div class="col-md-12 col-sm-12 col-xs-12 no-margin">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <input id="places_input" name="keywords" class="text controls stop-auto-submit" value="<?php if ( isset( $search_info['keywords'] ) ) echo $search_info['keywords']; ?>" type="text" placeholder="<?php echo _( 'Enter a location' ); ?>">
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <input id="check-in-date" name="checkin" class="traveline_date_input hasDatepicker datetimepicker text" data-out-selector="#check-out-date" value="<?php if ( isset( $search_info['checkin'] ) ) echo $search_info['checkin']; ?>" type="text" placeholder="<?php echo _( 'Check in' ); ?>" readonly="readonly">
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <input id="check-out-date" name="checkout" class="traveline_date_input hasDatepicker datetimepicker text" data-in-selector="#check-in-date" value="<?php if ( isset( $search_info['checkout'] ) ) echo $search_info['checkout']; ?>" type="text" placeholder="<?php echo _( 'Check out' ); ?>" readonly="readonly">
                                        </div>
										<div class="col-md-3 col-sm-3 col-xs-12">
											<button type="submit" class="button pink narrow wide-fat" placeholder=""><?php echo _( 'Search' ); ?></span><!--<i class="fa fa-search fa-1x fa-lg"></i>--></button>
										</div>
                                        <!-- More Filter-->
                                        <div id="filter-more" class="filter-list panel-collapse collapse hidden-sm hidden-xs">
                                            <ul>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Service' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <?php foreach ( $pet_service_type_enum as $key => $enum ) : ?>
                                                            <?php if ( '1024' != $key && '128' != $key && '256' != $key  ) : ?>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="checkbox" name="service_types[]" value="<?php echo $key; ?>" /><label><b><?php echo $enum; ?></b></label></li>
                                                            <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Slots Needed' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <?php foreach ( $pet_slots_needed_enum as $key => $enum ) : ?>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="radio" name="slots_needed" value="<?php echo $key; ?>" /><label><b><?php echo $enum; ?></b></label></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Type of Pet' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <?php foreach ( $pet_service_provided_enum as $key => $enum ) : ?>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="checkbox" name="service_provided[]" value="<?php echo $key; ?>" <?php if ( $key == '1' ) : echo 'data-select-hide="#pet_level"'; endif; ?> /><label><b><?php echo $enum; ?></b></label></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li id="pet_level" class="panel-collapse collapse in">
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Dog Size' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <?php foreach ( $pet_dog_size_accepted_enum as $key => $enum ) : ?>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="checkbox" name="service_size_accepted[]" value="<?php echo $key; ?>" /><label><b><?php echo $enum; ?></b></label></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Host with Pets' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="checkbox" name="resident_pets" value="1" /><label><b>Yes</b></label></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Type of Residence' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <?php foreach ( $pet_property_type_enum as $key => $enum ) : ?>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="checkbox" name="property_type[]" value="<?php echo $key; ?>" /><label><b><?php echo $enum; ?></b></label></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Host with Yard' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <li class="col-md-3 col-sm-3 col-xs-4"><input type="checkbox" name="yard_type" value="1" /><label><b>Yes</b></label></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Specific Skills' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <?php foreach ( $pet_skill_enum as $key => $enum ) : ?>
                                                            <li class="col-md-6 col-sm-6 col-xs-6"><input type="checkbox" name="skills[]" value="<?php echo $key; ?>" /><label><b><?php echo $enum; ?></b></label></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Max Price' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <li class="col-md-1 col-sm-1 col-xs-2">
                                                                <label id="price_label"><b>$0</b></label>
                                                                <input type="hidden" id="price" value="0" name="price" />
                                                            </li>
                                                            <li class="col-md-6 col-sm-6 col-xs-8">
                                                                <div class="box_slider" data-min="1" data-max="200" data-value="0" data-label="#price_label" data-hide="#price" data-pre="$"></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-md-12"><h3><b><?php echo _( 'Min Score' ); ?></b></h3></div>
                                                    <div class="col-md-12 no-margin">
                                                        <ul>
                                                            <li class="col-md-1 col-sm-1 col-xs-2">
                                                                <label id="score_label"><b>0</b></label>
                                                                <input type="hidden" id="score" value="0" name="score" />
                                                            </li>
                                                            <li class="col-md-6 col-sm-6 col-xs-8">
                                                                <div class="box_slider" data-min="1" data-max="5" data-step="1" data-value="0" data-label="#score_label" data-hide="#score" ></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
											<input type="hidden" id="service" value="0"/>
											<input type="hidden" id="pet_type" value="0"/>
											<input type="hidden" id="dog_size" value="0"/>
											<input type="hidden" id="residence" value="0"/>
											<input type="hidden" id="skills" value="0"/>
                                        </div>
                                        <!-- END More Filter-->
                                        <div class="filter-buttons">
                                            <!--<div class="col-md-9 col-sm-9 col-xs-6">-->
												<div id="search-buttons" class="search-field col-md-1 col-sm-1 col-xs-2 hidden-sm hidden-xs">
													<button id="search-filter-button" type="button" class="button mini brown wide-fat"><span><?php //echo _( 'Advanced Filter' ); ?></span><i class="fa fa-angle-double-down fa-2x fa-lg"></i></button>
												</div>
												<div id="search-filter-result-box" class="col-md-7 col-sm-7 col-xs-12">
												</div>
                                                <input type="hidden" id="paged" name="paged" value="" />

                                                <input type="hidden" id="screen_width" name="screen_width" value="" />

                                                <input type="hidden" id="north_east_lat" name="north_east_lat" value="" />
                                                <input type="hidden" id="north_east_lng" name="north_east_lng" value="" />
                                                <input type="hidden" id="south_west_lat" name="south_west_lat" value="" />
                                                <input type="hidden" id="south_west_lng" name="south_west_lng" value="" />

                                                <input type="hidden" id="sort_order" name="sort_order" value="" />
												
												<div class="text-right col-md-2 col-sm-2 col-xs-6 hidden-sm hidden-xs">
													<h3 class="margin-top-10"><?php echo _( 'Sort by : ' ); ?></h3>
												</div>
												<div class="col-md-2 col-sm-3 col-xs-6 hidden-sm hidden-xs" id="slider_search_box">
													<select class="chosen-select">
														<!-- mobile
														<option value=""><?php echo _( 'Nearest distance' ); ?></option>
														-->
														<option value="1"><?php echo _( 'Price high to low' ); ?></option>
														<option value="2"><?php echo _( 'Price low to high' ); ?></option>
														<option value="3"><?php echo _( 'Review score' ); ?></option>
														<option value="4"><?php echo _( 'Response Time' ); ?></option>
													</select>
												</div>

                                                <!--<button type="submit" class="button narrow wide-fat highlight" placeholder=""><?php //echo _( 'Search' ); ?></button>-->
                                            <!--</div>-->
                                            
                                        </div>
                                    </div>
                                </div>
							</form>
                        </div>
