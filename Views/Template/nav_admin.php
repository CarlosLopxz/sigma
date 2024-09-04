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

            
            <li>
                <a class="app-menu__item " href="<?=base_url();?>/roles">
                    <i class="app-menu__icon bi bi-toggles"></i>
                    <span class="app-menu__label">Roles</span>
                </a>
            </li>

                
            <li>
                <a class="app-menu__item " href="<?=base_url();?>/usuarios">
                    <i class="app-menu__icon bi bi-people-fill"></i>
                    <span class="app-menu__label">Usuarios</span>
                </a>
            </li>

            <li>
                <a class="app-menu__item " href="<?=base_url();?>/programas">
                    <i class="app-menu__icon bi bi-calendar-week-fill"></i>
                    <span class="app-menu__label">Programas</span>
                </a>
            </li>
            

            <li>
                <a class="app-menu__item " href="<?=base_url();?>/competencias">
                    <i class="app-menu__icon bi bi-award-fill"></i>
                    <span class="app-menu__label">Competencias</span>
                </a>
            </li>
            

            <li>
                <a class="bg-danger app-menu__item" href="<?=base_url();?>/logout">
                    <i class="app-menu__icon bi bi-box-arrow-left"></i>
                    <span class="app-menu__label">Salir</span>
                </a>
            </li>

        </ul>

    </aside>