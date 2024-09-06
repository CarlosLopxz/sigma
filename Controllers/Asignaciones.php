<?php

class Asignaciones extends Controllers
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
        getPermisos(MUSUARIOS);
    }



    public function Asignaciones()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Asignaciones";
        $data['page_title'] = "Asignaciones";
        $data['page_name'] = "asignaciones";
        $data['page_functions_js'] = "functions_asignaciones.js";
        $this->views->getView($this, "asignaciones", $data);
    }

    public function setFicha()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtNumeroFicha'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectossss');
            } else {
                $intIdeFicha = intval($_POST['ideDetalleFicha']);
                $strNumeroFicha = intval(strClean($_POST['txtNumeroFicha']));
                $strNombreFicha = strClean($_POST['txtNombreFicha']);
                $strIdeInstructor = intval(strClean($_POST['txtIdeInstructor']));
                $strNombreInstructor = strClean($_POST['txtNombreInstructor']);
                $strCodigoCompetencia =intval(strClean($_POST['txtCodigoCompetencia']));
                $strNombreCompetencia = strClean($_POST['txtNombreCompetencia']);
                $strNumeroHoras = intval(strClean($_POST['txtNumeroHoras']));
                $strListadoMeses = strClean($_POST['listadoMeses']);

                // $intStatus = intval(strClean($_POST['listStatus']));

                $intTipoId = 5;
                $request_user = "";
                if ($intIdeFicha == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertFicha(
                            $strNumeroFicha,
                            $strIdeInstructor,
                            $strCodigoCompetencia,
                            $strNumeroHoras,
                            $strListadoMeses
                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        $request_user = $this->model->updateFicha(
                            $intIdeFicha,
                            $strCodigoPrograma,
                            $strFichaPrograma,
                            $strIdeInstructor
                        );
                    }
                }
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Guardada correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Actualizada correctamente');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! la asignación ya existe');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFichas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFichas();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnAsignar = '';
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

               

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
                }



                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idedetalleficha'] . ')" title="Ver Ficha"><i class="bi bi-eye"></i></button>';
                   
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-success" onClick="fntEditInfo(this,' . $arrData[$i]['idedetalleficha'] . ')" title="Editar Ficha"><i class="bi bi-check2-circle"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['idedetalleficha'] . ')" title="Eliminar Ficha"><i class="bi bi-trash3"></i></button>';
       
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getFicha($idedetalleficha)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idedetalleficha = intval($idedetalleficha);
            $htmlOptions = "";
            if ($idedetalleficha > 0) {
                $arrData = $this->model->selectFicha($idedetalleficha);
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



    public function delFicha()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdeFicha = intval($_POST['idedetalleficha']);
                $requestDelete = $this->model->deleteFicha($intIdeFicha);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Ficha');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Ficha.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getIdeFicha($fichaprograma)
    {
        if ($_SESSION['permisosMod']['r']) {
            $fichaprograma = intval($fichaprograma);
            $htmlOptions = "";
            if ($fichaprograma > 0) {
                $arrData = $this->model->selectIdeFicha($fichaprograma);
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

    public function getCompetencia($codigocompetencia)
    {
        if ($_SESSION['permisosMod']['r']) {
            $codigocompetencia = intval($codigocompetencia);
            $htmlOptions = "";
            if ($codigocompetencia > 0) {
                $arrData = $this->model->selectCompetencia($codigocompetencia);
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

    public function getInstructor($identificacion)
    {
        if ($_SESSION['permisosMod']['r']) {
            $identificacion = intval($identificacion);
            $htmlOptions = "";
            if ($identificacion > 0) {
                $arrData = $this->model->selectInstructor($identificacion);
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


    }