<?php 
class mycode{
    private $conn;
    public function __construct($dconn)
    {
        $this->conn=$dconn;
    }

    public function selectAll($table)
    {
        $stm=$this->conn->prepare("select * from  $table");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>