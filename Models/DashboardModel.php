<?php
class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cantRoles()
    {
        $sql = "SELECT COUNT(*) as total FROM rol WHERE status != 0 ";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }
    public function cantCompetencias()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_competencias WHERE status != 0 ";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }
    public function cantUsuarios()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_usuarios WHERE status != 0 AND rolid !=0";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }
    public function cantProgramas()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_programas WHERE status != 0 ";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }
   

}