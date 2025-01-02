<?php include __DIR__ . '/../../header.php'; ?>

<div class="container mt-5" style="padding-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Сбросить пароль</h3>
                </div>
                <div class="card-body">

                    <?php if (isset($_COOKIE['invalid_code']) && $_COOKIE['invalid_code'] === 'true'): ?>
                        <div style="text-align: center;">
                            <div style="background-color: #d4edda; color:rgb(87, 21, 58); padding: 5px; margin: 15px;">
                                код больше недействительный, отправьте код повторно.
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

                    <form action="/password/reset" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" class="form-control" placeholder="Введите ваш email" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">отправить код на почту</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../footer.php'; ?>