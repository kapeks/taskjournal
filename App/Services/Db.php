<?php

namespace App\Services;

use App\Exceptions\DbException;
use PDO;

class Db
{
    private static ?Db $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        try {
            $dbOption = (require __DIR__ . '/../../config/database.php')['db'];
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOption['host'] . ';dbname=' . $dbOption['dbname'],
                $dbOption['user'],
                $dbOption['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('ошибка подключения к бд' . $e->getMessage());
        }
    }

    public static function getInstance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * запрос к бд 
     * 
     * @param string $sql принимает сам sql запрос.
     * @param array $params принимает необходимые параметры для sql запроса.
     * @return array|false возвращает результат в виде массива или null.
     */
    public function query(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === false) {
            return null;
        }
        return $sth->fetchAll(PDO::FETCH_ASSOC);//только ассоциативный массив;
    }

}
