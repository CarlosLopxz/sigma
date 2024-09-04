<!-- Modal -->
<div class="modal fade" id="modalFormPrograma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Programa</h5>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formPrograma"" name=" formPrograma"" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="idePrograma"" name=" idePrograma"" value="">
                            <div class="modal-body">
                                <p class="requerido">Los campos con asterisco (<span class="requerido">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="requerido">Datos del Programa</p>
                            </div>

                            <div class="modal-body">
                                <label for="txtCodigoPrograma"">Codigo<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtCodigoPrograma"
                                    name="txtCodigoPrograma" required="" maxlength="10"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtNivelPrograma"">Nivel<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtNivelPrograma"
                                    name="txtNivelPrograma" required="" maxlength="10"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtNombrePrograma"">Nombre del Programa<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtNombrePrograma"
                                    name="txtNombrePrograma" required="" maxlength="30"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtHorasPrograma"">Horas Programas<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtHorasPrograma"
                                    name="txtHorasPrograma" required="" maxlength="30"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="listStatus">Estado</label>
                                <select class="form-select selectpicker" data-style="btn-success" id="listStatus"
                                    name="listStatus" required>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit"><i
                                        class="bi bi-send-fill"></i><span id="btnText">Guardar</span></button>

                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i
                                        class="bi bi-x-lg"></i>Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewPrograma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Programa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">


                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td id="celIdePrograma">233104</td>
                                </tr>
                                <tr>
                                    <td>Codigo:</td>
                                    <td id="celCodigoPrograma">233104</td>
                                </tr>
                                <tr>
                                    <td>Nivel:</td>
                                    <td id="celNivelPrograma">233104</td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td id="celNombrePrograma">233104</td>
                                </tr>
                                <tr>
                                    <td>Horas:</td>
                                    <td id="celHorasPrograma">233104</td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="celEstadoPrograma">Programación de Software</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"><i
                                class="bi bi-check2"></i>Listo</button>
                    </div>

                </div>
            </div>
        </div>