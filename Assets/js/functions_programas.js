let tableProgramas; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
    tableProgramas = $('#tableProgramas').dataTable( {
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "./es.json"

        },
        "ajax":{
            "url": base_url + "/Programas/getProgramas",
            "dataSrc": ""

        },
        "columns": [
            {"data": "ideprograma"},
            {"data": "codigoprograma"},
            {"data": "nivelprograma"},
            {"data": "nombreprograma"},
            {"data": "horasprograma"},
            {"data": "status"},
            {"data": "options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-warning margen-btn"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success margen-btn"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger margen-btn"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info margen-btn"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    if (document.querySelector("#formPrograma")) {
        let formPrograma = document.querySelector("#formPrograma");
        formPrograma.onsubmit = function(e) {
            e.preventDefault();
            let intIdePrograma = document.querySelector('#idePrograma').value;
            let intCodigoPrograma = document.querySelector('#txtCodigoPrograma').value;
            let strNivelPrograma = document.querySelector('#txtNivelPrograma').value;
            let strNombrePrograma = document.querySelector('#txtNombrePrograma').value;
            let strHorasPrograma = document.querySelector('#txtHorasPrograma').value;
            let intStatus = document.querySelector('#listStatus').value;

          
            if (intCodigoPrograma == '' || strNivelPrograma == '' || strNombrePrograma == '' || strHorasPrograma == '') 
            {
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
                    if (objData.status)
                    {
                            if (rowTable == "") {
                            tableProgramas.ajax.reload();
                            } else {
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge text-bg-success">Activo</span>' : 
                            '<span class="badge text-bg-danger">Inactivo</span>';
                            tableUsuarios.api().ajax.reload();
                            rowTable.cells[1].textContent =  strIdePrograma;
                            rowTable.cells[2].textContent = document.querySelector("#txtRolUsuario").selectedOptions[0].text;
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

// window.addEventListener('load', function() {
//     fntRolesUsuario();
// }, false);

// function fntRolesUsuario() {
//     if (document.querySelector('#txtRolUsuario')) {
//         let ajaxUrl = base_url + '/Roles/getSelectRoles';
//         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//         request.open("GET", ajaxUrl, true);
//         request.send();
//         request.onreadystatechange = function() {
//             if (request.readyState == 4 && request.status == 200) {
//                 document.querySelector('#txtRolUsuario').innerHTML = request.responseText;
//                 $('.txtRolUsuario').selectpicker('refresh');
//             }
//         }
//     }
// }

function fntViewInfo(idePrograma) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Programas/getPrograma/' + idePrograma;
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
                document.querySelector("#celCodigoPrograma").innerHTML = objData.data.codigoprograma;
                document.querySelector("#celNivelPrograma").innerHTML = objData.data.nivelprograma;
                document.querySelector("#celNombrePrograma").innerHTML = objData.data.nombreprograma;
                document.querySelector("#celHorasPrograma").innerHTML = objData.data.horasprograma;
                document.querySelector("#celEstadoPrograma").innerHTML = estadoPrograma;

                $('#modalViewPrograma').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditInfo(element, idePrograma) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Programa";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Programas/getPrograma/' + idePrograma;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idePrograma").value = objData.data.ideprograma;
                document.querySelector("#txtCodigoPrograma").value = objData.data.codigoprograma;
                document.querySelector("#txtNivelPrograma").value = objData.data.nivelprograma;
                document.querySelector("#txtNombrePrograma").value = objData.data.nombreprograma;
                document.querySelector("#txtHorasPrograma").value = objData.data.horasprograma;

                // ESTADO ACTIVO O INACTIVO
                document.querySelector("#listStatus").value = objData.data.status == 1 ? 1 : 2;
            }
        }
        $('#modalFormPrograma').modal('show');
    }
}

function fntDelInfo(idePrograma) {
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
            let strData = "idePrograma=" + idePrograma;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        tableProgramas.ajax.reload();
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
