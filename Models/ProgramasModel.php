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
        string $codigo,
        string $nivel,
        string $nombre,
        string $horas
    ) {
        $this->strCodigoPrograma = $codigo;
        $this->strNivelPrograma = $nivel;
        $this->strNombrePrograma = $nombre;
        $this->strHorasPrograma = $horas;

        $return = 0;
        $sql = "SELECT * FROM tbl_programas WHERE codigo = '{$this->strCodigoPrograma}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_programas(codigo, nivel, nombre, horas, status)
            VALUES(?, ?, ?, ?, ?)";

            $arrData = array(
                $this->strCodigoPrograma,
                $this->strNivelPrograma,
                $this->strNombrePrograma,
                $this->strHorasPrograma,
                1 // Estado activo por defecto
            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // Listar todos los programas
    public function selectProgramas()
    {
        $sql = "SELECT id, codigo, nivel, nombre, horas, status FROM tbl_programas";
        $request = $this->select_all($sql);
        return $request;
    }

    // Obtener un programa por ID
    public function selectPrograma(int $id)
    {
        $this->intIdePrograma = $id;
        $sql = "SELECT id, codigo, nivel, nombre, horas, status FROM tbl_programas WHERE id = $this->intIdePrograma";
        $request = $this->select($sql);
        return $request;
    }

    // Actualizar un programa existente
    public function updatePrograma(
        int $id,
        string $codigo,
        string $nivel,
        string $nombre,
        string $horas
    ) {
        $this->intIdePrograma = $id;
        $this->strCodigoPrograma = $codigo;
        $this->strNivelPrograma = $nivel;
        $this->strNombrePrograma = $nombre;
        $this->strHorasPrograma = $horas;

        $sql = "SELECT * FROM tbl_programas WHERE codigo = '{$this->strCodigoPrograma}' AND id != $this->intIdePrograma";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_update = "UPDATE tbl_programas SET codigo = ?, nivel = ?, nombre = ?, horas = ?
                             WHERE id = $this->intIdePrograma";

            $arrData = array(
                $this->strCodigoPrograma,
                $this->strNivelPrograma,
                $this->strNombrePrograma,
                $this->strHorasPrograma
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
