<?php
// Verificar que el archivo no se acceda directamente
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Añadir campos personalizados en la ficha de usuario en el backend.
 */
function conb2b_extra_user_profile_fields( $user ) {
    // Solo para usuarios con permisos de gestión
    if ( ! current_user_can( 'manage_options', $user->ID ) ) {
        return;
    }

    // Recuperar valores actuales
    $gxalmac_number = get_user_meta( $user->ID, 'gxalmac_number', true );
    $is_gxalmac_linked = get_user_meta( $user->ID, 'is_gxalmac_linked', true );
    ?>
    <h3><?php esc_html_e( 'Datos GXALMAC', 'conectab2b' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="gxalmac_number"><?php esc_html_e( 'Nº de cliente de GXALMAC', 'conectab2b' ); ?></label></th>
            <td>
                <input type="number" name="gxalmac_number" id="gxalmac_number" value="<?php echo esc_attr( $gxalmac_number ); ?>" class="regular-text" maxlength="8" />
                <span class="description"><?php esc_html_e( 'Número de cliente en el sistema GXALMAC (máx. 8 dígitos).', 'conectab2b' ); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="is_gxalmac_linked"><?php esc_html_e( 'Cliente vinculado a GXALMAC', 'conectab2b' ); ?></label></th>
            <td>
                <input type="checkbox" name="is_gxalmac_linked" id="is_gxalmac_linked" value="1" <?php checked( $is_gxalmac_linked, 1 ); ?> />
                <span class="description"><?php esc_html_e( 'Marca esta opción si el cliente está vinculado a GXALMAC.', 'conectab2b' ); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'conb2b_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'conb2b_extra_user_profile_fields' );

/**
 * Guardar los campos personalizados de la ficha de usuario.
 */
function conb2b_save_extra_user_profile_fields( $user_id ) {
    // Verificar permisos
    if ( ! current_user_can( 'manage_options', $user_id ) ) {
        return false;
    }

    // Guardar el número de cliente de GXALMAC
    update_user_meta( $user_id, 'gxalmac_number', sanitize_text_field( $_POST['gxalmac_number'] ) );

    // Guardar el estado del checkbox
    $is_gxalmac_linked = isset( $_POST['is_gxalmac_linked'] ) ? 1 : 0;
    update_user_meta( $user_id, 'is_gxalmac_linked', $is_gxalmac_linked );
}
add_action( 'personal_options_update', 'conb2b_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'conb2b_save_extra_user_profile_fields' );
