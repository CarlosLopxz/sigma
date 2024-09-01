<?php

class Programas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDADMINISTRADOR);
    }

    public function Programas()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Programas";
        $data['page_title'] = "Programas";
        $data['page_name'] = "programas";
        $data['page_functions_js'] = "functions_programas.js";
        $this->views->getView($this, "programas", $data);
    }

    public function setPrograma()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtIdentificacionPrograma'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdePrograma = intval($_POST['idePrograma']);
                $strIdentificacionPrograma = strClean($_POST['txtIdentificacionPrograma']);
                $strnombresprograma = strClean($_POST['txtnombresprograma']);
                $strRolPrograma = intval(strClean($_POST['txtRolPrograma']));
                $intStatus = intval(strClean($_POST['listStatus']));

                $request_programa = "";
                if ($intIdePrograma == 0) {
                    $option = 1;
                    $strPassword = empty($_POST['txtIdentificacionPrograma']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtIdentificacionPrograma']);
                    if ($_SESSION['permisosMod']['w']) {
                        $request_programa = $this->model->insertPrograma(
                            $strIdentificacionPrograma,
                            $strnombresprograma,
                            $strPassword,
                            $strRolPrograma,
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    $strPassword = empty($_POST['txtIdentificacionPrograma']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtIdentificacionPrograma']);
                    if ($_SESSION['permisosMod']['u']) {
                        $request_programa = $this->model->updatePrograma(
                            $intIdePrograma,
                            $strIdentificacionPrograma,
                            $strRolPrograma,
                            $intStatus
                        );
                    }
                }
                if ($request_programa > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 
