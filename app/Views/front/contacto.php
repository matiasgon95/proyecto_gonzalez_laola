<?php echo $this->extend('front/layouts'); ?>

<?= $this->section('contenedor'); ?>

<h1>Contacto</h1>
<form action="" class='container mt-5 mb-5'>
    <div class="container">
            <div class=" text-center mt-5 ">
                <h3>¿Tienes preguntas sobre nuestros productos o necesitas ayuda con tu compra? ¡Estamos aquí para  ayudarte!</h3>
            </div>
        <div class="row ">
          <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_name">Nombre</label>
                                <input id="form_name" type="text" name="nombre" class="form-control"  required="required"  data-error="Nombre es requerido.">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_lastname">Apellido</label>
                                <input id="form_lastname" type="text" name="apellido" class="form-control"   required="required"    data-error="Apellido es requerido.">
                                                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_email">Email</label>
                                <input id="form_email" type="email" name="email" class="form-control"   required="required" data-error="Un Email válido es requerido.">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_need">Asunto</label>
                                <input id="form_need" type="asunto" name="asunto" class="form-control"   required="required" data-error="Asunto requerido.">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_message">Consulta</label>
                                <textarea id="form_message" name="consulta" class="form-control" placeholder="Escriba su consulta aquí..." rows="4" required="required" data-error="Por favor, escriba su consulta."></textarea>
                                </div>
                            </div>


                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Enviar Consulta" style='margin-top: 10px'>
                    </div>
                    </div>
            </div>
            </div>
                </div>
        </div>
        </div>
    </div>
    </div>
</form>

<?= $this->endSection(); ?>
