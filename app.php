<?php
/**
 * Plugin Name
 *
 * @package           dsp_dashboard
 * @author            DanSP
 * @copyright         2022 DSP
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Festival Eventos
 * Plugin URI:        https://dansp.dev/plugins/dsp-dashboard
 * Description:       GDPR management with customer support
 * Version:           2.0.2.2
 * Requires at least: 5.2
 * Requires PHP:      7.1
 * Author:            DanSP
 * Author URI:        https://t.me/dansp89
 * Text Domain:       dsp_dashboard
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://dansp.dev/updates/plugins/dsp-dashboard
 */

defined('ABSPATH') || die ( 'You have no power here!' );

define( 'DSP_DASHBOARD_DIR',        plugin_dir_path( __FILE__ ) );
define( 'DSP_DASHBOARD_URL',        plugin_dir_url(  __FILE__ ) );
define( 'DSP_DASHBOARD_PATH',       plugin_basename( __FILE__ ) );
define( 'DSP_DASHBOARD_URL_FRONT',  plugin_dir_url(__FILE__) );
define( 'DSP_DASHBOARD_3TH_DIR', DSP_DASHBOARD_DIR.'3rd-part/' );
define( 'DSP_DASHBOARD_REST_URL', site_url("/wp-json/wp/v2") ); //API BASE URL REST: mysite.dev/wp-json/wp/v2

/**
 * Load all resources, this process is automatic by directories
*/
add_action( 'init', function(){
    foreach([
        DSP_DASHBOARD_3TH_DIR.'cmb/init.php',
        ] as $t ){ include_once $t; }
    
    foreach([
        'helpers',
        'inc',
        'inc/cpt',
        'inc/class',
        'inc/shortcodes',
        'core',
        'inc/users',
    ] as $d ){ foreach (glob( DSP_DASHBOARD_DIR."$d/*.php" ) as $incs) { include $incs; } }
    //Init templates
    class_exists('dsp_templates_manager') ? new dsp_templates_manager(): "";
});