<?php 

namespace App\Config;

class Database
{
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): \PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new \PDO(
                    sprintf(
                        '%s:host=%s;port=%d;dbname=%s',
                        $_ENV['DB_TYPE'],
                        $_ENV['DB_HOST'],
                        $_ENV['DB_PORT'],
                        $_ENV['DB_NAME']
                    ),
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD']
                );

                // Optional: Configure PDO options
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
