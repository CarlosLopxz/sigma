document.addEventListener('DOMContentLoaded', function() {
    var divLoading = document.querySelector("#divLoading");

    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");

        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strPassword = document.querySelector('#txtPassword').value;

            document.querySelector('#txtIdentificacion').classList.remove('is-invalid', 'animate-error');
            document.querySelector('#txtPassword').classList.remove('is-invalid', 'animate-error');

            let hasError = false;
            let errorMessage = "";

            if (strIdentificacion == "" && strPassword == "") {
                document.querySelector('#txtIdentificacion').classList.add('is-invalid', 'animate-error');
                document.querySelector('#txtPassword').classList.add('is-invalid', 'animate-error');
                errorMessage = "Escribe la identificación y la contraseña";
                hasError = true;
            } else if (strIdentificacion == "") {
                document.querySelector('#txtIdentificacion').classList.add('is-invalid', 'animate-error');
                errorMessage = "Escribe la identificación";
                hasError = true;
            } else if (strPassword == "") {
                document.querySelector('#txtPassword').classList.add('is-invalid', 'animate-error');
                errorMessage = "Escribe la contraseña";
                hasError = true;
            }

            if (hasError) {
               
                setTimeout(() => {
                    document.querySelector('#txtIdentificacion').classList.remove('animate-error');
                    document.querySelector('#txtPassword').classList.remove('animate-error');
                }, 400);

                return false;
            } else {
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            window.location = base_url + '/dashboard';
                        } else {
                            document.querySelector('#txtPassword').classList.add('is-invalid', 'animate-error');
                            document.querySelector('#txtIdentificacion').classList.add('is-invalid', 'animate-error');
                            document.querySelector('#txtPassword').value = "";
                            setTimeout(() => {
                                document.querySelector('#txtIdentificacion').classList.remove('animate-error');
                                document.querySelector('#txtPassword').classList.remove('animate-error');
                            }, 400);
                        }
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
    }
}, false);
