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
                $intIdeDetalleFicha = intval($_POST['idedetallecompetencia']);
                $strNumeroHoras = intval(strClean($_POST['txtNumeroHoras']));
                $strListadoMeses = strClean($_POST['listadoMeses']);
                $intCodCompetencia =intval(strClean($_POST['txtCodigoCompetencia']));
                $strIdeCompetencia = strClean($_POST['txtIdeCompetencia']);
                $strNumeroFicha = intval(strClean($_POST['txtNumeroFicha']));
                $strIdeFicha = strClean($_POST['txtIdeFicha']);
                $strIdeInstructor = intval(strClean($_POST['txtIdeInstructor']));
                $strIdeUsuario = strClean($_POST['txtIdeUsuario']);
                $strHorasTotalCompetencia = strClean($_POST['txtHorasTotalCompetencia']);
                $strHorasSumaAsignacionCompetencia = strClean($_POST['txtHorasSumaAsignacionCompetencia']);
                $strHorasAsignacionCompetenciActualizada= intval(strClean($_POST['txtHorasAsignacionCompetenciActualizada']));
                $strHorasPendienteCompetencia = intval(strClean($_POST['txtHorasPendienteCompetencia']));

                // $intStatus = intval(strClean($_POST['listStatus']));

                $intTipoId = 5;
                $request_user = "";
                if ($intIdeFicha == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertFicha(
                            $strNumeroHoras,
                            $strListadoMeses,
                            $strIdeCompetencia,
                            $strIdeFicha,
                            $strIdeUsuario,
                            $strHorasAsignacionCompetenciActualizada
                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        $request_user = $this->model->updateFicha(
                            $intIdeDetalleFicha,
                            $strNumeroHoras,
                            $strListadoMeses,
                            $strIdeCompetencia,
                            $strIdeFicha,
                            $strIdeUsuario,
                            $strHorasAsignacionCompetenciActualizada
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
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idedetallecompetencia'] . ')" title="Ver Asignaciones"><i class="far fa-eye"></i></button>';
                   
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idedetallecompetencia'] . ')" title="Editar Asignaciones"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['idedetallecompetencia'] . ', ' . $arrData[$i]['fichaide'] . ' )" title="Eliminar Asignaciones"><i class="bi bi-trash3"></i></button>';
       
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
                $intIdeDetalleFicha = intval($_POST['idedetallecompetencia']);
                $intFichaIde = intval($_POST['fichaide']);

                // Validación de valores recibidos
                if($intIdeDetalleFicha > 0 && $intFichaIde > 0) {
                $requestDelete = $this->model->deleteFicha($intIdeDetalleFicha, $intFichaIde);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Ficha');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Ficha.');
                }
                } else {
                $arrResponse = array('status' => false, 'msg' => 'Datos inválidos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    
    public function getSelectRoles()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectRoles();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['fichaprograma'] . '">' . $arrData[$i]['fichaprograma'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
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

    // public function getIdeFichasSelect()
    // {
    //     $htmlOptions = "";
    //     $arrData = $this->model->selectIdeFichassssss();
    //     if (count($arrData) > 0) {
    //         for ($i = 0; $i < count($arrData); $i++) {
    //             if ($arrData[$i]['status'] == 1) {
    //                 $htmlOptions .= '<option value="' . $arrData[$i]['ideficha'] . '">' . $arrData[$i]['numeroficha'] . '</option>';
    //             }
    //         }
    //     }
    //     echo $htmlOptions;
    //     die();
    // }

    public function getIdeFichasSelect()
{
    $htmlOptions = "";
    try {
        $arrData = $this->model->selectIdeFichaSelect(); // Corrige el nombre del método
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . htmlspecialchars($arrData[$i]['ideficha'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($arrData[$i]['numeroficha'], ENT_QUOTES, 'UTF-8') . '</option>';
                }
            }
        } else {
            $htmlOptions .= '<option value="">No se encontraron fichas activas</option>';
        }
    } catch (Exception $e) {
        $htmlOptions .= '<option value="">Error al cargar las fichas</option>';
        error_log('Error al obtener las fichas: ' . $e->getMessage());
    }
    echo $htmlOptions;
    die();
}


    public function getIdeFicha()
    {

        // switch ($_GET['op']) {
        //     case "combo":
        //         // Asegúrate de que 'op' es una opción válida
        //         $op = filter_input(INPUT_GET, 'op', FILTER_SANITIZE_STRING);
        
        //         if ($op === 'combo') {
        //             $arrData = $this->model->selectIdeFicha();
        
        //             if (!empty($arrData)) {
        //                 $htmlOptions = "<select class='form-control' data-live-search='true' id='txtNumeroFicha' name='txtNumeroFicha' required>
        //                     <option value=''>Seleccione LA FICHA</option>";
        
        //                 foreach ($arrData as $row) {
        //                     $htmlOptions .= "<option value='" . htmlspecialchars($row['ideficha'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['numeroficha'], ENT_QUOTES, 'UTF-8') . "</option>";
        //                 }
        
        //                 $htmlOptions .= "</select>";
        
        //                 echo $htmlOptions;
        //             } else {
        //                 // Manejo del caso cuando no se encuentran datos
        //                 echo "<select class='form-control' data-live-search='true' id='txtNumeroFicha' name='txtNumeroFicha' required>
        //                     <option value=''>No hay fichas disponibles</option>
        //                     </select>";
        //             }
        //         } else {
        //             // Manejo del caso cuando 'op' no es 'combo'
        //             http_response_code(400);
        //             echo "Operación no válida.";
        //         }
        //         break;
        //     default:
        //         http_response_code(400);
        //         echo "Operación no válida.";
        //         break;
        // }


        // $htmlOptions .= "";
        // switch ($_GET['op']) {
        //     case "combo":
        //         $arrData = $this->model->selectIdeFicha();
        //         if (count($arrData) > 0) {
        //             $htmlOptions .="<select class='form-control' id='txtNumeroFicha' name='txtNumeroFicha'>
        //             <option>Seleccione LA FICHA</option>";
        //             foreach ($arrData as $row) {
        //                 // $htmlOptions .= "<option value='" . $row['ideficha'] . "'>" . $row['numeroficha'] . "</option>";
        //                 $htmlOptions .= "<option value='" . htmlspecialchars($row['ideficha'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['numeroficha'], ENT_QUOTES, 'UTF-8') . "</option>";
        //             }
        //             $htmlOptions .= "</select>";
        //             echo $htmlOptions;
        //             die();
        //         }
        //         break;
        // }


        try {
            $htmlOptions = ""; // Inicializa $htmlOptions
            switch ($_GET['op']) {
                case "combo":
                    $arrData = $this->model->selectIdeFicha();
                    if (count($arrData) > 0) {
                        $htmlOptions .= "<select class='form-control' id='txtNumeroFicha' name='txtNumeroFicha'>
                                         <option>Seleccione LA FICHA</option>";
                        foreach ($arrData as $row) {
                            $htmlOptions .= "<option value='" . htmlspecialchars($row['ideficha'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['numeroficha'], ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                        $htmlOptions .= "</select>";
                    } else {
                        $htmlOptions .= "<p>No se encontraron fichas.</p>";
                    }
                    echo $htmlOptions;
                    die();
                    break;
                default:
                    echo "<p>Operación no válida.</p>";
                    die();
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        
        // TODO FUNCIONA CON SELECT TAMBIEN
        // $htmlOptions = "";
        // $arrData = $this->model->selectIdeFicha();
        // if (count($arrData) > 0) {
        //     $htmlOptions .= '<option value="default">Seleccionar FICHASSSS</option>';
        //     for ($i = 0; $i < count($arrData); $i++) {
        //         if ($arrData[$i]['status'] == 1) {
        //             $htmlOptions .= '<option value="' . $arrData[$i]['fichaprograma'] . '">' . $arrData[$i]['fichaprograma'] . '</option>';
        //         }
        //     }
        // }
        // echo $htmlOptions;
        // die();
        
    }

    public function getIdeFichaInput($fichaprograma)
    {
        // TODO FUNCIONA DIGITANDO
        if ($_SESSION['permisosMod']['r']) {
            $fichaprograma = intval($fichaprograma);
            $htmlOptions = "";
            if ($fichaprograma > 0) {
                $htmlOptions = "";
                $arrData = $this->model->selectIdeFichaInput($fichaprograma);
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

    public function getCodCompetencia()
    {
        // $htmlOptionss = "";
        // switch ($_GET["op"]) {
        //     case "combo":
        //         $arrData = $this->model->selectCodCompetencia($_POST["fichaide"]);
        //         if (count($arrData) > 0) {
        //             $htmlOptionss = "<select class='form-control' id='txtCodigoCompetencia'
        //             name='txtCodigoCompetencia'><option>Seleccione la competencia</option></select>";
        //             foreach ($arrData as $row) {
        //                 $htmlOptionss .= "<option value='" . $row['codigocompetencia'] . "'>" . $row['nombrecompetencia'] . "</option>";
        //             }
        //             echo $htmlOptionss;
                    
        //         }
        //         else {
        //             $htmlOptionss = "<select class='selectpicker form-control' data-live-search='true' id='txtCodigoCompetencia'
        //             name='txtCodigoCompetencia' required=''><option>La ficha no tiene competencias asignadas</option></select>";
        //             echo $htmlOptionss;
        //             // die();
        //         }
        //         break;
        // }

        // TODO PROPUESTA 2

        $htmlOptions = "";
switch ($_GET["op"]) {
    case "combo":
        $arrData = $this->model->selectCodCompetencia($_POST["fichaide"]);
        if (count($arrData) > 0) {
            $htmlOptions .= "<select class='form-control' id='txtCodigoCompetencia' name='txtCodigoCompetencia'>";
            $htmlOptions .= "<option value=''>Seleccione la competencia</option>";
            foreach ($arrData as $key => $row) {
                $htmlOptions .= "<option value='" . htmlspecialchars($row['codigocompetencia'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['codigocompetencia'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
            $htmlOptions .= "</select>";
            echo $htmlOptions;
        } else {
            $htmlOptions .= "<select class='form-control' data-live-search='true' id='txtCodigoCompetencia' name='txtCodigoCompetencia'><option value=''>La ficha no tiene competencias asignadas</option></select>";
            echo $htmlOptions;
        }
        break;
}


//         $htmlOptionss = "";
//         switch ($_GET["op"]) {
//         case "combo":
//         $arrData = $this->model->selectCodCompetencia($_POST["fichaide"]);
//         if (count($arrData) > 0) {
//             $htmlOptionss .="<select class='form-control' id='txtCodigoCompetencia' name='txtCodigoCompetencia'>";
//             $htmlOptionss .="<option value=''>Seleccione la competencia</option>";
//             foreach ($arrData as $key => $row) {
//                 $htmlOptionss .="<option value='" . $row['codigocompetencia'] . "'>" . $row['codigocompetencia'] . "</option>";
//             }
//             $htmlOptionss .= "</select>";
//             echo $htmlOptionss;
//         } else {
//             $htmlOptionss .="<select class='form-control' data-live-search='true' id='txtCodigoCompetencia'
//             name='txtCodigoCompetencia'><option value=''>La ficha no tiene competencias asignadas</option></select>";
//             echo $htmlOptionss;
//         }
//         break;
// }
        
        // TODO FUNCIONA SELECCIONANDO Y APARECE GENERAL
        // $htmlOptions = "";
        // $arrData = $this->model->selectCodCompetencia();
        // if (count($arrData) > 0) {
        //     $htmlOptions .= '<option value="default">Seleccionar COMPETENCIA</option>';
        //     for ($i = 0; $i < count($arrData); $i++) {
        //         if ($arrData[$i]['status'] == 1) {
        //             $htmlOptions .= '<option value="' . $arrData[$i]['codigocompetencia'] . '">' . $arrData[$i]['codigocompetencia'] . '</option>';
        //         }
        //     }
        // }
        // echo $htmlOptions;
        // die();


        // if ($_SESSION['permisosMod']['r']) {
        //     $codigocompetencia = intval($codigocompetencia);
        //     $htmlOptions = "";
        //     if ($identificacion > 0) {
        //         $arrData = $this->model->selectCodCompetencia($codigocompetencia);
        //         if (empty($arrData)) {
        //             $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        //         } else {
        //             $arrResponse = array('status' => true, 'data' => $arrData);
                   
        //         }
        //         echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        //     }
        // }
        // die();
        
    }


    }
    // public function getIdeFicha($fichaprograma)
    // {
    //     if ($_SESSION['permisosMod']['r']) {
    //         $fichaprograma = intval($fichaprograma);
    //         $htmlOptions = "";
    //         if ($fichaprograma > 0) {
    //             $arrData = $this->model->selectIdeFicha($fichaprograma);
    //             if (empty($arrData)) {
    //                 $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
    //             } else {
    //                 $arrResponse = array('status' => true, 'data' => $arrData);
                   
    //             }
    //             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //         }
    //     }
    //     die();
        
    // }

    // public function getCompetencia($codigocompetencia)
    // {
    //     if ($_SESSION['permisosMod']['r']) {
    //         $codigocompetencia = intval($codigocompetencia);
    //         $htmlOptions = "";
    //         if ($codigocompetencia > 0) {
    //             $arrData = $this->model->selectCompetencia($codigocompetencia);
    //             if (empty($arrData)) {
    //                 $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
    //             } else {
    //                 $arrResponse = array('status' => true, 'data' => $arrData);
                   
    //             }
    //             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //         }
    //     }
    //     die();
        
    // }

    // public function getInstructor($identificacion)
    // {
    //     if ($_SESSION['permisosMod']['r']) {
    //         $identificacion = intval($identificacion);
    //         $htmlOptions = "";
    //         if ($identificacion > 0) {
    //             $arrData = $this->model->selectInstructor($identificacion);
    //             if (empty($arrData)) {
    //                 $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
    //             } else {
    //                 $arrResponse = array('status' => true, 'data' => $arrData);
                   
    //             }
    //             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //         }
    //     }
    //     die();
        
    // }


    // }