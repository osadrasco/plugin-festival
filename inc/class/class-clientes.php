<?php

/**
 * Listar post type especifico
 * @example url http://youdomain.com/wp-json/wp/v2/clientes || http://youdomain.com/api/wp/v2/clientes
 * 
 * @link SCHEMA https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#argument-schema
 * @link SCHEMA https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/
 * @return mixed
 * @author DanSP <daniel.rootdir@gmail.com>
 * 
 * @example args https://www.shawnhooper.ca/2017/02/15/wp-rest-secrets-found-reading-core-code/
 * Args types array|boolean|integer|number|string
 * 
 * @doc api rest https://developer.wordpress.org/rest-api/reference/post-types/
 * //(?P<id>\d+)
*/

defined( 'ABSPATH' ) || die( 'You have no power here!' );


class DSP_clientes {
    public function __construct() {
        $this->logged = is_user_logged_in();

        $version    = '2';
        $base       = 'clientes';
        register_rest_route( "wp/v$version", "/$base",
            array(
                array(
                    'methods'               => 'GET',//WP_REST_Server::CREATABLE,
                    'callback'              => array( $this, 'dsp_listing' ),
                    'permission_callback'   => array( $this, 'permission' ),
                    'description'           => esc_html__( 'Listar todos os clientes do por cpf', 'dsp_dashboard' ),
                ),
            )
        );
    }
    
    public function dsp_listing( $request ){
        $asus = [];
        $return = array();
        $args = array(
            'post_type'     => 'dsp_lgpd',
            'post_status'   => 'publish',
            'posts_per_page'=> -1,
            'fields'        => 'ids'
        );
        $query = new WP_Query($args);

        $i = 0;
        if( $query->post_count > 0 ){
            foreach($query->posts as $id ){
                $metas = get_post_meta($id);
                // var_dump($metas);
                $asus[$i]['lgpd_document'] = "";
                $asus[$i]['lgpd_name'] = "";
                $asus[$i]['lgpd_telephone'] = "";
                $asus[$i]['lgpd_email'] = "";
                $asus[$i]['lgpd_protocol'] = "";
                $asus[$i]['lgpd_request_initial'] = "";
                $asus[$i]['lgpd_status'] = "";
                
                foreach($metas as $key => $val){
                    if( $key == 'lgpd_document' || $key == 'lgpd_telephone' ){
                        $valor = $val[0];
                        $valor = preg_replace("/[^0-9]/","", $valor);
                        if( $key == 'lgpd_document' ){
                            $asus[$i][$key] = $this->mask($valor, "###.###.###-##");
                        }
                        if( $key == 'lgpd_telephone' ){
                            $asus[$i][$key] = $this->mask($valor, "(##) #####-#####");
                        }
                    } else {
                        $asus[$i][$key] = $val[0];
                    }
                }
                unset( $asus[$i]['_edit_lock'] );
                // $asus[$i]['status']     = ;//get_post_status($id);
                $asus[$i]['id']         = $id;
                $asus[$i]['actions']    = "<div class='edit_lgpd' data-edit-view='$id' data-bs-toggle='modal' data-bs-target='#modal_edit_lgpd' onclick='dsp_lgpd_modal_edit($id)'><i class='fa-solid fa-eye text-info' role='button'></i></div>";
                $i++;
            }
        }
        $return['data'] = $asus;
        return new WP_REST_Response( $return, 200 );
    }
    /**
     * Return bool if user allowed7
     * @return Boolean
    */
    public function permission(){
        $spec = $this->logged;
        // var_dump($spec);
        return $spec;
    }
    /**
     * Mask
     * PHP Máscara CNPJ, CPF, Data e qualquer outra coisa
     * http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
     * ver em funcionamento ~~> https://ideone.com/wP7zN2
     * $cnpj = '11222333000199';
     * $cpf = '00100200300';
     * $cep = '08665110';
     * $data = '10102010';
     * $hora = '021050';
     * echo mask($cnpj, '##.###.###/####-##').'<br>';
     * echo mask($cpf, '###.###.###-##').'<br>';
     * echo mask($cep, '#####-###').'<br>';
     * echo mask($data, '##/##/####').'<br>';
     * echo mask($data, '##/##/####').'<br>';
     * echo mask($data, '[##][##][####]').'<br>';
     * echo mask($data, '(##)(##)(####)').'<br>';
     * echo mask($hora, 'Agora são ## horas ## minutos e ## segundos').'<br>';
     * echo mask($hora, '##:##:##');
     * @source <https://gist.github.com/leonirlopes/5a4a1f796c776d4a695b2d8ca78ab108>
    */
    public function mask($val, $mask){
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}

add_action('rest_api_init', function () {
    new DSP_clientes;
    // header( 'X-Powered-By: DanSP | https://t.me/dansp89' );
});