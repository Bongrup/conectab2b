<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Nombre del plugin: ConectaB2b
 * Versión file: 1.1
 * Versión del plugin: 0.1
 */

function connect_to_magicloops_api( $input ) {
    // Obtener la URL de la API desde la base de datos
    $url = get_option('conb2b_api_url', '');

    // Verificar si la URL está vacía
    if ( empty( $url ) ) {
        return new WP_Error( 'api_url_not_set', __( 'La URL de la API no está configurada.', 'conectab2b' ) );
    }

    // Datos a enviar en la petición
    $data = array(
        'input' => $input
    );

    // Opciones de la solicitud HTTP
    $args = array(
        'body'        => json_encode($data),
        'headers'     => array('Content-Type' => 'application/json'),
        'timeout'     => 45,
    );

    // Realiza la petición POST usando wp_remote_post
    $response = wp_remote_post( $url, $args );

    // Verifica si hubo un error en la petición
    if ( is_wp_error( $response ) ) {
        return $response; // Retorna el error directamente
    }

    // Decodifica la respuesta
    $decoded_response = json_decode( wp_remote_retrieve_body( $response ), true );

    // Verifica si la respuesta es válida
    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('api_response_error', __( 'La respuesta de la API no es válida.', 'conectab2b' ));
    }

    return $decoded_response;
}
