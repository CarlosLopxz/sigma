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
                <div class="widget-small icon color-cards-instructores"><i class="icon bi bi-file-earmark-person-fill fs-1"></i>
                    <div class="info">
                        <h4 class="txtdashboard-cards" >Instructores</h4>
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
                        <h4 class="txtdashboard-cards" >Competencias</h4>
                        <p><b><?=$data['usuarios']?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php }?>



        <?php if (!empty($_SESSION['permisos'][2]['d'])) {?>
        <div class="col-md-6 col-lg-3">
            <a href="<?=base_url()?>/usuarios" class="linkw">
                <div class="widget-small color-cards-usuarios"><i class="icon bi bi-people-fill fs-1"></i>
                    <div class="info">
                        <h4 class="txtdashboard-cards" >Usuarios</h4>
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
                        <h4 class="txtdashboard-cards" >Programas</h4>
                        <p><b><?=$data['programas']?></b></p>
                    </div>
                </div>
        </div>
        </a>
    </div>
    <?php }?>
     <div class="row">
       <div class="col-md-6">
         <div class="tile">
           <h3 class="tile-title">Horas Completadas - Semanales</h3>
           <div class="ratio ratio-16x9">
             <div id="salesChart"></div>
           </div>
         </div>
       </div>
       <div class="col-md-6">
         <div class="tile">
           <h3 class="tile-title">Gestion de Horas - Mensuales </h3>
           <div class="ratio ratio-16x9">
             <div id="supportRequestChart"></div>
           </div>
         </div>
       </div>
     </div>

</main>
<?php footerAdmin($data);?>