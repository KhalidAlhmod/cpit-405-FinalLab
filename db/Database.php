<?php

class Database {
    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbConnection;

    public function __construct() {
        // Fetch database credentials from environment variables
        $this->dbHost = getenv('DB_HOST');
        $this->dbPort = getenv('DB_PORT');
        $this->dbName = getenv('DB_DATABASE'); // Ensure this is set to 'bookmarks_db'
        $this->dbUser = getenv('DB_USERNAME');
        $this->dbPassword = getenv('DB_PASSWORD');

        // Check if all required environment variables are set
        if (!$this->dbHost || !$this->dbPort || !$this->dbUser || !$this->dbName || !$this->dbPassword) {
            die("Please set all database credentials as environment variables (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).");
        }
    }

    public function connect() {
        try {
            // Establish a connection using PDO
            $this->dbConnection = new PDO(
                "mysql:host=" . $this->dbHost . ";port=" . $this->dbPort . ";dbname=" . $this->dbName, 
                $this->dbUser, 
                $this->dbPassword
            );
            // Set PDO attributes for better error handling
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Catch and display database connection errors
            die("Database connection error: " . $e->getMessage());
        }

        return $this->dbConnection;
    }
}
