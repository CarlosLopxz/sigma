let tableFichas; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableFichas = $('#tableFichas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Fichas/getFichas",
            "dataSrc":""
        },
        "columns":[
            {"data":"fichaprograma"},
            {"data":"nombreprograma"},
            {"data":"ideinstructor"},
            {"data":"status"},
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



	if(document.querySelector("#formFicha")){
        let formFicha = document.querySelector("#formFicha");
        formFicha.onsubmit = function(e) {
            e.preventDefault();
            var intIdeFicha = document.querySelector('#ideFicha').value;
            let strCodigoPrograma = document.querySelector('#txtCodigoPrograma').value;
            let strNombrePrograma= document.querySelector('#txtNombrePrograma').value;
            let strFichaPrograma = document.querySelector('#txtFichaPrograma').value;
            let strIdeInstructor = document.querySelector('#txtIdeInstructor').value;
            let strNombreInstructor= document.querySelector('#txtNombreInstructor').value;

            if(strCodigoPrograma == '' || strNombrePrograma == '' || strFichaPrograma == '' || strIdeInstructor == '')
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
            let ajaxUrl = base_url+'/Fichas/setFicha'; 
            let formData = new FormData(formFicha);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableFichas.api().ajax.reload();
                        }else{
                            tableFichas.api().ajax.reload();
                           rowTable = "";
                        }
                        $('#modalFormFicha').modal("hide");
                        formFicha.reset();
                        swal("Ficha", objData.msg ,"success");
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



function fntViewInfo(ideficha){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getFicha/'+ideficha;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                document.querySelector("#celIdeFicha").innerHTML = objData.data.ideficha;
                document.querySelector("#celCodigoPrograma").innerHTML = objData.data.nombreprograma;
                document.querySelector("#celNumeroFicha").innerHTML = objData.data.fichaprograma;
                document.querySelector("#celIdeInstructor").innerHTML = objData.data.ideinstructor;
                document.querySelector("#celEstadoFicha").innerHTML = objData.data.status;
                
                $('#modalViewFicha').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, ideficha){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Ficha";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getFicha/'+ideficha;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                document.querySelector("#ideFicha").value = objData.data.ideficha;
                document.querySelector("#txtCodigoPrograma").value = objData.data.codigoprograma;
                document.querySelector("#txtNombrePrograma").value = objData.data.nombreprograma;
                document.querySelector("#txtFichaPrograma").value = objData.data.fichaprograma;
                document.querySelector("#txtIdeInstructor").value =objData.data.ideinstructor;
                document.querySelector("#txtNombreInstructor").value =objData.data.nombres;
                
            }
        }
        $('#modalFormFicha').modal('show');
        
    }
    
}


function fntDelInfo(ideficha){
    swal({
        title: "Eliminar Ficha",
        text: "¿Esta seguro que desea eliminar la ficha?",
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
            let ajaxUrl = base_url+'/Fichas/delFicha';
            let strData = "ideficha="+ideficha;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableFichas.api().ajax.reload();
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
    document.querySelector('#ideFicha').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Ficha";
    document.querySelector("#formFicha").reset();
    $('#modalFormFicha').modal('show');
}



function fntViewInfoCodigoPrograma(codprograma){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getPrograma/'+codprograma;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtNombrePrograma').value = objData.data.nombreprograma;
            }else{
                document.getElementById("txtNombrePrograma").value = '';
            }
        }
    }
}

function fntViewInfoIdeInstructor(identificacion){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getInstructor/'+identificacion;
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

