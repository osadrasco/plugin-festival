<?php
/**
 * @source <https://github.com/CMB2/CMB2-Snippet-Library/blob/master/options-and-settings-pages/options-pages-with-tabs-and-submenus.php>
*/
// Exit if accessed directly.
defined( 'ABSPATH' ) || die( 'You have no power here!' );

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function dsp_cfg_register_main_options_metabox() {

	/**
	 * Registers main options page menu item and form.
	 */
	$args = array(
		'id'           => 'dsp_cfg_main_options_page',
		'title'        => __('CFG', 'dsp_dashboard'),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'dsp_cfg_main_options',
		'tab_group'    => 'dsp_cfg_main_options',
		'tab_title'    => __('CFG', 'dsp_dashboard'),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsp_cfg_options_display_with_tabs';
	}

	$main_options = new_cmb2_box( $args );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Limite máximo para premiação', 'dps_dashboard' ),
		'description'=> __( 'Defina o limite máximo em que o cliente deverá receber o prêmio', 'dsp_dashboard' ),
		'id'         => 'limite_premio',
		'type'       => 'text',
	));
	$main_options->add_field( array(
		'name'       => esc_html__( 'Página da premiação', 'dps_dashboard' ),
		'description'=> __( 'Escolha a página que o cliente irá receber a mensagem que ganhou o prêmio!', 'dsp_dashboard' ),
		'id'         => 'pagina_premio',
		'type'       => 'select',
		'options'    => list_all_pages(),
	));


}
add_action( 'cmb2_admin_init', 'dsp_cfg_register_main_options_metabox' );

/**
 * A CMB2 options-page display callback override which adds tab navigation among
 * CMB2 options pages which share this same display callback.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 */
function dsp_cfg_options_display_with_tabs( $cmb_options ) {
	$tabs = dsp_cfg_options_page_tabs( $cmb_options );
	?>
	<div class="wrap cmb2-options-page option-<?php echo $cmb_options->option_key; ?>">
		<?php if ( get_admin_page_title() ) : ?>
			<h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
		<?php endif; ?>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $option_key => $tab_title ) : ?>
				<a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
			<?php endforeach; ?>
		</h2>
		<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $cmb_options->cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
			<input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
			<?php $cmb_options->options_page_metabox(); ?>
			<?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
		</form>
	</div>
	<?php
}

/**
 * Gets navigation tabs array for CMB2 options pages which share the given
 * display_cb param.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 *
 * @return array Array of tab information.
 */
function dsp_cfg_options_page_tabs( $cmb_options ) {
	$tab_group = $cmb_options->cmb->prop( 'tab_group' );
	$tabs      = array();

	foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
		if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
			$tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
				? $cmb->prop( 'tab_title' )
				: $cmb->prop( 'title' );
		}
	}

	return $tabs;
}

add_action('admin_head', function(){ ?>
    <style>
        .CodeMirror-sizer {
            margin-left: 2% !important;
        }
        pre.CodeMirror-line {
            margin-left: 3% !important;
        }
    </style>
    <?php
});
