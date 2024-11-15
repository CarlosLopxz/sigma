<?php
headerAdmin($data);
getModal('modalRoles', $data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-toggles"></i> <?=$data['page_title']?>
                <?php if ($_SESSION['permisosMod']['w']) {?>
                <button class="btn btn-warning bnt-rol espaciado" type="button" data-bs-toggle="modal" onclick="openModal();">
                    <i class="bi bi-toggles"></i>
                    Nuevo Rol</button>
                <?php }?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-fill"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/roles"><?=$data['page_title']?></a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableRoles">
                            <thead>
                                <tr>
                                    <th class="table-warning">Ítem</th>
                                    <th class="table-warning">Nombre</th>
                                    <th class="table-warning">Descripción</th>
                                    <th class="table-warning">Estado</th>
                                    <th class="table-warning" >Acciones</th>
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
<?php footerAdmin($data);?>