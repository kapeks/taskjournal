<?php include __DIR__ . '/../header.php'; ?>


<div class="container mt-5">
    <?php if (!empty($error)): ?>
        <div style="
                background-color: #f5bcbc; 
                color: #a71d2a; 
                border: 1px solid #f5c6cb; 
                border-radius: 4px; 
                padding: 10px; 
                margin-bottom: 15px; 
                text-align: center;
                font-size: 14px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="row">

        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-4 col-lg-3 mb-4">

                    <div class="task-date text-muted small ms-3" style="text-align: center">
                        <?= htmlspecialchars(date('Y-m-d', strtotime($task->created_at))) ?>
                    </div>

                    <div class="task-card shadow-sm">
                        <div class="task-header d-flex justify-content-between align-items-center">
                            <h5 class="task-title text-truncate mb-0" title="<?= htmlspecialchars($task->name) ?>">
                                <?= htmlspecialchars($task->name) ?>
                            </h5>
                        </div>
                        <div class="task-body mt-2">
                            <p class="text-muted overflow-auto"><?= htmlspecialchars($task->text) ?></p>
                        </div>
                        <div class="task-footer d-flex justify-content-center align-items-center gap-2">
                            <form action="/tasks/completed" method="POST" class="d-inline-block">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                <input type="hidden" name="_method" value="PATCH"> <!-- Указываем тип действия -->
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars($task->id) ?>">
                                <button type="submit" class="btn btn-sm <?= $task->completed == 0 ? 'btn-primary' : 'btn-success' ?>">
                                    <?= $task->completed == 0 ? 'Активная' : 'Выполнено' ?>
                                </button>
                            </form>

                            <a href="/tasks/<?= htmlspecialchars($task->id) ?>/edit"
                                class="btn btn-sm btn-warning d-inline-block">
                                изменить
                            </a>

                            <form action="/tasks/delete" method="POST" class="d-inline-block">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars($task->id) ?>">
                                <input type="hidden" name="_method" value="DELETE"> <!-- Указываем тип действия -->
                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php if ($filter === 'active'): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Активных задач пока нет.</div>
                </div>
            <?php elseif ($filter === 'completed'): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Выполненных задач пока нет.</div>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Задач пока нет. Добавьте новую задачу!</div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!--пагинация-->
    <nav aria-label="Page navigation" class="pagination-fixed">
        <ul class="pagination justify-content-center">
            <?php if ($paginator->hasPreviousPage()): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $paginator->currentPage - 1 ?>&filter=<?= htmlspecialchars($filter) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php foreach ($paginationLinks as $link): ?>
                <?php if ($link['page'] === null): ?>
                    <li class="page-item disabled"><span class="page-link"><?= $link['label'] ?></span></li>
                <?php else: ?>
                    <li class="page-item <?= $link['page'] == $paginator->currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $link['page'] ?>&filter=<?= htmlspecialchars($filter) ?>"><?= $link['label'] ?></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($paginator->hasNextPage()): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $paginator->currentPage + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>




</div>


<?php include __DIR__ . '/../footer.php'; ?>