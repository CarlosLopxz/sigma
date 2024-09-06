let tableAsignaciones; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableAsignaciones = $('#tableAsignaciones').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Asignaciones/getFichas",
            "dataSrc":""
        },
        "columns":[
            {"data":"programaficha"},
            {"data":"nombres"},
            {"data":"idecompetencia"},
            {"data":"cantidadhoras"},
            {"data":"mes"},
            {"data":"options"}

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-warning mt-3"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success mt-3"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger mt-3"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info mt-3"
            }
        ],
        "responsive":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });



	if(document.querySelector("#formAsignacion")){
        let formAsignacion = document.querySelector("#formAsignacion");
        formAsignacion.onsubmit = function(e) {
            e.preventDefault();
            var intIdeFicha = document.querySelector('#ideDetalleFicha').value;
            let strNumeroFicha = document.querySelector('#txtNumeroFicha').value;
            let strNombreFicha= document.querySelector('#txtNombreFicha').value;
            let strIdeInstructor = document.querySelector('#txtIdeInstructor').value;
            let strNombreInstructor= document.querySelector('#txtNombreInstructor').value;
            let strCodigoCompetencia= document.querySelector('#txtCodigoCompetencia').value;
            let strNombreCompetencia= document.querySelector('#txtNombreCompetencia').value;
            let strHorasTotalCompetencia= document.querySelector('#txtHorasTotalCompetencia').value;
            let strHorasSumaAsignacionCompetencia= document.querySelector('#txtHorasSumaAsignacionCompetencia').value;
            let strHorasPendienteCompetencia= document.querySelector('#txtHorasPendienteCompetencia').value;
            let strNumeroHoras= document.querySelector('#txtNumeroHoras').value;
            // document.getElementById("txtNumeroHoras").disabled = false;
            let strListadoMeses= document.querySelector('#listadoMeses').value;

            if(strNumeroFicha == '' || strNombreFicha == '' || strIdeInstructor == '' || strNumeroHoras == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos no estén vacíos" , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Asignaciones/setFicha'; 
            let formData = new FormData(formAsignacion);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableAsignaciones.api().ajax.reload();
                        }else{
                            tableAsignaciones.api().ajax.reload();
                           rowTable = "";
                        }
                        $('#modalFormAsignacion').modal("hide");
                        formAsignacion.reset();
                        swal("Asignacion", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
          
        }
        // TODO PENDIENTE DE REALIZARLE PRUEBAS
        // limpiarModal();
    }

}, false);



function fntViewInfo(idedetalleficha){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Asignaciones/getFicha/'+idedetalleficha;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                document.querySelector("#celFicha").innerHTML = objData.data.programaficha;
                document.querySelector("#celInstructor").innerHTML = objData.data.nombres;
                document.querySelector("#celCompetencia").innerHTML = objData.data.nombrecompetencia;
                document.querySelector("#celHoras").innerHTML = objData.data.total_horas_asignadas;
                document.querySelector("#celMes").innerHTML = objData.data.mes;
                
                $('#modalViewAsignacion').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, idedetalleficha){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Asignar Competencias";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Asignar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Asignaciones/getFicha/'+idedetalleficha;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                document.querySelector("#ideDetalleFicha").value = objData.data.idedetalleficha;
                document.querySelector("#txtNumeroFicha").value = objData.data.programaficha;
                document.querySelector("#txtNombreFicha").value = objData.data.nombreprograma;
                document.querySelector("#txtIdeInstructor").value = objData.data.ideinstructor;
                document.querySelector("#txtNombreInstructor").value =objData.data.nombres;
                document.querySelector("#txtCodigoCompetencia").value =objData.data.codigocompetencia;
                document.querySelector("#txtNombreCompetencia").value =objData.data.nombrecompetencia;
                document.querySelector("#txtHorasTotalCompetencia").value =objData.data.horascompetencia;
                document.querySelector("#txtHorasSumaAsignacionCompetencia").value =objData.data.total_horas_asignadas;
                // var valor1 = parseFloat(document.getElementById('txtHorasSumaAsignacionCompetencia').value = objData.data.total_horas_asignadas);
                document.querySelector("#txtHorasPendienteCompetencia").value =objData.data.horascompetencia;
                document.querySelector("#txtNumeroHoras").value =objData.data.cantidadhoras;
                document.querySelector("#listadoMeses").value =objData.data.mes;



                // TODO PRUEBA
                var valor1 = parseFloat(document.getElementById('txtHorasTotalCompetencia').value = objData.data.horascompetencia);
                var valor2 = parseFloat(document.getElementById('txtHorasSumaAsignacionCompetencia').value = objData.data.total_horas_asignadas);

                 // Realizar la resta
                var resultado = valor1 - valor2;

                // Mostrar el resultado en el campo de salida
                document.getElementById("txtHorasPendienteCompetencia").value = resultado;

            }
        }
        $('#modalFormAsignacion').modal('show');
        // ftnSumarCantidadHoras();


        
    }
    
}


function fntDelInfo(ideficha){
    swal({
        title: "Eliminar la Asignación",
        text: "¿Esta seguro que desea eliminar la asignación?",
        imageUrl: "Assets/images/iconos/eliminar.png" ,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Asignaciones/delFicha';
            let strData = "idedetalleficha="+ideficha;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableAsignaciones.api().ajax.reload();
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
    document.querySelector('#ideDetalleFicha').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Ficha";
    document.querySelector("#formAsignacion").reset();
    $('#modalFormAsignacion').modal('show');
}


function fntViewInfoIdeFicha(fichaprograma){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Asignaciones/getIdeFicha/'+fichaprograma;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtNombreFicha').value = objData.data.nombreprograma;
            }else{
                document.getElementById("txtNombreFicha").value = '';
            }
        }
    }
}

function fntViewInfoIdeInstructor(identificacion){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Asignaciones/getInstructor/'+identificacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtNombreInstructor').value = objData.data.nombres;
            }else{
                document.getElementById("txtNombreInstructor").value = '';
            }
        }
    }
}

function fntViewInfoCodigoCompetencia(codigocompetencia){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Asignaciones/getCompetencia/'+codigocompetencia;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtNombreCompetencia').value = objData.data.nombrecompetencia;
                var valor1 = parseFloat(document.getElementById('txtHorasTotalCompetencia').value = objData.data.horascompetencia);
                var valor2 = parseFloat(document.getElementById('txtHorasSumaAsignacionCompetencia').value = objData.data.total_horas_asignadas);

                 // Realizar la resta
                var resultado = valor1 - valor2;

                // Mostrar el resultado en el campo de salida
                document.getElementById("txtHorasPendienteCompetencia").value = resultado;
            }else{
                document.getElementById("txtNombreCompetencia").value = '';
                document.getElementById("txtHorasTotalCompetencia").value = '';
                document.getElementById("txtHorasPendienteCompetencia").value = '';
            }
        }
    }
}

function ftnSumarCantidadHoras() {
    // Obtener los valores de los inputs
    var valor1 = parseFloat(document.getElementById("txtHorasPendienteCompetencia").value);
    var valor2 = parseFloat(document.getElementById("txtNumeroHoras").value);
    
    // Limpiar mensajes de error
    var mensajeError = document.getElementById("mensajeError");
    mensajeError.textContent = "";



    // Verificar si valor1 es mayor que valor2
    if (valor1 < valor2) {
        // Mostrar mensaje de error
        mensajeError.textContent = "Importante: El número de horas asignadas es mayor que las horas pendientes";
        document.getElementById("txtNumeroHoras").value = '';
        return false; // Evitar el envío del formulario o la continuación del proceso
    }

    return true; // Validación exitosa
}

document.addEventListener("DOMContentLoaded", function() {
    // Seleccionar el input por su ID
    var inputField = document.getElementById("txtHorasPendienteCompetencia");
    var mensaje = document.getElementById("mensaje");
    var valorAnterior = ""; // Almacena el valor anterior del input

    // Usar setInterval para verificar cambios en el valor del input cada 500ms
    setInterval(function() {
        var valorActual = inputField.value.trim();

        // Comprobar si el valor ha cambiado
        if (valorActual !== valorAnterior) {
            valorAnterior = valorActual; // Actualizar el valor anterior
            if (valorActual == 0) {
                mensajeError.textContent = "El número de horas de la competencia ya se encuentra completo";
                document.getElementById("txtNumeroHoras").disabled = true;
                // document.getElementById("txtNumeroHoras").hidden = true;
                // mensaje.textContent = "El input tiene un valor: " + valorActual;
            } else {
                mensaje.textContent = "Horas pendientes de la competencia";
                document.getElementById("txtNumeroHoras").disabled = false;
                mensajeError.textContent = "";
            }
        }
    }, 500); // Revisa cada 500ms (medio segundo)
});



// TODO EJEMPLO
function realizarResta() {
    // Obtener los valores de los campos de entrada
    var valor111 = parseFloat(document.getElementById("txtHorasTotalCompetencia").value);
    var valor211= parseFloat(document.getElementById("valor2").value);

    // Realizar la resta
    var resultado = valor1 - valor2;

    // Mostrar el resultado en el campo de salida
    document.getElementById("resultado").value = resultado;

    // Opcionalmente, enviar los valores al servidor con AJAX
    enviarDatos(valor1, valor2, resultado);
}

function enviarDatos(valor1, valor2, resultado) {
    // Crear una solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "procesar_resta.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Datos enviados al servidor");
        }
    };
    xhr.send("valor1=" + valor1 + "&valor2=" + valor2 + "&resultado=" + resultado);
}


