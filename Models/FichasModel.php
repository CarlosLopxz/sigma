<?php
class FichasModel extends Mysql
{
    private $intIdeFicha;
    private $strCodigoPrograma;
    private $strCodigoFicha;
    private $strIdeInstructor;
    private $strStatus;



    public function __construct()
    {
        parent::__construct();
    }



    public function insertFicha(
        string $codigoprograma,
        string $numeroficha,
        string $ideinstructor
    ) {
        $this->strCodigoPrograma = $codigoprograma;
        $this->strNumeroFicha = $numeroficha;
        $this->strIdeInstructor = $ideinstructor;

        $return = 0;
        // $sql = "SELECT * FROM tbl_competencias, tbl_programas WHERE
		// 		codigocompetencia = '{$this->strCodigoCompetencia}' or programaide = '{$this->strCodigoPrograma}'";
				// codigocompetencia = '{$this->strCodigoCompetencia}' OR codigoprograma != '{$this->strCodigoPrograma}'";

// $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.programaide,tc.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.status
// FROM tbl_competencias as tc
// INNER JOIN tbl_programas as tp
// ON tp.codigoprograma = tc.programaide
// WHERE tc.codigocompetencia = $this->strCodigoCompetencia or tp.codigoprograma != $this->strCodigoCompetencia";

// $sql1 = "SELECT * FROM tbl_programas WHERE (codigoprograma = '{$this->strCodigoPrograma}') ";

$sql = "SELECT * FROM tbl_fichas WHERE (fichaprograma = $this->strNumeroFicha) ";

        $request = $this->select_all($sql);
        // $request2 = $this->select_all($sql2);

        if (empty($request) ) {
            $query_insert = "INSERT INTO tbl_fichas(codigoprograma,fichaprograma,ideinstructor)
            VALUES(?,?,?)";
            $arrData = array(
                $this->strCodigoPrograma,
                $this->strNumeroFicha,
                $this->strIdeInstructor
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

        $sql = "SELECT tf.ideficha,tf.codigoprograma,tf.fichaprograma,tf.ideinstructor,tf.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
        
        FROM tbl_fichas tf
        INNER JOIN tbl_programas  tp
        ON tp.codigoprograma = tf.codigoprograma
        WHERE tf.ideficha = tf.ideficha AND tf.status != 0";


        $request = $this->select_all($sql);
        return $request;
    }



    

    //VISTA INFORMACIÓN PROGRAMA
    public function selectFicha(int $ideficha)
    {
        $this->intIdeFicha = $ideficha;

        $sql = "SELECT tf.ideficha,tf.codigoprograma,tf.fichaprograma,tf.ideinstructor,tf.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
        ,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status
        
        FROM tbl_fichas tf
INNER JOIN tbl_programas  tp
ON tp.codigoprograma = tf.codigoprograma
INNER JOIN tbl_usuarios tu
ON tu.identificacion = tf.ideinstructor
WHERE tf.ideficha = $this->intIdeFicha ";

        $request = $this->select($sql);
        return $request;
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
        $sql = "UPDATE tbl_fichas SET status = ? WHERE ideficha = $this->intIdeFicha ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }

            //VISTA INFORMACIÓN PROGRAMA
            public function selectPrograma(int $codprograma)
            {
                $this->intCodPrograma = $codprograma;
                $sql = "SELECT *
                        FROM tbl_programas
                        WHERE codigoprograma = $this->intCodPrograma";
                $request = $this->select($sql);
                return $request;
            }

                    //VISTA INFORMACIÓN PROGRAMA
        public function selectInstructor(int $identificacion)
        {
            $this->intIdentificacion = $identificacion;
            $sql = "SELECT *
                    FROM tbl_usuarios
                    WHERE identificacion = $this->intIdentificacion AND rolid = 3";
            $request = $this->select($sql);
            return $request;
        }


}