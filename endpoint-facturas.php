<?php
// Verificar que el archivo no se acceda directamente
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Nombre del plugin: ConectaB2b
 * Versión file: 0.2
 * Versión del plugin: 0.1
 * Date last mod: HH:MM - DD-MM-2024
 */

/**
 * Añade contenido para el endpoint "Consultar Facturas", visible solo para roles específicos.
 */

 function facturas_content() {
    if ( current_user_can( get_option( 'conb2b_role', 'administrator' ) ) ) {
        echo '<h3>' . __( 'Facturas', 'conectab2b' ) . '</h3>';
        echo '<p>' . __( 'Aquí podrás ver y descargar tus facturas.', 'conectab2b' ) . '</p>';
        
        // Botón para probar la conexión con MockAPI
        echo '<div class="form-group">';
        echo '<button id="test-magicloops" class="button-primary" style="background-color: green; color: white;">';
        echo 'PROBAR JSON API';
        echo '</button>';
        echo '</div>';
        
        // Div para mostrar la respuesta de la API
        echo '<div id="mockapi-response" style="margin-top: 20px;"></div>';
        
        // Incluir la URL de la API desde la base de datos y el archivo JavaScript
        echo '<script type="text/javascript">
                var apiUrl = "' . esc_url(get_option('conb2b_api_url', '')) . '";
              </script>';
        echo '<script src="' . esc_url(plugins_url('/assets/js/prueba-api.js', __FILE__)) . '"></script>';
        
    } else {
        echo '<p>' . __( 'No tienes permisos para acceder a esta sección.', 'conectab2b' ) . '</p>';
    }
}

add_action( 'woocommerce_account_facturas_endpoint', 'facturas_content' );



