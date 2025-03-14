<h2><?= $header ?></h2>

<?php foreach ($messages as $message): ?>
    <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
        <p><strong>От:</strong> <?= htmlspecialchars($message['email']) ?></p>
        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
        <p><small>Дата: <?= $message['created_at'] ?></small></p>
    </div>
<?php endforeach; ?>
