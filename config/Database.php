<!-- <?php

class Database {
    private $host = '127.0.0.1';
    private $db_name = 'onlinecourse'; // Thay đổi tên database nếu cần
    private $username = 'root'; // Thay đổi username MySQL
    private $password = ''; // Thay đổi password MySQL
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?> -->