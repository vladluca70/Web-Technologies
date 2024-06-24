<?php
class Database
{
    private static $instance = null;
    private $pdo;

    private $host = 'localhost';
    private $dbname = 'try';
    private $user = 'postgres';
    private $password = 'euro2024';

    private function __construct() 
    {
        $dsn = "pgsql:host={$this->host};dbname={$this->dbname}";
        $this->pdo = new PDO($dsn, $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
