<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-clipboard2-fill"></i> <?=$data['page_title']?>
            <?php if ($_SESSION['permisosMod']['w']) {?>
        <button class="btn btn-warning espaciado" type="button" data-bs-toggle="modal" onclick="openModal();">
            <i class="bi bi-plus-lg"></i>
            Nueva Asignación</button>
        <?php }?></h1>
        </div>

       

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/asignaciones"><?=$data['page_title']?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableAsignaciones">
                            <thead class="table-success">
                                <tr>
                                    <th class="table-warning">Ficha</th>
                                    <th class="table-warning">Instructor</th>
                                    <th class="table-warning">Competencia</th>
                                    <th class="table-warning">Horas</th>
                                    <th class="table-warning">Mes</th>
                                    <th class="table-warning">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data);
getModal('modalAsignaciones', $data);
?>