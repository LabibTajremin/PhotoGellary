<?php

class Database {

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "assig1";
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function select($select, $table, $where = "", $extention = "") {
        $sql = "SELECT " . $select . " FROM " . $table . " " . $where . " " . $extention;
        $result = $this->conn->query($sql);
        return $result;
    }

    public function insert($table, $column, $values) {
        $sql = "INSERT INTO " . $table . " (" . $column . ") VALUES ( " . $values . " )";
        $result = $this->conn->query($sql);
    }

    public function delete($table, $where) {
        $sql = "DELETE FROM " . $table . " " . $where;
        $result = $this->conn->query($sql);
    }

    public function update($table, $set, $where) {

        $sql = "UPDATE " . $table . " SET " . $set . " " . $where;
        $result = $this->conn->query($sql);
    }

}
?>

