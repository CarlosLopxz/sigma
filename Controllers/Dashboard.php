<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(RADMINISTRADOR);
    }

    public function dashboard()
    {
        $data['page_id'] = 2;
        $data['page_tag'] = "Administrador - Sigma";
        $data['page_title'] = " Administrador - Sigma";
        $data['page_name'] = "Administrador";
        $data['page_functions_js'] = "functions_dashboard.js";
        $data['roles'] = $this->model->cantRoles();
        $data['competencias'] = $this->model->cantCompetencias();
        $data['usuarios'] = $this->model->cantUsuarios();
        $data['programas'] = $this->model->cantProgramas();

        if ($_SESSION['userData']['idrol'] == RCOORDINADOR) {
            $this->views->getView($this, "dashboardCliente", $data);
        } else {
            $this->views->getView($this, "dashboard", $data);
        }
    }

}