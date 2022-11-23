<?php
/**
 * Clean up Wordpress admin clutter and unnecessary items and others functions
 * @author DanSP <https://t.me/dansp89>
 * 
 * @source WP User Levels <https://codex.wordpress.org/User_Levels>
*/

defined("ABSPATH")|| die("You have no power here!");

/**
 * Check if page content from modal
 * @return Boolean
 */
if( !function_exists('is_manager_lgpd') ){
    function is_manager_modal(){
        return isset($_GET['is_modal']) && $_GET['is_modal'] == 'true' ? true : false;
    }
}

/**
 * Check if page is looping manager LGPD
 * @return Boolean
 */
if( !function_exists('is_manager_lgpd') ){
    function is_manager_lgpd(){
        $r = isset($_GET['page']) && $_GET['page'] == 'dsp_manager_lgpd' ? true : false;
        return $r;
    }
}

/**
 * Check if page is looping manager PROCESS
 * @return Boolean
 */
if( !function_exists('is_manager_process') ){
    function is_manager_process(){
        return isset($_GET['page']) && $_GET['page'] == 'dsp_manager_process' ? true : false;
    }
}

/**
 * Check if post type specific
 * @param String - post_type_name
 * @return Boolean
 */
if( !function_exists('is_post_type') ){
    function is_post_type( $post_type_name ){
        global $post;
        return (isset($post->post_type) && $post->post_type == $post_type_name) ? true : false;
    }
}

/**
 * Check if user is "attendant" (role: dsp_attendante)
 * @return Boolean
 */
if( !function_exists('is_user_attendant') ){
    function is_user_attendant(){
        return in_array( "dsp_attendant", wp_get_current_user()->roles);
    }
}

/**
 * Check if user is "administrator" (role: administrator)
 * @return Boolean
 */
if( !function_exists('is_user_administrator') ){
    function is_user_administrator(){
        return in_array( "administrator", wp_get_current_user()->roles);
    }
}

/**
 * Remove itens from admin top bar
 * @source <https://wordpress.stackexchange.com/a/290222/174515>
*/
add_action( 'wp_before_admin_bar_render', function() {
    return false;
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
});


/**
 * Remove icon wp topbar admin
*/
add_action( 'wp_before_admin_bar_render', function() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
}, 0 );
/**
 * Change footer admin text
*/
add_filter( 'admin_footer_text', function(){
    if( !in_array( "dsp_attendant", dsp_role_current_user() ) ) {
        _e( sprintf( __('<span id="footer-thankyou">Developer by %s</span>', 'dsp_dashboard'), '<a href="https://dansp.dev" target="_blank" style="text-decoration: none;">&lt;DanSP/&gt;</a>' ) );
    }
});
/**
 * Get current ROLE from user logged in
 * Return array com roles from user
 * @return Array
*/
function dsp_role_current_user(){
	$current_user = wp_get_current_user();
	return $current_user->roles;
}


/**
 * @screen option
 * Remove Screen Options and Help from admin dashboard
*/
add_action('admin_head', 'mytheme_remove_help_tabs');
function mytheme_remove_help_tabs() {
	if( in_array( "dsp_attendant", dsp_role_current_user() ) ) {
		$screen = get_current_screen();
		$screen->remove_help_tabs();
	}
}
/**
 * @screen option
 * @source <https://www.wpbeginner.com/wp-tutorials/how-to-disable-the-screen-options-button-in-wordpress/#:~:text=In%20that%20tab%2C%20you%20need,for%20any%20specific%20user%20roles.>
*/
function wpb_remove_screen_options() {
    global $post;
    // if( in_array( "dsp_attendant", dsp_role_current_user() ) ) {
    $post_types = ['dsp_lgpd', 'dsp_process'];
    if( isset($post->post_type) && in_array($post->post_type, $post_types) ) {
        return false;
    }
    return true; 
}
add_filter('screen_options_show_screen', 'wpb_remove_screen_options');
/**
 * @screen option
 * Change layout in classic Editor to 1 column
 * @source <https://wordpress.stackexchange.com/a/208272/174515>
*/
add_filter( "get_user_option_screen_layout_dsp_lgpd", function ( $selected ) {
    return 1;
});
add_filter( "get_user_option_screen_layout_dsp_process", function ( $selected ) {
    return 1;
});

/**
 * Create ROLES and CAPS
*/
add_action('after_setup_theme', 'dsp_create_roles_and_caps'); //if using in theme
add_action('plugin_loaded', 'dsp_create_roles_and_caps'); // if using in plugin
function dsp_create_roles_and_caps(){
	
    remove_role('dsp_attendant');

	add_role( 'dsp_attendant', __('Attendant', 'dsp_dashboard' ), array(
			'read'				=> true,
			'edit_post' 		=> true,
            'edit_posts'		=> true,
			'edit_lgpds'		=> true,
            'edit_lgpd' 		=> true,
			'edit_process'		=> true,
			'create_process'	=> true,
			'level_0'			=> true,
			'level_1'			=> true,
			'level_2'			=> true,
			// 'contributor'		=> false,
		)
	);
};

 /**
  * Remove metabox from admin painel
 */
add_action('wp_dashboard_setup', function() {
    global $wp_meta_boxes;
// 	echo '<pre style="padding-left: 25%">';
// 	print_r($wp_meta_boxes);
// 	echo '</pre>';
	if( in_array( "dsp_attendant", dsp_role_current_user() ) ) {
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    // 	unset($wp_meta_boxes['dashboard']);
    }
});

/*
 * Add new dashboard widgets
 * @source <https://code.tutsplus.com/articles/customizing-the-wordpress-admin-the-dashboard--wp-33110>
 */
function wptutsplus_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wptutsplus_dashboard_welcome', __('Welcome', 'dsp_dashboard'), 'wptutsplus_add_welcome_widget' );
    wp_add_dashboard_widget( 'wptutsplus_dashboard_links', __('Useful links', 'dsp_dashboard'), 'wptutsplus_add_links_widget' );
}
function wptutsplus_add_welcome_widget(){ ?>
    <!-- Source: https://codepen.io/chartjs/pen/bWeqxB -->
    <div class="chart-container">
        <canvas id="chart_0"></canvas>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>
    <script id="rendered-js" >
    var data = {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      datasets: [{
        label: "Dataset #1",
        backgroundColor: "rgba(255,99,132,0.2)",
        borderColor: "rgba(255,99,132,1)",
        borderWidth: 2,
        hoverBackgroundColor: "rgba(255,99,132,0.4)",
        hoverBorderColor: "rgba(255,99,132,1)",
        data: [65, 59, 20, 81, 56, 55, 40]
      }
    ]};
    var option = {
      scales: {
        yAxes: [{
          stacked: true,
          gridLines: {
            display: true,
            color: "rgba(255,99,132,0.2)" } }],
        xAxes: [{
          gridLines: {
            display: false
          }
        }]
      }
    };
    Chart.Bar('chart_0', {
      options: option,
      data: data
    });
    </script>

    <?php
}
function wptutsplus_add_links_widget() {
    $user = wp_get_current_user();
    ?>
    <h1><?php echo __("Welcome "). $user->display_name;?></h1>
    <?php
}
add_action( 'wp_dashboard_setup', 'wptutsplus_add_dashboard_widgets' );

/**
 * Custom admin theme
*/
add_action('admin_head', 'dsp_custom_theme');
function dsp_custom_theme(){
	if( in_array( "dsp_attendant", dsp_role_current_user() ) ) { ?>
		<!--<link rel='stylesheet' id='admin-theme-style-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/style.css' media='all' />-->
		<!--<link rel='stylesheet' id='admin-theme-icon-material-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/icon.css' media='all' />-->
		<!--<link rel='stylesheet' id='admin-theme-variables-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/color.variables.css' media='all' />-->
		<!--<link rel='stylesheet' id='admin-theme-default-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/theme.dark.css' media='all' />-->
		<!--<link rel='stylesheet' id='admin-theme-admin-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/admin.css' media='all' />-->
		<!--<link rel='stylesheet' id='admin-theme-color-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/color.css' media='all' />-->
		<!--<link rel='stylesheet' id='admin-theme-theme-css'  href='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/css/theme.css' media='all' />-->
		<!-- <script type='text/javascript' src='http://wp.flatfull.com/first/wp-admin/load-scripts.php?c=0&amp;load%5Bchunk_0%5D=jquery-core,jquery-migrate,utils,zxcvbn-async,moxiejs,plupload&amp;ver=5.7.8'></script> -->

		<!--<script src='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/js/flatfull.dropdown.js' id='admin-theme-dropdown-js'></script>-->
		<!--<script src='<?php _e(DSP_DASHBOARD_URL)?>assets/backend/js/flatfull.main.js' id='admin-theme-main-js'></script>-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            /* END:: DanSP - Custom CSS Inline */

            /* END:: DanSP - Custom CSS Inline */
        </style>
		<?php
	}
};


// add_filter( "get_user_option_screen_layout_product", function( $result, $option, $user ){
//     return '1';
// }, 10, 3 );
function admin_color_scheme() {
	// global $_wp_admin_css_colors;
	// echo '<pre style="padding-left: 25%">';
	// print_r($_wp_admin_css_colors);
	// echo '</pre>';
	// $_wp_admin_css_colors = 0;
 }
 add_action('admin_head', 'admin_color_scheme');
 
/**
* Tomar o controle do post
*/
add_filter('override_post_lock', function( $lock ) {
    global $post;
    
    if ( is_admin() && !current_user_can('update_core') && ( $post->post_type == 'dsp_lgpd' || $post->post_type == 'dsp_process' )) {
        return false;
    } else {
        return $lock;
    }
});

/**
 * Disable application password in profile
 * @source <https://wordpress.org/support/topic/hide-disabled-application-password-in-profile/>
*/
add_filter('wp_is_application_passwords_available', function(){
    if( in_array( "dsp_attendant", dsp_role_current_user() ) ) {
        return false;
    }    
});



/**
 * Add new role
*/
add_action( 'admin_init', function(){
	add_role( 'lojista', __('Lojista', 'dsp_dashboard') );
// 	remove_role('attendant');
});

/**
 * GEt Options status from process
*/
if( !function_exists('options_status_process') ){
    function options_status_process(){
        return array(
            'analysis'      => esc_html( 'In Analysis', 'dsp_dashboard'),
            'completed'     => esc_html( 'Completed', 'dsp_dashboard'),
        );
    }
}
/**
 * Remove protocol from url
 * @link <>
*/
if( !function_exists('removeProtocol') ){
    function removeProtocol($url){
        $remove = array("http://","https://");
        return str_replace($remove,"",$url);
    }
}
/**
 * Updated separared field in settings
 * @param String $value - value from keyname
*/
if( !function_exists('update_last_protocol') ){
    function update_last_protocol($value){
    	$settings_main = get_option( 'dsp_lgpd_main_options' );
        $settings_main['lgpd_last_protocol'] = $value;
        update_option('dsp_lgpd_main_options', $settings_main, false );
    }
}
/**
 * Getting templates field in settings
 * @return Array;
*/
if( !function_exists('get_templates_list') ){
    function get_templates_list(){
    	// echo '<pre style="padding-left: 25%">';
    	$settings_main = get_option( 'dsp_lgpd_templates_options' );
    	// var_dump($settings_main);
    	if( isset($settings_main['templates']) ){
    		return $settings_main['templates'];
    	}
    	$settings_main[0] = array(
    		'name'		=> __('Whitout templates', 'dsp_dashboard'),
    		'message'	=> __('_', 'dsp_dashboard'),
    	);
    	// var_dump($settings_main);
    	// echo '</pre>';
        return $settings_main;
    }
}
/**
 * Getting separared field in settings
 * @return String||Null;
*/
if( !function_exists('get_last_protocol') ){
    function get_last_protocol(){
    	$settings_main = get_option( 'dsp_lgpd_main_options' );
    	if( isset($settings_main["lgpd_last_protocol"]) ){
    		return $settings_main['lgpd_last_protocol'];
    	}
        return null;
    }
}
/**
 * List all email to send email registered in settings and return array ";"
 * @return Array||false
*/
if( !function_exists('get_lgpd_list_email') ){
    function get_lgpd_list_email(){
    	$settings_main = get_option( 'dsp_lgpd_main_options' );
    	if( array_key_exists('lgpd_email_list', $settings_main)){
    		return $settings_main['lgpd_email_list'];
    	}
        return false;
    }
}
/**
 * Get enum type "type", used in process
*/
if( !function_exists('options_enum_type') ){
    function options_enum_type(){
    	$enum = get_option('dsp_lgpd_enums_type');
    	if( $enum && array_key_exists("enum_type_list", $enum) &&  count($enum["enum_type_list"]) > 0 ){
    		foreach($enum["enum_type_list"] as $option){
    			$options[$option['key']] = $option['value'];
    		}
    	} else {
            $options['none'] = esc_html__( 'Please register options in settings', 'dsp_dashboard');
        }
    	return $options;
    }
}
/**
 * Send email to protocol first
 * 
*/
if( !function_exists('sender_email_now') ){
    function sender_email_now( $userToSend, $subject = "New Message", $message = "No datas", $attachs = []){
    	if( get_lgpd_list_email() === false ){
    		return __("Error to send email, contact the suporte.", "dsp_dashboard");
    	} else {
    		$multiple_recipients = get_lgpd_list_email(); // Email list to send
    		$multiple_recipients[] = $userToSend;
    		$subj = __( $subject, 'dsp_dashboard');
    		$body = $message;
    		$headers = array(
    			'Content-Type: text/html; charset=UTF-8'
    		);
    		
    		//return wp_mail( $multiple_recipients, $subj, $body, $headers, $attacheds );
    	}
    }
}
/**
 * Lock edition LGPD protocol on finalized|finish|finished
*/
add_action('admin_head', function(){
    global $post;
    if( isset($post) && $post->post_type == 'dsp_lgpd'){
        $predator = get_post_meta($post->ID, 'lgpd_status', true);
        $predator = isset($predator) ? $predator : "open";
        ?>
        <script>
            const in_predator = "<?php _e($predator); ?>";
        </script>
        <?php
    } else {
        ?>
        <script>
            const in_predator = "open";
        </script>
        <?php
        
    }
});

/**
 * Send email by ajax setter, any OK!
 */
add_action('wp_ajax_dsp_get_lgpd_send_datas' , 'dsp_get_lgpd_send_datas');
add_action('wp_ajax_nopriv_dsp_get_lgpd_send_datas','dsp_get_lgpd_send_datas');
function dsp_get_lgpd_send_datas() {
    $role = dsp_role_current_user();
    $data = $_POST;
    $return = [];
    // $return['datas'] = $data;
    $return['is_send'] = false;
    
    $multiple_recipients = get_lgpd_list_email(); // Email list to send
    $post_id = intval($data['id']);
    // $return['metas'] = get_post_meta($post_id);
    
    $current_lgpd_status = get_post_meta($post_id, 'lgpd_status', true);
    $return['statu_protocol'] = $current_lgpd_status;
    
    $user_id = get_current_user_id(); //Responsible for finalization

    if( is_user_logged_in() && (in_array( "dsp_attendant", $role ) || in_array( "administrator", $role )) && $return['protocol_status'] == "open" ) {
        
        if( isset($data['email']) && isset($data['message']) && isset($data['id']) && isset($data['protocol']) ){
            
            $m['email_user']= sanitize_email($data['email']);
            $m['subject']   = sprintf( __( "Protocol %s answered", "dsp_dashboard"), sanitize_text_field($data['protocol']) );
            $m['message']   = sanitize_text_field($data['message']);
            
            $multiple_recipients[] = $m['email_user'];
            
    		if( count($data['attach']) > 0 ){
    		    foreach($data['attach'] as $i){
    		        $attacheds[] = get_attached_file($i);
    		    }
    		}
    		
    		$headers = [];
    		//$return['atacheds'] = $attacheds;;
            $return['is_send'] = wp_mail( $multiple_recipients, $m['subject'], $m['message'], $headers, $attacheds);
            $return['message'] = __("E-mail sent and protocol completed successfully, if you need to reopen it, contact technical support or a system administrator.", "dsp_dashboard");
            
            $upm["lgpd_request_finished"]   = current_datetime()->format('Y-m-d H:i:s');
            $upm["lgpd_attendant"]          = $user_id;
            $upm["lgpd_status"]             = "closed";
            
            foreach( $upm as $key => $val ) {
                update_post_meta($post_id, $key, $val); // Update attedante
            }
        }
    } else {
        $return['is_send'] = false;
        $return['message'] = __( "This protocol has already been finalized, if you need to reopen it, contact your support or system administrator.", "dsp_dashboard" );
    }
    wp_send_json($return, 200);
    die();
}

/**
 * Get all user with lojistas role defined
 * @return Array
*/
if( !function_exists('get_all_lojistas') ){
    function get_all_lojistas(){
    	$blogusers = get_users( array( 'roles' => ['lojista', 'administrator'] ) );
        $userind[0] = __('Selecionar...', 'dsp_dashboard');
    	foreach($blogusers as $user ){
            $user_id = $user->data->ID;
            $user_display = $user->data->display_name;
            $userind[$user_id] = "($user_id) - $user_display";
        }
        return $userind;
    }
}

/**
 * Get all user with attendent role defined
 * @return Array
*/
if( !function_exists('get_all_attendents') ){
    function get_all_attendents(){
    	$blogusers = get_users( array( 'role' => ['dsp_attendant'] ) );
        $userind = false;
        $userind[0] = __('No attendant yet!', 'dsp_dashboard');
    	foreach($blogusers as $user ){
            $user_id = $user->data->ID;
            $user_display = $user->data->display_name;
            $userind[$user_id] = "($user_id) - $user_display";
        }
        return $userind;
    }
}
/**
 * Replace email datas placeholders in sender protocol request initial
 * @param Array $placeholders - array find and replace
 * @return String
*/
if( !function_exists('dsp_email_send_protocol') ){
    function dsp_email_send_protocol($placeholders = []){
    	$settings_main = get_option( 'dsp_lgpd_email_options' );
    	if( isset($settings_main['lgpd_email_request']) ){
    		$email_template = $settings_main['lgpd_email_request'];
    		ob_start();
    		print $email_template;
    		$email_template = ob_get_contents();
    		ob_get_clean();
    		
    		foreach ($placeholders as $x => $y ){
    			$email_template = str_replace( $x, $y, $email_template );
    		}
    		return $email_template;
    	} else { //Value if not defined
    		return _e('Hello {{user_name}}, your service protocol is: {{protocol}}.\nWe will get back to you shortly with the answer to your request.', 'dsp_dashboard' );
    	}
    }
}
/**
 * Get an list from email setter, and do copy CC to header email
 * @return list
*/
if( !function_exists('get_lgpd_list_email_senders') ){
    function get_lgpd_list_email_senders(){
    	$settings_main = get_option( 'dsp_lgpd_email_options' );
    	return $settings_main;
    }
}

/**
 * REMOVER Publish metabox
 * @source <https://wordpress.stackexchange.com/a/76818/174515>
*/
add_action( 'admin_menu', function () {
    // remove_meta_box( 'submitdiv', 'dsp_lgpd', 'side' );
    // remove_meta_box( 'slugdiv', 'dsp_lgpd', 'normal' );
});

/*
 * ============================== CHECK IF USERMETA VALUE EXISTS ==============================
 * SOURCE: https://helptipsweb.wordpress.com/2017/09/04/wordpress-check-if-user-meta-exists-with-same-value-for-any-other-user-except-current-user/
 * @params string $chave
 * @params string $valor
 * $params string $compare @link https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters 
*/
function usermeta_value_exists($chave, $valor, $compare = '='){
	$args = array(
		'meta_key'     => sanitize_text_field($chave),
		'meta_value'   => sanitize_text_field($valor),
		'meta_compare' => $compare,
	);
	$user_query = new WP_User_Query($args);
	$authors = $user_query->get_results();
	$usermeta_value = count($authors) > 0 ? true : false;
	return $usermeta_value;
}
/**
 * Verificar se um CPF exist e retorna os objetos
 * @param String - $cpf
 * @return Object|Boolean
*/
function cpf_exists($cpf){
	$args = array(
	    'fields' => 'ids',
	    'meta_query' => array(
		    'relation' => 'AND',
        		array(
        			'key'     => 'user_cpf',
        			'value'   => $cpf,
        	 		'compare' => 'LIKE'
        		),''
    		),
	    );
	$user_query = new WP_User_Query($args);
	return $user_query->get_results();
}

/* =========== START - Verificar se documento existe (CPF/CNPJ) =========== */
add_action('wp_ajax_dsp_checar_documento', 'dsp_checar_documento');
add_action('wp_ajax_nopriv_dsp_checar_documento', 'dsp_checar_documento');
function dsp_checar_documento(){
	$documento = str_replace('-', '', $_POST['documento']);
	$documento = (int) filter_var($documento, FILTER_SANITIZE_NUMBER_INT);
	$documento = sanitize_text_field($documento);

	if (strlen($documento) == 11 || strlen($documento) == 14) {
		$doc_return = usermeta_value_exists('cpf', $documento, '=') == true ? 'true' : 'false';
	} else {
		$doc_return = 'invalid';
	}

	print $doc_return;
	die;
}

add_action('wp_ajax_dsp_get_by_cpf', 'dsp_get_by_cpf');
add_action('wp_ajax_nopriv_dsp_get_by_cpf', 'dsp_get_by_cpf');
function dsp_get_by_cpf(){
	$data = $_POST;
	
	$return['cpf']= str_replace("-", "", filter_var($data['cpf'], FILTER_SANITIZE_NUMBER_INT));
	
	$cpf_checker = cpf_exists($return['cpf']);
	$return['id'] = $cpf_checker[0];
	
	$return['cpf_exists'] = count($cpf_checker) > 0 ? true : false;
	
	if( $return['cpf_exists'] ){
	    $user_id = intval($return['id']);
        $user = get_userdata( $user_id );
        
        $return['customer_datas'] = array(
            // '$cpf_checker' => $cpf_checker,
            'name'  => $user->first_name,
            'email' => $user->data->user_email,
            'cpf'   => get_user_meta($user_id, "user_cpf", true),
            // 'datas' => $user,
        );
	} else {
	    $return['customer_datas'] = array(
            'name'  => "",
            'email' => "",
            'cpf'   => ""
        );
	}
	wp_send_json($return);
	die();
}


add_action('wp_ajax_dsp_cadastro_usuario', 'dsp_cadastro_usuario');
add_action('wp_ajax_nopriv_dsp_cadastro_usuario', 'dsp_cadastro_usuario');
function dsp_cadastro_usuario(){
	$data = $_POST;
	
	$return['name']     = $data['name'];
	$return['email']    = $data['email'];
	$return['cpf']      = str_replace("-", "", filter_var($data['cpf'], FILTER_SANITIZE_NUMBER_INT));
	
	$cpf_checker = cpf_exists($return['cpf']);
	$return['id'] = $cpf_checker;
	
	$return['cpf_exists'] = count($cpf_checker) > 0 ? true : false;
	$return['email_exists'] = email_exists($email);
	
	if( $return['cpf_exists']){
        $return['status'] = false;    
        $return['msg']  = "CPF Já cadastrado";
	} else if ( $return['email_exists'] ) {
	    $return['status'] = false; 
        $return['msg']  = "E-mail Já cadastrado";
	} else if( !$return['cpf_exists'] && !$return['email_exists']){
	    
	    $pass = bin2hex(openssl_random_pseudo_bytes(10));
	    
		$user_id = wp_create_user($return['email'], $pass , $return['email']);
		
        if( intval($user_id) > 0 ){
    		$user = new WP_User($user_id);
    		$user->set_role('customer');
    		update_user_meta($user_id, "user_cpf", $return['cpf']);
            wp_update_user( array( 'ID' => $user_id, 'first_name' => $data["name"] ) );
            $return['id'] = $user_id;
            $return['status'] = true;
            $return['msg']  = "Usuário cadastrado com sucesso";
            
            $user = get_userdata($user_id);
            $return['customer_datas'] = array(
                'name'  => $user->first_name,
                'email' => $user->user_email,
                'cpf'   => get_user_meta($user_id, "user_cpf", true)
            );
        } else {
            
            $return['status'] = false;
            $return['msg']  = "Falha ao cadastrar o usuário";
            
        }
	}
	wp_send_json($return);
	die();
}

/**
 * Verificar se CPF já está cadastrado e evitar duplicatas
*/
add_action( 'profile_update', 'dsp_check_if_cpf_exists', 10, 1);
add_action( 'user_register', 'dsp_check_if_cpf_exists', 10, 1);
function dsp_check_if_cpf_exists( $user_id ) {
    if ( isset( $_POST['user_cpf'] ) ){
        if( count(cpf_exists($_POST['user_cpf'])) > 1 ){

        } else {
            update_user_meta($user_id, 'user_cpf', sanitize_text_field($_POST['user_cpf']));
        }
    }
}
/**
 * Notice error user cpf
 * @source <https://digwp.com/2016/05/wordpress-admin-notices/>
*/
function validate_profile_form_fields( $errors ) {
	if( count(cpf_exists($_POST['user_cpf'])) > 1 ){
		$errors->add( 'empty_company', '<h3 style="color: red;">O CPF informado já existe em nossa base de dados, por favor tente outro CPF.</h3>' );
	}
	return $errors;
}
add_filter( 'user_profile_update_errors', 'validate_profile_form_fields' );


/**
 * GET pagina_premio from settings 
*/
if( !function_exists('options_page_premium') ){
    function options_page_premium(){
    	$cfg = get_option('dsp_cfg_main_options');
    	if( $cfg && array_key_exists("pagina_premio", $cfg) ){
            return get_permalink( intval($cfg['pagina_premio']));
        }
    	return '#';
    }
}
if( !function_exists('list_all_pages') ){
    function list_all_pages(){
        $args = array(
            'post_type'         => 'page',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
        );
        $query = new WP_Query($args);
        // var_dump($query->posts);
        foreach( $query->posts as $a ){
            $post_title = $a->post_title;
            $post_id = $a->ID;
            $p[$post_id] = "($post_id) $post_title";
        }
        return $p;
    }
}

/**
 * GET limite_premio from settings 
*/
if( !function_exists('options_cfg_premium') ){
    function options_cfg_premium(){
    	$cfg = get_option('dsp_cfg_main_options');
    	if( $cfg && array_key_exists("limite_premio", $cfg) ){
            return intval($cfg['limite_premio']);
        }
    	return 0;
    }
}

/**
 * Obter a loja pelo id do usuário lojista
*/
function loja_por_id($lojista_id){ 
    $args = array(
    //   'fields' => 'ids',
        'pst_status'    => 'publish',
        'post_type'     => 'lojas_festival',
        'meta_query'    => array(
            array(
                'key' => 'loja_responsavel',
                'value' => $lojista_id
            )
       )
    );
    $datas = [];
    $query = new WP_Query( $args );
    if( $query->post_count > 0 ){
        foreach( $query->posts as $j ){
            $datas[] = array(
                "loja_id" => $j->ID,
                "loja_nome" => $j->post_title
            );
        }
    }
    return $datas;
}


/**
 * Lista os ID das lojas que o usuário já está participando
*/
function lojas_do_evento($get_his){
    // $get_his = get_user_meta($user_id, 'lojas_compradas', true);
    $lojas_id = [];
    if( count($get_his) > 0 ){
        foreach($get_his as $a){
            $b = json_decode($a);
            $lojas_id[] = intval($b->loja_id);
        }
    }
    return $lojas_id;
}

/**
 * Consultar dados do cliente
*/
add_action('wp_ajax_dsp_consultar_cpf_cliente', 'dsp_consultar_cpf_cliente');
add_action('wp_ajax_nopriv_dsp_consultar_cpf_cliente', 'dsp_consultar_cpf_cliente');
function dsp_consultar_cpf_cliente(){
	$data = $_POST;

	$return['cpf']  = str_replace("-", "", filter_var($data['cpf'], FILTER_SANITIZE_NUMBER_INT));
	
	$cpf_checker = cpf_exists($return['cpf']);
	$return['id'] = intval($cpf_checker[0]);
	
	$return['cpf_exists']   = count($cpf_checker) > 0 ? true : false;
	$return['historico'] = [];
	
	$lojista_id = get_current_user_id();
    $loja_id    = loja_por_id($lojista_id);
	
	$return['lojas'] = $loja_id;
	if( $return['cpf_exists'] ){
	    $customer_datas = get_userdata($return['id']);
	   // $return['customer_datas']['name'] = 
	    $hist = get_user_meta($return['id'], 'lojas_compradas', true);
	    $prush = [];
	    if( is_array($hist) && count($hist) > 0){
	        foreach($hist as $histoo){
	            $prush[] = json_decode($histoo);
	        }
	    }
	    $return['status'] = true;
        $return['msg']  = "CPF Já cadastrado, trazendo os dados";
        $return['historico'] = $prush;
	} else {
	    $return['status'] = false;
        $return['msg']  = "CPF não cadastrado, liberando formulário para novo cadastro";
        
	}
	
	wp_send_json($return);
	die();
}

/**
 * Registrar cliente no EVENTO
*/
add_action('wp_ajax_dsp_registar_evento_cliente', 'dsp_registar_evento_cliente');
add_action('wp_ajax_nopriv_dsp_registar_evento_cliente', 'dsp_registar_evento_cliente');
function dsp_registar_evento_cliente(){
	$data = $_POST;
    $email = sanitize_email($data['email']);
    
    $lojista_id = get_current_user_id();
    $loja_id = intval(sanitize_text_field($data['id_loja']));
    
    $user_id = intval($data["id_user"]);
    $get_his = get_user_meta($user_id, 'lojas_compradas', true);
    $un = is_array($get_his) && $get_his[0] != "" ? $get_his : [];
    
    $return = array(
	    "lojista_id"    => $lojista_id,
	    "loja_id"       => $loja_id,
	    "name"          => get_the_title($loja_id),
	    "datetime"      => current_datetime()->format('Y-m-d H:i:s')
	);
	
	$eventos_participando = lojas_do_evento($un);
	$return['premio'] = false;
	$return['atualizado'] = false;
	$return['limite'] = options_cfg_premium();
	
	$un[]  = json_encode($return);
// 	$return['count_run'] = count($un);
	$return['eventos'] = $eventos_participando;
	$return['msg'] = "Loja Inválida!";
	/**
	 * Atualizar somente se for lojista, admnistrador e ID de loja não for zero
	*/
    // if( in_array( "lojista", wp_get_current_user()->roles) || in_array( "administrator", wp_get_current_user()->roles) && intval($loja_id) > 0 ){
    if( intval($loja_id) > 0 ){
        
        if( in_array( $loja_id, $eventos_participando) ){
    	    $return['atualizado'] = false;
    	    $return['msg'] = "O cliente já está participando desta loja!";            
        } else {
	        
	        update_user_meta($user_id, "lojas_compradas", $un);
    	    $return['atualizado'] = true;
    	    $return['msg'] = "Atualizado com sucesso!";
    	    
            $get_his = get_user_meta($user_id, 'lojas_compradas', true);
            $un = is_array($get_his) && $get_his[0] != "" ? $get_his : [];
        }
        
        //Obter dados atualizados
        $get_his = get_user_meta($user_id, 'lojas_compradas', true);
        $un = is_array($get_his) && $get_his[0] != "" ? $get_his : [];
        $eventos_participando = lojas_do_evento($un);
        $un[]  = json_encode($return);
        // $return['count_run'] = count($un);
        $return['eventos'] = $eventos_participando;
        
        //Entregar o PRÊMIO se validado o limite de lojas
        if( count($return['eventos']) == $return['limite'] ){
            $return['premio'] = true;
            $return['atualizado'] = false;
            $return['msg'] = "Você ganhou o prêmio! confira o seu e-mail";
            delete_user_meta($user_id, "lojas_compradas");
            $return['email_sended'] = notificacaoPremio($email);
        }
    }
    $return['eventos_limite'] = count($return['eventos']) === $return['limite'];
	wp_send_json($return);
	die();
}

function notificacaoPremio($email){
    // $user = wp_get_current_user();

    $messagem = "
        Olá, você ganhou a sua caneca\n 
        Vá ao balcão apresente este e-mail para resgatar!
    ";
    
    $return['email_message']    = [$email];
    $return['email_title']      = "Resgate sua caneca";
    $return['email_msg']        = $messagem;
    
    $return['is_send'] = wp_mail( $email, $return['email_title'], $return['email_msg']);
    return $return;
}

/**
 * Listar ID de Lojas 
*/
function ids_lojas_festival(){
    $args = array(
        'post_type'     => 'lojas_festival',
        'post_status'   => 'publish', 
        'fields'        => 'ids',
        'posts_per_page'      => -1,
    );
    $query = new WP_Query($args);
    return $query->posts;
}

add_action('wp', function(){
    if( isset($_GET['testes']) ){
        
        die();
    }
});
