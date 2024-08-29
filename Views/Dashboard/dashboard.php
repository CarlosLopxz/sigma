<?php headerAdmin($data);?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1>
                <i class="bi bi-house-fill"></i>
                </i> Inicio
            </h1>
            <p class="info-sigma">Sistema de Información para la Gestión de Módulos Académicos - SIGMA</p>
        </div >
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        </ul>
    </div>
    <div class="row">

        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/instructores" class="linkw">
                <div class="widget-small icon color-cards-instructores"><i class="icon bi bi-people-fill fs-1"></i>
                    <div class="info">
                        <h4>Instructores</h4>
                        <p><b><?=$data['usuarios']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>


        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/competencias" class="linkw">
                <div class="widget-small color-cards-competencias"><i class="icon bi bi-award-fill fs-1"></i>
                    <div class="info">
                        <h4 >Competencias</h4>
                        <p><b><?=$data['usuarios']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>



        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/usuarios" class="linkw">
                <div class="widget-small color-cards-usuarios"><i class="icon bi bi-person-circle fs-1"></i>
                    <div class="info">
                        <h4>Usuarios</h4>
                        <p><b><?=$data['usuarios']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>


        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/programas" class="link-info">
                <div class="widget-small  color-cards-programas">
                    <i class="icon bi bi-calendar-week-fill fs-1"></i>
                    <div class="info">
                        <h4>Programas</h4>
                        <p><b><?=$data['programas']?></b></p>
                    </div>
                </div>
        </div>
        </a>
    </div>
    <?php }?>

</main>
<?php footerAdmin($data);?>