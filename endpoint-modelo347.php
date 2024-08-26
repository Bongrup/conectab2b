<?php
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
        echo '<p>' . __( 'Aquí podrás descargar tu Modelo 347.', 'conectab2b' ) . '</p>';
        // Aquí iría la lógica para gestionar el Modelo 347
    } else {
        echo '<p>' . __( 'No tienes permisos para acceder a esta sección.', 'conectab2b' ) . '</p>';
    }
}
add_action( 'woocommerce_account_modelo347_endpoint', 'modelo347_content' );
