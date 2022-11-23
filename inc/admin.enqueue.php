<?php

defined('ABSPATH') || die ( 'You have no power here!' );

add_action( 'admin_footer', 'dsp_admin_footer', 12);

function dsp_admin_footer(){
    if( isset($_GET['post_type']) && sanitize_text_field($_GET['post_type']) === 'lojas_festival'){ ?>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
        <script>
            jQuery(document).ready(function(){
                // Select2 - All fields <select>
                jQuery('select').select2({
                    width: 'resolve'
                });
                //Masks in admin
                jQuery('.cel_ddd').mask('(00) 00000-0000');
                jQuery('.cpf').mask('000.000.000-00');
            });
        </script>
        <?php
    }
}