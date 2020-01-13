<?php


class db
{
  private $dbHost = 'localhost';
  private $dbUser = 'postgres';
  private $dbPass = 'postgres';
  private $dbport = '5433';
  private $dbName = 'project_granja';
  //conección 
  public function conectDB()
  {
    $mysqlConnect = "pgsql:host=$this->dbHost;port=$this->dbport;dbname=$this->dbName";
    $dbConnecion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
    $dbConnecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnecion;
  }

 
}
