<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-award-fill"></i> <?=$data['page_title']?>
            <?php if ($_SESSION['permisosMod']['w']) {?>
        <button class="btn btn-warning espaciado" type="button" data-bs-toggle="modal" onclick="openModal();">
            <i class="bi bi-award-fill"></i>
            Nueva</button>
        <?php }?>
        </h1>
        </div>
      
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
                            <thead class="table-warning">
                                <tr>
                                <th class="text-center">Código </th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Horas</th>
                                    <th class="text-center">Avance</th>
                                    <th class="text-center">Ficha</th>
                                    <th class="text-center">Acciones</th>
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