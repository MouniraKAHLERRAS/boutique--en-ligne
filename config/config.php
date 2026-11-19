<?php
// config.php - Version corrigée et simplifiée
class Config {
    private static $instance = null;
    private $pdo = null;
    
    private function __construct() {
        try {
            $host = 'localhost';
            $dbname = 'mynafashn';
            $username = 'root';
            $password = '';
            $charset = 'utf8mb4';
            
            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Message d'erreur plus clair
            throw new Exception("Impossible de se connecter à la base de données: " . $e->getMessage());
        }
    }
    
    public static function connect() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
    
    // Test simple de connexion
    public static function testConnection() {
        try {
            $pdo = self::connect();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

function normalizeImagePath($imagePath) {
    $imagePath = preg_replace('#^/?(?:uploads|images)/#', 'assets/images/', $imagePath);
    $assetPath = dirname(__DIR__) . '/' . $imagePath;

    if (!is_file($assetPath) && preg_match('#^assets/images/[a-f0-9]+_(.+)$#i', $imagePath, $matches)) {
        $fallbackPath = 'assets/images/' . $matches[1];
        if (is_file(dirname(__DIR__) . '/' . $fallbackPath)) {
            return $fallbackPath;
        }
    }

    return $imagePath;
}
?>