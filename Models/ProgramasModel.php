<?php

class ProgramaModel extends Mysql
{
    private $intIdePrograma;
    private $strIdentificacionPrograma;
    private $strNombresPrograma;
    private $strPassword;
    private $strRolPrograma;
    private $strStatusPrograma;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertPrograma(
        string $identificacion,
        string $nombres,
        string $password,
        string $rol,
        string $status
    ) {
        $this->strIdentificacionPrograma = $identificacion;
        $this->strNombresPrograma = $nombres;
        $this->strPassword = $password;
        $this->strRolPrograma = $rol;
        $this->strStatusPrograma = $status;

        $return = 0;
        $sql = "SELECT * FROM tbl_programas WHERE identificacion = '{$this->strIdentificacionPrograma}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_programas (identificacion, nombres, password, rolid, status)    
                             VALUES (?, ?, ?, ?, ?)";
            $arrData = array(
                $this->strIdentificacionPrograma,
                $this->strNombresPrograma,
                $this->strPassword,
                $this->strRolPrograma,
                $this->strStatusPrograma
            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // LISTADO DE LA TABLA
    public function selectProgramas()
    {
        $whereAdmin = "";
        if ($_SESSION['idUser'] != 1) {
            $whereAdmin = " AND p.ideprograma != 1 ";
        }
        $sql = "SELECT p.ideprograma, p.identificacion, p.nombres, p.rolid, p.status, r.idrol, r.nombrerol 
                FROM tbl_programas p 
                INNER JOIN rol r ON p.rolid = r.idrol " . $whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPrograma(int $ideprograma)
    {
        $this->intIdePrograma = $ideprograma;
        $sql = "SELECT p.ideprograma, p.identificacion, p.nombres, p.rolid, p.status, r.idrol, r.nombrerol
                FROM tbl_programas p
                INNER JOIN rol r ON p.rolid = r.idrol
                WHERE p.ideprograma = $this->intIdePrograma";
        $request = $this->select($sql);
        return $request;
    }

    // ACTUALIZAR PROGRAMA
    public function updatePrograma(
        int $ideprograma,
        string $identificacion,
        string $rol,
        string $status
    ) {
        $this->intIdePrograma = $ideprograma;
        $this->strIdentificacionPrograma = $identificacion;
        $this->strRolPrograma = $rol;
        $this->strStatusPrograma = $status;

        $sql = "SELECT * FROM tbl_programas 
                WHERE (identificacion = '{$this->strIdentificacionPrograma}' AND ideprograma != $this->intIdePrograma)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE tbl_programas 
                    SET identificacion = ?, rolid = ?, status = ? 
                    WHERE ideprograma = $this->intIdePrograma";
            $arrData = array(
                $this->strIdentificacionPrograma,
                $this->strRolPrograma,
                $this->strStatusPrograma
            );
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deletePrograma(int $intIdePrograma)
    {
        $this->intIdePrograma = $intIdePrograma;
        $sql = "UPDATE tbl_programas SET status = ? WHERE ideprograma = $this->intIdePrograma";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
