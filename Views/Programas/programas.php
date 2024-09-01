<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-people-fill"></i> <?=$data['page_title']?>
                <?php if ($_SESSION['permisosMod']['w']) {?>
                <button class="btn btn-warning bnt-rol" type="button" data-bs-toggle="modal" onclick="openModal();">
                    <i class="bi bi-person-plus"></i>
                    Nuevo Programa</button>
                <?php }?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/programas"><?=$data['page_title']?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
<<<<<<< Updated upstream
                        <table class="table table-hover table-bordered" id="tableProgramas">
                            <thead>
                                <tr>
                                    <th>Ficha</th>
                                    <th>Nombre</th>  
                                    <th>Horas</th> 
                                    <th>Jornada</th>
=======
                        <table class="table table-hover table-bordered" id="tableUsuarios">
                            <thead>
                                <tr>
                                    <th>Ficha</th>
                                    <th>Nombre</th>
                                    <th>Horas</th>  
                                    <th>Jornada</th> 
>>>>>>> Stashed changes
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data);
<<<<<<< Updated upstream
getModal('modalProgramas', $data);
=======
getModal('modalUsuarios', $data);
>>>>>>> Stashed changes
?>