let tableProgramas; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableProgramas = $('#tableProgramas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Programas/getProgramas",
            "dataSrc":""
        },
        "columns":[
            {"data":"codigoprograma"},
            {"data":"nivelprograma"},
            {"data":"nombreprograma"},
            {"data":"horasprograma"},
            {"data":"options"}

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='bi bi-files fs-3 mb-2'></i>",
                "titleAttr":"Copiar",
                "className": "btn btn-warning mt-3"
            },{
                "extend": "excelHtml5",
                "text": "<i class='bi bi-filetype-exe fs-3 mb-2'></i>",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success mt-3"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-filetype-pdf fs-3 mb-2'></i>",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger mt-3"
            },{
                "extend": "csvHtml5",
                "text": "<i class='bi bi-filetype-csv fs-3 mb-2'></i>",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info mt-3"
            }
        ],
        "responsive":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });



	if(document.querySelector("#formPrograma")){
        let formPrograma = document.querySelector("#formPrograma");
        formPrograma.onsubmit = function(e) {
            e.preventDefault();
            var intIdePrograma = document.querySelector('#idePrograma').value;
            let strCodigoPrograma = document.querySelector('#txtCodigoPrograma').value;
            let strNivelPrograma = document.querySelector('#txtNivelPrograma').value;
            let strNombrePrograma = document.querySelector('#txtNombrePrograma').value;
            let strHorasPrograma = document.querySelector('#txtHorasPrograma').value;

            if(strCodigoPrograma == '' || strNombrePrograma == '')
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
            let ajaxUrl = base_url+'/Programas/setPrograma'; 
            let formData = new FormData(formPrograma);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableProgramas.api().ajax.reload();
                        }else{
                            tableProgramas.api().ajax.reload();
                           rowTable = "";
                        }
                        $('#modalFormPrograma').modal("hide");
                        formPrograma.reset();
                        swal("Programas", objData.msg ,"success");
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


function fntViewInfo(ideprograma){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Programas/getPrograma/'+ideprograma;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#celIdePrograma").innerHTML = objData.data.ideprograma;
                document.querySelector("#celCodigoPrograma").innerHTML = objData.data.codigoprograma;
                document.querySelector("#celNivelPrograma").innerHTML = objData.data.nivelprograma;
                document.querySelector("#celNombrePrograma").innerHTML = objData.data.nombreprograma;
                document.querySelector("#celHorasPrograma").innerHTML = objData.data.horasprograma;
                
                $('#modalViewPrograma').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, ideprograma){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Programa";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Programas/getPrograma/'+ideprograma;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idePrograma").value = objData.data.ideprograma;
                document.querySelector("#txtCodigoPrograma").value = objData.data.codigoprograma;
                document.querySelector("#txtNivelPrograma").value = objData.data.nivelprograma;
                document.querySelector("#txtNombrePrograma").value = objData.data.nombreprograma;
                document.querySelector("#txtHorasPrograma").value = objData.data.horasprograma;
                
            }
        }
        $('#modalFormPrograma').modal('show');
    }
}

function fntDelInfo(ideprograma){
    swal({
        title: "Eliminar Programa",
        text: "¿Esta seguro que desea eliminar el programa?",
        imageUrl: "Assets/images/alerta.png" ,
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
            let ajaxUrl = base_url+'/Programas/delPrograma';
            let strData = "idePrograma="+ideprograma;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableProgramas.api().ajax.reload();
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
    document.querySelector('#idePrograma').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Programa";
    document.querySelector("#formPrograma").reset();
    $('#modalFormPrograma').modal('show');



}




