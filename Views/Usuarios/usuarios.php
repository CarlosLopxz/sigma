<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-people-fill"></i> <?=$data['page_title']?>
                <?php if ($_SESSION['permisosMod']['w']) {?>
                <button class="btn btn-warning  espaciado" type="button" data-bs-toggle="modal" onclick="openModal();">
                    <i class="bi bi-person-plus"></i>Nuevo Usuario</button>
                <?php }?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/usuarios"><?=$data['page_title']?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class=" table table-hover table-bordered" id="tableUsuarios">
                            <thead>
                                <tr>
                                    <th class="table-warning">ID</th>
                                    <th class="table-warning"  >Identificación</th>
                                    <th class="table-warning"  >Nombres</th>
                                    <th class="table-warning"  >Apellidos</th>
                                    <th class="table-warning"  >Telefono</th>
                                    <th class="table-warning"  >Correo</th>
                                    <th class="table-warning"  >Rol</th>
                                    <th class="table-warning"  >Estado</th>
                                    <th class="table-warning"  >Acciones</th>
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
getModal('modalUsuarios', $data);
?>