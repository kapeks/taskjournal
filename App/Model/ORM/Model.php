<?php

namespace App\Model\ORM;

use App\Services\Db;

/**
 * базовый класс для crud.
 * 
 * @param protected static string $tableName название таблицы.
 * @param array $attributes атрибуты для crud.
 */
abstract class Model
{
    protected static string $tableName;
    protected array $attributes = [];

    /**
     * возвращает массив с обьектами, либо пустой массив.
     * 
     */
    public static function findAll(): array
    {
        $db = new Db();
        $tableName = static::$tableName;
        $sql = "SELECT * FROM {$tableName}";
        $results = $db->query($sql) ?? [];
        $instances = [];
        if ($results) {
            foreach ($results as $result) {
                $instance = new static();
                $instance->attributes = $result;
                $instances[] = $instance;
            }

            return $instances;
        }

        return $instances;
    }

    /**
     * возвращает экземпляр, либо null.
     */
    public static function find(int $id)
    {
        $db = new Db();
        $tableName = static::$tableName;
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        $result = $db->query($sql, ['id' => $id]);

        if ($result) {
            $instance = new static();
            $instance->attributes = $result[0];
            return $instance;
        }

        return null;
    }

    /**
     * сохраняет или обновляет запись.
     */
    public function save(): bool
    {
        $db = new Db();
        $tableName = static::$tableName;

        if (isset($this->attributes['id'])) {
            //обновление
            $columns = array_keys($this->attributes);
            $updates = implode(', ', array_map(fn($col) => "{$col} = :{$col}", $columns));
            $sql = "UPDATE {$tableName} SET {$updates} WHERE id = :id";
            return $db->query($sql, $this->attributes) !== null;
        } else {
            //сохранение 
            $columns = array_keys($this->attributes);
            $placeholders = implode(', ', array_map(fn($col) => ":{$col}", $columns));
            $columnsStr = implode(', ', $columns);
            $sql = "INSERT INTO {$tableName} ({$columnsStr}) VALUES ({$placeholders})";

            return $db->query($sql, $this->attributes) !== null;
        }
    }

    /**
     * удаление записи.
     */
    public function delete()
    {
        $db = new Db();
        $tableName = static::$tableName;
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        $result = $db->query($sql, ['id' => $this->attributes['id']]);
        if (empty($result))
        {
            return true;
        }else {
            return false;
        }
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * проверка существавания записи.
     * 
     * @param string $columnName название столбца.
     * @param mixed $value значение для этого столбца.
     */
    public static function findOneByColumn(string $columnName, $value): ?array
    {
        $db = new Db();
        $tableName = static::$tableName;
        $sql = "SELECT * FROM {$tableName} WHERE {$columnName} = :value LIMIT 1";
        $result = $db->query($sql, [
            'value' => $value
        ]);
        if ($result === [])
        {
            return null;
        }
        return $result[0];
    }

}
