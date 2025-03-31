<div class="card text-dark bg-light shadow-lg">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $viewPost['opponent_avatar'] ?>" alt="Аватар оппонента" width="30">
        <a href="/<?= $language ?>/<?= $viewPost['opponent_username'] ?>/profile" class="text-decoration-none">
            <?= htmlspecialchars($viewPost['opponent_name'] . ' ' . $viewPost['opponent_surname']) ?>
        </a>
        <div class="float-end">
            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($viewPost['created_at'])) ?></small>
        </div>
    </div>
    <div class="card-body">
        <h6 class="card-title text-muted">
            <?= $viewPost['discussion_type_name'] ?>
            <span class="text-muted">[<?= $viewPost['discussion_id'] ?>]</span>
            <?php if (!empty($viewPost['discussion_post_id'])): ?>
                to <?= $viewPost['discussion_level_up_type_name'] ?> <span>[<?= $viewPost['discussion_post_id'] ?>]</span>
            <?php else: ?>
                to <?= $viewPost['discussion_level_up_type_name'] ?>
                <a href="/<?= $language ?>/<?= $viewPost['author_username'] ?>/research/<?= $viewPost['research_id'] ?>" class="text-decoration-none">
                "<span><?= $viewPost['author_title'] ?></span>"
                </a>
                by
                <img class="rounded-circle border" src="<?= $viewPost['author_avatar'] ?>" alt="Аватар оппонента" width="30">
                <a href="/<?= $language ?>/<?= $viewPost['author_username'] ?>/profile" class="text-decoration-none">
                    <?= htmlspecialchars($viewPost['author_name'] . ' ' . $viewPost['author_surname']) ?>
                </a>
            <?php endif; ?>
        </h6>
        <p class="card-text"><?= htmlspecialchars($viewPost['discussion_content'] ?? 'Без обсуждения') ?></p>
    </div>
    <div class="card-footer bg-transparent">
        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
            <i class="bi bi-heart-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
            <i class="bi bi-heartbreak-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
            <i class="bi bi-chat-left-text-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3">
            <i class="bi bi-translate"></i>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3">
            <i class="bi bi-bookmark-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
            <i class="bi bi-bell-fill"></i>
            <span class="badge rounded-pill bg-secondary">0</span>
        </a>
        <div class="float-end">
            <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-pdf-fill"></i></a>
            <!-- Кнопки редактирования и удаления (только для автора поста) -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $viewPost['opponent_id']): ?>
                <a href="/<?= $language ?>/<?= $viewPost['opponent_username'] ?>/discussion/<?= $viewPost['discussion_id'] ?>/edit" class="btn btn-outline-warning btn-sm ms-3"><i class="bi bi-pencil-fill"></i></a>
                <form method="POST" action="/<?= $language ?>/<?= $viewPost['opponent_username'] ?>/discussion/<?= $viewPost['discussion_id'] ?>/delete" style="display:inline;">
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete') ?>');"><i class="bi bi-trash3-fill"></i></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>