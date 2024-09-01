let tableProgramas; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function() {

    tableProgramas = $('#tableProgramas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "./es.json"
        },
        "ajax": {
            "url": base_url + "/Programas/getProgramas",
            "dataSrc": ""
        },
        "columns": [
            {"data": "ideprograma"}, // el nombre en la tabla de dashboard 
            {"data": "identificacion"},
            {"data": "nombres"},
            {"data": "nombrerol"},
            {"data": "status"},
            {"data": "options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-warning btn-custom-margin"
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success btn-custom-margin"
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger btn-custom-margin"
            }, {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Exportar a CSV",
                "className": "btn btn-info btn-custom-margin"
            }
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    if (document.querySelector("#formPrograma")) {
        let formPrograma = document.querySelector("#formPrograma");
        formPrograma.onsubmit = function(e) {
            e.preventDefault();
            var intIdePrograma = document.querySelector('#idePrograma').value;
            let strIdentificacionPrograma = document.querySelector('#txtIdentificacionPrograma').value;
            let strnombresprograma = document.querySelector('#txtnombresprograma').value;
            let strRolPrograma = document.querySelector('#txtRolPrograma').value;
            let intStatus = document.querySelector('#listStatus').value;

            if (strIdentificacionPrograma == '' || strnombresprograma == '' || strRolPrograma == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    swal("Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Programas/setPrograma';
            let formData = new FormData(formPrograma);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        if (rowTable == "") {
                            tableProgramas.api().ajax.reload();
                        } else {
                            htmlStatus = intStatus == 1 ?
                                '<span class="badge text-bg-success">Activo</span>' :
                                '<span class="badge text-bg-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strIdentificacionPrograma;
                            rowTable.cells[2].textContent = document.querySelector("#txtRolPrograma").selectedOptions[0].text;
                            rowTable.cells[3].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                        $('#modalFormPrograma').modal("hide");
                        formPrograma.reset();
                        swal("Programa", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

}, false);

window.addEventListener('load', function() {
    fntRolesPrograma();
}, false);

function fntRolesPrograma() {
    if (document.querySelector('#txtRolPrograma')) {
        let ajaxUrl = base_url + '/Roles/getSelectRoles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#txtRolPrograma').innerHTML = request.responseText;
                $('.txtRolPrograma').selectpicker('refresh');
            }
        }
    }
}

function fntViewInfo(ideprograma) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Programas/getPrograma/' + ideprograma;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {

                let estadoPrograma = objData.data.status == 1 ?
                    '<span class="badge text-bg-success">Activo</span>' :
                    '<span class="badge text-bg-danger">Inactivo</span>';

                document.querySelector("#celIdePrograma").innerHTML = objData.data.ideprograma;
                document.querySelector("#celIdentificacionPrograma").innerHTML = objData.data.identificacion;
                document.querySelector("#celRolPrograma").innerHTML = objData.data.rolid;
                document.querySelector("#celEstadoPrograma").innerHTML = estadoPrograma;

                $('#modalViewPrograma').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditInfo(element, ideprograma) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Programa";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Programas/getPrograma/' + ideprograma;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {

        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idePrograma").value = objData.data.ideprograma;
                document.querySelector("#txtIdentificacionPrograma").value = objData.data.identificacion;
                document.querySelector("#txtRolPrograma").value = objData.data.idrol;

                // ESTADO ACTIVO O INACTIVO
                if (objData.data.status == 1) {
                    document.querySelector("#listStatus").value = 1;
                } else {
                    document.querySelector("#listStatus").value = 2;
                }

            }
        }
        $('#modalFormPrograma').modal('show');
    }
}

function fntDelInfo(ideprograma) {
    swal({
        title: "Eliminar Programa",
        text: "¿Realmente quiere eliminar el Programa?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {

        if (isConfirm) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Programas/delPrograma';
            let strData = "idePrograma=" + ideprograma;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        tableProgramas.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }

    });

}

function openModal() {
    rowTable = "";
    document.querySelector('#idePrograma').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Programa";
    document.querySelector("#formPrograma").reset();
    $('#modalFormPrograma').modal('show');
}
