let tableUsuarios; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"ideusuario"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"correo"},
            {"data":"nombrerol"},
            {"data":"status"},
            {"data":"options"}

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='bi bi-files fs-5 mb-2'></i>",
                "titleAttr":"Copiar",
                "className": "btn btn-warning mt-3"
            },{
                "extend": "excelHtml5",
                "text": "<i class='bi bi-filetype-exe fs-5 mb-2'></i>",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success mt-3"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-filetype-pdf fs-5 mb-2'></i>",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger mt-3"
            },{
                "extend": "csvHtml5",
                "text": "<i class='bi bi-filetype-csv fs-5 mb-2'></i>",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info mt-3"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });



	if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
            var intIdeUsuario = document.querySelector('#ideUsuario').value;
            let strIdentificacionUsuario = document.querySelector('#txtIdentificacionUsuario').value;
            let strNombresUsuario = document.querySelector('#txtNombresUsuario').value;
            let strApellidosUsuario = document.querySelector('#txtApellidosUsuario').value;
            let strCorreoUsuario = document.querySelector('#txtCorreoUsuario').value;
            let strRolUsuario = document.querySelector('#txtRolUsuario').value;
            let intStatus = document.querySelector('#listStatus').value;

            if(strIdentificacionUsuario == '' || strNombresUsuario == '' || strApellidosUsuario == '' || strCorreoUsuario == '' || strRolUsuario == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableUsuarios.api().ajax.reload();
                            
                        }else{
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge text-bg-success">Activo</span>' : 
                            '<span class="badge text-bg-danger">Inactivo</span>';
                            tableUsuarios.api().ajax.reload();
                           rowTable.cells[1].textContent =  strIdentificacionUsuario;
                            //rowTable.cells[2].textContent =  strRolUsuario;
                           rowTable.cells[2].textContent = document.querySelector("#txtRolUsuario").selectedOptions[0].text;
                            rowTable.cells[3].innerHTML = htmlStatus;
                           rowTable = "";
                        }
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        swal("Usuario", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

}, false);

window.addEventListener('load', function() {
    fntRolesUsuario();
}, false);


function fntRolesUsuario(){
if(document.querySelector('#txtRolUsuario')){
    let ajaxUrl = base_url+'/Roles/getSelectRoles';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#txtRolUsuario').innerHTML = request.responseText;
            //$('.txtRolUsuario').selectpicker('render');
            $('#txtRolUsuario').picker({search : true});
            //$('#txtRolUsuario').selectpicker('refresh');
        }
    }
}
}

function fntViewInfo(ideusuario){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+ideusuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){

                let estadoUsuario = objData.data.status == 1 ? 
                '<span class="badge text-bg-success">Activo</span>' : 
                '<span class="badge text-bg-danger">Inactivo</span>';

                document.querySelector("#celIdeUsuario").innerHTML = objData.data.ideusuario;
                document.querySelector("#celIdentificacionUsuario").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombresUsuario").innerHTML = objData.data.nombres;
                document.querySelector("#celApellidosUsuario").innerHTML = objData.data.apellidos;
                document.querySelector("#celCorreoUsuario").innerHTML = objData.data.correo;
                document.querySelector("#celRolUsuario").innerHTML = objData.data.rolid;
                document.querySelector("#celEstadoUsuario").innerHTML = estadoUsuario;
                
                $('#modalViewUsuario').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, ideusuario){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary5", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+ideusuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#ideUsuario").value = objData.data.ideusuario;
                document.querySelector("#txtIdentificacionUsuario").value = objData.data.identificacion;
                document.querySelector("#txtNombresUsuario").value = objData.data.nombres;
                document.querySelector("#txtApellidosUsuario").value = objData.data.apellidos;
                document.querySelector("#txtCorreoUsuario").value = objData.data.correo;
                document.querySelector("#txtRolUsuario").value =objData.data.idrol;

                // ESTADO ACTIVO O INACTIVO
                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                
            }
        }
        $('#modalFormUsuario').modal('show');
    }
}

function fntDelInfo(ideusuario){
    swal({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar al Usuario?",
        imageUrl: "Assets/images/alerta.png" ,
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true,
        
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/delUsuario';
            let strData = "ideUsuario="+ideusuario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableUsuarios.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}


function openModal()
{
    rowTable = "";
    document.querySelector('#ideUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary5");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}




