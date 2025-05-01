<?php
// db_connect.php

/**
 * Database Configuration File
 * 
 * Establishes secure PDO connection and provides helper functions
 */

// Strict error reporting for development
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'salary');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => true
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            
            // Test connection
            $this->connection->query("SELECT 1");
            
        } catch (PDOException $e) {
            $this->logError($e);
            $this->showErrorPage();
            exit();
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query(string $sql, array $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->logError($e, $sql);
            return false;
        }
    }
    
    private function logError(PDOException $e, string $sql = '') {
        $message = date('[Y-m-d H:i:s] ') . $e->getMessage();
        if ($sql) {
            $message .= " [Query: $sql]";
        }
        error_log($message.PHP_EOL, 3, __DIR__.'/../logs/db_errors.log');
    }
    
    private function showErrorPage() {
        if (php_sapi_name() === 'cli') {
            echo "Database connection failed. Check error logs.\n";
            return;
        }
        
        header('HTTP/1.1 503 Service Unavailable');
        header('Content-Type: text/html; charset=utf-8');
        
        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <style>
        .error-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        .error-container h2 {
            margin-top: 0;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h2>Database Connection Error</h2>
        <p>We're experiencing technical difficulties. Please try again later.</p>
        <small>Administrators: Check error logs for details</small>
    </div>
</body>
</html>
HTML;
    }
}

// Initialize database connection
try {
    $database = Database::getInstance();
    $db = $database->getConnection();
    
    // Register shutdown function to clean up
    register_shutdown_function(function() use ($database) {
        // Any cleanup if needed
    });
    
} catch (Exception $e) {
    error_log("Database initialization failed: " . $e->getMessage());
    die("System temporarily unavailable. Please try again later.");
}

// Helper functions
function db_query(string $sql, array $params = []) {
    global $database;
    return $database->query($sql, $params);
}

function db_fetch_all(string $sql, array $params = []) {
    $stmt = db_query($sql, $params);
    return $stmt ? $stmt->fetchAll() : false;
}

function db_fetch_one(string $sql, array $params = []) {
    $stmt = db_query($sql, $params);
    return $stmt ? $stmt->fetch() : false;
}

function db_last_id() {
    global $db;
    // return $db->lastInsertId();
}
?>