<?php
// Verificar que el archivo no se acceda directamente
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Nombre del plugin: ConectaB2b
 * Versión file: 0.6
 * Versión del plugin: 0.1
 * Date last mod: HH:MM - DD-MM-2024
 */

function facturas_content() {
    if ( current_user_can( get_option( 'conb2b_role', 'administrator' ) ) ) {
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';
        echo '<h3>' . __( 'Facturas', 'conectab2b' ) . '</h3>';
        echo '<p>' . __( 'Aquí podrás ver y descargar tus facturas.', 'conectab2b' ) . '</p>';

        // Incluir el CSS externo
        echo '<link rel="stylesheet" type="text/css" href="' . esc_url(plugins_url('/assets/css/endpoints.css', __FILE__)) . '">';

        // Aquí se añade el formulario según las especificaciones
        ?>
        <form id="facturas-filter-form" method="post" action="">
            <!-- Bloque 1: Fechas -->
            <div class="form-row">
                <div class="form-group">
                    <label for="factura_fecha_inicio"><?php esc_html_e( 'Fecha inicio', 'conectab2b' ); ?></label>
                    <input type="text" id="factura_fecha_inicio" name="factura_fecha_inicio" value="<?php echo date('d/m/Y'); ?>" placeholder="dd/mm/aaaa" />
                </div>
                <div class="form-group">
                    <label for="factura_fecha_fin"><?php esc_html_e( 'Fecha fin', 'conectab2b' ); ?></label>
                    <input type="text" id="factura_fecha_fin" name="factura_fecha_fin" value="<?php echo '01/01/' . date('Y'); ?>" placeholder="dd/mm/aaaa" />
                </div>
                <div class="form-group">
                    <label for="factura_estado"><?php esc_html_e( 'Estado', 'conectab2b' ); ?></label>
                    <select id="factura_estado" name="factura_estado">
                        <option value="todas"><?php esc_html_e( 'Todas', 'conectab2b' ); ?></option>
                        <option value="pagadas"><?php esc_html_e( 'Pagadas', 'conectab2b' ); ?></option>
                        <option value="pendientes"><?php esc_html_e( 'Pendientes', 'conectab2b' ); ?></option>
                    </select>
                </div>
            </div>

            <!-- Bloque 2: Facturas -->
            <div class="form-row">
                <div class="form-group">
                    <label for="factura_numero_desde"><?php esc_html_e( 'Número de Factura Desde', 'conectab2b' ); ?></label>
                    <input type="number" id="factura_numero_desde" name="factura_numero_desde" value="0" min="0" max="9999999" />
                </div>
                <div class="form-group">
                    <label for="factura_numero_hasta"><?php esc_html_e( 'Número de Factura Hasta', 'conectab2b' ); ?></label>
                    <input type="number" id="factura_numero_hasta" name="factura_numero_hasta" value="9999999" min="0" max="9999999" />
                </div>
            </div>

            <!-- Bloque 3: Obra -->
            <div class="form-row">
                <div class="form-group">
                    <label for="factura_obra"><?php esc_html_e( 'Obra', 'conectab2b' ); ?></label>
                    <select id="factura_obra" name="factura_obra">
                        <option value="todas"><?php esc_html_e( 'Todas', 'conectab2b' ); ?></option>
                        <option value="sin_obra"><?php esc_html_e( 'Sin obra', 'conectab2b' ); ?></option>
                        <option value="obra_1"><?php esc_html_e( 'Obra 1', 'conectab2b' ); ?></option>
                        <option value="obra_2"><?php esc_html_e( 'Obra 2', 'conectab2b' ); ?></option>
                    </select>
                </div>
            </div>

            <!-- Bloque 4: Botones -->
            <div class="form-row">
                <button type="button" name="actualizar" class="button-primary"><?php esc_html_e( 'Actualizar', 'conectab2b' ); ?></button>
                <button type="submit" name="descargar_excel" class="button-secondary"><?php esc_html_e( 'Descargar Excel', 'conectab2b' ); ?></button>
            </div>
        </form>

        <!-- Tabla para mostrar facturas -->
        <div class="table-container">
            <table id="facturas-table" class="table-container">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th></th>
                        <th></th>
                        <th>FACT.</th>
                        <th>FECHA</th>
                        <th>OBRA</th>
                        <th>TOTAL</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se llenarán las filas dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Botones al final de la tabla -->
        <div class="form-row">
            <button type="button" class="button-print">IMPRIMIR SELECCIONADOS</button>
            <button type="button" class="button-send">ENVIAR POR EMAIL</button>
        </div>

        <!-- Paginación -->
        <div id="pagination" class="pagination">
            <!-- Aquí se generará la paginación -->
        </div>

        <?php
        
        // Botón para probar la conexión con MockAPI
        echo '<div class="form-group">';
        echo '<button id="test-magicloops" class="button-primary" style="background-color: green; color: white;">';
        echo 'PROBAR JSON API';
        echo '</button>';
        echo '</div>';
        
        // Div para mostrar la respuesta de la API
        echo '<div id="mockapi-response"></div>';
        
        // Incluir Pikaday solo en esta página
        echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">';
        echo '<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>';
        
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

