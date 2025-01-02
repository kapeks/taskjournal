<?php include __DIR__ . '/../../header.php'; ?>

<div class="container mt-5" style="padding-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Код отправлен на почту</h3>
                </div>
                <div class="card-body">

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

                    <form action="/password/verifyCode" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                        <div class="mb-3">
                            <label for="code" class="form-label">Код для сброса пароля</label>
                            <input type="string" id="code" name="code" class="form-control" placeholder="Введите код" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">отправить</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/../../footer.php'; ?>