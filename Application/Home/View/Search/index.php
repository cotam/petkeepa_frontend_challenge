<?php echo $_header; ?>
<?php echo $_navigation_alt; ?>
            <section id="search-page" class="section wide-fat">
                <div class="row no-margin">
					<div id="search-filter-box" class="search-filter-box col-xs-12">
                        <?php echo $_search_filter; ?>
                    </div>
                    <div id="search-map-box" class="col-md-5 no-margin">
                        <div id="map_canvas" class="search-map" data-input="#places_input" data-lat="<?php echo $latlng['lat']; ?>" data-lng="<?php echo $latlng['lng']; ?>" data-zoom="<?php echo $latlng['zoom']; ?>" data-title="<?php echo $latlng['title']; ?>" data-address="<?php echo $latlng['address']; ?>" data-result-content=".result-content" data-result-row=".ajax-search-result" data-north-east-lat-input="#north_east_lat" data-north-east-lng-input="#north_east_lng" data-south-west-lat-input="#south_west_lat" data-south-west-lng-input="#south_west_lng" ></div>

                        <!-- Map tips -->
                        <div class="map_tip map_moved">
                            <div class="checkbox no-margin">
                                <label>
                                    <input id="auto_select" name="auto_select" type="checkbox" checked="checked" />
                                </label> 
                                <small><?php echo _( 'Search When I Move the Map' ); ?></small>
                            </div>
                        </div>
                        
                        <div class="map_tip map_close text-center">
                            <a>
                                <?php echo _( 'Redo Search Here' ); ?> <i class="fa fa-repeat"></i>
                            </a>
                        </div>
                    </div><!-- /.sidebar -->
                    <!--<div id="search-filter-box" class="search-filter-box col-md-7 col-sm-12 col-xs-12">
                        <?php //echo $_search_filter; ?>
                    </div> -->

                    <div id="search-sort-box" class="search-sort-box col-md-7 col-sm-12 col-xs-12">
                        <hr class="no-margin" />

                        <div class="row no-margin">

                            <div id="search-filter-result-box" class="col-md-7 col-sm-7 col-xs-12 hidden-md hidden-lg">
                            </div> 
                                        
                            <div class="text-right col-md-2 col-sm-2 col-xs-6 hidden-sm hidden-lg">
                                <h3 class="margin-top-10"><?php echo _( 'Sort by : ' ); ?></h3>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 hidden-sm hidden-lg" id="slider_search_box">
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
                        </div>
                    </div>
                    
                    <div id="search-result-box" class="search-result-box contents result-content grid-contents col-md-7 scroll_detial">
                        <?php echo $search_rows; ?>
                        <!-- Page Nav -->
                    </div>
                </div><!-- /.row -->
            </section><!-- /#hotels.section -->		
        <?php echo $_footer_js; ?>
