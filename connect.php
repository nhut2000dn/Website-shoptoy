<?php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "shop_toy";
    $connection = mysqli_connect($host,$username,$password,$database) or die ("Không thể kết nối đến database");
    $item_per_page = 9; //item to display per page
	$mysqli = new mysqli($host, $username, $password, $database);
	mysqli_query($connection,"SET NAMES 'UTF8'");
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    class DBController {
        private $host = "localhost";
        private $user = "root";
        private $password = "root";
        private $database = "shop_toy";
        private $conn;
        
        function __construct() {
            $this->conn = $this->connectDB();
        }
        
        function connectDB() {
            $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
            mysqli_query($conn,"SET NAMES 'UTF8'");
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            return $conn;
        }
        
        function runQuery($query) {
            $result = mysqli_query($this->conn,$query);
            while($row=mysqli_fetch_assoc($result)) {
                $resultset[] = $row;
            }		
            if(!empty($resultset))
                return $resultset;
        }
        
        function numRows($query) {
            $result  = mysqli_query($this->conn,$query);
            $rowcount = mysqli_num_rows($result);
            return $rowcount;	
        }
    }
?>