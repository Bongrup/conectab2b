<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Nombre del plugin: ConectaB2b
 * Versión file: 0.5
 * Versión del plugin: 0.1
 * Date last mod: HH:MM - DD-MM-2024
 */

// Verificar que el archivo no se acceda directamente
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Añade contenido para el endpoint "Modelo 347", visible solo para roles específicos.
 */
function modelo347_content() {
    if ( current_user_can( get_option( 'conb2b_role', 'administrator' ) ) ) {
        echo '<h3>' . __( 'Modelo 347', 'conectab2b' ) . '</h3>';
        echo '<p>' . __( 'Aquí podrás descargar tu informe modelo 347.', 'conectab2b' ) . '</p>';
        
        // Botón para descargar Modelo 347
        echo '<div class="form-group">';
        echo '<a href="#" class="button-primary" style="background-color: green; color: white; padding: 10px 20px; text-decoration: none;">';
        echo __( 'DESCARGAR MODELO 347', 'conectab2b' );
        echo '</a>';
        echo '</div>';

        // Aquí iría la lógica para mostrar los albaranes del cliente
    } else {
        echo '<p>' . __( 'No tienes permisos para acceder a esta sección.', 'conectab2b' ) . '</p>';
    }
}
add_action( 'woocommerce_account_modelo347_endpoint', 'modelo347_content' );
