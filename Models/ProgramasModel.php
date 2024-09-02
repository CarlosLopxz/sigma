<?php

class ProgramasModel extends Mysql
{
    private $intIdePrograma;
    private $strCodigoPrograma;
    private $strNivelPrograma;
    private $strNombrePrograma;
    private $strHorasPrograma;
    private $strStatusPrograma;

    public function __construct()
    {
        parent::__construct();
    }

    // Insertar un nuevo programa
    public function insertPrograma(
        string $codigoprograma,
        string $nivelprograma,
        string $nombreprograma,
        string $horasprograma,
        string $status
    ) {
        $this->strCodigoPrograma = $codigoprograma;
        $this->strNivelPrograma = $nivelprograma;
        $this->strNombrePrograma = $nombreprograma;
        $this->strHorasPrograma = $horasprograma;
        $this->strStatusPrograma = $status;

        $return = 0;
        $sql = "SELECT * FROM tbl_programas WHERE 
                codigoprograma = '{$this->strCodigoPrograma}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_programas(codigoprograma, nivelprograma, nombreprograma, horasprograma, status)
            VALUES(?, ?, ?, ?, ?)";

            $arrData = array(
                $this->strCodigoPrograma,
                $this->strNivelPrograma,
                $this->strNombrePrograma,
                $this->strHorasPrograma,
                $this->strStatusPrograma
                // Estado activo por defecto
            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // // LISTADO DE LA TABLA
    // public function selectProgramas()
    // {
    //     $whereAdmin = "";
    //     if($_SESSION['idUser'] != 1 ){
    //         $whereAdmin = " and p.ideprograma != 1 ";
    //     }
    //     $sql = "SELECT u.ideprograma,u.codigoprograma,u.nivelprograma,u.nombreprograma,u.horasprograma,u.status
    //             FROM tbl_programas u 
    //             WHERE u.status != 0 ".$whereAdmin;
    //             $request = $this->select_all($sql);
    //             return $request;
    // }

    // public function selectPrograma(int $ideprograma){
    //     $this->intIdePrograma = $ideprograma;
    //     $sql = "SELECT u.ideprograma,u.codigoprograma,u.nivelprograma,u.nombreprograma,u.horasprograma,u.status
    //             FROM tbl_programas u
    //             WHERE u.ideprograma = $this->intIdePrograma";
    //     $request = $this->select($sql);
    //     return $request;
    // }

    // Listar todos los programas
    public function selectProgramas()
    {
        $sql = "SELECT ideprograma, codigoprograma, nivelprograma, nombreprograma, horasprograma, status FROM tbl_programas";
        $request = $this->select_all($sql);
        return $request;
    }

    // Obtener un programa por ID
    public function selectPrograma(int $ideprograma)
    {
        $this->intIdePrograma = $ideprograma;
        $sql = "SELECT ideprograma, codigoprograma, nivelprograma, nombreprograma, horasprograma, status FROM tbl_programas WHERE ideprograma = $this->intIdePrograma";
        $request = $this->select($sql);
        return $request;
    }

    // Actualizar un programa existente
    public function updatePrograma(
        int $ideprograma,
        string $codigoprograma,
        string $nivelprograma,
        string $nombreprograma,
        string $horasprograma,
        string $status
    ) {
        $this->intIdePrograma = $ideprograma;
        $this->strCodigoPrograma = $codigoprograma;
        $this->strNivelPrograma = $nivelprograma;
        $this->strNombrePrograma = $nombreprograma;
        $this->strHorasPrograma = $horasprograma;
        $this->strStatusPrograma = $status;

        $sql = "SELECT * FROM tbl_programas WHERE (codigoprograma = '{$this->strCodigoPrograma}' AND ideprogrma != $this->intIdePrograma)
        OR (nivelprograma = '{$this->strNivelPrograma}' AND ideprograma != $this->intIdePrograma)
        OR (nombreprograma = '{$this->strNombrePrograma}' AND ideprograma != $this->intIdePrograma)
        OR (horasprograma = '{$this->strHorasPrograma}' AND ideprograma != $this->intIdePrograma)";
        $request = $this->select_all($sql);
        

        if (empty($request)) {
            $query_update = "UPDATE tbl_programas SET codigoprograma = ?, nivelprograma = ?, nombreprograma = ?, horasprograma = ?, status=?
                             WHERE ideprograma = $this->intIdePrograma";

            $arrData = array(
                $this->strCodigoPrograma,
                $this->strNivelPrograma,
                $this->strNombrePrograma,
                $this->strHorasPrograma,
                $this->strStatus
            );

            $request_update = $this->update($query_update, $arrData);
            $return = $request_update;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // Eliminar un programa (desactivar)
    public function deletePrograma(int $id)
    {
        $this->intIdePrograma = $id;
        $sql = "UPDATE tbl_programas SET status = ? WHERE id = $this->intIdePrograma";
        $arrData = array(0); // Estado 0 para inactivo
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
