<?php include __DIR__ . '/../header.php'; ?>

<div class="container mt-5" style="padding-top: 60px;">
    <div class="sticker mx-auto" style="max-width: 500px;">
        <h1 class="text-center mb-4">Добавить задачу</h1>

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

        <form action="/tasks/create" method="POST">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="mb-3">
                <label for="task-title" class="form-label" style="color: #ffffff;">Название задачи</label>
                <input type="text" class="form-control" id="task-title" name="name" value="<?= htmlspecialchars($formData['name'] ?? '')?>" placeholder="Введите название" required>
            </div>
            <div class="mb-3">
                <label for="task-body" class="form-label" style="color: #ffffff;">Описание задачи</label>
                <textarea class="form-control" id="task-body" name="text" rows="4" placeholder="Введите описание" required><?= htmlspecialchars($formData['text'] ?? '')?></textarea>
            </div>
            <button type="submit" class="btn w-100" style="color: #ffffff;">Добавить задачу</button>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>