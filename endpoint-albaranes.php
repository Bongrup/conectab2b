<?php
// Verificar que el archivo no se acceda directamente
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Añade contenido para el endpoint "Consultar Albaranes", visible solo para roles específicos.
 */
function albaranes_content() {
    if ( current_user_can( get_option( 'conb2b_role', 'administrator' ) ) ) {
        echo '<h3>' . __( 'Tus Albaranes', 'conectab2b' ) . '</h3>';
        echo '<p>' . __( 'Aquí podrás ver y descargar tus albaranes.', 'conectab2b' ) . '</p>';
        // Aquí iría la lógica para mostrar los albaranes del cliente
    } else {
        echo '<p>' . __( 'No tienes permisos para acceder a esta sección.', 'conectab2b' ) . '</p>';
    }
}
add_action( 'woocommerce_account_albaranes_endpoint', 'albaranes_content' );
