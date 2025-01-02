<?php include __DIR__ . '/../header.php'; ?>

<div class="container mt-5" style="padding-top: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Регистрация</h3>
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

                    <form action="/users/register" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nickname</label>
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($formData['name'] ?? '') ?>" class="form-control" placeholder="Введите ваше имя" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" class="form-control" placeholder="Введите ваш email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Введите пароль" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Повторите пароль" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>