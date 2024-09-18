<?php
class AsignacionesModel extends Mysql
{
    private $intIdeDetalleFicha;
    private $strNumeroHoras;
    private $strListadoMeses;
    private $strIdeCompetencia;
    private $strIdeFicha;
    private $strIdeUsuario;
    private $strHorasAsignacionCompetenciActualizada;
    private $strStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertFicha(
        string $numerohoras,
        string $listadomeses,
        string $codigocompetencia,
        string $numeroficha,
        string $ideinstructor,
        string $asignacioncompetenciaactualizada

    ) {
        // TODO TABLA DETALLE FICHA
        $this->strNumeroHoras = $numerohoras;
        $this->strListadoMeses = $listadomeses;
        $this->strIdeCompetencia = $codigocompetencia;
        $this->strIdeFicha = $numeroficha;
        $this->strIdeUsuario = $ideinstructor;
        $this->strHorasAsignacionCompetenciActualizada = $asignacioncompetenciaactualizada;

        // TODO PENDIENTE POR REVISAR Y VALIDAR
        $sql = "SELECT tdc.idedetallecompetencia,tdc.cantidadhorasasignadas,tdc.mesasignacion,tdc.competenciaide,tdc.fichaide,tdc.usuarioide,tdc.status,tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status
                                FROM tbl_detalle_competencias  tdc 
                                INNER JOIN tbl_competencias tc
                                ON tc.idecompetencia = tdc.competenciaide                                 
                                WHERE tdc.mesasignacion = '{$this->strListadoMeses}' AND tdc.competenciaide = '{$this->strIdeCompetencia}' AND tdc.fichaide = '{$this->strIdeFicha}' AND tdc.status !=0";

        $request = $this->select_all($sql);

        if (empty($request)) {
            // TODO INSERTAR DATOS EN LA TABLA DETALLE COMPETENCIAS
            $query_insert = "INSERT INTO tbl_detalle_competencias(cantidadhorasasignadas,mesasignacion,competenciaide,fichaide,usuarioide)
            VALUES(?,?,?,?,?)";
            $arrData = array(
                $this->strNumeroHoras,
                $this->strListadoMeses,
                $this->strIdeCompetencia,
                $this->strIdeFicha,
                $this->strIdeUsuario
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;

            // TODO VERIFICAR SI SE REGISTRARÁ INFORMACIÓN EN LA TABLA TEMPORAL
            $sql1 = "SELECT * FROM tbl_detalle_temp_competencias WHERE (competenciaide = '{$this->strIdeCompetencia}' AND fichaide = '{$this->strIdeFicha}')";
            $request1 = $this->select_all($sql1);

                            if (empty($request1)) {
                            $query_insert2 = "INSERT INTO tbl_detalle_temp_competencias(avancehorascompetencia,competenciaide,fichaide)
                            VALUES(?,?,?)";
                            $arrData2 = array(
                                $this->strHorasAsignacionCompetenciActualizada,
                                $this->strIdeCompetencia,
                                $this->strIdeFicha
                            );
                            $request_insert2 = $this->insert($query_insert2, $arrData2);
                            $return = $request_insert2;
                            }
                            else {
                            // TODO ACTUALIZA LOS CAMPOS AVANCE DE HORAS DE LA TABLA DETALLE DE COMPETENCIAS
                            $sql = "UPDATE tbl_detalle_temp_competencias SET avancehorascompetencia = $this->strHorasAsignacionCompetenciActualizada
                                        WHERE competenciaide = $this->strIdeCompetencia AND fichaide = $this->strIdeFicha";

                                $arrData = array(
                                    $this->strHorasAsignacionCompetenciActualizada
                                );

                            $request = $this->update($sql, $arrData);
                            $return = $request;
                            }
                    }
                    else 
                    {
                        $return = "exist";
                    }
                    return $return;
    }

    // TODO LISTADO DE LA TABLA
    public function selectFichas()
    {
        // $sql = "SELECT * FROM tbl_fichas WHERE status != 0";

        $sql = "SELECT tdc.idedetallecompetencia,tdc.cantidadhorasasignadas,tdc.mesasignacion,tdc.competenciaide,tdc.fichaide,tdc.usuarioide,tdc.status,tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status
        
        FROM tbl_detalle_competencias  tdc 
        INNER JOIN tbl_competencias tc
        ON tc.idecompetencia = tdc.competenciaide
        INNER JOIN tbl_fichas tf
        ON tf.ideficha = tdc.fichaide
        INNER JOIN tbl_usuarios tu
        ON tu.ideusuario = tdc.usuarioide
        WHERE tdc.status != 0";


        $request = $this->select_all($sql);
        return $request;
    }

    //VISTA INFORMACIÓN PROGRAMA
    public function selectFicha(int $idedetalleficha)
    {
        $this->intIdeDetalleCompetencia = $idedetalleficha;

        $sql = "SELECT tdc.idedetallecompetencia,tdc.cantidadhorasasignadas,tdc.mesasignacion,tdc.competenciaide,tdc.fichaide,tdc.usuarioide,tdc.status,tdtc.idetemporal,(tdtc.avancehorascompetencia-tdc.cantidadhorasasignadas) AS resultado_actualizar,tdtc.competenciaide,tdtc.fichaide,tdtc.status,tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status
              
        FROM tbl_detalle_competencias tdc
        INNER JOIN tbl_detalle_temp_competencias  tdtc
        ON tdtc.competenciaide = tdc.competenciaide 
        INNER JOIN tbl_competencias tc 
        ON tc.idecompetencia = tdc.competenciaide
        INNER JOIN tbl_fichas tf 
        ON tf.ideficha = tdc.fichaide
        INNER JOIN tbl_usuarios tu
        ON tu.ideusuario = tdc.usuarioide
        WHERE tdc.idedetallecompetencia = '{$this->intIdeDetalleCompetencia}' AND tdc.competenciaide=tdtc.competenciaide AND tdc.fichaide=tdtc.fichaide AND tdc.status!=0";

        $request = $this->select($sql);
        return $request;
    }


    //ACTUALIZAR ASIGNACIÓN
    public function updateFicha(
    int $idedetalleficha,
    string $numerohoras,
    string $listadomeses,
    string $codigocompetencia,
    string $numeroficha,
    string $ideinstructor,
    string $asignacioncompetenciaactualizada
    ) {

    // TODO TABLA DETALLE FICHA
    $this->intIdeDetalleFicha = $idedetalleficha;
    $this->strNumeroHoras = $numerohoras;
    $this->strListadoMeses = $listadomeses;
    $this->strIdeCompetencia = $codigocompetencia;
    $this->strIdeFicha = $numeroficha;
    $this->strIdeUsuario = $ideinstructor;
    $this->strHorasAsignacionCompetenciActualizada = $asignacioncompetenciaactualizada;

        $sql = "SELECT * FROM tbl_detalle_competencias WHERE (competenciaide = '{$this->strIdeCompetencia}' AND fichaide = '{$this->strIdeFicha}' AND status!=0)";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            // TODO PENDIENTE LA VALIDACIÓN SI EL CODIGO ES IGUAL QUE EL CODIGO DE OTRA COMPETENCIA
            if ($this->strIdeFicha != "" ) {

                $sql1 = "UPDATE tbl_detalle_competencias SET cantidadhorasasignadas=?, mesasignacion=?
						 WHERE idedetallecompetencia = '{$this->intIdeDetalleFicha}'";
                        

                $arrData1 = array(
                    $this->strNumeroHoras,
                    $this->strListadoMeses
                );

                $sql2 = "UPDATE tbl_detalle_temp_competencias SET avancehorascompetencia=$this->strHorasAsignacionCompetenciActualizada
                    WHERE competenciaide = '{$this->strIdeCompetencia}' AND fichaide = '{$this->strIdeFicha}' AND status!=0";

                $arrData2 = array(
                $this->strHorasAsignacionCompetenciActualizada
        );          
                
            } 
                $request = $this->update($sql1, $arrData1);
                $request = $this->update($sql2, $arrData2);
                // return $request;
        } else 
        {
            $request = "exist";
        }
        return $request;
    }

    public function deleteFicha(int $intIdeDetalleFicha, int $intFichaIde)
    {
        $this->intIdeDetalleCompetencia = $intIdeDetalleFicha;
        $this->intFichaIde = $intFichaIde;
        // OK
        // $sql = "UPDATE tbl_detalle_competencias SET status = ? WHERE idedetallecompetencia = $this->intIdeDetalleFicha AND status!=0";
        // $arrData = array(0);
        // FIN OK

        $sql = "SELECT tdc.idedetallecompetencia,tdc.cantidadhorasasignadas,tdc.mesasignacion,tdc.competenciaide,tdc.fichaide,tdc.usuarioide,tdc.status,tdtc.idetemporal,tdtc.avancehorascompetencia,tdtc.competenciaide,tdtc.fichaide,tdtc.status,tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status
        FROM tbl_detalle_competencias tdc
        INNER JOIN tbl_detalle_temp_competencias  tdtc
        ON tdtc.competenciaide = tdc.competenciaide 
        INNER JOIN tbl_competencias tc 
        ON tc.idecompetencia = tdc.competenciaide
        INNER JOIN tbl_fichas tf 
        ON tf.ideficha = tdc.fichaide
        WHERE tdc.idedetallecompetencia = '{$this->intIdeDetalleCompetencia}' AND tdc.fichaide= '{$this->intFichaIde}' AND tdc.status!=0";
        $request = $this->select_all($sql);

            if (!empty($request)) {

                        $sql1 = "UPDATE tbl_detalle_competencias SET status = ? WHERE idedetallecompetencia = $this->intIdeDetalleCompetencia AND status!=0";
                        $arrData1 = array(0);

                        $request = $this->update($sql1, $arrData1);
                        
                        //  TODO PENDIENTE DE REVISAR Y HACER PRUEBAS PARA ACTUALIZAR LAS HORAS EN AMBAS TABLAS
                        $sql2 = "UPDATE tbl_detalle_temp_competencias  tdtc
                        INNER JOIN tbl_detalle_competencias  tdc
                        ON tdc.competenciaide = tdtc.competenciaide
                        AND tdc.fichaide = tdtc.fichaide
                        SET tdtc.avancehorascompetencia = tdtc.avancehorascompetencia - tdc.cantidadhorasasignadas
                        WHERE tdtc.fichaide = '{$this->intFichaIde}' AND tdc.idedetallecompetencia = '{$this->intIdeDetalleCompetencia}'";
                        $arrData2 = array(
                            $this->intFichaIde
                        );

                        // $sql2 = "UPDATE tbl_detalle_temp_competencias tdtc
                        // INNER JOIN tbl_detalle_competencias tdc
                        // ON tdc.competenciaide = tdtc.competenciaide
                        // AND tdc.fichaide = tdtc.fichaide
                        // SET tdtc.avancehorascompetencia = tdtc.avancehorascompetencia - tdc.cantidadhorasasignadas
                        // WHERE tdc.status != tdtc.status";
                        
                        // $sql2 = "UPDATE tbl_detalle_temp_competencias tdtc, tbl_detalle_competencias tdc,
                        // SET tdtc.avancehorascompetencia = tdtc.avancehorascompetencia - tdc.cantidadhorasasignadas WHERE tdtc.competenciaide = tdc.competenciaide AND tdtc.fichaide = tdc.fichaide AND tdtc.status!=0";
                        // $arrData2 = array();
                        
                        $request = $this->update($sql2, $arrData2);
                        return $request;
                    }
            else 
            {
                // echo"No existe";
                $return = "exist";
            }
            // return $return;
            // return $request;
    
}

public function selectRoles()
{
    // $whereAdmin = "";
    // if ($_SESSION['idUser'] != 1) {
    //     $whereAdmin = " and idrol != 1 ";
    // }
    //EXTRAER ROLES
    // $sql = "SELECT * FROM rol WHERE status != 0".$whereAdmin;
    $sql = "SELECT * FROM tbl_fichas WHERE status != 0";
    $request = $this->select_all($sql);
    return $request;
}

                      


                            //TODO VISTA INFORMACIÓN INSTRUCTOR
                            public function selectInstructor(int $identificacion)
                            {
                                $this->intIdentificacion = $identificacion;
                                $sql = "SELECT *
                                        FROM tbl_usuarios
                                        WHERE identificacion = $this->intIdentificacion AND rolid = 3";
                                $request = $this->select($sql);
                                return $request;
                            }

                            // public function selectIdeFichaSelect()
                            // {
                            //     $sql = "SELECT * FROM tbl_fichas WHERE status != 0 ORDER BY numeroficha ASC";
                            // $request = $this->select_all($sql);
                            //     return $request;
                            // }

                            public function selectIdeFichaSelect()
                            {
                                try {
                                    $sql = "SELECT ideficha,numeroficha,status FROM tbl_fichas WHERE status != 0 ORDER BY numeroficha ASC";
                                    $request = $this->select_all($sql);
                                    return $request;
                                } catch (Exception $e) {
                                    // Handle the exception (e.g., log the error, return a default value, etc.)
                                    error_log("Error executing query: " . $e->getMessage());
                                    return false;
                                }
                            }


                              //VISTA INFORMACIÓN FICHA
                        public function selectIdeFicha()
                        {

                            // TODO FUNCIONA DIGITANDO
                            // $this->intFichaPrograma = $fichaprograma;
                            // $sql = "SELECT *
                            //         FROM tbl_fichas
                            //         WHERE fichaprograma = $this->intFichaPrograma";

                            // $sql = "SELECT tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
                       
                            // FROM tbl_fichas tf 
                            // INNER JOIN tbl_usuarios tu
                            // ON tu.ideusuario = tf.usuarioide
                            // INNER JOIN tbl_programas tp
                            // ON tp.ideprograma = tf.programaide
                            // WHERE tf.numeroficha = $this->intFichaPrograma AND tf.status != 0";

                            // OK
                            $sql = "SELECT * FROM tbl_fichas WHERE status != 0 ORDER BY numeroficha ASC";
                            $request = $this->select_all($sql);
                            // $request = $this->select($sql);
                            return $request;
                        }

                        public function selectIdeFichaInput($fichaprograma)
                        {

                            // TODO FUNCIONA DIGITANDO
                            $this->intFichaPrograma = $fichaprograma;
                            // $sql = "SELECT *
                            //         FROM tbl_fichas
                            //         WHERE fichaprograma = $this->intFichaPrograma";

                            // $sql = "SELECT tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
                       
                            // FROM tbl_fichas tf 
                            // INNER JOIN tbl_usuarios tu
                            // ON tu.ideusuario = tf.usuarioide
                            // INNER JOIN tbl_programas tp
                            // ON tp.ideprograma = tf.programaide
                            // WHERE tf.numeroficha = $this->intFichaPrograma AND tf.status != 0";

                            // OK
                            $sql = "SELECT * FROM tbl_fichas WHERE ideficha = $this->intFichaPrograma AND status != 0";
                            $request = $this->select($sql);
                            // $request = $this->select($sql);
                            return $request;
                        }

                              //TODO VISTA INFORMACIÓN INSTRUCTOR
                              public function selectCodCompetencia($fichaide)
                              {
                                  $this->fichaIde = $fichaide;
                                //   $sql = "SELECT *
                                //           FROM tbl_competencias
                                //           WHERE codigocompetencia = $this->intIdentificacion";
                                //   $request = $this->select($sql);
                                //   return $request;
                                // OK
                                // $sql = "SELECT * FROM tbl_competencias WHERE status != 0";
                                // TODO PRUEBA
                                // $sql = "SELECT * FROM tbl_competencias WHERE programacodigo='$programacodigo'";
                                // $this->intCodCompetencia = $codigocompetencia;
    
                                // $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programacodigo,tc.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
                                            
                                // FROM tbl_competencias tc 
                                // INNER JOIN tbl_programas tp
                                // ON tc.programacodigo = tc.programacodigo
                                // WHERE tc.codigocompetencia = $this->intCodCompetencia";


                                // TODO OK
                                // $sql = "SELECT * FROM tbl_detalle_competencias WHERE fichaide='$fichaide' AND status=1";
                                
                                $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status
                                
                                FROM tbl_competencias tc

                                INNER JOIN tbl_fichas tf 
                                ON tf.ideficha = tc.fichaide                                
                                WHERE tc.fichaide =$this->fichaIde AND tc.status !=0";
                                // WHERE tc.fichaide ='$fichaide' AND tc.status !=0";
                                $request = $this->select_all($sql);
                                return $request;
                              }

                            //TODO VISTA INFORMACIÓN COMPETENCIAS
                            public function selectCompetencia(int $codigocompetencia)
                            {
                                $this->intCodCompetencia = $codigocompetencia;

                                $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,tdtc.idetemporal,tdtc.avancehorascompetencia,tdtc.competenciaide,tdtc.fichaide,tdtc.status,tdc.idedetallecompetencia,tdc.cantidadhorasasignadas,tdc.mesasignacion,tdc.competenciaide,tdc.fichaide,tdc.usuarioide,tdc.status
                                FROM tbl_competencias tc
                                INNER JOIN tbl_detalle_temp_competencias  tdtc
                                ON tdtc.competenciaide = tc.idecompetencia 
                                INNER JOIN tbl_detalle_competencias  tdc
                                ON tdc.competenciaide = tc.idecompetencia                                
                                WHERE tc.codigocompetencia = $this->intCodCompetencia AND tdtc.competenciaide=tdtc.competenciaide AND tdtc.fichaide=tdtc.fichaide AND tc.status !=0";
                                $request = $this->select_all($sql);
                                // return $request;

                                if (empty($request)) {

                                    $sql1 = "SELECT *
                                        FROM tbl_competencias
                                        WHERE codigocompetencia = $this->intCodCompetencia";
                                        $request1= $this->select($sql1);
                                        return $request1;
                                }
                                else {
                                    $sql2 = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,tdtc.idetemporal,tdtc.avancehorascompetencia,tdtc.competenciaide,tdtc.fichaide,tdtc.status,tdc.idedetallecompetencia,tdc.cantidadhorasasignadas,tdc.mesasignacion,tdc.competenciaide,tdc.fichaide,tdc.usuarioide,tdc.status
                                    FROM tbl_competencias tc
                                    INNER JOIN tbl_detalle_temp_competencias  tdtc
                                    ON tdtc.competenciaide = tc.idecompetencia 
                                    INNER JOIN tbl_detalle_competencias  tdc
                                    ON tdc.competenciaide = tc.idecompetencia
                                    WHERE tc.codigocompetencia = $this->intCodCompetencia AND tdtc.competenciaide=tdtc.competenciaide AND tdtc.fichaide=tdtc.fichaide AND tc.status !=0";

                                    $request2 = $this->select($sql2);
                                    return $request2;

                                    // TODO FUNCIONA CONSULTANDO HORAS PENDIENTES EN LA TABLA DETALLE COMPETENCIAS
                                    // -- $sql2 = "SELECT tdc.idedetallecompetencia,tdc.fichaprograma,tdc.codigocompetencia,SUM(horaspendientes) AS total_horas_asignadas,tdc.status,tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programacodigo,tc.status
                                
                                    // -- FROM tbl_detalle_competencias tdc 
                                    // -- INNER JOIN tbl_competencias tc
                                    // -- ON tc.codigocompetencia = tdc.codigocompetencia
                                    // WHERE tc.codigocompetencia = $this->intCodCompetencia AND tdc.status!=0";
                                    
                                }
                                                              
                                
                    }


}