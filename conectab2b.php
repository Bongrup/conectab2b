<?php
/**
 * Plugin Name: ConectaB2B
 * Plugin URI: https://bongrup.shop/
 * Description: Añade opciones para consultar facturas, albaranes y Modelo 347 en la sección "Mi Cuenta" de WooCommerce, visibles solo para roles específicos seleccionados desde la administración del plugin.
 * Version: 0.8
 * Author: Guillermo Elvira
 * Author URI: https://bongrup.shop/
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

/**
 * Cargar archivos de idioma
 */
function conb2b_load_textdomain() {
    load_plugin_textdomain( 'conectab2b', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'conb2b_load_textdomain' );

/**
 * Agrega los endpoints para las nuevas funcionalidades.
 */
function add_b2b_endpoints() {
    add_rewrite_endpoint( 'facturas', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'albaranes', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'modelo347', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_b2b_endpoints' );

/**
 * Registra los nuevos ítems en el menú "Mi Cuenta", visibles solo para roles específicos.
 */
function add_b2b_menu_items( $items ) {
    $role = get_option( 'conb2b_role', 'administrator' );
    $current_user = wp_get_current_user();

    // Remover temporalmente el ítem de "Salir"
    $logout = $items['customer-logout'];
    unset($items['customer-logout']);

    if ( in_array( $role, (array) $current_user->roles ) ) {
        if ( get_option( 'conb2b_show_facturas', 1 ) ) {
            $items['facturas'] = __( 'Consultar Facturas', 'conectab2b' );
        }
        if ( get_option( 'conb2b_show_albaranes', 1 ) ) {
            $items['albaranes'] = __( 'Consultar Albaranes', 'conectab2b' );
        }
        if ( get_option( 'conb2b_show_modelo347', 1 ) ) {
            $items['modelo347'] = __( 'Consultar Modelo 347', 'conectab2b' );
        }
    }

    // Volver a agregar el ítem de "Salir" al final
    $items['customer-logout'] = $logout;

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'add_b2b_menu_items' );

/**
 * Limpia las reglas de reescritura al activar el plugin.
 */
function b2b_activate() {
    add_b2b_endpoints();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'b2b_activate' );

/**
 * Limpia las reglas de reescritura al desactivar el plugin.
 */
function b2b_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'b2b_deactivate' );

/**
 * Agregar una página de administración bajo el menú de WooCommerce
 */
function conb2b_add_admin_menu() {
    add_submenu_page(
        'woocommerce',
        'ConectaB2B', // Título de la página
        'ConectaB2B', // Título del menú
        'manage_options', // Capacidad requerida
        'conecta-b2b', // Slug de la página
        'conb2b_admin_page_content' // Función que muestra el contenido de la página
    );
}

add_action( 'admin_menu', 'conb2b_add_admin_menu' );


function conb2b_enqueue_scripts() {
    // Solo cargar el CSS y JS en la página de "Mi Cuenta" de WooCommerce
    if ( is_account_page() ) {
        wp_enqueue_style(
            'conectab2b-css',
            plugin_dir_url( __FILE__ ) . 'assets/css/conectab2b.css',
            array(),
            '1.0.0',
            'all'
        );

        wp_enqueue_script(
            'conectab2b-js',
            plugin_dir_url( __FILE__ ) . 'assets/js/conectab2b.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'conb2b_enqueue_scripts' );


// Incluir archivos adicionales
require_once plugin_dir_path( __FILE__ ) . 'admin-page.php';
require_once plugin_dir_path( __FILE__ ) . 'extra_profile.php';
require_once plugin_dir_path( __FILE__ ) . 'endpoint-facturas.php';
require_once plugin_dir_path( __FILE__ ) . 'endpoint-albaranes.php';
require_once plugin_dir_path( __FILE__ ) . 'endpoint-modelo347.php';
