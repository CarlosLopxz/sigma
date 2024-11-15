<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUsuario"" name=" formUsuario"" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideUsuario"" name=" ideUsuario"" value="">
                            <div class="modal-body">
                                <p class="requerido">Los campos con asterisco (<span class="requerido">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="requerido">Datos del Usuario</p>
                            </div>

                            <div class="modal-body">
                                <label for="txtIdentificacionUsuario"">Identificación<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtIdentificacionUsuario"
                                    name="txtIdentificacionUsuario" required="" maxlength="10"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtNombresUsuario"">Nombres<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtNombresUsuario"
                                    name="txtNombresUsuario" required="" maxlength="30"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtApellidosUsuario"">Apellidos<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtApellidosUsuario"
                                    name="txtApellidosUsuario" required="" maxlength="30"
                                    onkeypress="return controlTag(event);">
                            </div>


                            <div class="modal-body">
                                <label for="txtCorreoUsuario"">Correo Electronico<span class="
                                    requerido">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtCorreoUsuario"
                                    name="txtCorreoUsuario" required="" maxlength="30"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body mb-1">
                                <label for="txtRolUsuario">Selecciona el Rol</label>
                                <select class="form-control selectpicker" id="txtRolUsuario" name="txtRolUsuario">
                                </select>
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
<div class="modal fade" id="modalViewUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
                
            </div>

            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">


                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td id="celIdeUsuario">233104</td>
                                </tr>
                                <tr>
                                    <td>Identificación:</td>
                                    <td id="celIdentificacionUsuario">233104</td>
                                </tr>
                                <tr>
                                    <td>Nombres:</td>
                                    <td id="celNombresUsuario">233104</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td id="celApellidosUsuario">233104</td>
                                </tr>

                                <tr>
                                    <td>Correo Electronico:</td>
                                    <td id="celCorreoUsuario">233104</td>
                                </tr>
                                <tr>
                                    <td>Rol:</td>
                                    <td id="celRolUsuario">2875079</td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="celEstadoUsuario">Programación de Software</td>
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