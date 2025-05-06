<!-- Список постов -->
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <?php
        $avatarFile = !empty($message['avatar']) ? "/uploads/avatars/" . htmlspecialchars($message['avatar']) : "/img/default-avatar.jpg";
        $avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
        ?>
        <div class="card text-dark border mb-2 bg-body shadow">
            <div class="card-header">
                <div class="float-start">
                    <img class="rounded-circle border" src="<?= $avatarUrl ?>" alt="Аватар пользователя" width="30">
                    <a href="/<?= $language ?>/<?= $message['username'] ?>/profile" class="text-decoration-none">
                        <?= htmlspecialchars($message['name'] . ' ' . $message['surname']) ?>
                    </a>
                </div>
                <div class="float-end">
                    <small class="text-muted"><?= date('d.m.Y H:i', strtotime($message['created_at'])) ?></small>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text"><?= nl2br(htmlspecialchars($message['message'] ?? 'Без обсуждения')) ?></p>
            </div>
            <div class="card-footer bg-transparent">
                <div class="float-start">
                    <a href="" class="btn btn-outline-secondary btn-sm border-0" title="Send email">
                        <i class="bi bi-envelope-fill me-2"></i><?= htmlspecialchars($message['email']) ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока здесь нет сообщений.</p>
<?php endif; ?>