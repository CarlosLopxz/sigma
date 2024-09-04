<?php
class CompetenciasModel extends Mysql
{
    private $intIdeCompetencia;
    private $strCodigoCompetencia;
    private $strNombreCompetencia;
    private $strHorasCompetencia;
    private $strCodigoPrograma;
    private $strStatus;
    

    public function __construct()
    {
        parent::__construct();
    }

        // TODO CONSULTA DE LOS PROGRAMAS DE FORMACIÓN
        public function selectProgramas()
        {
            // ORIGINAL DE CONSULTA DE PROGRAMAS
            $sql = "SELECT * FROM tbl_programas
            WHERE status != 0 ORDER BY nombreprograma ASC";

// $sql = "SELECT ,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programaide,tc.status

// FROM tbl_programas tp
// INNER JOIN tbl_competencias  tc
// ON tc.programaide = tp.codigoprograma
// WHERE status != 0 ORDER BY tp.nombreprograma ASC";

            $request = $this->select_all($sql);
            return $request;
        }

        public function selectProgramasEditar($codigoprograma)
        {
            // ORIGINAL DE CONSULTA DE PROGRAMAS
        // OK
        // $sql = "SELECT * FROM tbl_programas
        //     WHERE status != 0 ORDER BY nombreprograma ASC";

        $sql = "SELECT * FROM tbl_programas as m, tbl_competencias as d
        WHERE m.codigoprograma = d.programacodigo ";

        // $this->intIdeCompetencia = $codigoprograma;

        // $sql = "SELECT ,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programaide,tc.status

        // -- FROM tbl_programas tp
        // -- INNER JOIN tbl_competencias  tc
        // -- ON tc.programaide = tp.codigoprograma
        // -- WHERE tp.codigoprograma = $this->intIdeCompetencia ";
        // WHERE status != 0 ORDER BY tp.nombreprograma ASC";

        $request = $this->select_all($sql);
        return $request;
        // /OK

            // $request = $this->select_all($sql);
            // return $request;
        }



    public function insertCompetencia(
        string $codigocompetencia,
        string $nombrecompetencia,
        string $horascompetencia,
        string $ideprograma
    ) {
        $this->strCodigoCompetencia = $codigocompetencia;
        $this->strNombreCompetencia = $nombrecompetencia;
        $this->strHorasCompetencia = $horascompetencia;
        $this->strCodigoPrograma = $ideprograma;

        $return = 0;
        // $sql = "SELECT * FROM tbl_competencias, tbl_programas WHERE
		// 		codigocompetencia = '{$this->strCodigoCompetencia}' or programaide = '{$this->strCodigoPrograma}'";
				// codigocompetencia = '{$this->strCodigoCompetencia}' OR codigoprograma != '{$this->strCodigoPrograma}'";

// $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.programaide,tc.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.status
// FROM tbl_competencias as tc
// INNER JOIN tbl_programas as tp
// ON tp.codigoprograma = tc.programaide
// WHERE tc.codigocompetencia = $this->strCodigoCompetencia or tp.codigoprograma != $this->strCodigoCompetencia";

$sql1 = "SELECT * FROM tbl_competencias WHERE (codigocompetencia = '{$this->strCodigoCompetencia}') ";

$sql2 = "SELECT * FROM tbl_programas WHERE (codigoprograma = $this->strCodigoPrograma) ";

        $request1 = $this->select_all($sql1);
        $request2 = $this->select_all($sql2);

        if (empty($request1) && !empty($request2) ) {
            $query_insert = "INSERT INTO tbl_competencias(codigocompetencia,nombrecompetencia,horascompetencia,programacodigo)
            VALUES(?,?,?,?)";
            $arrData = array(
                $this->strCodigoCompetencia,
                $this->strNombreCompetencia,
                $this->strHorasCompetencia,
                $this->strCodigoPrograma
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // LISTADO DE LA TABLA
    public function selectCompetencias()
    {
        // $sql = "SELECT * FROM tbl_competencias WHERE status != 0";
        $sql = "SELECT * FROM tbl_programas as tp, tbl_competencias as tc
        WHERE tp.codigoprograma = tc.programacodigo AND tc.status != 0";
        $request = $this->select_all($sql);
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

    

    //VISTA INFORMACIÓN COMPETENCIA
    public function selectCompetencia(int $idecompetencia)
    {
        $this->intIdeCompetencia = $idecompetencia;

$sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programacodigo,tc.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status

FROM tbl_competencias tc
INNER JOIN tbl_programas  tp
ON tp.codigoprograma = tc.programacodigo
WHERE tc.idecompetencia = $this->intIdeCompetencia ";

        $request = $this->select($sql);
        return $request;
    }


    //ACTUALIZAR Competencia
    public function updateCompetencia(
        int $ideCompetencia,
        string $codigoCompetencia,
        string $nombreCompetencia,
        string $horasCompetencia,
        string $codigoprograma
    ) {

        $this->intIdeCompetencia = $ideCompetencia;
        $this->strCodigoCompetencia = $codigoCompetencia;
        $this->strNombreCompetencia = $nombreCompetencia;
        $this->strHorasCompetencia = $horasCompetencia;
        $this->strCodigoPrograma = $codigoprograma;

        $sql = "SELECT * FROM tbl_competencias WHERE (codigocompetencia = '{$this->strCodigoCompetencia}' AND idecompetencia != $this->intIdeCompetencia)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            // TODO PENDIENTE LA VALIDACIÓN SI EL CODIGO ES IGUAL QUE EL CODIGO DE OTRO PROGRAMA DE FORMACIÓN
            if (($this->strCodigoCompetencia != "" OR $this->strCodigoCompetencia !=  $this->strCodigoCompetencia)) {

                $sql = "UPDATE tbl_competencias SET codigocompetencia=?, nombrecompetencia=?, horascompetencia=?, programacodigo=?
						WHERE idecompetencia = $this->intIdeCompetencia";

                $arrData = array(
                    $this->strCodigoCompetencia,
                    $this->strNombreCompetencia,
                    $this->strHorasCompetencia,
                    $this->strCodigoPrograma
                );
            } 
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCompetencia(int $intIdeCompetencia)
    {
        $this->intIdeCompetencia = $intIdeCompetencia;
        $sql = "UPDATE tbl_competencias SET status = ? WHERE idecompetencia = $this->intIdeCompetencia ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }


}