<?php

namespace App\Services;

use App\Model\Task;
use App\Exceptions\NotFoundException;
use App\Services\Validators\TaskValidator;

/**
 * класс отвечает за бизнес-логику задач.
 */
class TaskService 
{
    /**
     * создание записи.
     * 
     * @param array $data POST данные.
     * @param int $userID ид пользователя.
     */
    public static function create(array $data, int $userID)
    {
        $data['name'] = trim($data['name']);
        $data['text'] = trim($data['text']);

        TaskValidator::validate($data);

        $task = new Task();
        $task->name = $data['name'];
        $task->text = $data['text'];
        $task->user_id = $userID;
        $task->save();
    }

    /**
     * метод удаления записи пользователя.
     * 
     * @param int $taskID ид записи.
     * @param int $userID ид пользователя.
     */
    public static function destroy(int $taskID, int $userID)
    {
        $task = Task::find($taskID);
        if ($task === null)
        {
            throw new NotFoundException('такой записи нет');
        }
        if ($task->user_id !== $userID)
        {
            throw new NotFoundException();
        }

        $task->delete();
    }

    /**
     * редактирование задачи
     * 
     * @param array $data POST данные.
     * @param int $taskID ид задачи.
     */
    public static function edit(array $data, int $taskID)
    {

        TaskValidator::validate($data);

        $task = Task::find($taskID);
        if($task === null)
        {
            throw new NotFoundException('такой записи нет');
        }

        $task->name = $data['name'];
        $task->text = $data['text'];
        $task->save();
    }

    /**
     * обработка активности задачи.
     * 
     * @param int $taskID ид записи.
     * @param int $userID ид пользователя.
     */
    public static function completed(int $taskID, int $userID)
    {
        $task = Task::find($taskID);
        if ($task->user_id !== $userID)
        {
            throw new NotFoundException();
        }
        if ($task === null)
        {
            throw new NotFoundException('такой записи нет');
        }
        if ($task->completed == 1)
        {
            $task->completed = 0;
            $task->save();
        } else {
            $task->completed = 1;
            $task->save();
        }
    }
}