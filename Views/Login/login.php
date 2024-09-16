<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sigma">
    <link rel="shortcut icon" href="<?=media();?>/images/faviicon.png">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?=media();?>/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title><?=$data['page_tag'];?></title>
    <style>
        /* CSS para el campo de entrada redondeado */
        .form-control.rounded-input {
            border-radius: 50px; /* Ajusta el valor según tus necesidades */
            border: 1px solid #ccc;
            padding: 10px 15px;
            font-size: 16px;
            background-color: transparent;
            position: relative;
        }
        
        .form-control.rounded-input:focus {
            border-color: #2e6b4e5e; /* Cambia el color del borde al hacer foco */
            box-shadow: 0 0 0 0.2rem #2e6b4e5e; /* Agrega una sombra al hacer foco */
            outline: none;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-container {
            position: relative;
        }

        .input-container label {
            position: absolute;
            top: 50%;
            left: 15px;
            font-size: 13px;
            color: #aaa;
            transition: 0.2s ease all;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .input-container .form-control:focus + label,
        .input-container .form-control:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #2e6b4e;
        }
        .login-head{
            margin-bottom:10px;
        }

        /* Ocultar las flechas en campos de entrada de tipo number para diferentes navegadores */
        
        /* Para navegadores Webkit (Chrome, Safari) */
        .form-control[type="number"]::-webkit-inner-spin-button,
        .form-control[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Para Firefox */
        .form-control[type="number"] {
            -moz-appearance: textfield; /* Cambia la apariencia para eliminar las flechas en Firefox */
        }
        .input-container{
            margin-bottom:45px;
        }
        .hr{
            margin-top:30px;
        }
        .tyt{
            margin-left:10px;
        }
    </style>
</head>

<body>
    <section class="material-half-bg">
    </section>
    <section class="login-content">
        <div class="login-box">
            <div id="divLoading">
                <div class="spinner-border visually-hidden" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
            
            <form class="login-form needs-validation" name="formLogin" id="formLogin" novalidate>
                <img src="<?=media();?>/images/logonegro.png" alt="" class="cursor-evento logo-img">
                <h3 class="login-head tipo"><i class="bi bi-person-fill me-2"></i>INICIAR SESION</h3>

                <div class="form-group hr">
                    <div class="input-container">
                        <input id="txtIdentificacion" name="txtIdentificacion" class="form-control rounded-input " type="number"
                            placeholder=" " required>
                        <label for="txtIdentificacion">Usuario</label>
                        <div class="invalid-feedback tyt">El inicio de sesión o la contraseña no son válidos.</div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-container">
                        <input id="txtPassword" name="txtPassword" class="form-control rounded-input" type="password"
                            placeholder=" " required>
                        <label for="txtPassword">Ingrese Contraseña</label>
                        <div class="invalid-feedback tyt">El inicio de sesión o la contraseña no son válidos.</div>
                    </div>
                </div>

                <div id="alertLogin" class="text-center"></div>
                <div class="mb-3 btn-container d-grid block-login">
                    <button type="submit" id="btn-login" class="btn btn-primary5 btn-block">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </section>
    <!-- ORIGINAL -->
    <script>
        const base_url = "<?=base_url();?>";

        // Desplazar la página hacia arriba al hacer clic en los campos de entrada
        document.querySelectorAll('.rounded-input').forEach(input => {
            input.addEventListener('focus', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // Hace el desplazamiento más suave
                });
            });
        });
    </script>

    <!-- Essential javascripts for application to work-->
    <script src="<?=media();?>/js/jquery-3.7.0.min.js"></script>
    <script src="<?=media();?>/js/popper.min.js"></script>
    <script src="<?=media();?>/js/bootstrap.min.js"></script>
    <script src="<?=media();?>/js/fontawesome.js"></script>
    <script src="<?=media();?>/js/main.js"></script>
    <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function () {
            $('.login-box').toggleClass('flipped');
            return false;
        });

        // Manejar la validación del formulario
        (function () {
            'use strict';

            // Obtener los formularios que queremos validar
            var forms = document.querySelectorAll('.needs-validation');

            // Iterar sobre ellos y prevenir el envío si hay errores
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
        })();

        function resetValidation() {
    var form = document.getElementById('formLogin');
    
    // Elimina la clase 'was-validated'
    form.classList.remove('was-validated');

    // Elimina las clases 'is-valid' y 'is-invalid' de todos los inputs
    form.querySelectorAll('.form-control').forEach(function (input) {
        input.classList.remove('is-valid', 'is-invalid');
    });
}

}

    </script>

    <!-- JavaScript-->
    <script src="<?=media();?>/js/plugins/pace.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.js"></script>
    <script src="<?=media();?>/js/<?=$data['page_functions_js'];?>"></script>

</body>

</html>
