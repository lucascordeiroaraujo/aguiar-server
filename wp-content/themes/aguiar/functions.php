<?php

	ob_start();

	date_default_timezone_set('Brazil/East');

	ini_set('display_errors', 'on');

	function custom_login_page(){

		echo '
			<style  type="text/css">
				h1 a{
					background-image:url(' . get_bloginfo('template_directory') . '/logo-login.png) !important;
					width: 320px !important;
					background-size: 320px !important;
				}
			</style>
		';

	}add_action('login_head',  'custom_login_page');


	function custom_dashboard(){

		echo '
			<style  type="text/css">
				#adminmenu li.wp-menu-separator{
					border-top: 1px solid #CCC !important;
					border-bottom: 1px solid #CCC !important;
				}
				#adminmenu{
					margin-top: 0px;
					border-top: 5px solid #0074A2;
					border-bottom: 5px solid #0074A2;
				}
				#toplevel_page_edit-post_type-acf-field-group, #wp-admin-bar-comments, #wp-admin-bar-updates,
				span.update-plugins, #wp-admin-bar-new-content, #contextual-help-link-wrap, #footer-thankyou, #wp-version-message,  
				#wp-admin-bar-wpseo-menu, #toplevel_page_gadash_settings, .column-wpseo-score-readability, #wp-admin-bar-all-in-one-seo-pack,
				.column-comments, .column-tags, .column-author, #dashboard_right_now, #dashboard_activity, #wpseo-dashboard-overview, #toplevel_page_smush, 
				#toplevel_page_gadwp_settings, #dashboard_quick_press, #revisionsdiv, #commentsdiv, #welcome-panel, #scpo-notice, .frash-notice-email, 
				#toplevel_page_all-in-one-seo-pack-aioseop_class, #tagsdiv-post_tag, #postimagediv, #menu-appearance, #dashboard_primary, 
				#post-preview, div.misc-pub-post-status, #visibility, a.edit-timestamp, #menu_order, #pageparentdiv p, #show-settings-link,
				tr.user-rich-editing-wrap, tr.user-syntax-highlighting-wrap, tr.user-admin-color-wrap, tr.user-comment-shortcuts-wrap, 
				tr.show-admin-bar.user-admin-bar-front-wrap, tr.user-description-wrap, tr.user-profile-picture, tr.user-display-name-wrap, 
				tr.user-nickname-wrap, #toplevel_page_wp-graphiql-wp-graphiql, #wp-admin-bar-view, #message p a, #edit-slug-box, a.acf-hndle-cog,
				span.view, #bulk-action-selector-bottom, #doaction2, #collapse-menu, #menu-posts-contact, .empty-container, .acf-to-rest-api-donation-notice, 
				#dashboard_site_health {
					display: none !important;
				}
				#pageparentdiv select{
					width: 100%;
				}
			</style>
		';

	}add_action('admin_head', 'custom_dashboard');


	function wps_admin_bar(){

		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('wp-logo');

		$wp_admin_bar->remove_menu('about');

		$wp_admin_bar->remove_menu('wporg');

		$wp_admin_bar->remove_menu('documentation');

		$wp_admin_bar->remove_menu('support-forums');

		$wp_admin_bar->remove_menu('feedback');

		$wp_admin_bar->remove_menu('view-site');

	}add_action('wp_before_admin_bar_render', 'wps_admin_bar');


	function alt_admin_footer(){

		echo '<span id="footer-thankyou"></span>';

	}add_filter('admin_footer_text', 'alt_admin_footer');


	function wphidenag(){

		remove_action('admin_notices','update_nag',3);

	}add_action('admin_menu','wphidenag');


	function remove_links_menu(){

		remove_menu_page('edit.php');

		remove_menu_page('options-general.php');

		remove_menu_page('tools.php');

		remove_menu_page('edit.php');

		remove_menu_page('edit-comments.php');

		remove_menu_page('plugins.php');

		remove_menu_page('link-manager.php');

		remove_menu_page('upload.php');

		remove_submenu_page('index.php','update-core.php');

		remove_submenu_page('themes.php','themes.php');

		remove_submenu_page('themes.php','customize.php');

		remove_submenu_page('themes.php','widgets.php');

	}add_action('admin_menu', 'remove_links_menu');


	function change_footer_version(){

		return '';

	}add_filter('update_footer', 'change_footer_version', 9999);


	function restore_dashboard_columns(){

		add_screen_option(
			'layout_columns',
			array(
				'max'     => 3,
				'default' => 3
			)
		);

	}add_action('admin_head-index.php', 'restore_dashboard_columns');


	add_filter('use_block_editor_for_post', '__return_false', 10);


	function add_file_types_to_uploads($file_types){

		$new_filetypes = array();

		$new_filetypes['svg'] = 'image/svg';

		$file_types = array_merge($file_types, $new_filetypes);

		return $file_types;

	}add_action('upload_mimes', 'add_file_types_to_uploads');

	function register_cpts(){

		register_post_type('itineraries', array(
			'labels' => array(
				'name' 				=> _x('Roteiros', 'itineraries'),
				'singular_name' 	=> _x('Roteiros', 'itineraries')
			),
			'hierarchical' 			=> true,
			'supports' 				=> array('title'),
			'public' 				=> true,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'show_in_nav_menus' 	=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'has_archive' 			=> true,
			'query_var' 			=> true,
			'can_export' 			=> true,
			'rewrite' 				=> true,
			'capability_type' 		=> 'post',
			'menu_position' 		=> 6,
			'menu_icon' 			=> 'dashicons-airplane',
			'show_in_rest'       	=> true,
			'rest_base'          	=> 'itineraries',
			'rest_controller_class' => 'WP_REST_Posts_Controller'
		));

		register_post_type('newsletter', array(
			'labels' => array(
				'name' 				=> _x('Newsletter', 'newsletter'),
				'singular_name' 	=> _x('Newsletter', 'newsletter')
			),
			'hierarchical' 			=> true,
			'supports' 				=> array('title'),
			'public' 				=> true,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'show_in_nav_menus' 	=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'has_archive' 			=> true,
			'query_var' 			=> true,
			'can_export' 			=> true,
			'rewrite' 				=> true,
			'capability_type' 		=> 'post',
			'menu_position' 		=> 6,
			'menu_icon' 			=> 'dashicons-email',
			'show_in_rest'       	=> false
		));

	}add_action('init', 'register_cpts');

	function tr_create_my_taxonomy(){

		register_taxonomy(
			'itineraries-category',
			'itineraries',
			array(
				'hierarchical'      	=> true,
				'public' 				=> true,
				'show_ui'           	=> true,
				'show_admin_column' 	=> true,
				'query_var'         	=> true,
				'label' 				=> __('Locais de Embarque'),
				'rewrite' => array(
					'slug' => 'itineraries-category'
				),
				'show_in_rest'       	=> true,
				'rest_base'          	=> 'itineraries-category',
				'rest_controller_class' => 'WP_REST_Terms_Controller'
			)
		);

	}add_action('init', 'tr_create_my_taxonomy');

	if(function_exists('add_image_size')):

		add_image_size('testimonials', 730, 730, array('center', 'center'));

		add_image_size('testimonials-person', 123, 123, array('center', 'center'));

		add_image_size('itineraries-list', 390, 390, array('top', 'top'));

		add_image_size('itinerarie', 800, 800, array('center', 'center'));

		add_image_size('itinerarie-pictures', 300, 250, array('center', 'center'));

	endif;

	function wp_register_newsletter($request){

		$params = $request->get_params();

		$hasEmail = get_posts(array(
			'numberposts'	=> 2,
			'post_type'		=> 'newsletter',
			'meta_key'		=> 'email',
			'meta_value'	=> $params['body'][0],
			'post_status' 	=> 'any'
		));

		if(!$hasEmail) {

			$postId = wp_insert_post(array(
				'post_title' 	=> $params['body'][0],
				'post_type' 	=> 'newsletter',
			));

		}

		if($postId || $hasEmail):

			if($postId) {

				update_field('email', $params['body'][0], $postId);

				update_field('whatsapp', $params['body'][1], $postId);

				update_field('date', date('d/m/Y H:i:s'), $postId);

				update_field('last_update', date('d/m/Y H:i:s'), $postId);

			}

			if($hasEmail) {

				update_field('whatsapp', $params['body'][1], $hasEmail[0]->ID);

				update_field('last_update', date('d/m/Y H:i:s'), $hasEmail[0]->ID);

			}

			$response = new WP_REST_Response('', 200);

		else:

			$response = new WP_REST_Response('', 204);

		endif;

		$response->set_headers(array('Cache-Control' => 'no-cache'));

		return rest_ensure_response($response);
	}

	function wp_filter_itineraries($request) {

		$params = $request->get_params();

		$months = array(
			'janeiro' 	=> '01', 
			'fevereiro' => '02', 
			'marco' 	=> '03', 
			'abril' 	=> '04', 
			'maio' 		=> '05', 
			'junho' 	=> '06', 
			'julho' 	=> '07', 
			'agosto' 	=> '08', 
			'setembro' 	=> '09', 
			'outubro' 	=> '10', 
			'novembro' 	=> '11', 
			'dezembro' 	=> '12'
		);

		$posts = get_posts(array(
			'numberposts'	=> -1,
			'post_type'		=> 'itineraries',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'itineraries-category',
					'field' 	=> 'slug',
					'terms' 	=> $params['boarding_place']
				)
			)
		));

		$itinerariesList = array();
		
		$count = 0;

		foreach($posts as $post):

			if($count < intval($params['per_page'], 10)):

				$count++;

				$itinerariesList[] = array(
					'slug' 	=> $post->post_name,
					'title' => array(
						'rendered' => $post->post_title
					),
					'acf' 	=> array(
						'list_image' 		=> get_field('list_image', $post->ID),
						'included_resume' 	=> get_field('included_resume', $post->ID),
						'price' 			=> get_field('price', $post->ID),
						'installment' 		=> get_field('installment', $post->ID),
						'output' 			=> get_field('output', $post->ID),
						'arrival' 			=> get_field('arrival', $post->ID)
					)
				);

			endif;

		endforeach;

		return $itinerariesList;

	}

	function wp_cities_and_months() {

		$posts = get_posts(array(
			'numberposts'	=> -1,
			'post_type'		=> 'itineraries'
		));

		$months = [];

		$cities = [];

		$ptBrMonths = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

		$taxonomies = get_terms(array(
			'taxonomy' 		=> 'itineraries-category',
			'hide_empty' 	=> true
		));

		foreach($posts as $post):

			$date = explode('-', get_field('output', $post->ID));

			if(!array_key_exists($date[1], $months)) {

				$months[$date[1]] = [
					'month' 		=> $ptBrMonths[$date[1]*1],
					'abbreviation'	=> substr($ptBrMonths[$date[1]*1], 0, 3),
					'slug' 			=> strtolower(str_replace('ç', 'c', $ptBrMonths[$date[1]*1]))
				];

			}

			foreach($taxonomies as $city):

				if(!array_key_exists($city->name, $cities)) {

					$cities[$city->name] = [
						'name' => $city->name,
						'slug' => $city->slug
					];

				}

			endforeach;

		endforeach;

		asort($cities);

		ksort($months);

		return [
			'months' => $months,
			'cities' => $cities
		];

	}

	function wp_get_roadmap($request) {
		$params = $request->get_params();

		$post = array_shift(get_posts(array(
			'post_type'	=> 'itineraries',
			'name' 		=> $params['post_slug']
		)));

		$itinerary = array();

		if($post):
			$categories = wp_get_post_terms($post->ID, 'itineraries-category');

			$boardingPlace = array();

			if($categories):
				foreach($categories as $cat):
					$boardingPlace[] = array(
						'value' => $cat->slug,
						'label' => $cat->name
					);
				endforeach;
			endif;

			$itinerary[] = array(
				'slug' => $post->post_name,
				'title' => array(
					'rendered' => $post->post_title
				),
				'acf' => array(
					'banner' 			=> get_field('banner', $post->ID),
					'list_image' 		=> get_field('list_image', $post->ID),
					'image' 			=> get_field('image', $post->ID),
					'sale_type' 		=> get_field('sale_type', $post->ID),
					'included_resume' 	=> get_field('included_resume', $post->ID),
					'old_price' 		=> get_field('old_price', $post->ID),
					'price' 			=> get_field('price', $post->ID),
					'installment' 		=> get_field('installment', $post->ID),
					'output' 			=> get_field('output', $post->ID),
					'arrival' 			=> get_field('arrival', $post->ID),
					'boarding_place' 	=> $boardingPlace,
					'included' 			=> get_field('included', $post->ID),
					'pictures' 			=> get_field('pictures', $post->ID),
					'seo_title' 		=> get_field('seo_title', $post->ID),
					'seo_description' 	=> get_field('seo_description', $post->ID),
					'seo_image' 		=> get_field('seo_image', $post->ID),
				)
			);
		endif;

		return $itinerary;
	}

	add_action('rest_api_init', function(){

		register_rest_route('aguiar', '/registerNewsletter', array(
			'methods' 	=> 'POST',
			'callback' 	=> 'wp_register_newsletter',
		));

		register_rest_route('aguiar', '/itineraries/(?P<per_page>[0-9_-]+)/(?P<boarding_place>[a-zA-Z0-9_-]+)', array(
			'methods' 	=> 'GET',
			'callback' 	=> 'wp_filter_itineraries',
		));

		register_rest_route('aguiar', '/city-month', array(
			'methods' 	=> 'GET',
			'callback' 	=> 'wp_cities_and_months',
		));

		register_rest_route('aguiar', '/itinerary/(?P<post_slug>[a-zA-Z0-9_-]+)', array(
			'methods' 	=> 'GET',
			'callback' 	=> 'wp_get_roadmap',
		));

	});

?>