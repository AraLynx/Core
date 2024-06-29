<?php
namespace app\core;

class Database
{
    public \PDO $pdo;

    public function __construct(array $params)
    {
        $type = $params['type'] ?? '';
        $host = $params['host'] ?? '';
        $name = $params['name'] ?? '';

        $user = $params['user'] ?? '';
        $password = $params['password'] ?? '';

        $dsn = $type.":Server=".$host.";Database=".$name;

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
    #endregion data process
}
