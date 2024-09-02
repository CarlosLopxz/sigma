<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Programas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
</head>

<body>

    <!-- Table for Programs -->
    <div class="container mt-4">
        <button class="btn btn-primary" onclick="openModal()">Nuevo Programa</button>
        <table id="tableProgramas" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nivel</th>
                    <th>Nombre</th>
                    <th>Horas</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal for Create/Update Program -->
    <div class="modal fade" id="modalFormPrograma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="titleModal">Nuevo Programa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPrograma" name="formPrograma" enctype="multipart/form-data" method="POST">
                        <input type="hidden" id="idePrograma" name="idePrograma" value="">
                        <div class="modal-body">
                            <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                            <hr>
                            <p class="text-primary">Datos del Programa</p>
                        </div>
                        <div class="modal-body">
                            <label for="txtCodigoPrograma">Código<span class="required">*</span></label>
                            <input type="text" class="form-control valid validText" id="txtCodigoPrograma" name="txtCodigoPrograma" required="" maxlength="30" onkeypress="return controlTag(event);">
                        </div>
                        <div class="modal-body">
                            <label for="txtNivelPrograma">Nivel<span class="required">*</span></label>
                            <input type="text" class="form-control valid validText" id="txtNivelPrograma" name="txtNivelPrograma" required="" maxlength="30" onkeypress="return controlTag(event);">
                        </div>
                        <div class="modal-body">
                            <label for="txtNombrePrograma">Nombre<span class="required">*</span></label>
                            <input type="text" class="form-control valid validText" id="txtNombrePrograma" name="txtNombrePrograma" required="" maxlength="30" onkeypress="return controlTag(event);">
                        </div>
                        <div class="modal-body">
                            <label for="txtHorasPrograma">Horas<span class="required">*</span></label>
                            <input type="text" class="form-control valid validNumber" id="txtHorasPrograma" name="txtHorasPrograma" required="" maxlength="5" onkeypress="return controlTag(event);">
                        </div>
                        <div class="modal-body">
                            <label for="listStatus">Estado</label>
                            <select class="form-select selectpicker" data-style="btn-success" id="listStatus" name="listStatus" required>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button id="btnActionForm" class="btn btn-success" type="submit"><i class="bi bi-send"></i><span id="btnText">Guardar</span></button>
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for View Program Details -->
    <div class="modal fade" id="modalViewPrograma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header header-primary">
                    <h5 class="modal-title" id="titleModal">Datos del Programa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <td>Código:</td>
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
                                        <td id="celEstadoPrograma">Activo</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal"><i class="bi bi-check2"></i>Listo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
