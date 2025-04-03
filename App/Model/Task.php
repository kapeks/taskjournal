<?php

namespace App\Model;

use App\Model\ORM\Model;
use App\Services\Db;

class Task extends Model
{
    protected static string $tableName = 'tasks';

    /*** метод возвращает записи,которые соответствуют пользователю.
     * 
     * @param int $userId ид пользователя.
     * 
     * @return array массив с обьектами, либо пустой массив.
     */
    public static function findByAllUserId(int $userId): array
    {
        $db = Db::getInstance();
        $tableName = static::$tableName;
        $sql = "SELECT * FROM {$tableName} WHERE user_id = :user_id ORDER BY created_at DESC";
        $results = $db->query($sql, ['user_id' => $userId]) ?? [];
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

}