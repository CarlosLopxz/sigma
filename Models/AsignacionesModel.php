<?php
class AsignacionesModel extends Mysql
{
    private $intIdeFicha;
    private $strNumeroFicha;
    private $strIdeInstructor;
    private $strCodigoCompetencia;
    private $strNumeroHoras;
    private $strListadoMeses;
    private $strStatus;

    public function __construct()
    {
        parent::__construct();
    }



    public function insertFicha(
        string $numeroficha,
        string $ideinstructor,
        string $codigocompetencia,
        string $numerohoras,
        string $listadomeses
    ) {
        $this->strNumeroFicha = $numeroficha;
        $this->strIdeInstructor = $ideinstructor;
        $this->strCodigoCompetencia = $codigocompetencia;
        $this->strNumeroHoras = $numerohoras;
        $this->strListadoMeses = $listadomeses;

        $return = 0;

        $sql = "SELECT * FROM tbl_detalle_fichas WHERE (idecompetencia = '{$this->strCodigoCompetencia}' AND mes = '{$this->strListadoMeses}')";

        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_detalle_fichas(programaficha,ideinstructor,idecompetencia,cantidadhoras,mes)
            VALUES(?,?,?,?,?)";
            $arrData = array(
                $this->strNumeroFicha,
                $this->strIdeInstructor,
                $this->strCodigoCompetencia,
                $this->strNumeroHoras,
                $this->strListadoMeses
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // LISTADO DE LA TABLA
    public function selectFichas()
    {
        // $sql = "SELECT * FROM tbl_fichas WHERE status != 0";

        $sql = "SELECT tdf.idedetalleficha,tdf.programaficha,tdf.ideinstructor,tdf.idecompetencia,tdf.cantidadhoras,tdf.mes,tdf.status,tf.ideficha,tf.codigoprograma,tf.fichaprograma,tf.ideinstructor,tf.status,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status
        
        FROM tbl_detalle_fichas  tdf 
        INNER JOIN tbl_fichas tf
        ON tf.fichaprograma = tdf.programaficha
        INNER JOIN tbl_usuarios tu
        ON tu.identificacion = tdf.ideinstructor
        WHERE tdf.status != 0";


        $request = $this->select_all($sql);
        return $request;
    }



    

    //VISTA INFORMACIÓN PROGRAMA
    public function selectFicha(int $idedetalleficha)
    {
        $this->intIdeDetalleFicha = $idedetalleficha;

        

        $sql = "SELECT tdf.idedetalleficha,tdf.programaficha,tdf.ideinstructor,tdf.idecompetencia,tdf.cantidadhoras,SUM(tc.horascompetencia-tdf.cantidadhoras) AS total_horas_asignadas,tdf.mes,tdf.status,tf.codigoprograma,tf.fichaprograma,tf.ideinstructor,tf.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status,tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programacodigo,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
        
        FROM tbl_detalle_fichas  tdf 
        INNER JOIN tbl_fichas tf
        ON tf.fichaprograma = tdf.programaficha
        INNER JOIN tbl_usuarios tu
        ON tu.identificacion = tf.ideinstructor
        INNER JOIN tbl_competencias tc
        ON tc.codigocompetencia = tdf.idecompetencia
        INNER JOIN tbl_programas tp
        ON tp.codigoprograma = tf.codigoprograma
        WHERE tdf.idedetalleficha = $this->intIdeDetalleFicha";

        // $sql2 = "SELECT SUM(cantidadhoras) AS total_horas_asignadas FROM tbl_detalle_fichas";

        // $sql2 = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programacodigo,tc.status,tdf.idedetalleficha,tdf.programaficha,tdf.ideinstructor,tdf.idecompetencia,SUM(cantidadhoras) AS total_horas_asignadas,tdf.mes,tdf.status
                                        
        // FROM tbl_competencias tc 
        // INNER JOIN tbl_detalle_fichas tdf
        // ON tdf.idecompetencia = tc.codigocompetencia
        // WHERE codigocompetencia = tdf.idecompetencia AND tdf.status != 0";

        $request = $this->select($sql);
        // $request2 = $this->select($sql2);
        return $request;
        // return $request2;
    }


    //ACTUALIZAR FICHA
    public function updateFicha(
        int $ideficha,
        string $codigoprograma,
        string $codigoficha,
        string $ideinstructor
    ) {

        $this->intIdeFicha = $ideficha;
        $this->strCodigoPrograma = $codigoprograma;
        $this->strCodigoFicha = $codigoficha;
        $this->strIdeInstructor = $ideinstructor;

        $sql = "SELECT * FROM tbl_fichas WHERE (fichaprograma = '{$this->strCodigoFicha}' AND ideficha != $this->intIdeFicha)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            // TODO PENDIENTE LA VALIDACIÓN SI EL CODIGO ES IGUAL QUE EL CODIGO DE OTRO PROGRAMA
            if (($this->strCodigoFicha != "" OR $this->strCodigoFicha !=  $this->strCodigoFicha) ) {

                $sql = "UPDATE tbl_fichas SET codigoprograma=?, fichaprograma=?, ideinstructor=?
						WHERE ideficha = $this->intIdeFicha";

                $arrData = array(
                    $this->strCodigoPrograma,
                    $this->strCodigoFicha,
                    $this->strIdeInstructor
                );
            } 
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteFicha(int $intIdeFicha)
    {
        $this->intIdeFicha = $intIdeFicha;
        $sql = "UPDATE tbl_detalle_fichas SET status = ? WHERE idedetalleficha = $this->intIdeFicha ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
        
    }

                        //VISTA INFORMACIÓN FICHA
                        public function selectIdeFicha(int $fichaprograma)
                        {
                            $this->intFichaPrograma = $fichaprograma;
                            // $sql = "SELECT *
                            //         FROM tbl_fichas
                            //         WHERE fichaprograma = $this->intFichaPrograma";

                            $sql = "SELECT tf.ideficha,tf.codigoprograma,tf.fichaprograma,tf.ideinstructor,tf.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
                                        
                            FROM tbl_fichas tf 
                            INNER JOIN tbl_programas tp
                            ON tp.codigoprograma = tf.codigoprograma
                            WHERE fichaprograma = $this->intFichaPrograma AND tf.status != 0";

                            
                            $request = $this->select($sql);
                            return $request;
                        }

    



                            //VISTA INFORMACIÓN INSTRUCTOR
                public function selectInstructor(int $identificacion)
                {
                    $this->intIdentificacion = $identificacion;
                    $sql = "SELECT *
                            FROM tbl_usuarios
                            WHERE identificacion = $this->intIdentificacion AND rolid = 3";
                    $request = $this->select($sql);
                    return $request;
                }

                            //VISTA INFORMACIÓN COMPETENCIAS
                            public function selectCompetencia(int $codigocompetencia)
                            {
                                $this->intCodCompetencia = $codigocompetencia;
                                // OK
                                // $sql = "SELECT *
                                //         FROM tbl_competencias
                                //         WHERE codigocompetencia = $this->intCodCompetencia";

                                // $sql = "SELECT *
                                // FROM tbl_competencias
                                // WHERE codigocompetencia = $this->intCodCompetencia";

                                $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programacodigo,tc.status,tdf.idedetalleficha,tdf.programaficha,tdf.ideinstructor,tdf.idecompetencia,SUM(cantidadhoras) AS total_horas_asignadas,tdf.mes,tdf.status
                                        
                                FROM tbl_competencias tc 
                                INNER JOIN tbl_detalle_fichas tdf
                                ON tdf.idecompetencia = tc.codigocompetencia
                                WHERE codigocompetencia = $this->intCodCompetencia AND tdf.status != 0";

                                // SELECT SUM(monto1) AS total_monto1, 
                                // SUM(monto2) AS total_monto2, 
                                // SUM(monto3) AS total_monto3, 
                                // SUM(monto1 + monto2 + monto3) AS total_general 
                                // FROM transacciones;

                                
                                $request = $this->select($sql);
                                return $request;
                    }


}