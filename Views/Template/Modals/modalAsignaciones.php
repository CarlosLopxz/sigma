<!-- Modal -->
<div class="modal fade" id="modalFormAsignacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Asignación</h5>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formAsignacion" name="formAsignacion" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideDetalleFicha" name="ideDetalleFicha" value="">
                            <div class="modal-body">
                                <p class="requerido">Los campos con asterisco (<span class="requerido">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="requerido">Datos de la Asignación</p>
                            </div>


                            <div class="modal-body">
                                <label for="txtNumeroFicha">Número de Ficha<span class="requerido">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtNumeroFicha"
                                    name="txtNumeroFicha" 
                                    onchange="fntViewInfoIdeFicha(this.value);" required=""
                                    maxlength="10" onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdeFicha">Nombre de la FICHA <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtIdeFicha" name="txtIdeFicha"
                                    required="" disabled>
                            </div>



                            <div class="modal-body">
                                <label for="txtCodigoCompetencia">ID de la COMPETENCIA<span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtCodigoCompetencia"
                                    onchange="fntViewInfoCodigoCompetencia(this.value);" name="txtCodigoCompetencia"
                                    required="" maxlength="10" onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdeCompetencia">Nombre de la COMPETENCIA<span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtIdeCompetencia"
                                    name="txtIdeCompetencia" required="" disabled>
                            </div>

                            <div class="modal-body">
                                <label for="txtHorasTotalCompetencia">HORAS TOTAL de la COMPETENCIA<span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtHorasTotalCompetencia"
                                    name="txtHorasTotalCompetencia" required="" disabled>
                            </div>

                            <div class="modal-body">
                                <label for="txtHorasSumaAsignacionCompetencia">HORAS total ASIGNADAS de la
                                    COMPETENCIA<span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtHorasSumaAsignacionCompetencia"
                                    name="txtHorasSumaAsignacionCompetencia" required="" disabled>
                            </div>

                            <div class="modal-body">
                                <label for="txtHorasPendienteCompetencia">HORAS PENDIENTE de la COMPETENCIA<span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtHorasPendienteCompetencia"
                                    name="txtHorasPendienteCompetencia" required="" disabled>
                                <!-- Mensaje de salida -->
                                <p id="mensaje"></p>
                            </div>


                            <div class="modal-body">
                                <label for="txtNumeroHoras">Cantidad de horas a ASIGNAR<span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtNumeroHoras"
                                    onchange="ftnSumarCantidadHoras(this.value);" name="txtNumeroHoras" required="">
                                <p id="mensajeError" style="color: red;"></p>
                            </div>

                            <div class="modal-body">
                                <select class="form-select" id="listadoMeses" name="listadoMeses" required=""
                                    aria-label="Default select example">
                                    <label for="listadoMeses">Selecciona el mes</label>
                                    <option value="Enero">Enero</option>
                                    <option value="Febrero">Febrero</option>
                                    <option value="Marzo">Marzo</option>
                                    <option value="Abril">Abril</option>
                                    <option value="Mayo">Mayo</option>
                                    <option value="Junio">Junio</option>
                                    <option value="Julio">Julio</option>
                                    <option value="Agosto">Agosto</option>
                                    <option value="Septiembre">Septiembre</option>
                                    <option value="Octubre">Octubre</option>
                                    <option value="Noviembre">Noviembre</option>
                                    <option value="Diciembre">Diciembre</option>
                                </select>
                            </div>

                            <!-- <div class="modal-body">
                                <label for="txtNombreCompetencia">Nombre del COMPETENCIA <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control" id="txtNombreCompetencia"
                                    name="txtNombreCompetencia" required="" disabled>
                            </div> -->

                            <div class="modal-body">
                                <label for="txtIdeInstructor">Identificación del Instructor<span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtIdeInstructor"
                                    onchange="fntViewInfoIdeInstructor(this.value);" name="txtIdeInstructor" required=""
                                    maxlength="10" onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdeUsuario">Nombre del INSTRUCTOR <span
                                        class="requerido">*</span></label>
                                <input type="text" class="form-control" id="txtIdeUsuario"
                                    name="txtIdeUsuario" required="" disabled>
                            </div>

                            <BR></BR>
                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit"><i
                                        class="bi bi-floppy"></i><span id="btnText">Guardar</span></button>

                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal" id="cerrarModal"><i
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
<div class="modal fade" id="modalViewAsignacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">atos de la Asignación de la competencia</h5>
            </div>

            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">


                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Número de Ficha:</td>
                                    <td id="celFicha">233104</td>
                                </tr>
                                <tr>
                                    <td>Instructor:</td>
                                    <td id="celInstructor">233104</td>
                                </tr>

                                <tr>
                                    <td>Competencia:</td>
                                    <td id="celCompetencia">Programación de Software</td>
                                </tr>

                                <tr>
                                    <td>Horas Asignadas:</td>
                                    <td id="celHoras">Horas</td>
                                </tr>

                                <tr>
                                    <td>Mes de Asignación:</td>
                                    <td id="celMes">2875079</td>
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