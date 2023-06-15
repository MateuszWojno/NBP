<?php

namespace NBP\Persistence\Database;

use PDO;
use PDOException;

class Connection
{

    public function __construct(private string $hostname,
                                private string $username,
                                private string $password,
                                private string $database)
    {
    }

    public function getPDO(): PDO
    {
        try {
            $pdo = new PDO("mysql:host=$this->hostname;dbname=$this->database, $this->username, $this->password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $exception) {
            throw new MissingPersistenceException($exception);
        }
    }
}