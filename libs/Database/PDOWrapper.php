<?php

namespace Database;
use Debug\Linda;

/**
 * Class PDOWrapper
 * @package Database
 */
class PDOWrapper
{

    /**
     * @var null|\PDO
     */
    private $pdo = NULL;


    /**
     * PDOWrapper constructor.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     */
    public function __construct($host, $username, $password, $database) {
        $this->pdo = new \PDO('mysql:dbname=' . $database . ';host=' . $host, $username, $password);
    }

    /**
     * Queries and fetches all of the data from database specified in query.
     * @param string $query
     * @return array
     */
    public function queryAndFetchAll($query) {
        return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Queries and fetches single data from database specified in query.
     * @param string $query
     * @return mixed
     */
    public function queryAndFetch($query) {
        return $this->pdo->query($query)->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Takes more than one parameter... for each questionmark insert one parameter.
     * @param string $query
     * @return array
     */
    public function prepareExecuteAndFetch($query) {
        $args = func_get_args();
        array_shift($args);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Takes more than one parameter... for each questionmark insert one parameter.
     * @param string $query
     * @return bool
     */
    public function prepareAndExecute($query) {
        $args = func_get_args();
        array_shift($args);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
    }

}