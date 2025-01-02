<?php include __DIR__ . '/../header.php'; ?>
<div class="custom-body" style="padding-top: 40px;">
    <div class="custom-container">
        <div class="custom-profile-header">
            <div class="custom-avatar">U</div>
            <div class="custom-profile-info">
                <h1><?= htmlspecialchars($user->name) ?></h1>
                <p>Email: <?= htmlspecialchars($user->email) ?></p>
                <p>Зарегистрирован: <?= htmlspecialchars($user->created_at) ?></p>
            </div>
        </div>

        <?php if (empty($task)): ?>
            <div class="custom-tasks">
                <h2>Активные задачи <span class="custom-task-count">(0)</span></h2>
                <ul>
                    <li>задач пока нет</li>
                </ul>
            </div>
            <div class="custom-tasks">
                <h2>Выполненные задачи <span class="custom-task-count">(0)</span></h2>
                <ul>
                    <li>выполненных задач пока нет</li>
                </ul>
            </div>
        <?php else: ?>
            <div class="custom-tasks">
                <?php $activeTasksCount = 0; ?>
                <?php foreach ($task as $tasks): ?>
                    <?php if ($tasks->completed == 0): ?>
                        <?php $activeTasksCount++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <h2>Активные задачи <span class="custom-task-count"><?= htmlspecialchars($activeTasksCount) ?></span></h2>
                <ul>
                    <?php foreach ($task as $tasks): ?>
                        <?php if ($tasks->completed == 0): ?>
                            <li><?= htmlspecialchars($tasks->name) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="custom-tasks">
                <?php $completed = 0; ?>
                <?php foreach ($task as $tasks): ?>
                    <?php if ($tasks->completed == 1): ?>
                        <?php $completed++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <h2>выполненные задачи <span class="custom-task-count"><?= htmlspecialchars($completed) ?></span></h2>
                <ul>
                    <?php foreach ($task as $tasks): ?>
                        <?php if ($tasks->completed == 1): ?>
                            <li><?= htmlspecialchars($tasks->name) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="custom-profile-actions">
            <a href="/users/delete" class="custom-delete-button">Удалить профиль</a>
            <a href="/password/reset" class="custom-delete-button">Изменить пароль</a>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>