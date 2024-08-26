<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function facturas_content() {
    // Verificamos si el usuario tiene el rol permitido
    if ( current_user_can( get_option( 'conb2b_role', 'administrator' ) ) ) {
        ?>
        <div class="facturas-wrapper">
            <h3><?php esc_html_e( 'Tus Facturas', 'conectab2b' ); ?></h3>
            <p><?php esc_html_e( 'Aquí podrás ver y descargar tus facturas.', 'conectab2b' ); ?></p>

            <form id="facturas-filter-form" method="post" action="">
                <!-- Primera fila: Fechas y Estado -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="factura_fecha_desde"><?php esc_html_e( 'Fecha Desde', 'conectab2b' ); ?></label>
                        <input type="date" id="factura_fecha_desde" name="factura_fecha_desde" value="<?php echo esc_attr(date('Y-m-01')); ?>" />
                    </div>
                    <div class="form-group">
                        <label for="factura_fecha_hasta"><?php esc_html_e( 'Fecha Hasta', 'conectab2b' ); ?></label>
                        <input type="date" id="factura_fecha_hastag" name="factura_fecha_hasta" value="<?php echo esc_attr(date('Y-m-d')); ?>" />
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

                <!-- Segunda fila: Número de Factura -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="factura_numero_desde"><?php esc_html_e( 'Número de Factura Desde', 'conectab2b' ); ?></label>
                        <input type="number" id="factura_numero_desde" name="factura_numero_desde" min="0" max="999999" />
                    </div>
                    <div class="form-group">
                        <label for="factura_numero_hasta"><?php esc_html_e( 'Número de Factura Hasta', 'conectab2b' ); ?></label>
                        <input type="number" id="factura_numero_hasta" name="factura_numero_hasta" min="0" max="999999" />
                    </div>
                </div>

                <!-- Tercera fila: Obras -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="factura_obra"><?php esc_html_e( 'Obra', 'conectab2b' ); ?></label>
                        <select id="factura_obra" name="factura_obra">
                            <option value="todas"><?php esc_html_e( 'Todas', 'conectab2b' ); ?></option>
                            <!-- Opciones de obra serán añadidas dinámicamente más adelante -->
                        </select>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="form-row">
                    <button type="button" name="actualizar" class="button-primary"><?php esc_html_e( 'Actualizar', 'conectab2b' ); ?></button>
                    <button type="submit" name="descargar_excel" class="button-secondary"><?php esc_html_e( 'Descargar Excel', 'conectab2b' ); ?></button>
                </div>
            </form>

            <!-- Tabla de Facturas -->
            <div id="facturas-table-wrapper" style="display:none;">
                <table class="facturas-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all" /></th>
                            <th><?php esc_html_e( 'Factura', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( 'Fecha', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( 'Obra', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( 'Nombre', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( 'Total', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( 'Venc. Pend.', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( 'DESC', 'conectab2b' ); ?></th>
                            <th><?php esc_html_e( '@', 'conectab2b' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ( $i = 0; $i < 15; $i++ ) : ?>
                            <tr>
                                <td><input type="checkbox" name="select_factura[]" /></td>
                                <td><?php echo mt_rand(9000, 200000); ?></td>
                                <td><?php echo date('d/m/Y', mt_rand(strtotime('2024-01-01'), strtotime('2024-08-28'))); ?></td>
                                <td><?php esc_html_e( 'SIN OBRA', 'conectab2b' ); ?></td>
                                <td><?php esc_html_e( 'Rafael Velasco', 'conectab2b' ); ?></td>
                                <td><?php echo number_format(mt_rand(100000, 99999999) / 100, 2, ',', '.') . '€'; ?></td>
                                <td><?php esc_html_e( 'Sin vencimientos', 'conectab2b' ); ?></td>
                                <td><a href="#"><?php esc_html_e( 'Desc', 'conectab2b' ); ?></a></td>
                                <td><a href="#"><?php esc_html_e( 'Email', 'conectab2b' ); ?></a></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botones después de la tabla -->
            <div id="facturas-action-buttons" style="display:none;">
                <button type="button" class="button-primary"><?php esc_html_e( 'Descargar Facturas', 'conectab2b' ); ?></button>
                <button type="button" class="button-secondary"><?php esc_html_e( 'Mandar por Email', 'conectab2b' ); ?></button>
            </div>
        </div>
        <?php
    } else {
        echo '<p>' . esc_html__( 'No tienes permisos para acceder a esta sección.', 'conectab2b' ) . '</p>';
    }
}
add_action( 'woocommerce_account_facturas_endpoint', 'facturas_content' );
