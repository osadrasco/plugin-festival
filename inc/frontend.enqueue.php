<?php

defined('ABSPATH') || die ( 'You have no power here!' );

add_action('wp_head', function(){
    $hash_store = isset($_GET["store"]) ? $_GET["store"] : 0;
    $lojas_allow = json_encode(ids_lojas_festival());
    ?>
    <script>
        const loja_id = <?php _e( sanitize_text_field($hash_store)) ?>;
        const loja_logo = "<?php _e( get_post_meta( sanitize_text_field($hash_store), "loja_logo", true)) ?>";
        const lojas_allow = <?php _e($lojas_allow) ?>;
        const loja_premiacao_page = '<?php _e(options_page_premium())?>';
    </script>
    <style>
    /**
     * Table responsive
     * @source <https://codepen.io/herudea/pen/YxLRWR>
    */
    body {
      font-family: "Open Sans", sans-serif;
      line-height: 1.25;
    }
    
    table {
      border: 0;
      border-collapse: collapse;
      margin: 0;
      padding: 0;
      width: 100%;
      table-layout: fixed;
    }
    table caption {
      text-align: left;
      font-size: 1.3em;
      margin: 0.5em 0 0.75em;
    }
    table thead {
      display: none;
    }
    table tr {
      display: block;
      border: 1px solid #eee;
      padding: 1em 1em 0.5em;
    }
    table tr + tr {
      margin-top: 0.625em;
    }
    table td {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      border-bottom: 1px solid #eee;
      font-size: 0.8em;
      line-height: 1.35em;
    }
    table td:before {
      content: attr(data-label);
      font-size: 0.9em;
      text-align: left;
      font-weight: bold;
      text-transform: uppercase;
      max-width: 45%;
      color: #545454;
    }
    table td + td {
      margin-top: 0.8em;
    }
    table td:last-child {
      border-bottom: 0;
    }
    
    @media screen and (min-width: 600px) {
      table caption {
        font-size: 1.5em;
      }
      table thead {
        display: table-header-group;
      }
      table tr {
        display: table-row;
        border: 0;
      }
      table th, table td {
        text-align: center;
      }
      table th {
        font-size: 0.85em;
        text-transform: uppercase;
      }
      table td {
        display: table-cell;
      }
      table td:before {
        display: none;
      }
      table td:last-child {
        border-bottom: 1px solid #eee;
      }
    }
    /**
     * check box escolha de lojas
    */
    #escolha_loja_para_atualizar p {
        display: flex;
    }
    #escolha_loja_para_atualizar label {
        padding-left: 8px;
    }
    </style>
    <script>jQuery.noConflict();</script>
    
    <?php
}, 9999);

/**
 * Never worry about cache again!
 */
add_action('wp_enqueue_scripts', function($hook) {

	wp_enqueue_script( 'jquery', "https://code.jquery.com/jquery-3.6.1.min.js", array() );
	wp_enqueue_script( 'jquery-mask', "https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js", array() );
// 	wp_register_style( 'my_css', 	plugins_url( 'style.css', 	 __FILE__ ), false );
// 	wp_enqueue_style ( 'my_css' );

});

add_action('wp_footer', function(){ ?>
    <script>
        jQuery("#novo_usuario").hide();
    </script>
    <?php
}, 15);
add_action('wp_footer', function(){
    if( isset( $_GET['store']) ){ ?>
        <script>
        jQuery(document).ready(() => {
            jQuery("#evento_message").html("");
            jQuery("#loja_logo").attr("src", loja_logo);
            jQuery("#form-field-is_cpf").mask('000.000.000-00');
            jQuery("#botao_cadastro").attr("type", "button");
            validStore();
            jQuery("#novo_usuario").show();    
        });
        jQuery(document).on("keyup","#form-field-is_cpf", function(){
            validarCPF( jQuery("#form-field-is_cpf").val().trim() ) ? jQuery("#form-field-is_cpf").css("border-color", "lime") : jQuery("#form-field-is_cpf").css("border-color", "red");
        });

        // Verificar CPF
        jQuery(document).on( "keyup", "#form-field-is_cpf", function(){
            var cpf_err = jQuery("#form-field-is_cpf").val();
            
            if( cpf_err.replace(/[^0-9]/gi, '').length == 11 ){
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php')?>',
                    type: 'post',
                    data: {
                        action: 'dsp_get_by_cpf',
                        cpf: cpf_err.replace(/[^0-9]/gi, ''),
                    },
                    success: function(data) {
                        console.log( data );
                        jQuery("#form-field-is_name").val(data.customer_datas.name);
                        jQuery("#form-field-is_email").val(data.customer_datas.email);
                    },
                    error: function(data) {
                      console.log( data );
                    }
                });
            }
        });
        
        // Formulário de cadastro
        jQuery(document).on( "click", "#botao_cadastro", function(){
            if( jQuery("#form-field-is_name").val().trim() == "" || jQuery("#form-field-is_email").val().trim() == "" || jQuery("#form-field-is_cpf").val().trim() == "" ) {
                alert("Preencha todos os campos");
                return;
            }
            if( !validStore() ){
                return;
            }
    
            if( !validarCPF( jQuery("#form-field-is_cpf").val() )  ){
                alert("CPF inválido, digite um CPF válido!");
                return;
            }
            
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php')?>',
                type: 'post',
                data: {
                    action: 'dsp_cadastro_usuario',
                    name: jQuery("#form-field-is_name").val(),
                    email: jQuery("#form-field-is_email").val(),
                    cpf: jQuery("#form-field-is_cpf").val(),
                },
                success: function(data) {
                  console.log( data );
                  jQuery("#form-field-user_id").val(data.id);
                  registrarClienteNoEvento();
                },
                error: function(data) {
                  console.log( data );
                }
            });
        });
        
        //Registrar cliente no evento
        function registrarClienteNoEvento(){
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php')?>',
                type: 'post',
                data: {
                    action: 'dsp_registar_evento_cliente',
                    id_user: Number(jQuery("#form-field-user_id").val()),
                    email: jQuery("#form-field-is_email").val(),
                    id_loja: Number(loja_id),
                },
                success: function(data) {
                    console.log( data );
                    jQuery("#evento_message").html("");
                    if(data.atualizado){
                        jQuery("#evento_message").html(`<span style="color: lime">${data.msg}</span>`);
                    } else {
                        if(data.premio){
                            jQuery("#evento_message").html(`<span style="color: blue">${data.msg}</span>`);
                            window.location.href = loja_premiacao_page;
                        } else {
                            jQuery("#evento_message").html(`<span style="color: red">${data.msg}</span>`);
                        }
                    }
                },
                error: function(data) {
                  console.log( data );
                }
            });
        }
        
        function validStore(){
            if( loja_id && loja_id == 0 && getUrlParameter('store') || !lojas_allow.includes(loja_id)){
                alert("ID de Loja inválido, solicite o link novamente!");
                return false;
            }
            return true;
        }
        /**
            jQuery(document).ready(() => {
                //Change button type on sender register
                jQuery("#botao_cadastro").attr("type", "button");
                jQuery("#consultar_cpf_cliente").attr("type", "button");
                jQuery("#button_register_event_client").attr("href","javascript:void(0)");
                jQuery("#form-field-is_cpf").mask('000.000.000-00');
                jQuery("#form-field-cpf_cliente").mask('000.000.000-00');
                
                //Default hidde
                // jQuery("#novo_usuario").hide();
                jQuery("#entregar_premio").hide();
                jQuery("#registar_cliente").hide();
                jQuery("#premio_ou_historico").hide();
            });
            jQuery(document).on("keyup","#form-field-cpf_cliente", function(){
                validarCPF( jQuery("#form-field-cpf_cliente").val().trim() ) ? jQuery("#form-field-cpf_cliente").css("border-color", "lime") : jQuery("#form-field-cpf_cliente").css("border-color", "red");
            });
            
            // Formulário de cadastro
            jQuery(document).on( "click", "#botao_cadastro", function(){
                if( jQuery("#form-field-is_name").val().trim() == "" || jQuery("#form-field-is_email").val().trim() == "" || jQuery("#form-field-is_cpf").val().trim() == "" ) {
                    alert("Preencha todos os campos");
                    return false;
                }
                
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php')?>',
                    type: 'post',
                    data: {
                        action: 'dsp_cadastro_usuario',
                        name: jQuery("#form-field-is_name").val(),
                        email: jQuery("#form-field-is_email").val(),
                        cpf: jQuery("#form-field-is_cpf").val(),
                    },
                    success: function(data) {
                      console.log( data );
                    },
                    error: function(data) {
                      console.log( data );
                    }
                });
            });
            
            //Consultar CPF de cliente
            jQuery(document).on( "click", "#consultar_cpf_cliente", function(){
                if( jQuery("#form-field-cpf_cliente").val().trim() == "") {
                    alert("Preencha o CPF para ser consultado");
                    return false;
                }
                if( !validarCPF(jQuery("#form-field-cpf_cliente").val().trim()) ){
                    alert("O CPF informado é inválido, digite um CPF válido!");
                    return false;
                }
                const innerHistorico = "#premio_ou_historico";
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php')?>',
                    type: 'post',
                    data: {
                        action: 'dsp_consultar_cpf_cliente',
                        cpf: jQuery("#form-field-cpf_cliente").val(),
                    },
                    success: function(data) {
                      console.log( data );
                      //Mostrar o botão de registrar o usuário no evento caso exista cadastro ou liberar o formulário de cadastro
                      if( data.cpf_exists ){
                        jQuery("#novo_usuario").hide();
                        jQuery("#entregar_premio").hide();
                        jQuery("#registar_cliente").show();
                        jQuery("#registar_cliente").attr('data-cliente', data.id);
                        jQuery("#escolha_loja_para_atualizar").html("");
                        if( data.lojas.length > 0){
                            jQuery("#escolha_loja_para_atualizar").show();
                            data.lojas.forEach((item)=>{
                                var checkeder = data.lojas.length == 1 ? 'checked=true' : '';
                                jQuery("#escolha_loja_para_atualizar").append(`
                                    <p>
                                      <input type="radio" ${checkeder} value="${item.loja_id}" name="id_loja" id="loja_${item.loja_id}"/>  
                                      <label for="loja_${item.loja_id}">${item.loja_nome}</label>
                                    </p>
                                `);
                            });
                            
                        } else {
                            jQuery("#escolha_loja_para_atualizar").show();
                            jQuery("#escolha_loja_para_atualizar").html('<div style="color:red; text-align: center;">Sem loja cadastrada!.</div>')
                        }
                      } else {
                        jQuery("#novo_usuario").show();
                        jQuery("#entregar_premio").hide();
                        jQuery("#registar_cliente").hide();
                        jQuery("#registar_cliente").removeAttr('data-cliente');
                      }
                      
                        //Mostrar o histório de eventos do cliente
                      if( data.historico.length > 0 ){
                        data.historico.forEach((item, index)=>{
                            jQuery("#premio_ou_historico tbody").append(`<tr>
                                <td data-label="Loja">${item.name}</td>
                                <td data-label="Data">${item.datetime}</td>
                            </tr>`)
                        });96697997249
                      }
                    },
                    error: function(data) {
                      console.log( data );
                    }
                });
            });
    
    
            //Registrar cliente no evento
            jQuery(document).on( "click", "#registar_cliente", function(){
                if( jQuery("#form-field-cpf_cliente").val().trim() == "") {
                    alert("Preencha o CPF para ser consultado");
                    return false;
                }
                if( !jQuery("[name=id_loja]").is(':checked') ){
                    alert("Escolha uma loja para ser atualizada");
                    return false;
                }
                
                const innerHistorico = "#premio_ou_historico";
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php')?>',
                    type: 'post',
                    data: {
                        action: 'dsp_registar_evento_cliente',
                        id_user: Number(jQuery("#registar_cliente").attr('data-cliente')),
                        id_loja: Number(jQuery("[name=id_loja]:checked").val()),
                    },
                    success: function(data) {
                        console.log( data );
                        jQuery("#novo_usuario").hide();
                        jQuery("#entregar_premio").hide();
                        jQuery("#registar_cliente").hide();
                        jQuery("#premio_ou_historico").hide();
                        
                        if(data.atualizado){
                            jQuery("#premio_ou_historico").show();
                        } else {
                            jQuery("#premio_ou_historico").hide();
                        }
                        alert(data.msg);
                    },
                    error: function(data) {
                      console.log( data );
                    }
                });
            });
         */
            const isEmail = (email) => {
                return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(email); // NEW REGEX, 98.9% working
            }
            const validarCPF = (cpf) => {
                cpf = cpf.replace(/[^\d]+/g,'');
                if(cpf == '') return false;
                // Elimina CPFs invalidos conhecidos	
                if (cpf.length != 11 || 
                    cpf == "00000000000" || 
                    cpf == "11111111111" || 
                    cpf == "22222222222" || 
                    cpf == "33333333333" || 
                    cpf == "44444444444" || 
                    cpf == "55555555555" || 
                    cpf == "66666666666" || 
                    cpf == "77777777777" || 
                    cpf == "88888888888" || 
                    cpf == "99999999999")
                        return false;		
                // Valida 1o digito	
                add = 0;
                for (i=0; i < 9; i ++)
                    add += parseInt(cpf.charAt(i)) * (10 - i);
                    rev = 11 - (add % 11);	
                    if (rev == 10 || rev == 11)
                        rev = 0;
                    if (rev != parseInt(cpf.charAt(9)))
                        return false;
                // Valida 2o digito
                add = 0;
                for (i = 0; i < 10; i ++)
                    add += parseInt(cpf.charAt(i)) * (11 - i);
                rev = 11 - (add % 11);	
                if (rev == 10 || rev == 11)
                    rev = 0;
                if (rev != parseInt(cpf.charAt(10)))
                    return false;
                return true;
            }
            /**
             * Obter param da url
             * @source <https://stackoverflow.com/a/21903119>
             * @param {String} sParam -
             * #return {String|Boolean}
            */
            const getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;
                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
                return false;
            };
            </script>
        <?php
    }
}, 99);