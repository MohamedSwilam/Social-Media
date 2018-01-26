<?php
class database {
    //put your code here
    private $server = "localhost";
    private $user = 'root';
    private $pass = '';
    private $db = 'socialmedia';
    private $conn;
    
    private function connect() {
        $this->conn = new mysqli($this->server, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error)
            die($this->conn->connect_error);
    }
    
    private function close() {
        $this->conn->close();
    }
    
    protected function booleanQuery($sql) {
        $this->connect();
        $result = $this->conn->query($sql); 
        $this->close();
        return $result;
    }

    protected function dataQuery($sql) {
        $this->connect();
        $result = $this->conn->query($sql);
        $data = NULL;
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->close();
        return $data;
    }
    
    protected function countRows($sql){
        $this->connect();
        $result = $this->conn->query($sql);
        $num_rows = $result->num_rows;
        $this->close();
        return $num_rows;
    }
}
