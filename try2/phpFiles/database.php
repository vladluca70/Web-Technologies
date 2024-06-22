<?php
class Database {
    private static $instance = null;
    private $pdo;

    private $host = 'localhost';
    private $dbname = 'try';
    private $user = 'postgres';
    private $password = 'euro2024';

    // Constructorul privat pentru a preveni crearea directă a instanței
    private function __construct() 
    {
        $dsn = "pgsql:host={$this->host};dbname={$this->dbname}";
        $this->pdo = new PDO($dsn, $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    // Metoda pentru obținerea instanței unice
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Metoda pentru obținerea conexiunii PDO
    public function getConnection() {
        return $this->pdo;
    }

    // // Metoda privată pentru a preveni clonarea instanței
    // private function __clone() {}

    // // Metoda __wakeup este privată pentru a preveni deserializarea instanței
    // private function __wakeup() {}
}
?>
