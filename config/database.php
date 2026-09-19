<?php
/**
 * Database Configuration - Prefab Wooden Homes
 * Secure PDO connection with prepared statements
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'prefab_wooden_homes');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES    => false,
                PDO::MYSQL_ATTR_INIT_COMMAND  => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                die("Service temporarily unavailable. Please try again later.");
            }
        }
        return self::$instance;
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() { throw new \Exception("Cannot unserialize singleton"); }
}
