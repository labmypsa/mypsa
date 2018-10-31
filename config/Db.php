<?php

abstract class Db {

    private static $db_host = APP_SERVER;
    private static $db_user = APP_USER;
    private static $db_pass = APP_PASS;
    protected $db_name = APP_DB;
    protected $query, $table, $table_aux, $primary_key;
    protected $rows = array();
    private $conn;
       
    public function read_single($id, $view = null) {
        if ($view == null) {
            $this->query = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = '" . $id . "'";
            $this->get_results_from_query();
            return $this->rows;
        } else {
            $table_aux = $this->table;
            $this->table = $view;
            $this->query = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = '" . $id . "'";       
            $this->get_results_from_query();
            $this->table = $table_aux;
            return $this->rows;
            
        }
    }
    public function select2($view, $string, $page){
        $total_rows = 30;
        $fin = $page * $total_rows;
        $inicio = $fin - $total_rows;
        $field = "nombre";
        $query = "SELECT * FROM $view ";
        $query .= "WHERE ".$field." LIKE '%".$string."%' ORDER BY nombre ASC LIMIT ".$inicio.", ".$fin."";
        $this->query = $query;        
        $this->get_results_from_query();
        return $this->rows;
    }
    public function like($str, $columns, $view = null) {
        if ($view == null) {
        $query = "SELECT * FROM " . $this->table . " WHERE (";
        
        } else{
        $query = "SELECT * FROM " . $view . " WHERE (";
        }
        foreach ($columns as $column) {
            $query .= $column . " like " . "'%".$str ."%')";
            $query .= ' OR (';
        }
        $query = substr($query,0,-5);
        $query.=';';
        $this->query = $query;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function read_single_by($data, $view = null) {
        if ($view == null) {
            $query = "SELECT * FROM " . $this->table . " WHERE ";
            foreach ($data as $key => $value) {
                $query .= $key . " = '" . $value . "'";
                $query .= " AND ";
            }
            $query = substr($query, 0, -5);
            $this->query = $query;                        
            $this->get_results_from_query();
            return $this->rows;
        } else {
            $table_aux = $this->table;
            $this->table = $view;
            $query = "SELECT * FROM " . $this->table . " WHERE ";
            foreach ($data as $key => $value) {
                $query .= $key . " = '" . $value . "'";
                $query .= " AND ";
            }
            $query = substr($query, 0, -5);
            $this->query = $query;  
            //vadump($this->query);
            //exit;
            $this->get_results_from_query();
            $this->table = $table_aux;           
            return $this->rows;
        }
    }

    public function read($view = null) {
        if ($view == null) {
            $this->query = "SELECT * FROM " . $this->table . "";
            $this->get_results_from_query();
            return $this->rows;
        } else {
            $table_aux = $this->table;
            $this->table = $view;
            $this->query = "SELECT * FROM " . $this->table . "";
            $this->get_results_from_query();
            $this->table = $table_aux;
            return $this->rows;
        }
    }

    public function insert($data) {
        $query = "INSERT INTO ";
        $query .= $this->table . " (";
        foreach ($data as $key => $value) {
            $query .= $key . ",";
        }
        $query = substr($query, 0, - 1);
        $query .= ") VALUES (";
        foreach ($data as $key => $value) {
            if (gettype($value) == "integer") {
                $query .= $value . ",";
            } else if(gettype($value) == "NULL"){
                $query .= $value . "NULL,";
            }                        
            else{
               $query .= "'" . $value . "',";
            } 
        }
        $query = substr($query, 0, - 1);
        $query .= ");";
        $this->query = $query;
        //var_dump($query);
        //exit;
        return $this->execute_single_query();
    }

    public function edit($data) {
        $query = "UPDATE ";
        $query .= $this->table . " SET ";
        foreach ($data as $key => $value) {            
            if (gettype($value) == "integer") {
                $query .= $key . "=" . $value . ",";
            } else if(gettype($value) == "NULL"){
                $query .= $key . "=" . $value . "NULL,";
            }            
            else{
                 $query .= $key . "='" . $value . "',";  
            }            
        }
        $query = substr($query, 0, - 1);
        $query .= " WHERE " . $this->primary_key . "='" . $data[$this->primary_key] . "';";  
        $this->query = $query;            
        return $this->execute_single_query();
    }

    public function delete($id) {
        $this->query = "DELETE FROM " . $this->table . " WHERE " . $this->primary_key . "='" . $id[$this->primary_key] . "';";
        // var_dump($this->query);
        // exit;
        return $this->execute_single_query();
    }

    private function open_connection() {
        $this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);
        //$this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, '$this->db_name');
        $this->conn->set_charset("utf8");
        if ($this->conn->connect_error) {
            var_dump($this->conn);
            //Encontrar la manera de que retorne un flash error
            //Usando el numero del error para formatear el error
        }
    }

    private function close_connection() {
        $this->conn->close();
    }

    protected function execute_single_query() {
        $this->open_connection();
        if ($this->conn->query($this->query)) {
            $this->close_connection();
            return true;
            //return $this->conn;
        } else {
            $this->close_connection();
            return false;
            //return $this->conn;
        }
    }

    protected function get_results_from_query() {
        unset($this->rows);
        $this->open_connection();
        $result = $this->conn->query($this->query);
        if ($result) {
            while ($this->rows[] = $result->fetch_assoc());
            $result->close();
            $this->close_connection();
            array_pop($this->rows);
        } else {
            return false;
        }
    }
}
