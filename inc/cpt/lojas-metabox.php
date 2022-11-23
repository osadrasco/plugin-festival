<?php
/**
 * Custom fields for CPT
 * @author Dansp <https://t.me/dansp89>
*/
defined('ABSPATH') || die ( 'You have no power here!' );

if( !function_exists('dsp_metabox_cpt_lojas')){
    add_action( 'cmb2_admin_init', 'dsp_metabox_cpt_lojas' );
    /**
     * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
     */
    function dsp_metabox_cpt_lojas() {
    	/**
    	 * Sample metabox to demonstrate each field type included
    	 */
    	$field = new_cmb2_box( array(
    		'id'            => 'dsp_lojas_metas',
    		'title'         => esc_html__( 'Dados da loja', 'dsp_dashboard' ),
    		'object_types'  => array( 'lojas_festival' ),
    	) );
        
        // BEGIN::Line 1
        $field->add_field( array(
    		'name' => esc_html__( 'Logo', 'dsp_dashboard' ),
    		'description' => "Logo da loja",
    		'id'   => 'loja_logo',
    		'type' => 'file',
    	));
        $field->add_field( array(
    		'name' => esc_html__( 'Nome da Loja', 'dsp_dashboard' ),
    		'description' => "Razão social da loja",
    		'id'   => 'loja_nome',
    		'type' => 'text',
            'attributes' => array(
                'placeholder'   => esc_html__( 'Ex: Maria Coxinha', 'dsp_dashboard' ),
            ),
    	));
        $field->add_field( array(
            'name' => esc_html__( 'Nome do Responsavel', 'dsp_dashboard' ),
            'description' => "Nome do responsavel pelo estabelecimento",
            'id'   => 'loja_responsavel',
    		'type' => 'select',
            'options' => get_all_lojistas(),
            'attributes' => array(
                'width' => '100%'
            )
    	));
    	$field->add_field( array(
            'name' => esc_html__( 'Contato do Responsavel', 'dsp_dashboard' ),
            'description' => "Celular do responsavel",
            'id'   => 'loja_contato_responsavel',
    		'type' => 'text',
            'attributes' => array(
                'placeholder'   => esc_html__( 'Ex: (11) 00000-0000', 'dsp_dashboard' ),
                'class'         => 'cel_ddd',
            ),
    	));
    	$field->add_field( array(
            'name' => esc_html__( 'E-mail do responsavel', 'dsp_dashboard' ),
            'description' => "E-mail do responsavel pela loja",
            'id'   => 'loja_email',
    		'type' => 'text_email',
            'attributes' => array(
                'placeholder'   => esc_html__( 'Ex: user@user.com', 'dsp_dashboard' ),
            ),
    	));
    }
}