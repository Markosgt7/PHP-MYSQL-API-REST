<?php 

  class Conectar{
    protected $dbh;
    protected function conexion(){
      try {
        $conectar = $this->dbh = new PDO("mysql:host=localhost; dbname=php-api","root","");
        return $conectar;
      } catch (Exception $e) {
        print "!Error de conexión: ". $e->getMessage() . "<br/>";
        die();
      }
    }
    public function set_name(){
      return $this->dbh->query("SET NAMES 'utf8'");
    }  
  }

?>