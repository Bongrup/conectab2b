<?php
/**
 * Nombre del plugin: ConectaB2B
 * Versión file: 1.2
 * Versión del plugin: 0.1
 */

function conb2b_admin_page_content() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_POST['conb2b_save_settings'] ) ) {
        $role = sanitize_text_field( $_POST['conb2b_role'] );
        $show_facturas = isset( $_POST['conb2b_show_facturas'] ) ? 1 : 0;
        $show_albaranes = isset( $_POST['conb2b_show_albaranes'] ) ? 1 : 0;
        $show_modelo347 = isset( $_POST['conb2b_show_modelo347'] ) ? 1 : 0;

        // Guardar en la base de datos
        update_option( 'conb2b_role', $role );
        update_option( 'conb2b_show_facturas', $show_facturas );
        update_option( 'conb2b_show_albaranes', $show_albaranes );
        update_option( 'conb2b_show_modelo347', $show_modelo347 );

        // Guardar los campos de conexión con GXALMAC
        if ( isset( $_POST['conb2b_gxalmac_user'] ) ) {
            update_option( 'conb2b_gxalmac_user', encrypt_data( sanitize_text_field( $_POST['conb2b_gxalmac_user'] ) ) );
        }
        if ( isset( $_POST['conb2b_gxalmac_password'] ) ) {
            update_option( 'conb2b_gxalmac_password', encrypt_data( sanitize_text_field( $_POST['conb2b_gxalmac_password'] ) ) );
        }
        if ( isset( $_POST['conb2b_gxalmac_token'] ) ) {
            update_option( 'conb2b_gxalmac_token', encrypt_data( sanitize_text_field( $_POST['conb2b_gxalmac_token'] ) ) );
        }
        if ( isset( $_POST['conb2b_gxalmac_secretkey'] ) ) {
            update_option( 'conb2b_gxalmac_secretkey', encrypt_data( sanitize_text_field( $_POST['conb2b_gxalmac_secretkey'] ) ) );
        }

        // Añadir la nueva URL API
        if ( isset( $_POST['conb2b_api_url'] ) ) {
            update_option( 'conb2b_api_url', esc_url_raw( $_POST['conb2b_api_url'] ) );
        }

        echo '<div class="updated"><p>' . __( 'Settings saved successfully.', 'conectab2b' ) . '</p></div>';
    }

    $current_role = get_option( 'conb2b_role', 'administrator' );
    $current_show_facturas = get_option( 'conb2b_show_facturas', 1 );
    $current_show_albaranes = get_option( 'conb2b_show_albaranes', 1 );
    $current_show_modelo347 = get_option( 'conb2b_show_modelo347', 1 );

    // Desencriptar los datos guardados para mostrarlos en los campos
    $gxalmac_user = decrypt_data( get_option( 'conb2b_gxalmac_user' ) );
    $gxalmac_password = decrypt_data( get_option( 'conb2b_gxalmac_password' ) );
    $gxalmac_token = decrypt_data( get_option( 'conb2b_gxalmac_token' ) );
    $gxalmac_secretkey = decrypt_data( get_option( 'conb2b_gxalmac_secretkey' ) );

    // Obtener la URL de la API
    $api_url = esc_url( get_option( 'conb2b_api_url', '' ) );

    global $wp_roles;
    $roles = $wp_roles->roles;
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'ConectaB2B Settings', 'conectab2b' ); ?></h1>
        <p><?php esc_html_e( 'Configure the visibility settings and GXALMAC connection settings for the ConectaB2B plugin.', 'conectab2b' ); ?></p>

        <form method="post" action="">
            <?php wp_nonce_field( 'conb2b_save_settings', 'conb2b_nonce' ); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Visible only to Role:', 'conectab2b' ); ?></th>
                    <td>
                        <select name="conb2b_role">
                            <?php foreach ( $roles as $role_key => $role ) : ?>
                                <option value="<?php echo esc_attr( $role_key ); ?>" <?php selected( $current_role, $role_key ); ?>>
                                    <?php echo esc_html( $role['name'] ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Show Options:', 'conectab2b' ); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="conb2b_show_facturas" value="1" <?php checked( $current_show_facturas, 1 ); ?> />
                            <?php esc_html_e( 'Show "Consultar Facturas"', 'conectab2b' ); ?>
                        </label><br />
                        <label>
                            <input type="checkbox" name="conb2b_show_albaranes" value="1" <?php checked( $current_show_albaranes, 1 ); ?> />
                            <?php esc_html_e( 'Show "Consultar Albaranes"', 'conectab2b' ); ?>
                        </label><br />
                        <label>
                            <input type="checkbox" name="conb2b_show_modelo347" value="1" <?php checked( $current_show_modelo347, 1 ); ?> />
                            <?php esc_html_e( 'Show "Consultar Modelo 347"', 'conectab2b' ); ?>
                        </label>
                    </td>
                </tr>
            </table>

            <h2><?php esc_html_e( 'CONEXIÓN CON GXALMAC', 'conectab2b' ); ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Usuario:', 'conectab2b' ); ?></th>
                    <td><input type="text" name="conb2b_gxalmac_user" value="<?php echo esc_attr( $gxalmac_user ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Contraseña:', 'conectab2b' ); ?></th>
                    <td><input type="password" name="conb2b_gxalmac_password" value="<?php echo esc_attr( $gxalmac_password ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Token:', 'conectab2b' ); ?></th>
                    <td><input type="text" name="conb2b_gxalmac_token" value="<?php echo esc_attr( $gxalmac_token ); ?>" style="width: 400px;" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Secret Key:', 'conectab2b' ); ?></th>
                    <td><input type="text" name="conb2b_gxalmac_secretkey" value="<?php echo esc_attr( $gxalmac_secretkey ); ?>" style="width: 400px;" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'URL API:', 'conectab2b' ); ?></th>
                    <td><input type="text" name="conb2b_api_url" value="<?php echo esc_attr( $api_url ); ?>" style="width: 100%;" /></td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" name="conb2b_save_settings" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'conectab2b' ); ?>" />
            </p>
        </form>
    </div>
    <?php
}

/**
 * Funciones para cifrar y descifrar datos
 */
function encrypt_data( $data ) {
    $encryption_key = wp_salt(); // Utiliza una clave de cifrado segura
    $iv = openssl_random_pseudo_bytes( openssl_cipher_iv_length( 'aes-256-cbc' ) );
    $encrypted_data = openssl_encrypt( $data, 'aes-256-cbc', $encryption_key, 0, $iv );
    return base64_encode( $encrypted_data . '::' . $iv );
}

function decrypt_data( $data ) {
    $encryption_key = wp_salt(); // Utiliza la misma clave de cifrado
    list( $encrypted_data, $iv ) = explode( '::', base64_decode( $data ), 2 );
    return openssl_decrypt( $encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv );
}

require_once plugin_dir_path( __FILE__ ) . 'api-connection.php';

// Llamada a la función API
if ( isset( $_POST['input_field'] ) ) {
    $api_response = connect_to_magicloops_api( sanitize_text_field( $_POST['input_field'] ) );

    if ( is_wp_error( $api_response ) ) {
        echo '<div class="error"><p>' . esc_html( $api_response->get_error_message() ) . '</p></div>';
    } else {
        echo '<div class="updated"><p>' . esc_html( 'Respuesta de la API: ' . $api_response['loopOutput'] ) . '</p></div>';
    }
}


