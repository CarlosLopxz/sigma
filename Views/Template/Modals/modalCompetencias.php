<!-- Modal para agregar/editar Competencia -->
<div class="modal fade" id="modalFormCompetencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Competencia</h5>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formCompetencia" name="formCompetencia" enctype="multipart/form-data" method="POST" novalidate>
                            <input type="hidden" id="ideCompetencia" name="ideCompetencia" value="">

                            <div class="modal-body">
                                <p class="requerido">Los campos con asterisco (<span class="requerido">*</span>) son obligatorios.</p>
                                <hr>
                                <p class="requerido">Datos de la Competencia</p>
                            </div>

                            <div class="modal-body">
                                <label for="txtCodigoCompetencia">Código de la Competencia <span class="requerido">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtCodigoCompetencia" name="txtCodigoCompetencia" required maxlength="10" onkeypress="return controlTag(event);">
                                <div class="invalid-feedback">Por favor, ingrese un código válido.</div>
                            </div>

                            <div class="modal-body">
                                <label for="txtNombreCompetencia">Nombre de la Competencia <span class="requerido">*</span></label>
                                <input type="text" class="form-control validText" id="txtNombreCompetencia" name="txtNombreCompetencia" required>
                                <div class="invalid-feedback">Por favor, ingrese un nombre válido.</div>
                            </div>

                            <div class="modal-body">
                                <label for="txtHorasCompetencia">Horas de la Competencia <span class="requerido">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtHorasCompetencia" name="txtHorasCompetencia" required maxlength="10" onkeypress="return controlTag(event);">
                                <div class="invalid-feedback">Por favor, ingrese las horas válidas.</div>
                            </div>

                            <div class="modal-body">
                                <label for="txtCodigoPrograma">Código del Programa <span class="requerido">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtCodigoPrograma" onchange="fntViewInfoCodigoPrograma(this.value);" name="txtCodigoPrograma" required maxlength="10" onkeypress="return controlTag(event);">
                                <div class="invalid-feedback">Por favor, ingrese un código de programa válido.</div>
                            </div>

                            <div class="modal-body">
                                <label for="txtNombrePrograma">Nombre del Programa <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtNombrePrograma" name="txtNombrePrograma" required disabled>
                                <div class="invalid-feedback">Por favor, ingrese el nombre del programa.</div>
                            </div>

                            <br>
                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit">
                                    <i class="bi bi-send-fill"></i><span id="btnText">Guardar</span>
                                </button>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg"></i>Cerrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de Competencia -->
<div class="modal fade" id="modalViewCompetencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la Competencia</h5>
            </div>

            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Código:</td>
                                    <td id="celCodigoCompetencia">233104</td>
                                </tr>

                                <tr>
                                    <td>Nombre Competencia:</td>
                                    <td id="celNombreCompetencia">Programación de Software</td>
                                </tr>

                                <tr>
                                    <td>Horas de la Competencia:</td>
                                    <td id="celHorasCompetencia">Horas Competencia</td>
                                </tr>

                                <tr>
                                    <td>Programa:</td>
                                    <td id="celCodigoPrograma">2875079</td>
                                </tr>
                                <tr>
                                    <td>Programa:</td>
                                    <td id="celNombrePrograma">2875079</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                            <i class="bi bi-check2"></i>Listo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('formCompetencia').addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();
    if (!this.checkValidity()) {
        this.classList.add('was-validated');
    } else {
        // Si el formulario es válido, se puede proceder con el envío o alguna otra acción.
        this.submit();
    }
}, false);
</script>
