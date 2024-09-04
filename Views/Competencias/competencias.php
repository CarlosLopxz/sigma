<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-award-fill"></i> <?=$data['page_title']?> </h1>
        </div>
        <?php if ($_SESSION['permisosMod']['w']) {?>
        <button  id="btnprogram" class="btn btn-warning" type="button" data-bs-toggle="modal" onclick="openModal();">
            <i class="bi bi-plus-lg"></i>
            Nueva Competencia</button>
        <?php }?>

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-fill"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/competencias"><?=$data['page_title']?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableCompetencias">
                            <thead class="table-success">
                                <tr>
                                    <th class="table-warning"">Código </th>
                                    <th class="table-warning"">Nombre</th>
                                    <th class="table-warning"">Horas</th>
                                    <th class="table-warning"">Código Programa</th>
                                    <th class="table-warning"">Acciones</th>
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
getModal('modalCompetencias', $data);
?>