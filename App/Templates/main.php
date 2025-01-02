<?php include __DIR__ . '/header.php'; ?>

<div class="main-body">
    <header class="hero">
        <h1>Добро пожаловать в дневник задач</h1>
        <p>Ваш лучший инструмент для организации задач, управления целями и поддержания продуктивности.</p>
        <a href="/users/login" class="btn btn-light btn-lg">Начать</a>
    </header>

    <main class="features">
        <h2 class="text-center my-4">Что мы предлагаем</h2>
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-4 text-center feature-item">
                    <i class="bi bi-card-checklist fs-1 text-primary"></i>
                    <h5 class="mt-3">Создание и управление задачами</h5>
                    <p>Организуйте и легко управляйте задачами, расставьте приоритеты и отслеживайте ход их выполнения.</p>
                </div>
                <div class="col-md-4 text-center feature-item d-flex align-items-center justify-content-center">
                    <img
                        src="/public/img/example2.png"
                        alt="Пример таблицы задач"
                        style="max-height: 220px; object-fit: contain; width: auto;"
                        class="img-fluid shadow rounded">
                </div>
                <div class="col-md-4 text-center feature-item">
                    <i class="bi bi-shield-lock fs-1 text-success"></i>
                    <h5 class="mt-3">Безопасно и надежно</h5>
                    <p>Наслаждайтесь спокойствием, зная, что ваши данные защищены и конфиденциальны.</p>
                </div>
            </div>
        </div>
    </main>


    <section class="cta">
        <h2>Начните свой путь к лучшей организации уже сегодня!</h2>
        <a href="/users/register" class="btn btn-primary btn-lg">Зарегистрироваться</a>
        <a href="/users/login" class="btn btn-outline-primary btn-lg">Авторизоваться</a>
    </section>

    <footer class="text-center py-4">
        <p>&copy; <?= htmlspecialchars(date('Y')); ?> Task Journal. Все права защищены.</p>
    </footer>

</div>

<?php include __DIR__ . '/footer.php'; ?>