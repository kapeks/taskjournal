<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($data)): ?>
    <?php foreach ($data as $dates): ?>
        <?= $dates->email ?>
        <?php endforeach; ?>
<?php else: ?>
    <div>данных нет!</div>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>