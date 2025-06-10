<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container mt-5 mb-5">
    <div class="terminos-container bg-dark p-4 rounded shadow-lg">
        <div class="text-center mb-5">
            <h1 class="display-4 text-info mb-3">Términos y Condiciones</h1>
            <div class="separator-line mx-auto mb-4"></div>
            <p class="lead">Bienvenido a <strong class="text-info">GL Technology</strong>. Al acceder a este sitio web y utilizar nuestros servicios, aceptás los siguientes términos y condiciones. Te recomendamos leerlos detenidamente antes de realizar cualquier operación.</p>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="accordion" id="terminosAccordion">
                    <!-- Sección 1 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button bg-dark text-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                <i class="fas fa-info-circle me-2"></i> 1. Información General
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>GL Technology es una tienda online dedicada a la venta de componentes y periféricos de computadoras. Nuestro objetivo es brindar a nuestros clientes una experiencia segura, transparente y satisfactoria en todo el proceso de compra.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                <i class="fas fa-laptop me-2"></i> 2. Uso del Sitio
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>El uso de este sitio web implica la aceptación de los presentes términos. GL Technology se reserva el derecho de modificar estos términos en cualquier momento sin previo aviso. Es responsabilidad del usuario consultar periódicamente esta sección.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                <i class="fas fa-shield-alt me-2"></i> 3. Políticas de Privacidad
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Toda la información personal brindada por el usuario será tratada con estricta confidencialidad. Los datos se utilizan únicamente para procesar pedidos, emitir facturas y brindar soporte al cliente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                <i class="fas fa-box-open me-2"></i> 4. Disponibilidad de Productos
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Los productos publicados están sujetos a disponibilidad de stock. En caso de no contar con disponibilidad inmediata, nos pondremos en contacto para ofrecer una solución alternativa o realizar el reintegro correspondiente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 5 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                <i class="fas fa-tag me-2"></i> 5. Precios
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Todos los precios están expresados en pesos argentinos e incluyen IVA. GL Technology se reserva el derecho de modificar los precios sin previo aviso, respetando siempre los valores pactados en compras ya confirmadas.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 6 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                <i class="fas fa-certificate me-2"></i> 6. Garantías
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Todos los productos comercializados cuentan con garantía oficial del fabricante, cuya duración puede variar dependiendo del tipo de producto. El cliente deberá contactarnos para iniciar el proceso correspondiente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 7 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                <i class="fas fa-headset me-2"></i> 7. Soporte Postventa
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Brindamos soporte técnico y atención postventa a través de nuestros canales de contacto. Nos comprometemos a responder de forma oportuna y eficiente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 8 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                <i class="fas fa-truck me-2"></i> 8. Formas de Entrega
                            </button>
                        </h2>
                        <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Realizamos envíos a todo el país mediante empresas de logística reconocidas. También ofrecemos retiro en punto de entrega si estuviera disponible. Los tiempos de entrega serán informados durante la compra.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 9 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                <i class="fas fa-credit-card me-2"></i> 9. Formas de Pago
                            </button>
                        </h2>
                        <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Aceptamos tarjetas de crédito, débito, transferencias y otros medios electrónicos habilitados. El despacho se realiza una vez confirmado el pago.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 10 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                <i class="fas fa-undo me-2"></i> 10. Devoluciones
                            </button>
                        </h2>
                        <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>Se aceptan devoluciones dentro de los primeros 10 días desde la recepción del producto, siempre que se encuentre en su estado original. En caso de producto defectuoso, GL Technology asumirá los costos de envío.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 11 -->
                    <div class="accordion-item bg-dark border-info mb-3">
                        <h2 class="accordion-header" id="heading11">
                            <button class="accordion-button bg-dark text-info collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                <i class="fas fa-copyright me-2"></i> 11. Propiedad Intelectual
                            </button>
                        </h2>
                        <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#terminosAccordion">
                            <div class="accordion-body">
                                <p>El contenido de este sitio (textos, imágenes, código, etc.) es propiedad de GL Technology o de sus respectivos propietarios y está protegido por leyes de propiedad intelectual.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="<?= base_url() ?>" class="btn btn-outline-info"><i class="fas fa-home me-2"></i>Volver al inicio</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
