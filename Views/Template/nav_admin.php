    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
                src="<?= media();?>/images/<?=$_SESSION['userData']['imgperfil'];?>" alt="Imagen de perfil">
            <div>
                <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
                <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>
            </div>
        </div>

        <ul class="app-menu">
            <li>
                <a class="app-menu__item" href="<?=base_url();?>/dashboard">
                    <i class="app-menu__icon bi bi-house-fill"></i>
                    <span class="app-menu__label">Inicio</span>
                </a>
            </li>

            <?php if (!empty($_SESSION['permisos'][1]['r'])) {?>
            <li class="treeview" id="color-admin-nav">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-person-fill-gear"></i>
                    <span class="app-menu__label">Administrador</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i></a>
                <ul class="treeview-menu">
                    <?php if (!empty($_SESSION['permisos'][1]['u'])) {?>
                    <li class="roles-list">
                        <a class="treeview-item" href="<?=base_url();?>/roles">
                            <i class="app-menu__icon bi bi-toggles"></i>  
                            Roles</a>
                    </li>
                    
                    <?php }?>
                </ul>
                <li><a class="app-menu__item " href="<?=base_url();?>/usuarios">
                    <i class="app-menu__icon bi bi-people-fill"></i>
                    <span class="app-menu__label">Usuarios</span></a></li>

                <li>
                    <a class="app-menu__item " href="<?=base_url();?>/programas">
                    <i class="app-menu__icon bi bi-calendar-week-fill"></i>
                    <span class="app-menu__label">Programas</span></a>
                </li>
            </li>

            <li><a class="app-menu__item " href="<?=base_url();?>/competencias">
                    <i class="app-menu__icon bi bi-award-fill"></i>
                    <span class="app-menu__label">Competencias</span></a></li>
            <?php }?>

            <li>
                <a class="bg-danger app-menu__item" href="<?=base_url();?>/logout">
                    <i class="app-menu__icon bi bi-box-arrow-left"></i>
                    <span class="app-menu__label">Salir</span>
                </a>
            </li>

        </ul>

    </aside>