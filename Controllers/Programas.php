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
        getPermisos(RADMINISTRADOR);
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
            if (empty($_POST['txtCodigoPrograma'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdePrograma = intval($_POST['idePrograma']);
                $strCodigoPrograma = strClean($_POST['txtCodigoPrograma']);
                $strNivelPrograma = strClean($_POST['txtNivelPrograma']);
                $strNombrePrograma = strClean($_POST['txtNombrePrograma']);
                $strHorasPrograma = strClean($_POST['txtHorasPrograma']);
                $intStatus = intval(strClean($_POST['listStatus']));


                $request_programa = "";
                if ($intIdePrograma == 0) {
                    $option = 1;
                    $strPassword =  empty($_POST['txtCodigoPrograma']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtCodigoPrograma']);
                    if ($_SESSION['permisosMod']['w']) {
                        $request_programa = $this->model->insertPrograma(
                            $strCodigoPrograma,
                            $strNivelPrograma,
                            $strNombrePrograma,
                            $strHorasPrograma,
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    $strPassword =  empty($_POST['txtCodigoPrograma']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtCodigoPrograma']);
                    if ($_SESSION['permisosMod']['u']) {
                        $request_programa = $this->model->updatePrograma(
                            $intIdePrograma,
                            $strCodigoPrograma,
                            $strNivelPrograma,
                            $strNombrePrograma,
                            $strHorasPrograma,
                            $intStatus
                        );
                    }
                }
                if ($request_programa > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Programa guardado correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Programa actualizado correctamente');
                    }
                } else if ($request_programa == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el código del Programa ya existe, ingrese otro');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProgramas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectProgramas();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if($arrData[$i]['status'] == 1)
                {
                    $arrData[$i]['status'] = '<span class="badge text-bg-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge text-bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['ideprograma'] . ')" title="Ver Programa"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['ideprograma'] . ')" title="Editar Programa"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['ideprograma'] . ')" title="Eliminar Programa"><i class="bi bi-trash3"></i></button>';
       
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPrograma($ideprograma)
    {
        if ($_SESSION['permisosMod']['r']) {
            $ideprograma = intval($ideprograma);
            if ($ideprograma > 0) {
                $arrData = $this->model->selectPrograma($ideprograma);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delPrograma()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdePrograma = intval($_POST['idePrograma']);
                $requestDelete = $this->model->deletePrograma($intIdePrograma);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Programa');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Programa.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}

