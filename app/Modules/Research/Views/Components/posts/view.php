<div class="card text-dark bg-light shadow-lg mb-2">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $avatar ?>" alt="Аватар автора" width="30">
        <a href="/<?= $language ?>/<?= $user['username'] ?>/profile" class="text-decoration-none">
            <?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?>
        </a>
        <div class="float-end">
            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small>
        </div>
    </div>
    <div class="card-body">
        <h6><em><?= $post['category_name'] ?></em></h6>
        <h4 class="card-title mb-3">
            <strong><?= htmlspecialchars($post['title'] ?? 'Без названия') ?></strong>
        </h4>
        <div class="card-text"><?= nl2br(htmlspecialchars($post['content'] ?? 'Без содержания')) ?></div>
    </div>
    <div class="card-footer bg-transparent">
        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Agree">
            <i class="bi bi-heart-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Disagree">
            <i class="bi bi-heartbreak-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Comments">
            <i class="bi bi-chat-left-text-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
            <i class="bi bi-translate"></i>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Bookmark">
            <i class="bi bi-bookmark-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Subscription">
            <i class="bi bi-bell-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <div class="float-end">
            <a href="#" class="btn btn-outline-secondary btn-sm" title="Download PDF"><i class="bi bi-file-pdf-fill"></i></a>
            <!-- Кнопки редактирования и удаления (только для автора поста) -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['user_id']): ?>
                <a href="/<?= $language ?>/<?= $user['username'] ?>/research/<?= $post['id'] ?>/edit" class="btn btn-outline-warning btn-sm ms-3" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <form method="POST" action="/<?= $language ?>/<?= $user['username'] ?>/research/<?= $post['id'] ?>/delete" style="display:inline;">
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete') ?>');" title="Delete"><i class="bi bi-trash3-fill"></i></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>