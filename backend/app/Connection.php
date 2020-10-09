<?php 
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

class Connection 
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "devDB";
    private $connection;

    public function get_connection()
    {
        try{
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);
        } catch (mysqli_sql_exception $e) {
            die("Error Connection: " . $e->getMessage());
        }
        return $this->connection;
    }
}