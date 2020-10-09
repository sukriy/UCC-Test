<?php
include 'Connection.php';

class Vehicles extends Connection 
{
    public $table = 'vehicles';
    public $conn;

    public function __construct()
    {
        try{
            // GET CONNECTION
            $this->conn = $this->get_connection();

            // CREATE TABLE IF NOT EXIST
            mysqli_query($this->conn, "
                CREATE TABLE IF NOT EXISTS `$this->table` (
                    `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                    `name` varchar(255) NOT NULL,
                    `engine_displacement` varchar(255) NOT NULL,
                    `engine_power` decimal(6,2) NOT NULL,
                    `price` int(11) NOT NULL,
                    `location` varchar(255) NOT NULL,  
                    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        } catch (mysqli_sql_exception $e) {
            die("Error Vehicles: " . $e->getMessage());
        }
    }
    public function retrieve($get)
    {
        $data = null;
        $sql = "SELECT * FROM `$this->table`";

        if(isset($get['id']))
        {
            $sql .= " WHERE id = ".$get['id'];
        }

        // SORT COLUMN
        if(isset($get['column']) && isset($get['sortby']))
        {
            $sql .= "ORDER BY ".$get['column'].' '.$get['sortby'];
        }

        try{
            $data = $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'data' => $data->fetch_all(MYSQLI_ASSOC),
        ];
    }
    public function store($post)
    {
        // VALIDATE POST VALUE
        if(empty($post['name']))
        {
            return [
                'success' => false,
                'message' => 'name paramater is required'
            ];
        }
        if(empty($post['engine_displacement']))
        {
            return [
                'success' => false,
                'message' => 'Engine Displacement paramater is required'
            ];
        }else if(is_numeric($post['engine_displacement']) == false){
            return [
                'success' => false,
                'message' => 'Engine Displacement must be integer'
            ];
        }
        if(empty($post['engine_displacement_unit']))
        {
            return [
                'success' => false,
                'message' => 'Engine Displacement_unit paramater is required'
            ];
        }
        if(isset($post['price']) && (is_numeric($post['price']) == false && $post['price'] != ''))
        {
            return [
                'success' => false,
                'message' => 'Price must be integer'
            ];
        }

        // INITIAL VARIABLE
        $name = $post['name'];
        $engine_displacement = $post['engine_displacement'].' '.$post['engine_displacement_unit'];
        $price = is_numeric($post['price']) ? $post['price'] : 0;
        $location = $post['location'] ?? '';


        // CALCULATE ENGINE DISPLACEMENT UNIT TO CUBIC CENTIMETER
        $engine_power = 0;
        if($post['engine_displacement_unit'] == 'liter'){
            $engine_power = $post['engine_displacement'] * 1000;
        }else if($post['engine_displacement_unit'] == 'ci'){
            $engine_power = $post['engine_displacement'] * 16.387064;
        }else{
            $engine_power = $post['engine_displacement'];
        }

        // MULTIPLY CUBIC CENTIMETER VALUE BY 15 TO GET ENGINER POWER
        $engine_power = $engine_power / 15;

        // INSERT TO DATABASE
        try{
            $this->conn->query("
                INSERT INTO `$this->table`
                (`name`, `engine_displacement`, `engine_power`, `price`, `location`) VALUES 
                ('$name', '$engine_displacement', $engine_power, $price, '$location');
            ");
        } catch (mysqli_sql_exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'message' => 'Success register new vehicle'
        ];
    }
    public function reset()
    {
        try{
            mysqli_query($this->conn, "DELETE FROM `$this->table`");
        } catch (mysqli_sql_exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return [
            'success' => true,
            'message' => 'Success reset vehicle'
        ];
    }
}