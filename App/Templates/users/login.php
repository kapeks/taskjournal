<?php include __DIR__ . '/../header.php'; ?>

<div class="container mt-5" style="padding-top: 60px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Авторизация</h3>
                </div>
                <div class="card-body">

                    <?php if (isset($_COOKIE['activation_success']) && $_COOKIE['activation_success'] === 'true'): ?>
                        <div style="text-align: center;">
                            <div style="background-color: #d4edda; color: #155724; padding: 5px; margin: 15px;">
                                Активация прошла успешно
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_COOKIE['password_success']) && $_COOKIE['password_success'] === 'true'): ?>
                        <div style="text-align: center;">
                            <div style="background-color: #d4edda; color: #155724; padding: 5px; margin: 15px;">
                                Пароль успешно изменен
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_COOKIE['success_delete']) && $_COOKIE['success_delete'] === 'true'): ?>
                        <div style="text-align: center;">
                            <div style="background-color: #d4edda; color: #155724; padding: 5px; margin: 15px;">
                                успешное удаление
                            </div>
                        </div>
                    <?php endif; ?>

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

                    <form action="/users/login" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_COOKIE['user_email'] ?? $formData['email'] ?? '') ?>" class="form-control" placeholder="Введите ваш email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Введите пароль" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input
                                type="checkbox"
                                id="rememberMe"
                                name="remember_me"
                                class="form-check-input"
                                <?= isset($_COOKIE['rememberMe']) && $_COOKIE['rememberMe'] === 'true' ? 'checked' : '' ?>>
                            <label for="rememberMe" class="form-check-label">Запомнить меня</label>
                        </div>

                        <div style="text-align: right;">
                            <a href="/password/reset" class="text-decoration-none">Восстановить пароль</a>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">Войти</button>
                            <a href="/users/register" class="text-decoration-none">Зарегистрироваться</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>