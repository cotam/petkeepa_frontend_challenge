<?php

namespace Home\Controller;

use Think\Controller;
use \Braintree_Transaction;

class SearchController extends HomeBaseController {
	public $_widget = array (
			'search_filter' 
	);
	
	/**
	 * Search Page
	 */
	public function index() {
		global $pet_property_type_enum, $pet_service_provided_enum, $pet_dog_size_accepted_enum, $pet_service_type_enum, $pet_slots_needed_enum, $pet_skill_enum, $pet_service_cancellation_enum;
		
		$this->assign ( 'pet_property_type_enum', $pet_property_type_enum );
		$this->assign ( 'pet_service_provided_enum', $pet_service_provided_enum );
		$this->assign ( 'pet_dog_size_accepted_enum', $pet_dog_size_accepted_enum );
		$this->assign ( 'pet_service_type_enum', $pet_service_type_enum );
		$this->assign ( 'pet_slots_needed_enum', $pet_slots_needed_enum );
		$this->assign ( 'pet_skill_enum', $pet_skill_enum );
		$this->assign ( 'pet_service_cancellation_enum', $pet_service_cancellation_enum );
		
		$d_search = D ( 'Search' );
		
		/**
		 * **** Condition *****
		 */
		$search_data = array ();
		
		// Residence type
		if (false !== I ( 'get.property_type', false )) {
			$search_data ['property_type'] = union_enum ( I ( 'get.property_type' ) );
		}
		// Courtyard type
		if (false !== I ( 'get.yard_type', false )) {
			$search_data ['yard_type'] = I ( 'get.yard_type' );
		}
		// Service collection
		if (false !== I ( 'get.service_types', false )) {
			$search_data ['service_types'] = union_enum ( I ( 'get.service_types' ) );
		}
		// Pet type
		if (false !== I ( 'get.service_provided', false )) {
			$search_data ['service_provided'] = union_enum ( I ( 'get.service_provided' ) );
		}
		// Pet size
		if (false !== I ( 'get.service_size_accepted', false )) {
			$search_data ['service_size_accepted'] = union_enum ( I ( 'get.service_size_accepted' ) );
		}
		// Skills
		if (false !== I ( 'get.skills', false )) {
			$search_data ['skills'] = union_enum ( I ( 'get.skills' ) );
		}
		// Service vavancies needed
		if (false !== I ( 'get.slots_needed', false )) {
			$search_data ['slots_needed'] = I ( 'get.slots_needed' );
		}
		// If HOST owns pet(s)
		if (false !== I ( 'get.resident_pets', false )) {
			$search_data ['resident_pets'] = I ( 'get.resident_pets' );
		}
		// Start date
		if ('' !== I ( 'get.checkin', '' )) {
			$search_data ['checkin'] = I ( 'get.checkin' );
		}
		// End date
		if ('' !== I ( 'get.checkout', '' )) {
			$search_data ['checkout'] = I ( 'get.checkout' );
		}
		// Maximum price
		if ('0' !== I ( 'get.price', '0' )) {
			$search_data ['price'] = I ( 'get.price' );
		}
		// Star level
		if ('0' !== I ( 'get.score', '0' )) {
			$search_data ['score'] = I ( 'get.score' );
		}
		// Keyword
		if ('' !== I ( 'get.keywords', '' )) {
			$search_data ['keywords'] = preg_replace ( '/[\s|\+|,|;]+/i', '|', I ( 'get.keywords' ) );
		}
		// Coordinate range
		if (I ( 'get.screen_width' ) > 768) {
			if (0 !== I ( 'get.north_east_lat', 0 ) && 0 !== I ( 'get.north_east_lng', 0 ) && 0 !== I ( 'get.south_west_lat', 0 ) && 0 !== I ( 'get.south_west_lng', 0 )) {
				$search_data ['north_east_lat'] = I ( 'get.north_east_lat' );
				$search_data ['north_east_lng'] = I ( 'get.north_east_lng' );
				$search_data ['south_west_lat'] = I ( 'get.south_west_lat' );
				$search_data ['south_west_lng'] = I ( 'get.south_west_lng' );
			}
		}
		
		/**
		 * **** Sequence *****
		 */
		if (0 !== I ( 'get.sort_order', 0 )) {
			$search_data ['sort_order'] = I ( 'get.sort_order' );
		}
		
		/**
		 * **** Paging *****
		 */
		if ('' !== I ( 'get.paged', '' )) {
			$search_data ['paged'] = I ( 'get.paged' );
		}
		
		/**
		 * **** Query *****
		 */
		$hosts = $d_search->get_hosts ( $search_data );
		$host_count = $d_search->get_host_count ();
		
		$host_paged = array (
				'paged' => I ( 'get.paged', '1' ),
				'max_paged' => ( int ) ceil ( $host_count / C ( 'PAGED' ) ) 
		);
		
		$this->assign ( 'hosts', $hosts );
		$this->assign ( 'host_count', $host_count );
		$this->assign ( 'host_paged', $host_paged );
		
		$search_rows = $this->fetch ( 'search_rows' );
		
		if (IS_AJAX) {
			$this->ajaxReturn ( array (
					'html' => $search_rows 
			) );
			exit ();
		} else {
		}
		
		$latlng = array ();
		$user_id = get_session_id ();
		
		if (false !== I ( 'get.lat', false ) && false !== I ( 'get.lng', false ) && false !== I ( 'get.keywords', false )) {
			// Priority to use user search geographic coordinates as center of map
			$latlng ['lat'] = I ( 'get.lat' );
			$latlng ['lng'] = I ( 'get.lng' );
			$latlng ['title'] = 'Location';
			$latlng ['address'] = I ( 'get.keywords' );
			$latlng ['zoom'] = C ( 'MAP_DEFAULT_ZOOM' );
		} else if ($user_id) {
			$d_user = D ( 'User/User' );
			$info = $d_user->get_user_info ( array (
					'usr_login_id' => $user_id 
			) );
			if ($info) {
				// User residential address geographic location
				$latlng ['lat'] = $info ['lat'];
				$latlng ['lng'] = $info ['lng'];
				$latlng ['title'] = 'My Home';
				$latlng ['address'] = $info ['address'];
				$latlng ['zoom'] = C ( 'MAP_DEFAULT_HOME_ZOOM' );
			}
		}
		$this->assign ( 'latlng', $latlng );
		
		$this->display ();
	}
	
	/**
	 * Search results single page
	 */
	public function detail() {
		if (false === I ( 'get.host_id', false )) {
			$this->error ( _ ( 'Parameter Error' ) );
			exit ();
		}
		if ('' != I ( 'get.preview', '' ))
		{
			$this->assign ( 'preview', true );
		}
		
		$d_letter = D ( 'User/Letter' );
		$d_search = D ( 'Search' );
		$d_host = D ( 'User/Host' );
		$d_user = D ( 'User/User' );
		$d_rate = D ( 'User/Rate' );
		$d_attachment = D ( 'User/Attachment' );
		$d_comments = D ( 'User/Comment' );
		
		$user_id = get_session_id ();
		$host_id = I ( 'get.host_id' );
		
		if ( session( '?checkin' ) ) {
			$this->assign( 'checkin', session( 'checkin' ) );
			session( 'checkin', null );
		}
		if ( session( '?checkout' ) ) {
			$this->assign( 'checkout', session( 'checkout' ) );
			session( 'checkout', null );
		}
		if ( session( '?checkinsit' ) ) {
			$this->assign( 'checkinsit', session( 'checkinsit' ) );
			session( 'checkinsit', null );
		}
		if ( session( '?checkoutsit' ) ) {
			$this->assign( 'checkoutsit', session( 'checkoutsit' ) );
			session( 'checkoutsit', null );
		}
		if ( session( '?checkinot' ) ) {
			$this->assign( 'checkinot', session( 'checkinot' ) );
			session( 'checkinot', null );
		}
		if ( session( '?total_pets_boarding' ) ) {
			$this->assign( 'total_pets_boarding', session( 'total_pets_boarding' ) );
			session( 'total_pets_boarding', null );
		}
		if ( session( '?big_dog_boarding' ) ) {
			$this->assign( 'big_dog_boarding', session( 'big_dog_boarding' ) );
			session( 'big_dog_boarding', null );
		}
		if ( session( '?big_dog_boarding_qty' ) ) {
			$this->assign( 'big_dog_boarding_qty', session( 'big_dog_boarding_qty' ) );
			session( 'big_dog_boarding_qty', null );
		}
		if ( session( '?big_dog_boarding_meal' ) ) {
			$this->assign( 'big_dog_boarding_meal', session( 'big_dog_boarding_meal' ) );
			session( 'big_dog_boarding_meal', null );
		}
		if ( session( '?medium_dog_boarding' ) ) {
			$this->assign( 'medium_dog_boarding', session( 'medium_dog_boarding' ) );
			session( 'medium_dog_boarding', null );
		}
		if ( session( '?medium_dog_boarding_qty' ) ) {
			$this->assign( 'medium_dog_boarding_qty', session( 'medium_dog_boarding_qty' ) );
			session( 'medium_dog_boarding_qty', null );
		}
		if ( session( '?medium_dog_boarding_meal' ) ) {
			$this->assign( 'medium_dog_boarding_meal', session( 'medium_dog_boarding_meal' ) );
			session( 'medium_dog_boarding_meal', null );
		}
		if ( session( '?small_dog_boarding' ) ) {
			$this->assign( 'small_dog_boarding', session( 'small_dog_boarding' ) );
			session( 'small_dog_boarding', null );
		}
		if ( session( '?small_dog_boarding_qty' ) ) {
			$this->assign( 'small_dog_boarding_qty', session( 'small_dog_boarding_qty' ) );
			session( 'small_dog_boarding_qty', null );
		}
		if ( session( '?small_dog_boarding_meal' ) ) {
			$this->assign( 'small_dog_boarding_meal', session( 'small_dog_boarding_meal' ) );
			session( 'small_dog_boarding_meal', null );
		}
		if ( session( '?boarding_nights' ) ) {
			$this->assign( 'boarding_nights', session( 'boarding_nights' ) );
			session( 'boarding_nights', null );
		}
		if ( session( '?cat_boarding' ) ) {
			$this->assign( 'cat_boarding', session( 'cat_boarding' ) );
			session( 'cat_boarding', null );
		}
		if ( session( '?cat_boarding_qty' ) ) {
			$this->assign( 'cat_boarding_qty', session( 'cat_boarding_qty' ) );
			session( 'cat_boarding_qty', null );
		}
		if ( session( '?cat_boarding_meal' ) ) {
			$this->assign( 'cat_boarding_meal', session( 'cat_boarding_meal' ) );
			session( 'cat_boarding_meal', null );
		}
		if ( session( '?total_pets_sitting' ) ) {
			$this->assign( 'total_pets_sitting', session( 'total_pets_sitting' ) );
			session( 'total_pets_sitting', null );
		}
		if ( session( '?big_dog_sitting' ) ) {
			$this->assign( 'big_dog_sitting', session( 'big_dog_sitting' ) );
			session( 'big_dog_sitting', null );
		}
		if ( session( '?big_dog_sitting_qty' ) ) {
			$this->assign( 'big_dog_sitting_qty', session( 'big_dog_sitting_qty' ) );
			session( 'big_dog_sitting_qty', null );
		}
		if ( session( '?big_dog_sitting_meal' ) ) {
			$this->assign( 'big_dog_sitting_meal', session( 'big_dog_sitting_meal' ) );
			session( 'big_dog_sitting_meal', null );
		}
		if ( session( '?medium_dog_sitting' ) ) {
			$this->assign( 'medium_dog_sitting', session( 'medium_dog_sitting' ) );
			session( 'medium_dog_sitting', null );
		}
		if ( session( '?medium_dog_sitting_qty' ) ) {
			$this->assign( 'medium_dog_sitting_qty', session( 'medium_dog_sitting_qty' ) );
			session( 'medium_dog_sitting_qty', null );
		}
		if ( session( '?medium_dog_sitting_meal' ) ) {
			$this->assign( 'medium_dog_sitting_meal', session( 'medium_dog_sitting_meal' ) );
			session( 'medium_dog_sitting_meal', null );
		}
		if ( session( '?small_dog_sitting' ) ) {
			$this->assign( 'small_dog_sitting', session( 'small_dog_sitting' ) );
			session( 'small_dog_sitting', null );
		}
		if ( session( '?small_dog_sitting_qty' ) ) {
			$this->assign( 'small_dog_sitting_qty', session( 'small_dog_sitting_qty' ) );
			session( 'small_dog_sitting_qty', null );
		}
		if ( session( '?small_dog_sitting_meal' ) ) {
			$this->assign( 'small_dog_sitting_meal', session( 'small_dog_sitting_meal' ) );
			session( 'small_dog_sitting_meal', null );
		}
		if ( session( '?sitting_nights' ) ) {
			$this->assign( 'sitting_nights', session( 'sitting_nights' ) );
			session( 'sitting_nights', null );
		}
		if ( session( '?cat_sitting' ) ) {
			$this->assign( 'cat_sitting', session( 'cat_sitting' ) );
			session( 'cat_sitting', null );
		}
		if ( session( '?cat_sitting_qty' ) ) {
			$this->assign( 'cat_sitting_qty', session( 'cat_sitting_qty' ) );
			session( 'cat_sitting_qty', null );
		}
		if ( session( '?cat_sitting_meal' ) ) {
			$this->assign( 'cat_sitting_meal', session( 'cat_sitting_meal' ) );
			session( 'cat_sitting_meal', null );
		}
		if ( session( '?booking_type' ) ) {
			$this->assign( 'booking_type', session( 'booking_type' ) );
			session( 'booking_type', null );
		}
		if ( session( '?day_care_qty' ) ) {
			$this->assign( 'day_care_qty', session( 'day_care_qty' ) );
			session( 'day_care_qty', null );
		}
		if ( session( '?home_visit_qty' ) ) {
			$this->assign( 'home_visit_qty', session( 'home_visit_qty' ) );
			session( 'home_visit_qty', null );
		}
		if ( session( '?pet_walking_qty' ) ) {
			$this->assign( 'pet_walking_qty', session( 'pet_walking_qty' ) );
			session( 'pet_walking_qty', null );
		}
		if ( session( '?pet_grooming_qty' ) ) {
			$this->assign( 'pet_grooming_qty', session( 'pet_grooming_qty' ) );
			session( 'pet_grooming_qty', null );
		}
		if ( session( '?pet_bathing_qty' ) ) {
			$this->assign( 'pet_bathing_qty', session( 'pet_bathing_qty' ) );
			session( 'pet_bathing_qty', null );
		}
		if ( session( '?pickup_service_qty' ) ) {
			$this->assign( 'pickup_service_qty', session( 'pickup_service_qty' ) );
			session( 'pickup_service_qty', null );
		}
		if ( session( '?other_nights' ) ) {
			$this->assign( 'other_nights', session( 'other_nights' ) );
			session( 'other_nights', null );
		}
		if (IS_POST) {
			switch (I ( 'post.opt', '' )) {
				case 'pet_boarding_booking' :
					if (! get_session_id () || ! D ( 'User/User' )->user_exist_verifition ( array (
								'id' => get_session_id () 
						) )) {
							if ( ! session( '?booking_type' ) ) {
								session( array( 'name' => 'booking_type', 'expire' => 1200 ) );
								session( 'booking_type', 'Pet_Boarding' );
							}
							if ( ! session( '?checkin' ) ) {
								session( array( 'name' => 'checkin', 'expire' => 1200 ) );
								session( 'checkin', I ( 'post.checkin', '' ) );
							}
							if ( ! session( '?checkout' ) ) {
								session( array( 'name' => 'checkout', 'expire' => 1200 ) );
								session( 'checkout', I ( 'post.checkout', '' ) );
							}
							if ( ! session( '?total_pets_boarding' ) ) {
								session( array( 'name' => 'total_pets_boarding', 'expire' => 1200 ) );
								session( 'total_pets_boarding', I ( 'post.total_pets_boarding', '' ) );
							}
							if ( ! session( '?boarding_nights' ) ) {
								session( array( 'name' => 'boarding_nights', 'expire' => 1200 ) );
								session( 'boarding_nights', I ( 'post.boarding_nights', '' ) );
							}
							if ( ! session( '?big_dog_boarding' ) ) {
								session( array( 'name' => 'big_dog_boarding', 'expire' => 1200 ) );
								session( 'big_dog_boarding', I ( 'post.big_dog_boarding', '' ) );
							}
							if ( ! session( '?big_dog_boarding_qty' ) ) {
								session( array( 'name' => 'big_dog_boarding_qty', 'expire' => 1200 ) );
								session( 'big_dog_boarding_qty', I ( 'post.big_dog_boarding_qty', '' ) );
							}
							if ( ! session( '?big_dog_boarding_meal' ) ) {
								session( array( 'name' => 'big_dog_boarding_meal', 'expire' => 1200 ) );
								session( 'big_dog_boarding_meal', I ( 'post.big_dog_boarding_meal', '' ) );
							}
							if ( ! session( '?medium_dog_boarding' ) ) {
								session( array( 'name' => 'medium_dog_boarding', 'expire' => 1200 ) );
								session( 'medium_dog_boarding', I ( 'post.medium_dog_boarding', '' ) );
							}
							if ( ! session( '?medium_dog_boarding_qty' ) ) {
								session( array( 'name' => 'medium_dog_boarding_qty', 'expire' => 1200 ) );
								session( 'medium_dog_boarding_qty', I ( 'post.medium_dog_boarding_qty', '' ) );
							}
							if ( ! session( '?medium_dog_boarding_meal' ) ) {
								session( array( 'name' => 'medium_dog_boarding_meal', 'expire' => 1200 ) );
								session( 'medium_dog_boarding_meal', I ( 'post.medium_dog_boarding_meal', '' ) );
							}
							if ( ! session( '?small_dog_boarding' ) ) {
								session( array( 'name' => 'small_dog_boarding', 'expire' => 1200 ) );
								session( 'small_dog_boarding', I ( 'post.small_dog_boarding', '' ) );
							}
							if ( ! session( '?small_dog_boarding_qty' ) ) {
								session( array( 'name' => 'small_dog_boarding_qty', 'expire' => 1200 ) );
								session( 'small_dog_boarding_qty', I ( 'post.small_dog_boarding_qty', '' ) );
							}
							if ( ! session( '?small_dog_boarding_meal' ) ) {
								session( array( 'name' => 'small_dog_boarding_meal', 'expire' => 1200 ) );
								session( 'small_dog_boarding_meal', I ( 'post.small_dog_boarding_meal', '' ) );
							}
							if ( ! session( '?cat_boarding' ) ) {
								session( array( 'name' => 'cat_boarding', 'expire' => 1200 ) );
								session( 'cat_boarding', I ( 'post.cat_boarding', '' ) );
							}
							if ( ! session( '?cat_boarding_qty' ) ) {
								session( array( 'name' => 'cat_boarding_qty', 'expire' => 1200 ) );
								session( 'cat_boarding_qty', I ( 'post.cat_boarding_qty', '' ) );
							}
							if ( ! session( '?cat_boarding_meal' ) ) {
								session( array( 'name' => 'cat_boarding_meal', 'expire' => 1200 ) );
								session( 'cat_boarding_meal', I ( 'post.cat_boarding_meal', '' ) );
							}
							if ( ! session( '?total_pets_sitting' ) ) {
								session( array( 'name' => 'total_pets_sitting', 'expire' => 1200 ) );
								session( 'total_pets_sitting', I ( 'post.total_pets_sitting', '' ) );
							}
							if ( ! session( '?sitting_nights' ) ) {
								session( array( 'name' => 'sitting_nights', 'expire' => 1200 ) );
								session( 'sitting_nights', I ( 'post.sitting_nights', '' ) );
							}
							if ( ! session( '?big_dog_sitting' ) ) {
								session( array( 'name' => 'big_dog_sitting', 'expire' => 1200 ) );
								session( 'big_dog_sitting', I ( 'post.big_dog_sitting', '' ) );
							}
							if ( ! session( '?big_dog_sitting_qty' ) ) {
								session( array( 'name' => 'big_dog_sitting_qty', 'expire' => 1200 ) );
								session( 'big_dog_sitting_qty', I ( 'post.big_dog_sitting_qty', '' ) );
							}
							if ( ! session( '?big_dog_sitting_meal' ) ) {
								session( array( 'name' => 'big_dog_sitting_meal', 'expire' => 1200 ) );
								session( 'big_dog_sitting_meal', I ( 'post.big_dog_sitting_meal', '' ) );
							}
							if ( ! session( '?medium_dog_sitting' ) ) {
								session( array( 'name' => 'medium_dog_sitting', 'expire' => 1200 ) );
								session( 'medium_dog_sitting', I ( 'post.medium_dog_sitting', '' ) );
							}
							if ( ! session( '?medium_dog_sitting_qty' ) ) {
								session( array( 'name' => 'medium_dog_sitting_qty', 'expire' => 1200 ) );
								session( 'medium_dog_sitting_qty', I ( 'post.medium_dog_sitting_qty', '' ) );
							}
							if ( ! session( '?medium_dog_sitting_meal' ) ) {
								session( array( 'name' => 'medium_dog_sitting_meal', 'expire' => 1200 ) );
								session( 'medium_dog_sitting_meal', I ( 'post.medium_dog_sitting_meal', '' ) );
							}
							if ( ! session( '?small_dog_sitting' ) ) {
								session( array( 'name' => 'small_dog_sitting', 'expire' => 1200 ) );
								session( 'small_dog_sitting', I ( 'post.small_dog_sitting', '' ) );
							}
							if ( ! session( '?small_dog_sitting_qty' ) ) {
								session( array( 'name' => 'small_dog_sitting_qty', 'expire' => 1200 ) );
								session( 'small_dog_sitting_qty', I ( 'post.small_dog_sitting_qty', '' ) );
							}
							if ( ! session( '?small_dog_sitting_meal' ) ) {
								session( array( 'name' => 'small_dog_sitting_meal', 'expire' => 1200 ) );
								session( 'small_dog_sitting_meal', I ( 'post.small_dog_sitting_meal', '' ) );
							}
							if ( ! session( '?cat_sitting' ) ) {
								session( array( 'name' => 'cat_sitting', 'expire' => 1200 ) );
								session( 'cat_sitting', I ( 'post.cat_sitting', '' ) );
							}
							if ( ! session( '?cat_sitting_qty' ) ) {
								session( array( 'name' => 'cat_sitting_qty', 'expire' => 1200 ) );
								session( 'cat_sitting_qty', I ( 'post.cat_sitting_qty', '' ) );
							}
							if ( ! session( '?cat_sitting_meal' ) ) {
								session( array( 'name' => 'cat_sitting_meal', 'expire' => 1200 ) );
								session( 'cat_sitting_meal', I ( 'post.cat_sitting_meal', '' ) );
							}
							$this->error ( _ ( 'Please login to continue.' ), U ( 'Home/User/login' ) . '?redirect_to=' . urlencode ( __SELF__ ) );
							exit ();
						} else if ('0' == I ( 'get.host_id', '0' )) {
							$this->error ( _ ( 'Param error. request urls must be including host identification.' ) );
							exit ();
						}
						
						$d_service = D ( 'User/Service' );
						
						$host = $d_host->get_host ( array (
								'usr_login_id' => I ( 'get.host_id' ) 
						) );

						$rates = $d_rate->get_rates ( array (
								'usr_login_id' => I ( 'get.host_id' ) 
						) );
						
						$rate_tree = array ();
						foreach ( $rates as $rate ) {
							switch ($rate ['service_type']) {
								case '1' :
								case '2' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] = $rate ['price'];
									}
									break;
								case '4' :
								case '8' :
								case '16' :
								case '32' :
								case '512':
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = $rate ['price'];
									}
									break;
								case '64' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array (
												$rate ['price'],
												$rate ['price_info'] 
										);
									}
									break;
								case '128' :
								case '256' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = $rate ['price'];
									}
									break;
							}
						}
						
						$d_search = D ( 'Search' );
						
						if ('0' == I ( 'get.host_id', '0' )) {
							$this->add_error ( _ ( 'Params error.' ) );
						}
						if ('' == I ( 'post.checkin', '' ) || '' == I ( 'post.checkout', '' )) {
							$this->add_error ( _ ( 'Please input check-in or check-out dates.' ) );
						}
						if (strtotime ( I ( 'post.checkin' ) ) > strtotime ( I ( 'post.checkout' ) )) {
							$this->add_error ( _ ( 'Check-in date must be before Check-out date.' ) );
						}
						
						if (I ( 'post.total_pets_boarding' ) > 3) {
							$this->add_error ( _ ( 'You cannot book more than 3 pets at a time.' ) );
						}
						
						if ($user_id == I ( 'get.host_id' )) {
							$this->add_error ( _ ( 'You cannot book yourself as a service provider.' ) );
						}
						
						$limited = $d_search->get_service_limited ( array (
								'checkin' => I ( 'post.checkin' ),
								'checkout' => I ( 'post.checkout' ),
								'usr_login_id_seller' => I ( 'get.host_id' ) 
						) );
						
						$days = strtotime ( date ( 'Ymd', strtotime ( I ( 'post.checkout' ) ) ) ) - strtotime ( date ( 'Ymd', strtotime ( I ( 'post.checkin' ) ) ) );
						$days = ($days < 0 ? 0 : $days == 0 ? 1 : $days / 86400);
						if(!$this->has_error()){
							
							if (0 < $limited ['busy_days']) {
								$this->add_error ( _ ( 'Sorry! but the host is unavailable on the chosen dates.' ) );
							} else if (
									($days <= $limited ['one_slot']) || ($days <= $limited ['tow_slots']) || ($days <= $limited ['three_slots'])) {
							} else {
								
								$this->add_error ( _ ( 'Sorry! but the host is unavailable on the chosen dates.' ) );
							}
						}
						
						if (! $this->has_error ()) {
							// All service categories
							$service_types = array ();
							// All basic services (pet)
							$base_service = array ();
							// All additional services
							$other_service = array ();
							// Handling charge
							$fee_service = array ();
							
							// Total service fees
							$service_cost = 0;
							
							array_push ( $service_types, 1 );
							$pets = 0;
							if (I ( 'post.big_dog_boarding' ))
								$pets = I ( 'post.big_dog_boarding_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [1] [1] [4]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 1,
										'pet_size_accepted' => 4,
										'service_type' => 1,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.big_dog_boarding_meal' )) {
									$cost = $rate_tree [128] [1] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 128 );
									array_push ( $other_service, array (
											'service_provided' => 1,
											'pet_size_accepted' => 4,
											'service_type' => 128,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$pets = 0;
							if (I ( 'post.medium_dog_boarding' ))
								$pets = I ( 'post.medium_dog_boarding_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [1] [1] [2]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 1,
										'pet_size_accepted' => 2,
										'service_type' => 1,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.medium_dog_boarding_meal' )) {
									$cost = $rate_tree [128] [1] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 128 );
									array_push ( $other_service, array (
											'service_provided' => 1,
											'pet_size_accepted' => 2,
											'service_type' => 128,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$pets = 0;
							if (I ( 'post.small_dog_boarding' ))
								$pets = I ( 'post.small_dog_boarding_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [1] [1] [1]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 1,
										'pet_size_accepted' => 1,
										'service_type' => 1,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.small_dog_boarding_meal' )) {
									$cost = $rate_tree [128] [1] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 128 );
									array_push ( $other_service, array (
											'service_provided' => 1,
											'pet_size_accepted' => 1,
											'service_type' => 128,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$pets = 0;
							if (I ( 'post.cat_boarding' ))
								$pets = I ( 'post.cat_boarding_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [1] [2] [0]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 2,
										'pet_size_accepted' => 0,
										'service_type' => 1,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.cat_boarding_meal' )) {
									$cost = $rate_tree [256] [2] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 256 );
									array_push ( $other_service, array (
											'service_provided' => 2,
											'pet_size_accepted' => 0,
											'service_type' => 256,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$commission = $service_cost * C ( 'SERVICE_FEE' ) / 100;
							$service_cost += $commission;
							
							$fee_service = array (
									'service_type' => 1024,
									'cost' => $commission 
							);
							
							$service_id = $d_service->add_service ( array (
									'order_id' => 'OD-' . date ( 'Ymd' ) . sprintf ( "%'.04d", ($d_service->get_last_orders () + 1) ),
									'usr_login_id_seller' => I ( 'get.host_id' ),
									'usr_login_id_buyer' => $user_id,
									'pet_services' => union_enum ( $service_types ),
									'service_status' => '0',
									'cost' => $service_cost,
									'commission' => $commission,
									'start_date' => strtotime ( I ( 'post.checkin' ) ),
									'end_date' => strtotime ( I ( 'post.checkout' ) ),
									
									'base_service' => $base_service,
									'other_service' => $other_service,
									'fee_service' => $fee_service 
							) );
							
							header ( "Location: " . U ( 'Search/payment?service_id=' . $service_id ) );
							exit ();
						}			
						$this->assign_error ();
					break;
				case 'pet_sitting_booking' :
					if (! get_session_id () || ! D ( 'User/User' )->user_exist_verifition ( array (
								'id' => get_session_id () 
						) )) {
							if ( ! session( '?booking_type' ) ) {
								session( array( 'name' => 'booking_type', 'expire' => 1200 ) );
								session( 'booking_type', 'Pet_Sitting' );
							}
							if ( ! session( '?checkinsit' ) ) {
								session( array( 'name' => 'checkinsit', 'expire' => 1200 ) );
								session( 'checkinsit', I ( 'post.checkinsit', '' ) );
							}
							if ( ! session( '?checkoutsit' ) ) {
								session( array( 'name' => 'checkoutsit', 'expire' => 1200 ) );
								session( 'checkoutsit', I ( 'post.checkoutsit', '' ) );
							}
							if ( ! session( '?total_pets_sitting' ) ) {
								session( array( 'name' => 'total_pets_sitting', 'expire' => 1200 ) );
								session( 'total_pets_sitting', I ( 'post.total_pets_sitting', '' ) );
							}
							if ( ! session( '?sitting_nights' ) ) {
								session( array( 'name' => 'sitting_nights', 'expire' => 1200 ) );
								session( 'sitting_nights', I ( 'post.sitting_nights', '' ) );
							}
							if ( ! session( '?big_dog_sitting' ) ) {
								session( array( 'name' => 'big_dog_sitting', 'expire' => 1200 ) );
								session( 'big_dog_sitting', I ( 'post.big_dog_sitting', '' ) );
							}
							if ( ! session( '?big_dog_sitting_qty' ) ) {
								session( array( 'name' => 'big_dog_sitting_qty', 'expire' => 1200 ) );
								session( 'big_dog_sitting_qty', I ( 'post.big_dog_sitting_qty', '' ) );
							}
							if ( ! session( '?big_dog_sitting_meal' ) ) {
								session( array( 'name' => 'big_dog_sitting_meal', 'expire' => 1200 ) );
								session( 'big_dog_sitting_meal', I ( 'post.big_dog_sitting_meal', '' ) );
							}
							if ( ! session( '?medium_dog_sitting' ) ) {
								session( array( 'name' => 'medium_dog_sitting', 'expire' => 1200 ) );
								session( 'medium_dog_sitting', I ( 'post.medium_dog_sitting', '' ) );
							}
							if ( ! session( '?medium_dog_sitting_qty' ) ) {
								session( array( 'name' => 'medium_dog_sitting_qty', 'expire' => 1200 ) );
								session( 'medium_dog_sitting_qty', I ( 'post.medium_dog_sitting_qty', '' ) );
							}
							if ( ! session( '?medium_dog_sitting_meal' ) ) {
								session( array( 'name' => 'medium_dog_sitting_meal', 'expire' => 1200 ) );
								session( 'medium_dog_sitting_meal', I ( 'post.medium_dog_sitting_meal', '' ) );
							}
							if ( ! session( '?small_dog_sitting' ) ) {
								session( array( 'name' => 'small_dog_sitting', 'expire' => 1200 ) );
								session( 'small_dog_sitting', I ( 'post.small_dog_sitting', '' ) );
							}
							if ( ! session( '?small_dog_sitting_qty' ) ) {
								session( array( 'name' => 'small_dog_sitting_qty', 'expire' => 1200 ) );
								session( 'small_dog_sitting_qty', I ( 'post.small_dog_sitting_qty', '' ) );
							}
							if ( ! session( '?small_dog_sitting_meal' ) ) {
								session( array( 'name' => 'small_dog_sitting_meal', 'expire' => 1200 ) );
								session( 'small_dog_sitting_meal', I ( 'post.small_dog_sitting_meal', '' ) );
							}
							if ( ! session( '?cat_sitting' ) ) {
								session( array( 'name' => 'cat_sitting', 'expire' => 1200 ) );
								session( 'cat_sitting', I ( 'post.cat_sitting', '' ) );
							}
							if ( ! session( '?cat_sitting_qty' ) ) {
								session( array( 'name' => 'cat_sitting_qty', 'expire' => 1200 ) );
								session( 'cat_sitting_qty', I ( 'post.cat_sitting_qty', '' ) );
							}
							if ( ! session( '?cat_sitting_meal' ) ) {
								session( array( 'name' => 'cat_sitting_meal', 'expire' => 1200 ) );
								session( 'cat_sitting_meal', I ( 'post.cat_sitting_meal', '' ) );
							}
							$this->error ( _ ( 'Please login to continue.' ), U ( 'Home/User/login' ) . '?redirect_to=' . urlencode ( __SELF__ ) );
							exit ();
						} else if ('0' == I ( 'get.host_id', '0' )) {
							$this->error ( _ ( 'Param error. request urls must be including host identification.' ) );
							exit ();
						}
						
						$d_service = D ( 'User/Service' );
						
						$host = $d_host->get_host ( array (
								'usr_login_id' => I ( 'get.host_id' ) 
						) );

						$rates = $d_rate->get_rates ( array (
								'usr_login_id' => I ( 'get.host_id' ) 
						) );
						
						$rate_tree = array ();
						foreach ( $rates as $rate ) {
							switch ($rate ['service_type']) {
								case '1' :
								case '2' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] = $rate ['price'];
									}
									break;
								case '4' :
								case '8' :
								case '16' :
								case '32' :
								case '512' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = $rate ['price'];
									}
									break;
								case '64' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array (
												$rate ['price'],
												$rate ['price_info'] 
										);
									}
									break;
								case '128' :
								case '256' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = $rate ['price'];
									}
									break;
							}
						}
						
						$d_search = D ( 'Search' );
						
						if ('0' == I ( 'get.host_id', '0' )) {
							$this->add_error ( _ ( 'Params error.' ) );
						}
						if ('' == I ( 'post.checkinsit', '' ) || '' == I ( 'post.checkoutsit', '' )) {
							$this->add_error ( _ ( 'Please input check-in or check-out dates.' ) );
						}
						if (strtotime ( I ( 'post.checkinsit' ) ) > strtotime ( I ( 'post.checkoutsit' ) )) {
							$this->add_error ( _ ( 'Check-in date must be before Check-out date.' ) );
						}
						
						if (I ( 'post.total_pets_boarding' ) > 3) {
							$this->add_error ( _ ( 'You cannot book more than 3 pets at a time.' ) );
						}
						
						if ($user_id == I ( 'get.host_id' )) {
							$this->add_error ( _ ( 'You cannot book yourself as a service provider.' ) );
						}
						
						$limited = $d_search->get_service_limited ( array (
								'checkin' => I ( 'post.checkinsit' ),
								'checkout' => I ( 'post.checkoutsit' ),
								'usr_login_id_seller' => I ( 'get.host_id' ) 
						) );
						
						$days = strtotime ( date ( 'Ymd', strtotime ( I ( 'post.checkoutsit' ) ) ) ) - strtotime ( date ( 'Ymd', strtotime ( I ( 'post.checkinsit' ) ) ) );
						$days = ($days < 0 ? 0 : $days == 0 ? 1 : $days / 86400);
						if(!$this->has_error()){
							
							if (0 < $limited ['busy_days']) {
								$this->add_error ( _ ( 'Sorry! but the host is unavailable on the chosen dates.' ) );
							} else if (
									($days <= $limited ['sitting_slot'])) {
							} else {
								
								$this->add_error ( _ ( 'Sorry! but the host is unavailable on the chosen dates.' ) );
							}
						}
						
						if (! $this->has_error ()) {
							// All service categories
							$service_types = array ();
							// All basic services (pet)
							$base_service = array ();
							// All additional services
							$other_service = array ();
							// Handling charge
							$fee_service = array ();
							
							// Total service fees
							$service_cost = 0;
							
							array_push ( $service_types, 2 );
							$pets = 0;
							if (I ( 'post.big_dog_sitting' ))
								$pets = I ( 'post.big_dog_sitting_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [2] [1] [4]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 1,
										'pet_size_accepted' => 4,
										'service_type' => 2,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.big_dog_sitting_meal' )) {
									$cost = $rate_tree [128] [1] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 128 );
									array_push ( $other_service, array (
											'service_provided' => 1,
											'pet_size_accepted' => 4,
											'service_type' => 128,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$pets = 0;
							if (I ( 'post.medium_dog_sitting' ))
								$pets = I ( 'post.medium_dog_sitting_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [2] [1] [2]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 1,
										'pet_size_accepted' => 2,
										'service_type' => 2,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.medium_dog_sitting_meal' )) {
									$cost = $rate_tree [128] [1] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 128 );
									array_push ( $other_service, array (
											'service_provided' => 1,
											'pet_size_accepted' => 2,
											'service_type' => 128,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$pets = 0;
							if (I ( 'post.small_dog_sitting' ))
								$pets = I ( 'post.small_dog_sitting_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [2] [1] [1]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 1,
										'pet_size_accepted' => 1,
										'service_type' => 2,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.small_dog_sitting_meal' )) {
									$cost = $rate_tree [128] [1] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 128 );
									array_push ( $other_service, array (
											'service_provided' => 1,
											'pet_size_accepted' => 1,
											'service_type' => 128,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$pets = 0;
							if (I ( 'post.cat_sitting' ))
								$pets = I ( 'post.cat_sitting_qty' );
							
							// All Pets (required when Basic Service IS NOT 0)
							for($i = 1; $i <= $pets; $i ++) {
								// Save Pet Basic Service
								$cost = ( int ) ($rate_tree [2] [2] [0]) * $days;
								$service_cost += $cost;
								array_push ( $base_service, array (
										'service_provided' => 2,
										'pet_size_accepted' => 0,
										'service_type' => 2,
										'amount' => $days,
										'cost' => $cost 
								) );
								// Save Pet Meals for Additional Services
								if (I ( 'post.cat_sitting_meal' )) {
									$cost = $rate_tree [256] [2] * $days;
									$service_cost += $cost;
									array_push ( $service_types, 256 );
									array_push ( $other_service, array (
											'service_provided' => 2,
											'pet_size_accepted' => 0,
											'service_type' => 256,
											'amount' => $days,
											'cost' => $cost 
									) );
								}
							}
							
							$commission = $service_cost * C ( 'SERVICE_FEE' ) / 100;
							$service_cost += $commission;
							
							$fee_service = array (
									'service_type' => 1024,
									'cost' => $commission 
							);
							$service_id = $d_service->add_service ( array (
									'order_id' => 'OD-' . date ( 'Ymd' ) . sprintf ( "%'.04d", ($d_service->get_last_orders () + 1) ),
									'usr_login_id_seller' => I ( 'get.host_id' ),
									'usr_login_id_buyer' => $user_id,
									'pet_services' => union_enum ( $service_types ),
									'service_status' => '0',
									'cost' => $service_cost,
									'commission' => $commission,
									'start_date' => strtotime ( I ( 'post.checkinsit' ) ),
									'end_date' => strtotime ( I ( 'post.checkoutsit' ) ),
									
									'base_service' => $base_service,
									'other_service' => $other_service,
									'fee_service' => $fee_service 
							) );
							
							header ( "Location: " . U ( 'Search/payment?service_id=' . $service_id ) );
							exit ();
						}			
						$this->assign_error ();
					break;
				case 'other_services_booking' :
					if (! get_session_id () || ! D ( 'User/User' )->user_exist_verifition ( array (
								'id' => get_session_id () 
						) )) {
							if ( ! session( '?booking_type' ) ) {
								session( array( 'name' => 'booking_type', 'expire' => 1200 ) );
								session( 'booking_type', 'Other_Services' );
							}
							if ( ! session( '?other_nights' ) ) {
								session( array( 'name' => 'other_nights', 'expire' => 1200 ) );
								session( 'other_nights', I ( 'post.other_nights', '' )  );
							}
							if ( ! session( '?checkinot' ) ) {
								session( array( 'name' => 'checkinot', 'expire' => 1200 ) );
								session( 'checkinot', I ( 'post.checkinot', '' ) );
							}
							if ( ! session( '?day_care_qty' ) ) {
								session( array( 'name' => 'day_care_qty', 'expire' => 1200 ) );
								session( 'day_care_qty', I ( 'post.day_care_qty', '' ) );
							}
							if ( ! session( '?home_visit_qty' ) ) {
								session( array( 'name' => 'home_visit_qty', 'expire' => 1200 ) );
								session( 'home_visit_qty', I ( 'post.home_visit_qty', '' ) );
							}
							if ( ! session( '?pet_walking_qty' ) ) {
								session( array( 'name' => 'pet_walking_qty', 'expire' => 1200 ) );
								session( 'pet_walking_qty', I ( 'post.pet_walking_qty', '' ) );
							}
							if ( ! session( '?pet_grooming_qty' ) ) {
								session( array( 'name' => 'pet_grooming_qty', 'expire' => 1200 ) );
								session( 'pet_grooming_qty', I ( 'post.pet_grooming_qty', '' ) );
							}
							if ( ! session( '?pet_bathing_qty' ) ) {
								session( array( 'name' => 'pet_bathing_qty', 'expire' => 1200 ) );
								session( 'pet_bathing_qty', I ( 'post.pet_bathing_qty', '' ) );
							}
							if ( ! session( '?pickup_service_qty' ) ) {
								session( array( 'name' => 'pickup_service_qty', 'expire' => 1200 ) );
								session( 'pickup_service_qty', I ( 'post.pickup_service_qty', '' ) );
							}
							$this->error ( _ ( 'Please login to continue.' ), U ( 'Home/User/login' ) . '?redirect_to=' . urlencode ( __SELF__ ) );
							exit ();
						} else if ('0' == I ( 'get.host_id', '0' )) {
							$this->error ( _ ( 'Param error. request urls must be including host identification.' ) );
							exit ();
						}
						
						$d_service = D ( 'User/Service' );
						
						$host = $d_host->get_host ( array (
								'usr_login_id' => I ( 'get.host_id' ) 
						) );

						$rates = $d_rate->get_rates ( array (
								'usr_login_id' => I ( 'get.host_id' ) 
						) );
						
						$rate_tree = array ();
						foreach ( $rates as $rate ) {
							switch ($rate ['service_type']) {
								case '1' :
								case '2' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] = $rate ['price'];
									}
									break;
								case '4' :
								case '8' :
								case '16' :
								case '32' :
								case '512' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = $rate ['price'];
									}
									break;
								case '64' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array (
												$rate ['price'],
												$rate ['price_info'] 
										);
									}
									break;
								case '128' :
								case '256' :
									if (! isset ( $rate_tree [$rate ['service_type']] )) {
										$rate_tree [$rate ['service_type']] = array ();
									}
									if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
										$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = $rate ['price'];
									}
									break;
							}
						}
						
						$d_search = D ( 'Search' );
						
						if ('0' == I ( 'get.host_id', '0' )) {
							$this->add_error ( _ ( 'Params error.' ) );
						}
						if ('' == I ( 'post.checkinot', '' ) ) {
							$this->add_error ( _ ( 'Please input check-in date.' ) );
						}
						
						if ($user_id == I ( 'get.host_id' )) {
							$this->add_error ( _ ( 'You cannot book yourself as a service provider.' ) );
						}

						if (! $this->has_error ()) {
							// All service categories
							$service_types = array ();
							// All basic services (pet)
							$base_service = array ();
							// All additional services
							$other_service = array ();
							// Handling charge
							$fee_service = array ();
							
							// Total service fees
							$service_cost = 0;
							if (I ( 'post.day_care_qty' ) != 0)
							{
								$cost = ( int ) $rate_tree [4][0] * I ( 'post.day_care_qty') ;
								$service_cost += $cost;
								array_push ( $service_types, 4 );
								array_push ( $other_service, array (
										'service_type' => 4,
										'amount' => I ( 'post.day_care_qty'),
										'cost' => $cost 
								) );
							}
							if (I ( 'post.home_visit_qty' ) != 0)
							{
								$cost = ( int ) $rate_tree [512][0] * I ( 'post.home_visit_qty') ;
								$service_cost += $cost;
								array_push ( $service_types, 512 );
								array_push ( $other_service, array (
										'service_type' => 512,
										'amount' => I ( 'post.home_visit_qty'),
										'cost' => $cost 
								) );
							}
							if (I ( 'post.pet_walking_qty' ) != 0)
							{
								$cost = ( int ) $rate_tree [8][0] * I ( 'post.pet_walking_qty') ;
								$service_cost += $cost;
								array_push ( $service_types, 8 );
								array_push ( $other_service, array (
										'service_type' => 8,
										'amount' => I ( 'post.pet_walking_qty'),
										'cost' => $cost 
								) );
							}
							
							if (I ( 'post.pet_grooming_qty' ) != 0)
							{
								$cost = ( int ) $rate_tree [16][0] * I ( 'post.pet_grooming_qty') ;
								$service_cost += $cost;
								array_push ( $service_types, 16 );
								array_push ( $other_service, array (
										'service_type' => 16,
										'amount' => I ( 'post.pet_grooming_qty'),
										'cost' => $cost 
								) );
							}
							
							if (I ( 'post.pet_bathing_qty' ) != 0)
							{
								$cost = ( int ) $rate_tree [32][0] * I ( 'post.pet_bathing_qty') ;
								$service_cost += $cost;
								array_push ( $service_types, 32 );
								array_push ( $other_service, array (
										'service_type' => 32,
										'amount' => I ( 'post.pet_bathing_qty'),
										'cost' => $cost 
								) );
							}
							
							if (I ( 'post.pickup_service_qty' ) != 0)
							{
								$cost = ( int ) $rate_tree [64][0] * I ( 'post.pickup_service_qty') ;
								$service_cost += $cost;
								array_push ( $service_types, 64 );
								array_push ( $other_service, array (
										'service_type' => 64,
										'amount' => I ( 'post.pickup_service_qty'),
										'cost' => $cost 
								) );
							}
							
							$commission = $service_cost * C ( 'SERVICE_FEE' ) / 100;
							$service_cost += $commission;
							
							$fee_service = array (
									'service_type' => 1024,
									'cost' => $commission 
							);
							$service_id = $d_service->add_service ( array (
									'order_id' => 'OD-' . date ( 'Ymd' ) . sprintf ( "%'.04d", ($d_service->get_last_orders () + 1) ),
									'usr_login_id_seller' => I ( 'get.host_id' ),
									'usr_login_id_buyer' => $user_id,
									'pet_services' => union_enum ( $service_types ),
									'service_status' => '0',
									'cost' => $service_cost,
									'commission' => $commission,
									'start_date' => strtotime ( I ( 'post.checkinot' ) ),
									'end_date' => strtotime ( I ( 'post.checkout' ) ),
									
									'base_service' => $base_service,
									'other_service' => $other_service,
									'fee_service' => $fee_service 
							) );
							
							header ( "Location: " . U ( 'Search/payment?service_id=' . $service_id ) );
							exit ();
						}			
						$this->assign_error ();
					break;
				case 'comments' :
					if ($user_id == $host_id) {
						if ('' == I ( 'post.comments' )) {
							$this->add_error ( _ ( 'Please enter a review.' ) );
						} else if (0 == I ( 'post.reply' )) {
							$this->add_error ( _ ( 'Params error.' ) );
						}
						
						if (! $this->has_error ()) {
							if ($d_comments->add_comment ( array (
									'usr_login_id_from' => 0,
									'usr_login_id_to' => $host_id,
									'reply' => I ( 'post.reply' ),
									'comment' => I ( 'post.comments' ),
									'score' => 0 
							) )) {
								$this->add_message ( _ ( 'Review has been added successfully.' ) );
							} else {
								$this->add_error ( _ ( 'Review could not be added at this time. Please try again later.' ) );
							}
						}
					} else {
						if ('' == I ( 'post.comments' )) {
							$this->add_error ( _ ( 'Please enter a review.' ) );
						} else if (0 == I ( 'post.score' )) {
							$this->add_error ( _ ( 'Please select a rating.' ) );
						}
						
						if (! $this->has_error ()) {
							$host = $d_host->get_host ( array (
									'usr_login_id' => $host_id 
							) );
							$comments = $host ['comments'] + 1;
							$score = ($host ['score'] * $host ['comments'] + I ( 'post.score' )) / $comments;
							
							$d_host->host_update ( array (
									'usr_login_id' => $host_id,
									'comments' => $comments,
									'score' => $score 
							) );
							
							if ($d_comments->add_comment ( array (
									'usr_login_id_from' => $user_id,
									'usr_login_id_to' => $host_id,
									'comment' => I ( 'post.comments' ),
									'score' => I ( 'post.score' ) 
							) )) {
								$this->add_message ( _ ( 'Review has been added successfully.' ) );
							} else {
								$this->add_error ( _ ( 'Review could not be added at this time. Please try again later.' ) );
							}
						}
					}
					
					break;
				case 'chat' :
					if ($user_id == $host_id) {
						$this->error ( _ ( 'You cannot send message to yourself.' ) );
					} else if ('' == I ( 'post.letter', '' )) {
						$this->error ( _ ( 'Please type in a message.' ) );
					} else if ('' == I ( 'post.title', '' )) {
						$this->error ( _ ( 'Please type in a title.' ) );
					}
					
					$session_id = $d_letter->add_letter_session ( array (
							'usr_login_id_session_from' => $user_id,
							'usr_login_id_session_to' => $host_id,
							'title' => I ( 'post.title' ) 
					) );
					if ($d_letter->add_letter ( array (
							'usr_login_id_from' => $user_id,
							'usr_login_id_to' => $host_id,
							'session_id' => $session_id,
							'letter' => I ( 'post.letter' ),
							'letter_status' => 2 
					) )) {
						$a_email = new \Home\Controller\MailController ();
						$to_user = $d_user->get_user_info ( array (
								'usr_login_id' => $host_id 
						) );
						$user = $d_user->get_user_info ( array (
								'usr_login_id' => $user_id 
						) );
						$url = U ( '/User/Letter/letter_box@' . PET_DOMAIN . '?session_id=' . $session_id );
						$email_error = email_send ( $to_user ['email'], sprintf ( _ ( 'Petkeepa : Message from %s' ), $user ['first_name'] ), $a_email->message_email ( $to_user, $user, $url ) );
						if (is_string ( $email_error )) {
							db_log ( $email_error, __CLASS__ . __FUNCTION__, "E" );
						} else {
							db_log ( $to_user ['email'] . 's\' new letter sent', __CLASS__ . __FUNCTION__, "I" );
						}
						$this->success ( _ ( 'Message has been send successfully.' ) );
					} else {
						$this->error ( _ ( 'Message sent unsuccessful. Please try again later.' ) );
					}
					
					break;
				case 'meet' :
					if ($user_id == $host_id) {
						$this->error ( _ ( 'You cannot send meet request to yourself.' ) );
					} else if ('' == I ( 'post.letter', '' )) {
						$this->error ( _ ( 'Please type in a message.' ) );
					} 
					
					$session_id = $d_letter->add_letter_session ( array (
							'usr_login_id_session_from' => $user_id,
							'usr_login_id_session_to' => $host_id,
							'from_tags' => 'MG',
							'to_tags' => 'MG',
							'title' => 'Meet & Greet Request' 
					) );
					if ($d_letter->add_letter ( array (
							'usr_login_id_from' => $user_id,
							'usr_login_id_to' => $host_id,
							'session_id' => $session_id,
							'letter' => I ( 'post.letter' ),
							'letter_status' => 2
					) )) {
						$a_email = new \Home\Controller\MailController ();
						$to_user = $d_user->get_user_info ( array (
								'usr_login_id' => $host_id 
						) );
						$user = $d_user->get_user_info ( array (
								'usr_login_id' => $user_id 
						) );
						$url = U ( '/User/Letter/letter_box@' . PET_DOMAIN . '?session_id=' . $session_id );
						$email_error = email_send ( $to_user ['email'], sprintf ( _ ( 'Petkeepa : Meet & Greet Request from %s' ), $user ['first_name'] ), $a_email->meet_greet_email ( $to_user, $user, $url, '' ) );
						if (is_string ( $email_error )) {
							db_log ( $email_error, __CLASS__ . __FUNCTION__, "E" );
						} else {
							db_log ( $to_user ['email'] . 's\' new letter sent', __CLASS__ . __FUNCTION__, "I" );
						}
						$this->success ( _ ( 'Message has been send successfully.' ) );
					} else {
						$this->error ( _ ( 'Message sent unsuccessful. Please try again later.' ) );
					}
					
					break;
			}
			
			$this->assign_error ();
			$this->assign_message ();
		}
		
		$success_service_counts = $d_search->get_service_count ( array (
				'usr_login_id_seller' => $host_id,
				'usr_login_id_buyer' => $user_id,
				'service_status' => 3 
		) );
		
		$host = $d_host->get_host ( array (
				'usr_login_id' => $host_id 
		) );
		
		$pet_head_img = $d_attachment->get_attachment( array( 'id' => $host['pet_head_img'] ) );
		$host['pet_head_img_url'] = $pet_head_img['url'];

		$comments = $d_comments->get_comments ( array (
				'usr_login_id_to' => $host_id 
		) );
		$rates = $d_rate->get_rates ( array (
				'usr_login_id' => $host_id 
		) );
		
		$rate_tree = array ();
		foreach ( $rates as $rate ) {
			switch ($rate ['service_type']) {
				case '1' :
				case '2' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = array ();
					}
					if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
						$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = array ();
					}
					if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] )) {
						$rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] = $rate ['price'];
					}
					break;
				case '4' :
				case '8' :
				case '16' :
				case '32' :
				case '512' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = $rate ['price'];
					}
					break;
				case '64' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = array (
								$rate ['price'],
								$rate ['price_info'] 
						);
					}
					break;
				case '128' :
				case '256' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = array ();
					}
					if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
						$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = $rate ['price'];
					}
					break;
			}
		}
		
		if ($login_id) {
			$d_collection = D ( 'User/Collection' );
			
			// Added and saved to Favorite?
			$this->assign ( 'is_collected', $d_collection->collection_exist_verifition ( array (
					'usr_login_id_collector' => $user_id,
					'usr_login_id_collection' => $host_id 
			) ) );
		}
		
		if (! empty ( $host ) && ! empty ( $host ['pics'] )) {
			$host ['pics'] = $d_attachment->get_attachments ( array (
					'ids' => $host ['pics'] 
			) );
		}
		
		$unrespond_count = $d_letter->get_unrespond_letters_count ( array (
				'usr_login_id_to' => $user_id 
		) );
		$letters_count = $d_letter->get_letters_count ( array (
				'usr_login_id_to' => $user_id 
		) );
		$response_rate = ($letters_count == 0 ? 100 : ( int ) ((($letters_count - $unrespond_count) / $letters_count) * 100));
		
		$this->assign ( 'rates', $rate_tree );
		$this->assign ( 'comments', $comments );
		$this->assign ( 'success_service_counts', $success_service_counts );
		$this->assign ( 'response_rate', $response_rate );
		
		$this->assign ( 'host', $host );
		
		$this->display ();
	}
	
	/**
	 * Calendar
	 */
	public function calendar() {
		$d_user = D ( 'User/User' );
		$d_host = D ( 'User/Host' );
		$d_service = D ( 'User/Service' );
		
		$user_id = I ( 'get.host_id' );
		
		if ('0' != I ( 'post.id', '0' )) {
			$id = I ( 'post.id' );
		} else {
			$this->ajaxReturn ( array () );
		}
		if (IS_AJAX) {
			$opt = I ( 'post.option', '' );
			switch ($opt) {
				default :
					if (false === I ( 'post.start', false ) || false === I ( 'post.end', false )) {
						$this->ajaxReturn ( array (
								'status' => 'error' 
						) );
						exit ();
					}
					$service_data = array (
							'usr_login_id_seller' => $user_id,
							'start_date' => I ( 'post.start' ),
							'end_date' => I ( 'post.end' ) 
					);
					
					$services = $d_service->get_service_calendar ( $service_data );
					
					$ajax_services = array ();
					if ($services) {
						foreach ( $services as $service ) {
							// Service Status is [not offering service], OR offering boarding service for 3 pets for the day, OR offering sitting service for 1 pet for the day
							if ('5' == $service ['service_status'] || (3 <= $service ['count'] && ! is_set ( 2, $service ['pet_services'] )) || (1 <= $service ['count'] && is_set ( 2, $service ['pet_services'] ))) {
								array_push ( $ajax_services, array (
										'start' => date ( 'Y-m-d', strtotime ( $service ['date'] ) ),
										'end' => date ( 'Y-m-d', strtotime ( $service ['date'] ) ),
										'color' => '#FF6666',
										'editable' => true,
										'id' => $service ['id'] 
								) );
							}
						}
					}
					
					$this->ajaxReturn ( $ajax_services );
					break;
			}
		}
	}
	
	
	/**
	 * Booking
	 */
	public function booking() {
		if (! get_session_id () || ! D ( 'User/User' )->user_exist_verifition ( array (
				'id' => get_session_id () 
		) )) {
			$this->error ( _ ( 'Please login to continue.' ), U ( 'Home/User/login' ) . '?redirect_to=' . urlencode ( __SELF__ ) );
			exit ();
		} else if ('0' == I ( 'get.host_id', '0' )) {
			$this->error ( _ ( 'Param error. request urls must be including host identification.' ) );
			exit ();
		}
		
		$d_service = D ( 'User/Service' );
		$d_host = D ( 'User/Host' );
		$d_user = D ( 'User/User' );
		
		$user_id = get_session_id ();
		
		$host = $d_host->get_host ( array (
				'usr_login_id' => I ( 'get.host_id' ) 
		) );
		
		// Get user pricing details
		$d_rate = D ( 'User/Rate' );
		
		$rates = $d_rate->get_rates ( array (
				'usr_login_id' => I ( 'get.host_id' ) 
		) );
		
		$rate_tree = array ();
		foreach ( $rates as $rate ) {
			switch ($rate ['service_type']) {
				case '1' :
				case '2' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = array ();
					}
					if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
						$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = array ();
					}
					if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] )) {
						$rate_tree [$rate ['service_type']] [$rate ['pet_type']] [$rate ['pet_level']] = $rate ['price'];
					}
					break;
				case '4' :
				case '8' :
				case '16' :
				case '32' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = $rate ['price'];
					}
					break;
				case '64' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = array (
								$rate ['price'],
								$rate ['price_info'] 
						);
					}
					break;
				case '128' :
				case '256' :
					if (! isset ( $rate_tree [$rate ['service_type']] )) {
						$rate_tree [$rate ['service_type']] = array ();
					}
					if (! isset ( $rate_tree [$rate ['service_type']] [$rate ['pet_type']] )) {
						$rate_tree [$rate ['service_type']] [$rate ['pet_type']] = $rate ['price'];
					}
					break;
			}
		}
		
		if (IS_POST) {
			$d_search = D ( 'Search' );
			
			if ('0' == I ( 'get.host_id', '0' )) {
				$this->add_error ( _ ( 'Params error.' ) );
			}
			if ('' == I ( 'post.checkin', '' ) || '' == I ( 'post.checkout', '' )) {
				$this->add_error ( _ ( 'Please input check-in or check-out dates.' ) );
			}
			if (strtotime ( I ( 'post.checkin' ) ) > strtotime ( I ( 'post.checkout' ) )) {
				$this->add_error ( _ ( 'Check-in date must be before Check-out date.' ) );
			}
			if ('' == I ( 'post.base_service', '' )) {
				$this->add_error ( _ ( 'Please select type of service.' ) );
			}
			if ('0' != I ( 'post.base_service' )) {
				if ('0' == I ( 'post.pets', '0' )) {
					$this->add_error ( _ ( 'Please select at least one pet.' ) );
				}
				if (false == I ( 'post.service_provided_1', false )) {
					$this->add_error ( _ ( 'Please select your pet category.' ) );
				}
				if ('1' == I ( 'post.service_provided_1' ) && false == I ( 'post.pet_size_accepted_1', false )) {
					$this->add_error ( _ ( 'Please select your pet\'s weight.' ) );
				}
			}
			if ('0' == I ( 'post.base_service' )) {
				if ('0' == I ( 'post.service_type_8', '0' ) && '0' == I ( 'post.service_type_16', '0' ) && '0' == I ( 'post.service_type_32', '0' ) && '0' == I ( 'post.service_type_64', '0' )) {
					$this->add_error ( _ ( 'Please select other service.' ) );
				}
			}
			if ($user_id == I ( 'get.host_id' )) {
				$this->add_error ( _ ( 'You cannot book yourself as a service provider.' ) );
			}
			
			$limited = $d_search->get_service_limited ( array (
					'checkin' => I ( 'post.checkin' ),
					'checkout' => I ( 'post.checkout' ),
					'usr_login_id_seller' => I ( 'get.host_id' ) 
			) );
			
			$days = strtotime ( date ( 'Ymd', strtotime ( I ( 'post.checkout' ) ) ) ) - strtotime ( date ( 'Ymd', strtotime ( I ( 'post.checkin' ) ) ) );
			$days = ($days < 0 ? 0 : $days == 0 ? 1 : $days / 86400);
			if(!$this->has_error()){
				
				if (0 < $limited ['busy_days']) {
					$this->add_error ( _ ( 'Sorry! but the host is unavailable on the chosen dates.' ) );
				} else if (
						('2' == I ( 'post.base_service' ) && $days <= $limited ['sitting_slot']) || 
						('1' == I ( 'post.base_service' ) && '0' != I ( 'post.service_provided_1', '0' ) && $days <= $limited ['one_slot']) || 
						('1' == I ( 'post.base_service' ) && '0' != I ( 'post.service_provided_2', '0' ) && $days <= $limited ['tow_slots']) || 
						('1' == I ( 'post.base_service' ) && '0' != I ( 'post.service_provided_3', '0' ) && $days <= $limited ['three_slots']) || 
						('0' == I ( 'post.base_service' ) && $days <= $limited ['one_slot'])) {
				} else {
					
					$this->add_error ( _ ( 'Sorry! but the host is unavailable on the chosen dates.' ) );
				}
			}
			
			if (! $this->has_error ()) {
				// All service categories
				$service_types = array ();
				// All basic services (pet)
				$base_service = array ();
				// All additional services
				$other_service = array ();
				// Handling charge
				$fee_service = array ();
				
				// Total service fees
				$service_cost = 0;
				
				if (I ( 'post.base_service' ) != '0') {
					array_push ( $service_types, I ( 'post.base_service' ) );
					
					$pets = I ( 'post.pets' );
					
					// All Pets (required when Basic Service IS NOT 0)
					for($i = 1; $i <= $pets; $i ++) {
						if ('2' == I ( 'post.service_provided_' . $i, '0' ) || ('1' == I ( 'post.service_provided_' . $i, '0' ) && false != I ( 'post.pet_size_accepted_' . $i, false ))) {
							// Save Pet Basic Service
							$cost = ( int ) ($rate_tree [I ( 'post.base_service' )] [I ( 'post.service_provided_' . $i )] [('1' == I ( 'post.service_provided_' . $i ) ? I ( 'post.pet_size_accepted_' . $i ) : '0')]) * $days;
							$service_cost += $cost;
							array_push ( $base_service, array (
									'service_provided' => I ( 'post.service_provided_' . $i ),
									'pet_size_accepted' => ('1' == I ( 'post.service_provided_' . $i ) ? I ( 'post.pet_size_accepted_' . $i ) : '0'),
									'service_type' => I ( 'post.base_service' ),
									'amount' => $days,
									'cost' => $cost 
							) );
							// Save Pet Meals for Additional Services
							if ('1' == I ( 'post.service_provided_' . $i ) && '0' != I ( 'post.service_type_128_' . $i, '0' )) {
								$cost = $rate_tree [128] [I ( 'post.service_provided_' . $i )] * $days;
								$service_cost += $cost;
								array_push ( $service_types, 128 );
								array_push ( $other_service, array (
										'service_provided' => I ( 'post.service_provided_' . $i ),
										'pet_size_accepted' => I ( 'post.pet_size_accepted_' . $i, '0' ),
										'service_type' => 128,
										'amount' => $days,
										'cost' => $cost 
								) );
							}
							if ('2' == I ( 'post.service_provided_' . $i ) && '0' != I ( 'post.service_type_256_' . $i, '0' )) {
								$cost = $rate_tree [256] [I ( 'post.service_provided_' . $i )] * $days;
								$service_cost += $cost;
								array_push ( $service_types, 256 );
								array_push ( $other_service, array (
										'service_provided' => I ( 'post.service_provided_' . $i ),
										'pet_size_accepted' => I ( 'post.pet_size_accepted_' . $i, '0' ),
										'service_type' => 256,
										'amount' => $days,
										'cost' => $cost 
								) );
							}
						}
					}
				}
				$s_t = array (
						8,
						16,
						32,
						64 
				);
				// Save Additional Services
				foreach ( $s_t as $v ) {
					if ('0' != I ( 'post.service_type_' . $v, '0' )) {
						$cost = ( int ) ($v == '64' ? $rate_tree [$v] [0] : $rate_tree [$v]) * I ( 'post.service_type_' . $v );
						$service_cost += $cost;
						array_push ( $service_types, $v );
						array_push ( $other_service, array (
								'service_type' => $v,
								'amount' => I ( 'post.service_type_' . $v ),
								'cost' => $cost 
						) );
					}
				}
				
				$commission = $service_cost * C ( 'SERVICE_FEE' ) / 100;
				$service_cost += $commission;
				
				$fee_service = array (
						'service_type' => 1024,
						'cost' => $commission 
				);
				
				$service_id = $d_service->add_service ( array (
						'order_id' => 'OD-' . date ( 'Ymd' ) . sprintf ( "%'.04d", ($d_service->get_last_orders () + 1) ),
						'usr_login_id_seller' => I ( 'get.host_id' ),
						'usr_login_id_buyer' => $user_id,
						'pet_services' => union_enum ( $service_types ),
						'service_status' => '0',
						'cost' => $service_cost,
						'commission' => $commission,
						'start_date' => strtotime ( I ( 'post.checkin' ) ),
						'end_date' => strtotime ( I ( 'post.checkout' ) ),
						
						'base_service' => $base_service,
						'other_service' => $other_service,
						'fee_service' => $fee_service 
				) );
				
				header ( "Location: " . U ( 'Search/payment?service_id=' . $service_id ) );
				exit ();
			}
			
			$this->assign_error ();
		}
		
		$this->assign ( 'rates', $rate_tree );
		$this->assign ( 'host_id', I ( 'post.host_id' ) );
		$this->assign ( 'host', $host );
		
		$this->display ();
	}
	
	/**
	 * Payment
	 */
	public function payment() {
		$service_id = I ( 'get.service_id' );

		$user_id = get_session_id ();
		// No login and no service_id will redirect last page
		if (! $user_id || ! D ( 'User/User' )->user_exist_verifition ( array ('id' => $user_id ) )) {
			$this->error ( _ ( 'Your session has expired. Please log-in again.' ), U ( 'Home/User/login' ) . '?redirect_to=' . urlencode ( __SELF__ ) );
			exit ();
		} else if ('0' == $service_id) {
			$this->error ( _ ( 'Params error. request urls must be including booking identification.' ) );
			exit ();
		}
		
		$d_service = D ( 'User/Service' );
		$d_host = D ( 'User/Host' );
		$d_payment = D ( 'User/Payment' );
		$d_letter = D ( 'User/Letter' );
		$d_user = D ( 'User/User' );
		$email = get_session_email ();
		
		$service = $d_service->get_service ( array (
				'id' => $service_id,
				'usr_login_id_buyer' => $user_id 
		) );
		
		if (empty ( $service )) {
			$this->error ( _ ( 'Can not find your service information.' ) );
			exit ();
		}
		
		if ($service ['start_date'] < time ()) {
		    $d_service->update_service(array('id'=>$service_id,'service_status'=>0));
			$this->error ( _ ( 'The start date of your order has already passed, please re-book.' ) );
			exit ();
		}
		
		$service_details = $d_service->get_service_detail ( array (
				'service_id' => $service_id 
		) );
		
		$host = $d_host->get_host ( array (
				'usr_login_id' => $service ['usr_login_id_seller']
		) );

		// -s- deal with the payment successful
		if (IS_GET && false !== I ( 'get.success', false )) {

			if ("false" != I ( 'get.success', "false" )) {
				if ('' != I ( 'get.paymentId', '' )) {
					$payment = $d_payment->get_payment ( array (
							'service_id' => $service_id 
					) );
					
					if (! empty ( $payment )) {
						if ($d_payment->update_payment ( array (
								'service_id' => $service_id,
								'pay_id' => I ( 'get.paymentId' ),
								'pay_status' => '1',
								'payer_id' => I ( 'get.PayerID', '' ) 
						) )) {
							
							$from_user = $d_user->get_user_info ( array (
									'usr_login_id' => $user_id 
							) );
							
							$d_service->update_service(array('id'=>$service_id,'service_status'=>1));
							
							$msg = $d_letter->get_booking_message ( array (
							'service_id' => $service_id 
							) );
							
							$a_email = new \Home\Controller\MailController ();
							$pet_url = PET_DOMAIN;
							$url = U ( "/User/Booking/booking_service@{$pet_url}" );
							$email_error = email_send ( $host ['email'], _ ( 'Important message from Petkeepa' ), $a_email->system_email ( _ ( 'Booking Request' ), $url, $host, $from_user, $msg ) );
							if (is_string ( $email_error )) {
								db_log ( $email_error, __CLASS__ . __FUNCTION__, "E" );
							}
							
							$this->success ( _ ( 'Payment is successful.' ), U ( '/User/Booking/booking?booking=success'  ), 1 );
							
							db_log ( "Payment successfully. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "I" );
							exit ();
						} else {
							db_log ( "Update database error. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "E" );
						}
					} else {
						$this->add_error ( _ ( 'Sorry! but your payment information is not available. Please contact Petkeepa.' ) );
						$pay_id = I ( 'get.paymentId' );
						$status = I ( 'get.success' );
						db_log ( "Can not find your payment in websit. service_id: {$service_id}; pay_id: {$pay_id}; status: {$status}", __CLASS__ . __FUNCTION__, "E" );
					}
				}
			} else {
				$this->success ( _ ( 'Payment cancelled.' ), U ( 'Search/payment?service_id=' . $service_id ), 5 );
				// success is false
				/*if (false !== $d_payment->update_payment ( array (
						'service_id' => $service_id,
						'pay_status' => '5' 
				) )) {
					$this->success ( _ ( 'Payment cancelled.' ), U ( 'Search/payment?service_id=' . $service_id ), 5 );
					exit ();
				} else {
					$email = get_session_email ();
					db_log ( "Update database error. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "E" );
				}*/
			}
		}
		// -e- deal with the payment successful
		
		// -s- deal with the payment
		if (IS_POST) {
			$payment = $d_payment->get_payment ( array (
				'service_id' => $service_id 
			) );
			// send income email
			if (! is_array ( $payment )) {
				if ('' != I ( 'post.letter', '' )) {
					$session_id = $d_letter->add_letter_session ( array (
							'usr_login_id_session_from' => $user_id,
							'usr_login_id_session_to' => $service ['usr_login_id_seller'],
							'title' => I ( 'post.title' ),
							'service_id' => $service_id 
					) );
					$d_letter->add_letter ( array (
							'usr_login_id_from' => $user_id,
							'usr_login_id_to' => $service ['usr_login_id_seller'],
							'session_id' => $session_id,
							'letter' => I ( 'post.letter' ),
							'letter_status' => '2',
							'service_id' => $service_id 
					) );
				}
				if (false !== I ( 'post.request_meeting', false )) {
					$d_service->update_service ( array (
							'id' => $service_id,
							'meet' => '1' 
					) );
				}
			}

			$result = Braintree_Transaction::sale([
			  'amount' => sprintf ( "%01.2f", $service ['cost'] ),
			  'paymentMethodNonce' => $_POST['payment_method_nonce'],
			  'deviceData' => $_POST['device_data'],
			  'orderId' => uniqid('ORDER_'),
			  'options' => [
			    'submitForSettlement' => False
			  ]
			]);
			
			if ($result->success) {
				error_log($result->transaction->orderId);
				$res = is_array ( $payment ) ? $d_payment->update_payment ( array (
							'service_id' => $service_id,
							'pay_type' => '1',
							'pay_id' => $result->transaction->id,
							'pay_total' => $service ['cost'],
							'pay_currency' => '1',
							//'pay_status' => '1' 
					) ) : $d_payment->add_payment ( array (
							'service_id' => $service_id,
							'pay_type' => '1',
							'pay_id' => $result->transaction->id,
							'pay_total' => $service ['cost'],
							'pay_currency' => '1',
							//'pay_status' => '1' 
					) );
					
					if ($res) {
						//$this->success ( _ ( 'Redirect to the payment page.' ), $bill->links [1]->href );
						$this->success ( _ ( 'Redirect to the payment page.' ),U ( 'Search/payment@' . PET_DOMAIN, "service_id={$service_id}&success=true" ));
						db_log ( "Payment created successfully. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "I" );
						exit ();
					} else {
						db_log ( "Update database error. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "E" );
					}
			} else {
				$p_info = print_r ( $result, true );
				db_log ( "Return payment information from braintree error. service_id: {$service_id}; email: {$email}; payment: {$p_info}", __CLASS__ . __FUNCTION__, "E" );
			}
			// set a flag to determine whether can payment.
			/*$payment_type = I ( 'post.payment_type', 'paypal' );
			if ($payment_type) {
				if ($payment_type == 'paypal') {
					$token = get_paypal_token ();
					
					if ($token) {
						
						$bill = send_payment_request ( U ( 'Search/payment@' . PET_DOMAIN, "service_id={$service_id}&success=true" ), U ( 'Search/payment@' . PET_DOMAIN, "service_id={$service_id}&success=false" ), array (
								"amount" => array (
										"total" => sprintf ( "%01.2f", $service ['cost'] ),
										"currency" => C ( 'PET_CURRENCY' ) 
								),
								"description" => "" 
						), $token );
						if (isset ( $bill->id )) {
							$res = is_array ( $payment ) ? $d_payment->update_payment ( array (
									'service_id' => $service_id,
									'pay_type' => '1',
									'pay_id' => $bill->id,
									'pay_total' => $service ['cost'],
									'pay_currency' => '1',
									//'pay_status' => '1' 
							) ) : $d_payment->add_payment ( array (
									'service_id' => $service_id,
									'pay_type' => '1',
									'pay_id' => $bill->id,
									'pay_total' => $service ['cost'],
									'pay_currency' => '1',
									//'pay_status' => '1' 
							) );
							
							if ($res) {
								$this->success ( _ ( 'Redirect to the payment page.' ), $bill->links [1]->href );
								db_log ( "Payment created successfully. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "I" );
								exit ();
							} else {
								db_log ( "Update database error. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "E" );
							}
						} else {
							$p_info = print_r ( $bill, true );
							db_log ( "Return payment information from paypal error. service_id: {$service_id}; email: {$email}; payment: {$p_info}", __CLASS__ . __FUNCTION__, "E" );
						}
					} else {
						db_log ( "Can not link to payment.", __CLASS__ . __FUNCTION__, "E" );
					}
				} else {
					if (I ( 'post.last_name', '' ) && I ( 'post.first_name', '' ) && I ( 'post.card_number', '' ) && I ( 'post.expires_month', 0 ) && I ( 'post.expires_year', 0 ) && I ( 'post.security_code' )) {
						$params ['type'] = $payment_type;
						$params ['last_name'] = I ( 'post.last_name', '' );
						$params ['first_name'] = I ( 'post.first_name', '' );
						$params ['number'] = I ( 'post.card_number', '' );
						$params ['expire_month'] = I ( 'post.expires_month', 0 );
						$params ['expire_year'] = I ( 'post.expires_year', 0 );
						$params ['security_code'] = I ( 'post.security_code' );
						$response = vault_creditcard ( $user_id, $params );
						\Think\Log::write("[/vault/credit-card]:".json_encode($response));
						if ($response->name) {
							switch ($response->name) {
								case 'VALIDATION_ERROR' :
									$this->error ( _ ( $response->details [0]->issue ) );
									break;
								default :
							}
						} else {
							$res = is_array ( $payment ) ? $d_payment->update_payment ( array (
									'service_id' => $service_id,
									'pay_type' => '2',
									'pay_id' => $response->id,
									'pay_total' => $service ['cost'],
									'pay_currency' => '2',
									'pay_status' => '1' 
							) ) : $d_payment->add_payment ( array (
									'service_id' => $service_id,
									'pay_type' => '2',
									'pay_id' => $response->id,
									'pay_total' => $service ['cost'],
									'pay_currency' => '2',
									'pay_status' => '1' 
							) );
							
							if ($res) {
								$this->success ( _ ( 'Redirect to the payment page.' ), U ( 'User/Booking/booking' ) );
								db_log ( "Payment created successfully. service_id: {$service_id}; email: {$email}", __CLASS__ . __FUNCTION__, "I" );
								exit ();
							}
						}
					} else {
						$this->error ( _ ( 'Please complete your information.' ) );
					}
				}
			}else{
				$this->add_error('Please select payment type!');
			}*/
		}
		// -e- deal with the payment
		$this->assign_error ();
		
		$this->assign ( 'host', $host );
		$this->assign ( 'service', $service );
		$this->assign ( 'service_details', $service_details );
		
		$this->display ();
	}
}

