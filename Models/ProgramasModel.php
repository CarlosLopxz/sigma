<?php
class ProgramaModel extends Mysql /// aca insertas el nuevo codigo 
{
    private $intIdePrograma;
    private $strIdentificacionPrograma;
    private $strnombresprograma;
    private $strPassword;
    private $strRolPrograma;
    private $strStatusPrograma;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertUsuario(  /// siempre ver el (inser) del nombre del progrma 
        string $identificacion,
        string $nombres,
        string $password,
        string $rol,
        string $status
    ) {
        $this->strIdentificacionUsuario = $identificacion;  /// tambien se pone lo mismo 
        $this->strnombresPrograma = $nombres;                   
        $this->strPassword = $password;
        $this->strRolProgramas = $rol;
        $this->strStatusPrograma = $status;

        $return = 0;
        $sql = "SELECT * FROM tbl_programas WHERE
				identificacion = '{$this->strIdentificacionprograma}'";
        $request = $this->select_all($sql);

        if (empty($request)) {

            // $rs = 1;
            $query_insert = "INSERT INTO tbl_programas(identificacion,nombres,password,rolid,status)    
            VALUES(?,?,?,?,?)";
/// se coloca el nombre de la tabla que necesitas y que estas haciendo y se le coloca su respetico (?)
            $arrData = array(
                $this->strIdentificacionPrograma,
                $this->strnombresprograma,
                $this->strPassword,
                $this->strRolUsuario,
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
    public function selectUsuarios()
    {
        $whereAdmin = "";
        if($_SESSION['idUser'] != 1 ){
            $whereAdmin = " and p.ideprograma != 1 ";
        }
        $sql = "SELECT u.ideprograma,u.identificacion,u.nombres,u.rolid,u.status,r.idrol,r.nombrerol 
                FROM tbl_programas u 
                INNER JOIN rol r
                ON u.rolid = r.idrol ".$whereAdmin;
                // WHERE u.status != 0 ".$whereAdmin;
                $request = $this->select_all($sql);
                return $request;
    }

    public function selectUsuario(int $ideusuario){
        $this->intIdeUsuario = $ideusuario;
        $sql = "SELECT u.ideprograma,u.identificacion,u.rolid,u.status,r.idrol,r.nombrerol
                FROM tbl_programa u
                INNER JOIN rol r
                ON u.rolid = r.idrol
                WHERE u.ideprograma = $this->intIdePrograma";
        $request = $this->select($sql);
        return $request;
    }

    //ACTUALIZAR USUARIO
    public function updateUsuario(
        int $ideprograma,
        string $identificacion,
        string $rol,
        string $status
    ) {

        $this->intIdePrograma = $ideprograma;
        $this->strIdentificacionPrograma = $identificacion;
        $this->strRolUsuario = $rol;
        $this->strStatus = $status;

        $sql = "SELECT * FROM tbl_programas WHERE (identificacion = '{$this->strIdentificacionPrograma}' AND ideprograma != $this->intIdePrograma)
        OR (rolid = '{$this->strRolPrograma}' AND ideusuario != $this->intIdeUsuario)";
        $request != $this->select_all($sql);

        if (empty($request)) {
            // TODO PENDIENTE LA VALIDACIÓN SI EL CODIGO ES IGUAL QUE EL CODIGO DE OTRO USUARIO
            if (($this->strIdentificacionPrograma != "" OR $this->strIdentificacionPrograma !=  $this->strIdentificacionPrograma)) {

                $sql = "UPDATE tbl_programas SET identificacion=?, rolid=?, status=?
						WHERE ideprograma = $this->intIdePrograma ";

                $arrData = array(
                    $this->strIdentificacionPrograma,
                    $this->strRolPrograma,
                    $this->strStatus
                );
            } 
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteUsuario(int $intIdePrograma)
    {
        $this->intIdeUsuario = $intIdeUsuario;
        $sql = "UPDATE tbl_programas SET status = ? WHERE ideprograma = $this->intIdePrograma ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }

}